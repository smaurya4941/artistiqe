<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Search;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Shop;
use App\Models\Attribute;
use App\Models\AttributeCategory;
use App\Models\PreorderProduct;
use App\Utility\CategoryUtility;
use Carbon\Carbon;

class SearchController extends Controller
{
    public function index(Request $request, $category_id = null, $brand_id = null)
    {
        // ---------- Inputs ----------
        $query        = $request->keyword;
        $sort_by      = $request->sort_by;
        $product_type = $request->product_type ?? 'general_product';
        $seller_id    = $request->seller_id;

        // ---------- Price sanitize + normalize (accept 0) ----------
        $rawMin   = is_null($request->min_price) ? null : str_replace(['₹', ',', ' '], '', $request->min_price);
        $rawMax   = is_null($request->max_price) ? null : str_replace(['₹', ',', ' '], '', $request->max_price);
        $minPrice = ($rawMin === null || $rawMin === '') ? null : (is_numeric($rawMin) ? (float) $rawMin : null);
        $maxPrice = ($rawMax === null || $rawMax === '') ? null : (is_numeric($rawMax) ? (float) $rawMax : null);
        if ($minPrice !== null && $maxPrice !== null && $minPrice > $maxPrice) {
            [$minPrice, $maxPrice] = [$maxPrice, $minPrice];
        }
        // Keep original values for view
        $min_price = $request->min_price;
        $max_price = $request->max_price;

        // ---------- Sidebar data ----------
        $attributes = Attribute::all();

        // ⭐ UPDATED: new structure for attributes (radios): attribute[<id>] => <value>
        $attributeMap = (array) $request->input('attribute', []);                 // e.g. ['12' => 'Red', '15' => 'XL']
        // normalize + drop empty:
        $attributeMap = array_filter(array_map(function($v){
            return is_scalar($v) ? (string)$v : '';
        }, $attributeMap), function($v){
            return $v !== '';
        });

        // Back-compat: also accept legacy selected_attribute_values[]
        $legacyAttrVals = array_filter((array) $request->input('selected_attribute_values', []), function($v){
            return is_scalar($v) && $v !== '';
        });

        // For view compatibility (if needed)
        $selected_attribute_values = array_values(array_unique(array_merge(array_values($attributeMap), $legacyAttrVals)));

        $colors = Color::all();
        $selected_color = null;
        $is_available = null; // for preorder tab
        $category = [];

        // Top-level categories for sidebar
        $categories = Category::with('childrenCategories', 'coverImage')
            ->where('level', 0)
            ->orderBy('order_level', 'desc')
            ->get();

        // ---------- PREORDER PRODUCTS FLOW ----------
        if (addon_is_activated('preorder') && $product_type === 'preorder_product') {
            $products = PreorderProduct::where('is_published', 1);
            $products = filter_preorder_product($products);

            if ($category_id !== null) {
                $category      = Category::with('childrenCategories')->find($category_id);
                if ($category) {
                    $products = $category->preorderProducts();
                }
            }

            if ($request->has('is_available') && $request->is_available !== null) {
                $availability = $request->is_available;
                $currentDate  = Carbon::now()->format('Y-m-d');
                $products->where(function ($q) use ($availability, $currentDate) {
                    if ((string)$availability === '1') {
                        $q->where('is_available', 1)
                          ->orWhere('available_date', '<=', $currentDate);
                    } else {
                        $q->where(function ($x) {
                              $x->where('is_available', '!=', 1)
                                ->orWhereNull('is_available');
                          })
                          ->where(function ($x) use ($currentDate) {
                              $x->whereNull('available_date')
                                ->orWhere('available_date', '>', $currentDate);
                          });
                    }
                });
                $is_available = $availability;
            } else {
                $is_available = null;
            }

            if ($minPrice !== null || $maxPrice !== null) {
                $lo = $minPrice ?? 0;
                $hi = $maxPrice ?? 999999999;
                $products->whereBetween('unit_price', [$lo, $hi]);
            }

            if (!empty($query)) {
                $this->store($request);
                $products->where(function ($q) use ($query) {
                    foreach (explode(' ', trim($query)) as $word) {
                        $q->where('product_name', 'like', '%' . $word . '%')
                          ->orWhere('tags', 'like', '%' . $word . '%')
                          ->orWhereHas('preorder_product_translations', function ($qt) use ($word) {
                              $qt->where('product_name', 'like', '%' . $word . '%');
                          });
                    }
                });

                $case1 = $query . '%';
                $case2 = '%' . $query . '%';
                $products->orderByRaw('CASE
                    WHEN product_name LIKE "' . $case1 . '" THEN 1
                    WHEN product_name LIKE "' . $case2 . '" THEN 2
                    ELSE 3
                END');
            }

            switch ($sort_by) {
                case 'newest':    $products->orderBy('created_at', 'desc'); break;
                case 'oldest':    $products->orderBy('created_at', 'asc');  break;
                case 'price-asc': $products->orderBy('unit_price', 'asc');  break;
                case 'price-desc':$products->orderBy('unit_price', 'desc'); break;
                default:          $products->orderBy('id', 'desc');         break;
            }

            $products = $products->with('taxes')
                                 ->paginate(12, ['*'], 'preorder_product')
                                 ->appends($request->query());

            return view('frontend.product_listing', compact(
                'products', 'query', 'category', 'categories', 'category_id', 'brand_id', 'sort_by', 'seller_id',
                'min_price', 'max_price', 'attributes', 'selected_attribute_values', 'colors', 'selected_color',
                'product_type', 'is_available', 'attributeMap' // ⭐ pass new map (optional)
            ));
        }

        // ---------- GENERAL PRODUCTS FLOW ----------
        // Brand conditions
        $conditions = [];
        if ($brand_id !== null) {
            $conditions = array_merge($conditions, ['brand_id' => $brand_id]);
        } elseif ($request->brand !== null) {
            $brand = Brand::where('slug', $request->brand)->first();
            $conditions = array_merge($conditions, ['brand_id' => optional($brand)->id]);
        }

        $products = Product::where($conditions);

        // Category narrowing
        if ($category_id !== null) {
            $category_ids = CategoryUtility::children_ids($category_id);
            $category_ids[] = $category_id;
            $category = Category::with('childrenCategories')->find($category_id);

            if ($category) {
                $products = $category->products();
            }

            $attribute_ids = AttributeCategory::whereIn('category_id', $category_ids)->pluck('attribute_id')->toArray();
            if (!empty($attribute_ids)) {
                $attributes = Attribute::whereIn('id', $attribute_ids)->get();
            }
        }

        // Keyword search
        if (!empty($query)) {
            $this->store($request);

            $products->where(function ($q) use ($query) {
                foreach (explode(' ', trim($query)) as $word) {
                    $q->where('name', 'like', '%' . $word . '%')
                      ->orWhere('tags', 'like', '%' . $word . '%')
                      ->orWhereHas('product_translations', function ($qt) use ($word) {
                          $qt->where('name', 'like', '%' . $word . '%');
                      })
                      ->orWhereHas('stocks', function ($qs) use ($word) {
                          $qs->where('sku', 'like', '%' . $word . '%');
                      });
                }
            });

            $case1 = $query . '%';
            $case2 = '%' . $query . '%';
            $products->orderByRaw('CASE
                WHEN name LIKE "' . $case1 . '" THEN 1
                WHEN name LIKE "' . $case2 . '" THEN 2
                ELSE 3
            END');
        }

        // Sorting
        switch ($sort_by) {
            case 'newest':    $products->orderBy('created_at', 'desc'); break;
            case 'oldest':    $products->orderBy('created_at', 'asc');  break;
            case 'price-asc': $products->orderBy('unit_price', 'asc');  break;
            case 'price-desc':$products->orderBy('unit_price', 'desc'); break;
            default:          $products->orderBy('id', 'desc');         break;
        }

        // Color filter
        if ($request->has('color')) {
            $str = '"' . $request->color . '"';
            $products->where('colors', 'like', '%' . $str . '%');
            $selected_color = $request->color;
        }

        // ⭐ UPDATED: Attributes filter (radio per attribute)
        // Build final values to match (AND across attributes)
        $finalAttrValues = [];

        // from new map
        foreach ($attributeMap as $attrId => $val) {
            if ($val !== '') $finalAttrValues[(int)$attrId] = (string)$val;
        }
        // also include legacy loose values (OR semantics folded into AND one-by-one)
        foreach ($legacyAttrVals as $val) {
            // we don't know attrId here; still allow matching by value (broad)
            $finalAttrValues[] = (string)$val;
        }

        if (!empty($finalAttrValues)) {
            $products->where(function ($outer) use ($finalAttrValues) {
                foreach ($finalAttrValues as $key => $value) {
                    // choice_options is JSON like: [{"name":"Size","values":["S","M"]}, ...]
                    // We approximate by LIKE match on the plain value token.
                    $needle = '"' . addcslashes($value, '"\\') . '"';
                    $outer->where(function($q) use ($needle){
                        $q->where('choice_options', 'like', '%' . $needle . '%');
                    });
                }
            });
        }

        // ✅ Apply PRICE filter **LAST**
        if ($minPrice !== null || $maxPrice !== null) {
            $lo = $minPrice ?? 0;
            $hi = $maxPrice ?? 999999999;
            $products->where(function ($q) use ($lo, $hi) {
                $q->whereBetween('unit_price', [$lo, $hi])
                  ->orWhereHas('stocks', function ($qs) use ($lo, $hi) {
                      $qs->whereBetween('price', [$lo, $hi]);
                  });
            });
        }

        // Finalize
        $products = filter_products($products)
            ->with('taxes')
            ->paginate(24)
            ->appends($request->query());

        return view('frontend.product_listing', compact(
            'products', 'query', 'category', 'categories', 'category_id', 'brand_id', 'sort_by', 'seller_id',
            'min_price', 'max_price', 'attributes', 'selected_attribute_values', 'colors', 'selected_color',
            'product_type', 'is_available', 'attributeMap' // ⭐ pass new map (optional)
        ));
    }

    public function listing(Request $request)
    {
        return $this->index($request);
    }

    public function listingByCategory(Request $request, $category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();
        if ($category !== null) {
            return $this->index($request, $category->id);
        }
        abort(404);
    }

    public function listingByBrand(Request $request, $brand_slug)
    {
        $brand = Brand::where('slug', $brand_slug)->first();
        if ($brand !== null) {
            return $this->index($request, null, $brand->id);
        }
        abort(404);
    }

    // ---------- Suggestional Search ----------
    public function ajax_search(Request $request)
    {
        $keywords = [];
        $query    = $request->search;
        $preorder_products = null;

        $products = Product::where('published', 1)
            ->where('tags', 'like', '%' . $query . '%')
            ->get();

        foreach ($products as $product) {
            foreach (explode(',', (string) $product->tags) as $tag) {
                if (stripos($tag, $query) !== false) {
                    if (count($keywords) > 5) {
                        break;
                    } else {
                        if (!in_array(strtolower($tag), $keywords)) {
                            $keywords[] = strtolower($tag);
                        }
                    }
                }
            }
        }

        $products_query = filter_products(Product::query());
        $products_query = $products_query->where('published', 1)
            ->where(function ($q) use ($query) {
                foreach (explode(' ', trim($query)) as $word) {
                    $q->where('name', 'like', '%' . $word . '%')
                      ->orWhere('tags', 'like', '%' . $word . '%')
                      ->orWhereHas('product_translations', function ($qt) use ($word) {
                          $qt->where('name', 'like', '%' . $word . '%');
                      })
                      ->orWhereHas('stocks', function ($qs) use ($word) {
                          $qs->where('sku', 'like', '%' . $word . '%');
                      });
                }
            });

        $case1 = $query . '%';
        $case2 = '%' . $query . '%';
        $products_query->orderByRaw('CASE
            WHEN name LIKE "' . $case1 . '" THEN 1
            WHEN name LIKE "' . $case2 . '" THEN 2
            ELSE 3
        END');

        $products = $products_query->limit(3)->get();

        $categories = Category::where('name', 'like', '%' . $query . '%')
            ->get()
            ->take(3);

        $shops = Shop::whereIn('user_id', verified_sellers_id())
            ->where('name', 'like', '%' . $query . '%')
            ->get()
            ->take(3);

        if (addon_is_activated('preorder')) {
            $preorder_products = PreorderProduct::where('is_published', 1)
                ->where(function ($qb) use ($query) {
                    $qb->where('product_name', 'like', '%' . $query . '%')
                       ->orWhere('tags', 'like', '%' . $query . '%');
                })
                ->where(function ($q) {
                    $q->whereHas('user', function ($uq) {
                        $uq->where('user_type', 'admin');
                    })->orWhereHas('user.shop', function ($sq) {
                        $sq->where('verification_status', 1);
                    });
                })
                ->limit(3)
                ->get();
        }

        if (count($keywords) > 0 || count($categories) > 0 || count($products) > 0 || ($preorder_products && count($preorder_products) > 0)) {
            return view('frontend.partials.search_content', compact('products', 'categories', 'keywords', 'shops', 'preorder_products'));
        }

        return '0';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $search = Search::where('query', $request->keyword)->first();
        if ($search) {
            $search->count = $search->count + 1;
            $search->save();
        } else {
            $search = new Search();
            $search->query = $request->keyword;
            $search->save();
        }
    }
}
