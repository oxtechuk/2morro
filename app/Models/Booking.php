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
        'in_center' => 'في مقر المركز',
        'online' => 'أونلاين عن بُعد',
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
}
