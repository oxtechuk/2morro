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
        'urgent_price',
        'available_days',
        'urgent_days',
        'specific_dates',
        'urgent_dates',
        'time_slots',
        'is_active',
        'sort_order',
        'notes',
    ];

    protected $casts = [
        'is_online' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'urgent_price' => 'decimal:2',
        'available_days' => 'array',
        'urgent_days' => 'array',
        'specific_dates' => 'array',
        'urgent_dates' => 'array',
        'time_slots' => 'array',
        'sort_order' => 'integer',
    ];

    protected $appends = [
        'days_list',
        'days_english_list',
        'urgent_days_list',
        'urgent_days_english_list',
        'specific_dates_list',
        'urgent_dates_list',
        'slots_list',
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
     * Map days array to Arabic names
     */
    public static function mapToArabicDays(array $days): array
    {
        $map = array_flip(self::$allDays);
        $result = [];
        foreach ($days as $day) {
            $day = trim($day);
            if (isset(self::$allDays[$day])) {
                $result[] = self::$allDays[$day];
            } elseif (isset($map[$day])) {
                $result[] = $day;
            }
        }
        return array_values(array_unique($result));
    }

    /**
     * Map days array to English day keys
     */
    public static function mapToEnglishDays(array $days): array
    {
        $map = array_flip(self::$allDays);
        $result = [];
        foreach ($days as $day) {
            $day = trim($day);
            if (isset($map[$day])) {
                $result[] = $map[$day];
            } elseif (isset(self::$allDays[$day])) {
                $result[] = $day;
            }
        }
        return array_values(array_unique($result));
    }

    /**
     * Get array of days in Arabic
     */
    public function getDaysListAttribute(): array
    {
        $raw = $this->available_days;
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            $raw = is_array($decoded) ? $decoded : array_map('trim', explode(',', $raw));
        }
        if (!is_array($raw) || empty($raw)) {
            $raw = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];
        }
        return self::mapToArabicDays($raw);
    }

    /**
     * Get array of days in English (for calendar comparison)
     */
    public function getDaysEnglishListAttribute(): array
    {
        return self::mapToEnglishDays($this->days_list);
    }

    /**
     * Get urgent days list (Arabic)
     */
    public function getUrgentDaysListAttribute(): array
    {
        $raw = $this->urgent_days;
        if (is_string($raw)) {
            $decoded = json_decode($raw, true);
            $raw = is_array($decoded) ? $decoded : array_map('trim', explode(',', $raw));
        }
        if (!is_array($raw) || empty($raw)) {
            return $this->days_list; // default to normal days
        }
        return self::mapToArabicDays($raw);
    }

    /**
     * Get urgent days in English
     */
    public function getUrgentDaysEnglishListAttribute(): array
    {
        return self::mapToEnglishDays($this->urgent_days_list);
    }

    /**
     * Helper for parsing date lists
     */
    private function parseDateList($field): array
    {
        if (is_array($field)) {
            return array_values(array_filter(array_map('trim', $field)));
        }
        if (is_string($field) && !empty($field)) {
            $decoded = json_decode($field, true);
            if (is_array($decoded)) {
                return array_values(array_filter(array_map('trim', $decoded)));
            }
            return array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $field))));
        }
        return [];
    }

    /**
     * Get specific dates for normal booking in this branch
     */
    public function getSpecificDatesListAttribute(): array
    {
        return $this->parseDateList($this->specific_dates);
    }

    /**
     * Get specific dates for urgent booking in this branch
     */
    public function getUrgentDatesListAttribute(): array
    {
        return $this->parseDateList($this->urgent_dates);
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
