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
        Schema::create('doctor_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->enum('video_type', ['reel', 'standard'])->default('standard'); // reel: 9:16 vertical, standard: 16:9
            $table->enum('video_source', ['upload', 'url', 'youtube', 'vimeo'])->default('upload');
            $table->text('video_path')->nullable(); // Local relative path or full URL
            $table->string('thumbnail')->nullable();
            $table->string('duration')->nullable(); // e.g. "03:45"
            $table->foreignId('age_group_id')->nullable()->constrained('age_groups')->nullOnDelete();
            $table->foreignId('need_id')->nullable()->constrained('needs')->nullOnDelete();
            $table->boolean('is_paid')->default(false);
            $table->decimal('price', 10, 2)->default(0);
            $table->unsignedInteger('preview_seconds')->default(0); // Free teaser seconds before paywall
            $table->unsignedBigInteger('views_count')->default(0);
            $table->unsignedBigInteger('likes_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->integer('order_index')->default(0);
            $table->timestamps();
        });

        Schema::create('doctor_video_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_video_id')->constrained('doctor_videos')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->timestamps();
        });

        Schema::create('doctor_video_access', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('doctor_video_id')->constrained('doctor_videos')->cascadeOnDelete();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->decimal('price_paid', 10, 2)->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'doctor_video_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_video_access');
        Schema::dropIfExists('doctor_video_products');
        Schema::dropIfExists('doctor_videos');
    }
};
