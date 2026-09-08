<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductSearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $products = Product::where('published', 1)
            ->where(function ($query) use ($q) {
                $query->where('name', 'LIKE', "%$q%");
            })
            ->limit(5)
            ->get(['id', 'name', 'slug', 'thumbnail_img']);

        return response()->json($products);
    }
}
