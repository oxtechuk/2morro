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
        if (!Schema::hasTable('order_products')) {
            Schema::create('order_products', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('product_id')->nullable();
                $table->integer('quantity')->default(1);
                $table->decimal('price', 12, 2)->default(0.00);
                $table->string('unit')->nullable();
                $table->string('sku')->nullable();
                $table->timestamps();

                $table->index(['order_id', 'product_id']);
            });

            // If order_items table exists, copy records to order_products
            if (Schema::hasTable('order_items')) {
                try {
                    $items = DB::table('order_items')->get();
                    foreach ($items as $item) {
                        DB::table('order_products')->insert([
                            'order_id' => $item->order_id,
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity ?? 1,
                            'price' => $item->price ?? 0.00,
                            'created_at' => $item->created_at ?? now(),
                            'updated_at' => $item->updated_at ?? now(),
                        ]);
                    }
                } catch (\Throwable $e) {
                    // Ignore data copy error
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Keep table intact to prevent data loss
    }
};
