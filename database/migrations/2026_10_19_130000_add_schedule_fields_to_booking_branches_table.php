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
        if (Schema::hasTable('booking_branches')) {
            Schema::table('booking_branches', function (Blueprint $table) {
                if (!Schema::hasColumn('booking_branches', 'urgent_price')) {
                    $table->decimal('urgent_price', 10, 2)->nullable()->after('price');
                }
                if (!Schema::hasColumn('booking_branches', 'urgent_days')) {
                    $table->text('urgent_days')->nullable()->after('available_days');
                }
                if (!Schema::hasColumn('booking_branches', 'specific_dates')) {
                    $table->text('specific_dates')->nullable()->after('urgent_days');
                }
                if (!Schema::hasColumn('booking_branches', 'urgent_dates')) {
                    $table->text('urgent_dates')->nullable()->after('specific_dates');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('booking_branches')) {
            Schema::table('booking_branches', function (Blueprint $table) {
                $columns = ['urgent_price', 'urgent_days', 'specific_dates', 'urgent_dates'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('booking_branches', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};
