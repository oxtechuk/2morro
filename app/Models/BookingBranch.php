<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingBranch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'address',
        'phone',
        'is_online',
        'price',
        'available_days',
        'time_slots',
        'is_active',
        'sort_order',
        'notes',
    ];

    protected $casts = [
        'is_online' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'available_days' => 'array',
        'time_slots' => 'array',
        'sort_order' => 'integer',
    ];

    public static array $allDays = [
        'Saturday' => 'السبت',
        'Sunday' => 'الأحد',
        'Monday' => 'الاثنين',
        'Tuesday' => 'الثلاثاء',
        'Wednesday' => 'الأربعاء',
        'Thursday' => 'الخميس',
        'Friday' => 'الجمعة',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'booking_branch_id');
    }

    /**
     * Get array of days ensuring fallback
     */
    public function getDaysListAttribute(): array
    {
        if (is_array($this->available_days)) {
            return $this->available_days;
        }
        if (is_string($this->available_days)) {
            $decoded = json_decode($this->available_days, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            return array_map('trim', explode(',', $this->available_days));
        }
        return ['السبت', 'الأحد', 'الاثنين', 'الثلاثاء', 'الأربعاء', 'الخميس'];
    }

    /**
     * Get array of time slots ensuring fallback
     */
    public function getSlotsListAttribute(): array
    {
        if (is_array($this->time_slots)) {
            return $this->time_slots;
        }
        if (is_string($this->time_slots)) {
            $decoded = json_decode($this->time_slots, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            return array_map('trim', explode(',', $this->time_slots));
        }
        return [
            '12:00 PM - 02:00 PM',
            '02:00 PM - 04:00 PM',
            '04:00 PM - 06:30 PM',
            '06:30 PM - 09:00 PM',
        ];
    }
}
