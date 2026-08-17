<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'type',
        'details',
    ];

    // Log types in Arabic
    public static array $types = [
        'note' => 'ملاحظة',
        'call' => 'مكالمة هاتفية',
        'whatsapp' => 'واتساب',
        'email' => 'بريد إلكتروني',
        'system' => 'تحديث نظام',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function getTypeLabelAttribute(): string
    {
        return self::$types[$this->type] ?? $this->type;
    }

    public function getTypeIconAttribute(): string
    {
        return match ($this->type) {
            'call' => 'ph-phone',
            'whatsapp' => 'ph-whatsapp-logo',
            'email' => 'ph-envelope-simple',
            'system' => 'ph-gear-six',
            default => 'ph-note',
        };
    }
}
