<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (!Schema::hasColumn('categories', 'status')) {
                    $table->boolean('status')->default(true)->after('is_active');
                }
                if (!Schema::hasColumn('categories', 'parent_id')) {
                    $table->unsignedBigInteger('parent_id')->nullable()->after('id')->index();
                }
            });

            // Sync status with is_active if both exist
            if (Schema::hasColumn('categories', 'is_active') && Schema::hasColumn('categories', 'status')) {
                DB::table('categories')->whereNotNull('is_active')->update([
                    'status' => DB::raw('`is_active`')
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('categories')) {
            Schema::table('categories', function (Blueprint $table) {
                if (Schema::hasColumn('categories', 'status')) {
                    $table->dropColumn('status');
                }
                if (Schema::hasColumn('categories', 'parent_id')) {
                    $table->dropColumn('parent_id');
                }
            });
        }
    }
};
