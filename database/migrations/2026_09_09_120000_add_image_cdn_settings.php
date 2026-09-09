<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Seeds the Image CDN (Cloudinary fetch-mode) settings into `business_settings`
 * and registers the admin permission for the config screen.
 *
 * Runtime source of truth = business_settings (works under config:cache, is cached
 * by get_setting()). The CLOUDINARY_* / IMAGE_CDN_* .env values, if present, are
 * used only as the initial seed.
 *
 *   php artisan migrate --path=database/migrations/2026_09_09_120000_add_image_cdn_settings.php
 */
return new class extends Migration
{
    private array $settings = [
        // key                         => [env fallback key, default]
        'image_cdn_enabled'            => [null, '0'],
        'image_cdn_provider'           => [null, 'cloudinary'],
        'image_cdn_cloud_name'         => ['CLOUDINARY_CLOUD_NAME', ''],
        'image_cdn_default_transform'  => ['IMAGE_CDN_DEFAULT_TRANSFORM', 'f_auto,q_auto,dpr_auto'],
        'image_cdn_include_theme'      => [null, '0'],
        // Phase-2 (signed uploads) — stored now, unused by fetch mode
        'cloudinary_api_key'           => ['CLOUDINARY_API_KEY', ''],
        'cloudinary_api_secret'        => ['CLOUDINARY_API_SECRET', ''],
    ];

    public function up(): void
    {
        if (Schema::hasTable('business_settings')) {
            $now = now();
            foreach ($this->settings as $type => [$envKey, $default]) {
                $exists = DB::table('business_settings')->where('type', $type)->exists();
                if ($exists) {
                    continue;
                }
                $value = ($envKey && env($envKey) !== null && env($envKey) !== '')
                    ? (string) env($envKey)
                    : $default;

                DB::table('business_settings')->insert([
                    'type'       => $type,
                    'value'      => $value,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        // Admin permission for the config screen
        if (Schema::hasTable('permissions')) {
            $perm = DB::table('permissions')->where('name', 'image_cdn_configuration')->where('guard_name', 'web')->first();
            $permId = $perm->id ?? DB::table('permissions')->insertGetId([
                'name'       => 'image_cdn_configuration',
                'section'    => 'setup_configuration',
                'guard_name' => 'web',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            if (Schema::hasTable('role_has_permissions') && Schema::hasTable('roles')) {
                $roleIds = DB::table('roles')->whereIn('name', ['Super Admin', 'Admin'])->pluck('id');
                foreach ($roleIds as $roleId) {
                    $linked = DB::table('role_has_permissions')
                        ->where('role_id', $roleId)->where('permission_id', $permId)->exists();
                    if (! $linked) {
                        DB::table('role_has_permissions')->insert(['role_id' => $roleId, 'permission_id' => $permId]);
                    }
                }
            }
        }

        try {
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        } catch (\Throwable $e) {
        }

        $this->flushSettingsCache();
    }

    public function down(): void
    {
        if (Schema::hasTable('business_settings')) {
            DB::table('business_settings')->whereIn('type', array_keys($this->settings))->delete();
        }
        if (Schema::hasTable('permissions')) {
            $id = DB::table('permissions')->where('name', 'image_cdn_configuration')->value('id');
            if ($id && Schema::hasTable('role_has_permissions')) {
                DB::table('role_has_permissions')->where('permission_id', $id)->delete();
            }
            DB::table('permissions')->where('name', 'image_cdn_configuration')->delete();
        }
        $this->flushSettingsCache();
    }

    private function flushSettingsCache(): void
    {
        try {
            \Illuminate\Support\Facades\Cache::forget('business_settings');
        } catch (\Throwable $e) {
        }
    }
};
