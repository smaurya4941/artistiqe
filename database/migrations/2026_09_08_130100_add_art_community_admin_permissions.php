<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Registers the admin-panel permissions for managing the art community
 * (Artists / Collectors / Galleries) and attaches them to the built-in
 * admin roles. Idempotent.
 *
 *   php artisan migrate --path=database/migrations/2026_09_08_130100_add_art_community_admin_permissions.php
 */
return new class extends Migration
{
    private array $permissions = [
        'view_artists',
        'view_collectors',
        'view_galleries',
        'approve_art_community',
        'ban_art_community',
        'delete_art_community',
        'login_as_art_community',
    ];

    public function up(): void
    {
        if (! Schema::hasTable('permissions')) {
            return;
        }

        $now = now();
        $permissionIds = [];

        foreach ($this->permissions as $name) {
            $existing = DB::table('permissions')->where('name', $name)->where('guard_name', 'web')->first();

            if ($existing) {
                $permissionIds[] = $existing->id;
                continue;
            }

            $permissionIds[] = DB::table('permissions')->insertGetId([
                'name'       => $name,
                'section'    => 'art_community',
                'guard_name' => 'web',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        if (! Schema::hasTable('role_has_permissions') || ! Schema::hasTable('roles')) {
            return;
        }

        // Attach to Super Admin + Admin (any admin role covering the panel)
        $roleIds = DB::table('roles')
            ->whereIn('name', ['Super Admin', 'Admin'])
            ->pluck('id')
            ->all();

        foreach ($roleIds as $roleId) {
            foreach ($permissionIds as $permId) {
                $linked = DB::table('role_has_permissions')
                    ->where('role_id', $roleId)
                    ->where('permission_id', $permId)
                    ->exists();

                if (! $linked) {
                    DB::table('role_has_permissions')->insert([
                        'role_id'       => $roleId,
                        'permission_id' => $permId,
                    ]);
                }
            }
        }

        try {
            app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        } catch (\Throwable $e) {
            // permission cache not resolvable in this context — will refresh on next request
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('permissions')) {
            return;
        }

        $ids = DB::table('permissions')->whereIn('name', $this->permissions)->pluck('id')->all();

        if ($ids && Schema::hasTable('role_has_permissions')) {
            DB::table('role_has_permissions')->whereIn('permission_id', $ids)->delete();
        }

        DB::table('permissions')->whereIn('name', $this->permissions)->delete();
    }
};
