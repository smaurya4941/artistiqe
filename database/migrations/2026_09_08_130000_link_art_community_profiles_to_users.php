<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

/**
 * Turns the standalone "art community" registration tables
 * (artists / collector_registers / gallery_registers) into 1:1 profile
 * extensions of the users table.
 *
 *  - adds user_id (FK -> users.id) + an approval workflow (status / approved_at /
 *    reviewed_by / rejection_reason) to each table
 *  - back-fills a users row for every existing profile so nothing is orphaned
 *
 * Idempotent and transactional. Run explicitly:
 *   php artisan migrate --path=database/migrations/2026_09_08_130000_link_art_community_profiles_to_users.php
 */
return new class extends Migration
{
    /** table => user_type */
    private array $profiles = [
        'artists'             => 'artist',
        'collector_registers' => 'collector',
        'gallery_registers'   => 'gallery',
    ];

    public function up(): void
    {
        foreach (array_keys($this->profiles) as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $t) use ($table) {
                if (! Schema::hasColumn($table, 'user_id')) {
                    $t->unsignedBigInteger('user_id')->nullable()->after('id');
                }
                if (! Schema::hasColumn($table, 'status')) {
                    $t->enum('status', ['pending', 'approved', 'rejected'])
                        ->default('pending')->after('user_id');
                }
                if (! Schema::hasColumn($table, 'approved_at')) {
                    $t->timestamp('approved_at')->nullable()->after('status');
                }
                if (! Schema::hasColumn($table, 'reviewed_by')) {
                    $t->unsignedBigInteger('reviewed_by')->nullable()->after('approved_at');
                }
                if (! Schema::hasColumn($table, 'rejection_reason')) {
                    $t->text('rejection_reason')->nullable()->after('reviewed_by');
                }
            });

            // unique index + FK (guarded — index/FK names are deterministic)
            $this->addUniqueIndex($table, 'user_id');
            $this->addForeignKey($table, 'user_id');
            $this->addIndex($table, 'status');
        }

        $this->backfillUsers();
    }

    public function down(): void
    {
        foreach (array_keys($this->profiles) as $table) {
            if (! Schema::hasTable($table)) {
                continue;
            }
            foreach (['user_id', 'status', 'approved_at', 'reviewed_by', 'rejection_reason'] as $col) {
                if (Schema::hasColumn($table, $col)) {
                    try {
                        Schema::table($table, function (Blueprint $t) use ($table, $col) {
                            if ($col === 'user_id') {
                                try { $t->dropForeign([$col]); } catch (\Throwable $e) {}
                                try { $t->dropUnique([$col]); } catch (\Throwable $e) {}
                            }
                            if ($col === 'status') {
                                try { $t->dropIndex([$col]); } catch (\Throwable $e) {}
                            }
                            $t->dropColumn($col);
                        });
                    } catch (\Throwable $e) {
                        // column already gone
                    }
                }
            }
        }
    }

    private function backfillUsers(): void
    {
        foreach ($this->profiles as $table => $userType) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            $rows = DB::table($table)->whereNull('user_id')->get();

            foreach ($rows as $row) {
                DB::transaction(function () use ($row, $table, $userType) {
                    $email = $row->email ?? null;
                    $phone = $row->phone ?? null;

                    // Resolve a user by email (identity is the users table)
                    $user = null;
                    if ($email) {
                        $user = DB::table('users')->where('email', $email)->first();
                    }

                    if (! $user) {
                        $userId = DB::table('users')->insertGetId([
                            'name'              => $this->displayName($row, $table),
                            'email'             => $email,
                            'phone'             => $phone,
                            'password'          => $this->resolvePassword($row->password ?? null, $table),
                            'user_type'         => $userType,
                            'email_verified_at' => now(),
                            'created_at'        => $row->created_at ?? now(),
                            'updated_at'        => now(),
                        ]);
                    } else {
                        $userId = $user->id;
                        // Promote a plain customer row to the art-community type; never downgrade admin/seller
                        if (in_array($user->user_type, ['customer'])) {
                            DB::table('users')->where('id', $userId)->update([
                                'user_type'  => $userType,
                                'updated_at' => now(),
                            ]);
                        }
                    }

                    // Existing accounts are grandfathered in as approved
                    DB::table($table)->where('id', $row->id)->update([
                        'user_id'     => $userId,
                        'status'      => 'approved',
                        'approved_at' => now(),
                        'updated_at'  => now(),
                    ]);
                });
            }
        }
    }

    private function displayName(object $row, string $table): string
    {
        if ($table === 'gallery_registers') {
            $name = trim(($row->owner_name ?? '') . ' ' . ($row->owner_surname ?? ''));
        } else {
            $name = trim(($row->first_name ?? '') . ' ' . ($row->last_name ?? ''));
        }
        return $name !== '' ? $name : ($row->email ?? 'Art Community Member');
    }

    private function resolvePassword(?string $stored, string $table): string
    {
        if (! $stored) {
            return Hash::make(str()->random(32)); // unusable; user resets
        }
        // collector_registers / gallery_registers already store bcrypt hashes
        if (preg_match('/^\$2[aby]\$/', $stored)) {
            return $stored;
        }
        // artists historically stored plaintext
        return Hash::make($stored);
    }

    private function addUniqueIndex(string $table, string $column): void
    {
        $name = "{$table}_{$column}_unique";
        if (! $this->indexExists($table, $name)) {
            try {
                Schema::table($table, fn (Blueprint $t) => $t->unique($column, $name));
            } catch (\Throwable $e) {}
        }
    }

    private function addIndex(string $table, string $column): void
    {
        $name = "{$table}_{$column}_index";
        if (! $this->indexExists($table, $name)) {
            try {
                Schema::table($table, fn (Blueprint $t) => $t->index($column, $name));
            } catch (\Throwable $e) {}
        }
    }

    private function addForeignKey(string $table, string $column): void
    {
        $name = "{$table}_{$column}_foreign";
        $exists = DB::selectOne(
            'SELECT 1 AS x FROM information_schema.TABLE_CONSTRAINTS
              WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND CONSTRAINT_NAME = ?',
            [DB::getDatabaseName(), $table, $name]
        );
        if ($exists) {
            return;
        }
        try {
            Schema::table($table, function (Blueprint $t) use ($column, $name) {
                $t->foreign($column, $name)->references('id')->on('users')->nullOnDelete();
            });
        } catch (\Throwable $e) {}
    }

    private function indexExists(string $table, string $indexName): bool
    {
        $row = DB::selectOne(
            'SELECT 1 AS x FROM information_schema.STATISTICS
              WHERE TABLE_SCHEMA = ? AND TABLE_NAME = ? AND INDEX_NAME = ? LIMIT 1',
            [DB::getDatabaseName(), $table, $indexName]
        );
        return (bool) $row;
    }
};
