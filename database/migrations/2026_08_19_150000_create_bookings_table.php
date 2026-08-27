<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_number')->unique()->index();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Client & Child Details
            $table->string('parent_name');
            $table->string('parent_phone');
            $table->string('parent_email')->nullable();
            $table->string('child_name');
            $table->string('child_age');
            
            // Service & Appointment Details
            $table->string('service_type'); // e.g. 'general_evaluation', 'speech', 'behavior', 'early_intervention', 'iq_test', 'autism', 'adhd', 'learning_diff'
            $table->string('session_format')->default('in_center'); // 'in_center', 'online'
            $table->string('branch')->default('ibrahimiya'); // 'ibrahimiya', 'bitash', 'sidi_beshr', 'online'
            $table->date('booking_date');
            $table->string('booking_time'); // e.g. '12:00 PM', '04:00 PM', '07:30 PM'
            
            // Status & Notes
            $table->text('notes')->nullable();
            $table->string('status')->default('pending'); // 'pending', 'confirmed', 'completed', 'cancelled'
            $table->text('admin_notes')->nullable();
            $table->boolean('created_by_admin')->default(false);
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
