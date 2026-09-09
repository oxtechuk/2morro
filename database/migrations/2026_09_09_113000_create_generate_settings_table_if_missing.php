<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('generate_settings')) {
            Schema::create('generate_settings', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable()->default('2morro Store');
                $table->string('title')->nullable()->default('2morro');
                $table->unsignedBigInteger('logo_id')->nullable();
                $table->unsignedBigInteger('favicon_id')->nullable();
                $table->string('mobile')->nullable();
                $table->string('email')->nullable();
                $table->string('address')->nullable();
                $table->string('google_playstore_url')->nullable();
                $table->string('app_store_url')->nullable();
                $table->unsignedBigInteger('app_logo_id')->nullable();
                $table->boolean('show_download_app')->default(true);
                $table->string('admin_login_img')->nullable();
                $table->string('shop_login_img')->nullable();
                $table->boolean('show_sku')->default(0);
                $table->string('primary_color')->default('#2563ea');
                $table->string('secondary_color')->default('#eff6ff');
                $table->string('business_based_on')->default('commission');
                $table->float('commission')->default(10);
                $table->string('commission_type')->nullable()->default('percentage');
                $table->string('commission_charge')->default('per_order');
                $table->boolean('shop_pos')->default(1);
                $table->boolean('shop_register')->default(1);
                $table->string('shop_type')->nullable()->default('single');
                $table->boolean('new_product_approval')->default(1);
                $table->boolean('update_product_approval')->default(1);
                $table->float('min_withdraw')->nullable();
                $table->float('max_withdraw')->nullable();
                $table->integer('withdraw_request')->nullable();
                $table->string('currency')->nullable()->default('ج.م');
                $table->string('currency_position')->nullable()->default('suffix');
                $table->string('direction')->nullable()->default('rtl');
                $table->string('footer_text')->nullable();
                $table->boolean('show_footer')->default(true);
                $table->string('footer_phone')->nullable();
                $table->string('footer_email')->nullable();
                $table->string('footer_description')->nullable();
                $table->unsignedBigInteger('footer_logo_id')->nullable();
                $table->unsignedBigInteger('footer_qrcode_id')->nullable();
                $table->float('default_delivery_charge')->default(0);
                $table->boolean('cash_on_delivery')->default(1);
                $table->boolean('online_payment')->default(1);
                $table->string('product_description')->nullable();
                $table->string('page_description')->nullable();
                $table->string('blog_description')->nullable();
                // Top Header Fields
                $table->boolean('show_top_header')->default(false);
                $table->string('top_header_text')->nullable();
                $table->string('top_header_bg_color')->default('#2563ea');
                $table->string('top_header_text_color')->default('#ffffff');
                $table->string('top_header_link')->nullable();
                // Custom Payment Methods
                $table->boolean('instapay_enabled')->default(0);
                $table->string('instapay_address')->nullable();
                $table->unsignedBigInteger('instapay_logo_id')->nullable();
                $table->boolean('vodafone_cash_enabled')->default(0);
                $table->string('vodafone_cash_number')->nullable();
                $table->unsignedBigInteger('vodafone_cash_logo_id')->nullable();
                $table->boolean('bank_transfer_enabled')->default(0);
                $table->string('bank_name')->nullable();
                $table->string('bank_account_name')->nullable();
                $table->string('bank_iban')->nullable();
                $table->unsignedBigInteger('bank_transfer_logo_id')->nullable();
                $table->unsignedBigInteger('cash_on_delivery_logo_id')->nullable();
                $table->timestamps();
            });

            // Insert default row
            DB::table('generate_settings')->insert([
                'name' => '2morro Store',
                'title' => '2morro Store',
                'shop_type' => 'single',
                'currency' => 'ج.م',
                'currency_position' => 'suffix',
                'direction' => 'rtl',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('generate_settings');
    }
};
