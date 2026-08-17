<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crm_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('admin_id')->constrained('users')->onDelete('cascade');
            $table->string('type'); // call, email, whatsapp, note, system
            $table->text('details');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crm_logs');
    }
};
