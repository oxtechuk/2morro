<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('coupons')) {
            Schema::create('coupons', function (Blueprint $table) {
                $table->id();
                $table->string('code', 50)->unique();
                $table->string('discount_type', 20)->default('percentage'); // percentage, fixed
                $table->decimal('discount', 10, 2);
                $table->decimal('min_order_amount', 10, 2)->default(0.00);
                $table->decimal('max_discount_amount', 10, 2)->nullable();
                $table->date('start_date')->nullable();
                $table->date('expired_date')->nullable();
                $table->integer('limit_for_user')->default(1)->nullable();
                $table->integer('total_usage_limit')->nullable();
                $table->integer('total_used')->default(0);
                $table->string('applies_to', 20)->default('all'); // all, category, product
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('coupon_category')) {
            Schema::create('coupon_category', function (Blueprint $table) {
                $table->foreignId('coupon_id')->constrained()->cascadeOnDelete();
                $table->foreignId('category_id')->constrained()->cascadeOnDelete();
                $table->primary(['coupon_id', 'category_id']);
            });
        }

        if (!Schema::hasTable('coupon_product')) {
            Schema::create('coupon_product', function (Blueprint $table) {
                $table->foreignId('coupon_id')->constrained()->cascadeOnDelete();
                $table->foreignId('product_id')->constrained()->cascadeOnDelete();
                $table->primary(['coupon_id', 'product_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('coupon_product');
        Schema::dropIfExists('coupon_category');
        Schema::dropIfExists('coupons');
    }
};
