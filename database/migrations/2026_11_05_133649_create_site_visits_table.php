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
        Schema::create('site_visits', function (Blueprint $table) {
            $table->id();
            $table->string('ip_hash', 64)->nullable()->index();
            $table->text('url');
            $table->string('path', 255)->index();
            $table->string('route_name', 100)->nullable()->index();
            $table->string('page_type', 50)->default('page')->index(); // home, product, doctor_video, booking, search, checkout
            $table->unsignedBigInteger('entity_id')->nullable()->index();
            $table->text('referer')->nullable();
            $table->string('source', 50)->default('direct')->index(); // facebook, tiktok, google, instagram, whatsapp, linktree, direct, other
            $table->string('utm_source', 100)->nullable();
            $table->string('utm_medium', 100)->nullable();
            $table->string('utm_campaign', 100)->nullable();
            $table->string('device_type', 20)->default('mobile')->index(); // mobile, desktop, tablet
            $table->string('browser', 50)->nullable();
            $table->string('platform', 50)->nullable();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('created_at')->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_visits');
    }
};
