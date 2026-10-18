<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'customer_id')) {
                    $table->unsignedBigInteger('customer_id')->nullable()->after('user_id');
                }
                if (!Schema::hasColumn('orders', 'shop_id')) {
                    $table->unsignedBigInteger('shop_id')->nullable()->after('id');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'customer_id')) {
                    $table->dropColumn('customer_id');
                }
                if (Schema::hasColumn('orders', 'shop_id')) {
                    $table->dropColumn('shop_id');
                }
            });
        }
    }
};
