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
        if (Schema::hasTable('orders') && !Schema::hasColumn('orders', 'pos_order')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->boolean('pos_order')->default(false)->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'pos_order')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('pos_order');
            });
        }
    }
};
