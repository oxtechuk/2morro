<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('segment')->default('parent'); // parent, specialist, nursery, school
            $table->text('admin_notes')->nullable(); // ملاحظات إدارية عامة
            $table->integer('loyalty_points')->default(0); // نقاط ولاء العميل
            $table->timestamp('last_contacted_at')->nullable(); // آخر تواصل مع العميل
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_profiles');
    }
};
