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
        'notes',
        'status',
        'admin_notes',
        'created_by_admin',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'created_by_admin' => 'boolean',
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

    // Arabic mapping for Branches
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getServiceTypeLabelAttribute(): string
    {
        return self::$services[$this->service_type] ?? $this->service_type;
    }

    public function getBranchLabelAttribute(): string
    {
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
