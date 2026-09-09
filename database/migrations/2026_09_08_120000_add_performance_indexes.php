<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the indexes Active eCommerce ships without.
 *
 * The whole schema is admin-managed from the UI (every entity has a master
 * table with list / filter / search screens), so besides the foreign-key
 * columns this also indexes the status / type / flag columns those admin
 * list screens filter and sort on.
 *
 * Safe to run on a populated database:
 *   - every table is guarded with hasTable()
 *   - every column is guarded with hasColumn()
 *   - an index that already exists (by column set, or as the leading column
 *     of a composite) is skipped
 *   - each index is added in its own try/catch; a failure is logged and the
 *     migration continues
 *   - all indexes are plain (non-unique) so pre-existing duplicate rows in
 *     pivot tables cannot break the migration
 */
return new class extends Migration
{
    /**
     * table => list of column-sets to index.
     */
    private function map(): array
    {
        return [
            // ---- Catalog -------------------------------------------------
            'products' => [
                ['slug'],
                ['category_id'],
                ['brand_id'],
                ['user_id'],
                ['added_by'],
                ['published', 'approved'],
                ['auction_product'],
                ['wholesale_product'],
                ['digital'],
                ['todays_deal'],
                ['featured'],
                ['seller_featured'],
            ],
            'product_translations' => [
                ['product_id', 'lang'],
            ],
            'product_stocks' => [
                ['product_id'],
                ['sku'],
            ],
            'product_taxes' => [
                ['product_id'],
            ],
            'product_categories' => [
                ['product_id', 'category_id'],
                ['category_id'],
            ],
            'categories' => [
                ['parent_id'],
                ['featured'],
                ['top'],
            ],
            'category_translations' => [
                ['category_id', 'lang'],
            ],
            'brand_translations' => [
                ['brand_id', 'lang'],
            ],
            'attribute_values' => [
                ['attribute_id'],
            ],
            'flash_deal_products' => [
                ['flash_deal_id'],
                ['product_id'],
            ],

            // ---- Orders -------------------------------------------------
            'orders' => [
                ['combined_order_id'],
                ['user_id'],
                ['guest_id'],
                ['seller_id'],
                ['code'],
                ['delivery_status'],
                ['payment_status'],
                ['payment_type'],
                ['pickup_point_id'],
                ['carrier_id'],
            ],
            'order_details' => [
                ['order_id'],
                ['seller_id'],
                ['product_id'],
                ['delivery_status'],
                ['payment_status'],
                ['pickup_point_id'],
            ],
            'combined_orders' => [
                ['user_id'],
            ],
            'commission_histories' => [
                ['order_id'],
                ['order_detail_id'],
                ['seller_id'],
            ],
            'order_addresses' => [
                ['order_id'],
            ],

            // ---- Cart / customer activity ------------------------------
            'carts' => [
                ['user_id'],
                ['owner_id'],
                ['temp_user_id'],
                ['product_id'],
            ],
            'wishlists' => [
                ['user_id', 'product_id'],
                ['product_id'],
            ],
            'last_viewed_products' => [
                ['user_id', 'product_id'],
                ['product_id'],
            ],
            'reviews' => [
                ['product_id', 'status'],
                ['user_id'],
                ['type'],
            ],
            'product_queries' => [
                ['product_id'],
                ['customer_id'],
                ['seller_id'],
            ],
            'coupon_usages' => [
                ['user_id', 'coupon_id'],
                ['coupon_id'],
            ],
            'follow_sellers' => [
                ['user_id', 'shop_id'],
                ['shop_id'],
            ],

            // ---- Messaging / support ----------------------------------
            'conversations' => [
                ['sender_id'],
                ['receiver_id'],
            ],
            'messages' => [
                ['conversation_id'],
                ['user_id'],
            ],

            // ---- Wallet / money --------------------------------------
            'wallets' => [
                ['user_id'],
            ],
            'transactions' => [
                ['user_id'],
                ['status'],
            ],
            'seller_withdraw_requests' => [
                ['user_id'],
                ['status'],
            ],
            'refund_requests' => [
                ['user_id'],
                ['order_id'],
                ['order_detail_id'],
                ['seller_approval'],
                ['admin_approval'],
            ],
            'club_point_details' => [
                ['club_point_id'],
                ['order_id'],
            ],
            'club_points' => [
                ['user_id'],
            ],

            // ---- Media / uploads -------------------------------------
            'uploads' => [
                ['user_id'],
                ['type'],
            ],

            // ---- Users ---------------------------------------------
            'users' => [
                ['user_type'],
                ['referred_by'],
                ['provider_id'],
                ['referral_code'],
                ['customer_package_id'],
            ],
            'addresses' => [
                ['user_id'],
                ['city_id'],
                ['state_id'],
                ['country_id'],
            ],

            // ---- Notifications -------------------------------------
            'notifications' => [
                ['notification_type_id'],
                ['read_at'],
            ],

            // ---- Geo master data ----------------------------------
            'cities' => [
                ['state_id'],
                ['status'],
            ],
            'states' => [
                ['country_id'],
                ['status'],
            ],
            'countries' => [
                ['zone_id'],
                ['status'],
            ],

            // ---- Auction -----------------------------------------
            'auction_product_bids' => [
                ['product_id'],
                ['user_id'],
            ],

            // ---- Pre-order -------------------------------------
            'preorder_products' => [
                ['user_id'],
                ['added_by'],
                ['category_id'],
                ['brand_id'],
                ['published'],
                ['approved'],
            ],
            'preorder_product_translations' => [
                ['preorder_product_id', 'lang'],
            ],

            // ---- Affiliate ------------------------------------
            'affiliate_logs' => [
                ['affiliate_user_id'],
                ['referred_by_user'],
                ['order_id'],
            ],

            // ---- Custom art module --------------------------
            'artists' => [
                ['phone'],
            ],
            'collector_registers' => [
                ['phone'],
            ],
            'artworks' => [
                ['status'],
                ['artist_id', 'status'],
            ],
        ];
    }

    public function up(): void
    {
        foreach ($this->map() as $table => $sets) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            foreach ($sets as $columns) {
                $columns = (array) $columns;

                foreach ($columns as $c) {
                    if (! Schema::hasColumn($table, $c)) {
                        continue 2;
                    }
                }

                if ($this->indexCovers($table, $columns)) {
                    continue;
                }

                try {
                    Schema::table($table, function (Blueprint $t) use ($columns) {
                        $t->index($columns);
                    });
                } catch (\Throwable $e) {
                    Log::warning(sprintf(
                        'add_performance_indexes: skipped %s(%s): %s',
                        $table,
                        implode(',', $columns),
                        $e->getMessage()
                    ));
                }
            }
        }

        $this->ensureInnoDb('countries');
    }

    public function down(): void
    {
        foreach ($this->map() as $table => $sets) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            foreach ($sets as $columns) {
                $columns = (array) $columns;

                try {
                    Schema::table($table, function (Blueprint $t) use ($columns) {
                        $t->dropIndex($columns);
                    });
                } catch (\Throwable $e) {
                    // index was never created (guarded away) — nothing to drop
                }
            }
        }
    }

    /**
     * True when the column set is already the leading part of some index.
     */
    private function indexCovers(string $table, array $columns): bool
    {
        $target = implode(',', $columns);

        $rows = DB::select(
            'SELECT INDEX_NAME, GROUP_CONCAT(COLUMN_NAME ORDER BY SEQ_IN_INDEX) AS cols
               FROM information_schema.STATISTICS
              WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?
           GROUP BY INDEX_NAME',
            [DB::getDatabaseName(), $table]
        );

        foreach ($rows as $row) {
            if ($row->cols === $target) {
                return true;
            }
            if (str_starts_with($row->cols . ',', $target . ',')) {
                return true;
            }
        }

        return false;
    }

    private function ensureInnoDb(string $table): void
    {
        if (! Schema::hasTable($table)) {
            return;
        }

        $info = DB::selectOne(
            'SELECT ENGINE AS engine
               FROM information_schema.TABLES
              WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ?',
            [DB::getDatabaseName(), $table]
        );

        if ($info && strtoupper((string) $info->engine) !== 'INNODB') {
            try {
                DB::statement("ALTER TABLE `{$table}` ENGINE = InnoDB");
            } catch (\Throwable $e) {
                Log::warning("add_performance_indexes: could not convert {$table} to InnoDB: " . $e->getMessage());
            }
        }
    }
};
