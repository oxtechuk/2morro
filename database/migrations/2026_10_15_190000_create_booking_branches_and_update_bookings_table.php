<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create booking_branches table
        if (!Schema::hasTable('booking_branches')) {
            Schema::create('booking_branches', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // e.g. فرع الإبراهيمية
                $table->string('slug')->unique(); // e.g. ibrahimiya
                $table->string('address')->nullable();
                $table->string('phone')->nullable();
                $table->boolean('is_online')->default(false);
                $table->decimal('price', 10, 2)->default(300.00);
                $table->text('available_days')->nullable(); // JSON array of active days
                $table->text('time_slots')->nullable(); // JSON array of time slot strings
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->text('notes')->nullable();
                $table->timestamps();
            });

            // Seed default branches
            $defaultDays = json_encode(['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس'], JSON_UNESCAPED_UNICODE);
            $defaultSlots = json_encode([
                '12:00 PM - 02:00 PM',
                '02:00 PM - 04:00 PM',
                '04:00 PM - 06:30 PM',
                '06:30 PM - 09:00 PM'
            ], JSON_UNESCAPED_UNICODE);

            DB::table('booking_branches')->insert([
                [
                    'name' => 'فرع الإبراهيمية',
                    'slug' => 'ibrahimiya',
                    'address' => 'أول لاجتيه من شارع أبو قير - الإسكندرية',
                    'phone' => '01550504512',
                    'is_online' => false,
                    'price' => 300.00,
                    'available_days' => $defaultDays,
                    'time_slots' => $defaultSlots,
                    'is_active' => true,
                    'sort_order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'فرع أول البيطاش',
                    'slug' => 'bitash',
                    'address' => 'أمام بنك القاهرة - عمارة مركز القلب - العجمي',
                    'phone' => '01550504512',
                    'is_online' => false,
                    'price' => 300.00,
                    'available_days' => $defaultDays,
                    'time_slots' => $defaultSlots,
                    'is_active' => true,
                    'sort_order' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'فرع سيدي بشر',
                    'slug' => 'sidi_beshr',
                    'address' => 'أول نفق جمال عبد الناصر فوق رؤية سكان - الإسكندرية',
                    'phone' => '01550504512',
                    'is_online' => false,
                    'price' => 350.00,
                    'available_days' => $defaultDays,
                    'time_slots' => $defaultSlots,
                    'is_active' => true,
                    'sort_order' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'استشارة وتقييم أونلاين عن بُعد',
                    'slug' => 'online',
                    'address' => 'عبر تطبيق Zoom / WhatsApp مباشرة مع الأخصائي',
                    'phone' => '01550504512',
                    'is_online' => true,
                    'price' => 250.00,
                    'available_days' => $defaultDays,
                    'time_slots' => $defaultSlots,
                    'is_active' => true,
                    'sort_order' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        // 2. Add columns to bookings table
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'booking_branch_id')) {
                $table->foreignId('booking_branch_id')->nullable()->after('branch')->constrained('booking_branches')->nullOnDelete();
            }
            if (!Schema::hasColumn('bookings', 'price')) {
                $table->decimal('price', 10, 2)->default(0)->after('booking_time');
            }
            if (!Schema::hasColumn('bookings', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('price'); // vodafone_cash, instapay, bank_transfer, at_center
            }
            if (!Schema::hasColumn('bookings', 'payment_status')) {
                $table->string('payment_status')->default('pending')->after('payment_method'); // pending, paid, at_center
            }
            if (!Schema::hasColumn('bookings', 'payment_receipt')) {
                $table->string('payment_receipt')->nullable()->after('payment_status');
            }
            if (!Schema::hasColumn('bookings', 'payment_reference')) {
                $table->string('payment_reference')->nullable()->after('payment_receipt');
            }
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn([
                'booking_branch_id',
                'price',
                'payment_method',
                'payment_status',
                'payment_receipt',
                'payment_reference',
            ]);
        });

        Schema::dropIfExists('booking_branches');
    }
};
