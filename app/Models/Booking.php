<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_number',
        'user_id',
        'booking_branch_id',
        'parent_name',
        'parent_phone',
        'parent_email',
        'child_name',
        'child_age',
        'service_type',
        'session_format',
        'branch',
        'booking_date',
        'booking_time',
        'price',
        'payment_method',
        'payment_status',
        'payment_receipt',
        'payment_reference',
        'notes',
        'status',
        'admin_notes',
        'created_by_admin',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'created_by_admin' => 'boolean',
        'price' => 'decimal:2',
    ];

    // Arabic mapping for Service Types
    public static array $services = [
        'general_evaluation' => 'تقييم واستشارة شاملة لتنمية المهارات',
        'speech' => 'جلسات تخاطب وتنمية لغة ونطق',
        'early_intervention' => 'جلسات تدخل مبكر وتأهيل',
        'behavior' => 'جلسات تعديل سلوك وتنمية مهارات',
        'iq_test' => 'تطبيق اختبار ذكاء معتمد ومقنن',
        'autism' => 'تأهيل ورعاية أطفال طيف التوحد',
        'adhd' => 'جلسات فرط حركة وتشتت انتباه (ADHD)',
        'learning_diff' => 'جلسات صعوبات تعلم وتأسيس أكاديمي',
        'down_syndrome' => 'جلسات تأهيل متلازمة داون',
        'stuttering' => 'جلسات علاج التأتأة والتهتهة واللدغات',
    ];

    // Arabic mapping for Branches (fallback)
    public static array $branches = [
        'ibrahimiya' => 'فرع الإبراهيمية (أول لاجتيه من شارع أبو قير)',
        'bitash' => 'فرع أول البيطاش (أمام بنك القاهرة - عمارة مركز القلب)',
        'sidi_beshr' => 'فرع سيدي بشر (أول نفق جمال عبد الناصر فوق رؤية سكان)',
        'online' => 'استشارة وتقييم أونلاين عن بُعد (Online Zoom / WhatsApp)',
    ];

    // Formats
    public static array $formats = [
        'in_center' => 'في المركز (عادي)',
        'in_center_normal' => 'في المركز (عادي)',
        'in_center_urgent' => 'في المركز (مستعجل)',
        'online' => 'أونلاين عن بُعد (Zoom)',
    ];

    // Statuses
    public static array $statuses = [
        'pending' => 'قيد الانتظار والمراجعة',
        'confirmed' => 'مؤكد ومجدول',
        'completed' => 'تمت الجلسة بنجاح',
        'cancelled' => 'ملغي',
    ];

    // Payment Methods
    public static array $paymentMethods = [
        'vodafone_cash' => 'فودافون كاش (Vodafone Cash)',
        'instapay' => 'إنستاباي (InstaPay)',
        'bank_transfer' => 'تحويل بنكي',
        'at_center' => 'الدفع في مقر المركز',
    ];

    // Payment Statuses
    public static array $paymentStatuses = [
        'pending' => 'قيد مراجعة التحويل',
        'paid' => 'تم الدفع وتأكيد الإيصال',
        'at_center' => 'الدفع عند الحضور',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookingBranch()
    {
        return $this->belongsTo(BookingBranch::class, 'booking_branch_id');
    }

    public function getServiceTypeLabelAttribute(): string
    {
        return self::$services[$this->service_type] ?? $this->service_type;
    }

    public function getBranchLabelAttribute(): string
    {
        if ($this->bookingBranch) {
            return $this->bookingBranch->name . ($this->bookingBranch->address ? ' (' . $this->bookingBranch->address . ')' : '');
        }
        return self::$branches[$this->branch] ?? $this->branch;
    }

    public function getSessionFormatLabelAttribute(): string
    {
        return self::$formats[$this->session_format] ?? $this->session_format;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::$statuses[$this->status] ?? $this->status;
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return self::$paymentMethods[$this->payment_method] ?? ($this->payment_method ?: 'لم يحدد');
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return self::$paymentStatuses[$this->payment_status] ?? $this->payment_status;
    }

    public function getPaymentStatusBadgeAttribute(): string
    {
        return match ($this->payment_status) {
            'paid' => 'bg-success text-white',
            'at_center' => 'bg-info text-white',
            default => 'bg-warning text-dark',
        };
    }

    public function getReceiptUrlAttribute(): ?string
    {
        if (!$this->payment_receipt) {
            return null;
        }
        if (str_starts_with($this->payment_receipt, 'http')) {
            return $this->payment_receipt;
        }
        return asset('storage/' . $this->payment_receipt);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'confirmed' => 'bg-success text-white',
            'completed' => 'bg-primary text-white',
            'cancelled' => 'bg-danger text-white',
            default => 'bg-warning text-dark',
        };
    }

    /**
     * Retrieve complete schedule, calendar days, slots, and pricing configuration for all 3 booking types.
     */
    public static function getScheduleConfig(): array
    {
        $defaultDays = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];
        $defaultSlots = [
            '12:00 PM - 02:00 PM',
            '02:00 PM - 04:00 PM',
            '04:00 PM - 06:30 PM',
            '06:30 PM - 09:00 PM',
        ];

        $decodeArray = function ($value, $fallback = []) {
            if (is_array($value)) return $value;
            if (is_string($value) && strlen(trim($value)) > 0) {
                $json = json_decode($value, true);
                if (is_array($json)) return $json;
                return array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $value))));
            }
            return $fallback;
        };

        return [
            'normal' => [
                'key' => 'normal',
                'name' => 'حجز عادي ',
                'badge' => 'مجدول',
                'enabled' => Setting::get('booking_normal_enabled', '1') === '1',
                'price' => (float) Setting::get('booking_normal_price', '300.00'),
                'desc' => Setting::get('booking_normal_desc', 'حضور في مقر المركز ومقابلة مباشرة وفق جدول الفترات المعتمدة'),
                'days' => $decodeArray(Setting::get('booking_normal_days'), $defaultDays),
                'slots' => $decodeArray(Setting::get('booking_normal_slots'), $defaultSlots),
                'slot_capacity' => (int) Setting::get('booking_normal_slot_capacity', 1),
                'specific_dates' => $decodeArray(Setting::get('booking_normal_specific_dates'), []),
                'off_dates' => $decodeArray(Setting::get('booking_normal_off_dates'), []),
            ],
            'urgent' => [
                'key' => 'urgent',
                'name' => 'حجز مستعجل (طوارئ)',
                'badge' => 'مستعجل ',
                'enabled' => Setting::get('booking_urgent_enabled', '1') === '1',
                'price' => (float) Setting::get('booking_urgent_price', (float)Setting::get('booking_normal_price', '300.00') + (float)Setting::get('booking_urgent_fee', '150.00')),
                'desc' => Setting::get('booking_urgent_desc', 'كشف ومقابلة ذات أولوية قصوى خلال 24 إلى 48 ساعة'),
                'days' => $decodeArray(Setting::get('booking_urgent_days'), $defaultDays),
                'slots' => $decodeArray(Setting::get('booking_urgent_slots'), [
                    '10:00 AM - 11:30 AM',
                    '01:00 PM - 02:30 PM',
                    '08:00 PM - 09:30 PM',
                ]),
                'slot_capacity' => (int) Setting::get('booking_urgent_slot_capacity', 1),
                'max_days_ahead' => (int) Setting::get('booking_urgent_max_days_ahead', 2),
                'specific_dates' => $decodeArray(Setting::get('booking_urgent_specific_dates'), []),
                'off_dates' => $decodeArray(Setting::get('booking_urgent_off_dates'), []),
            ],
            'online' => [
                'key' => 'online',
                'name' => 'استشارة أونلاين (عن بُعد)',
                'badge' => 'عن بُعد ',
                'enabled' => Setting::get('booking_online_enabled', '1') === '1',
                'price' => (float) Setting::get('booking_online_price', '350.00'),
                'desc' => Setting::get('booking_online_desc', 'جلسة تقييم واستشارة بالفيديو عن بُعد عبر Zoom / Google Meet'),
                'days' => $decodeArray(Setting::get('booking_online_days'), ['Saturday', 'Sunday', 'Tuesday', 'Thursday', 'Friday']),
                'slots' => $decodeArray(Setting::get('booking_online_slots'), [
                    '04:00 PM - 05:00 PM',
                    '05:00 PM - 06:00 PM',
                    '06:00 PM - 07:00 PM',
                    '07:00 PM - 08:00 PM',
                    '08:00 PM - 09:00 PM',
                ]),
                'slot_capacity' => (int) Setting::get('booking_online_slot_capacity', 1),
                'platform' => Setting::get('booking_online_platform', 'Zoom / Google Meet'),
                'specific_dates' => $decodeArray(Setting::get('booking_online_specific_dates'), []),
                'off_dates' => $decodeArray(Setting::get('booking_online_off_dates'), []),
            ],
        ];
    }

    /**
     * Check how many bookings are already confirmed or pending for a given date and format.
     */
    public static function getBookedSlotsCount(string $date, string $sessionFormat): array
    {
        return self::whereDate('booking_date', $date)
            ->where(function ($q) use ($sessionFormat) {
                if ($sessionFormat === 'normal' || $sessionFormat === 'in_center_normal' || $sessionFormat === 'in_center') {
                    $q->whereIn('session_format', ['normal', 'in_center_normal', 'in_center']);
                } elseif ($sessionFormat === 'urgent' || $sessionFormat === 'in_center_urgent') {
                    $q->whereIn('session_format', ['urgent', 'in_center_urgent']);
                } else {
                    $q->where('session_format', $sessionFormat);
                }
            })
            ->whereIn('status', ['pending', 'confirmed'])
            ->selectRaw('booking_time, count(*) as count')
            ->groupBy('booking_time')
            ->pluck('count', 'booking_time')
            ->toArray();
    }
}
