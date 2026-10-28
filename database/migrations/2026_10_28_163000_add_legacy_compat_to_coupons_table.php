<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            if (!Schema::hasColumn('coupons', 'type')) {
                $table->string('type', 20)->nullable()->after('discount_type');
            }
            if (!Schema::hasColumn('coupons', 'min_amount')) {
                $table->decimal('min_amount', 10, 2)->default(0.00)->after('min_order_amount');
            }
            if (!Schema::hasColumn('coupons', 'started_at')) {
                $table->dateTime('started_at')->nullable()->after('start_date');
            }
            if (!Schema::hasColumn('coupons', 'expired_at')) {
                $table->dateTime('expired_at')->nullable()->after('expired_date');
            }
            if (!Schema::hasColumn('coupons', 'shop_id')) {
                $table->foreignId('shop_id')->nullable()->after('total_used');
            }
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn(['type', 'min_amount', 'started_at', 'expired_at', 'shop_id']);
        });
    }
};
