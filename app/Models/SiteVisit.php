<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class SiteVisit extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Determine traffic source from Referer and UTMs.
     */
    public static function detectSource(?string $referer, ?string $utmSource): string
    {
        if (!empty($utmSource)) {
            $utm = strtolower($utmSource);
            if (Str::contains($utm, ['fb', 'facebook', 'meta'])) return 'facebook';
            if (Str::contains($utm, ['ig', 'instagram'])) return 'instagram';
            if (Str::contains($utm, ['tiktok', 'tik_tok', 'tt'])) return 'tiktok';
            if (Str::contains($utm, ['google', 'cpc', 'organic'])) return 'google';
            if (Str::contains($utm, ['youtube', 'yt'])) return 'youtube';
            if (Str::contains($utm, ['wa', 'whatsapp'])) return 'whatsapp';
            if (Str::contains($utm, ['linktree'])) return 'linktree';
            return Str::limit($utm, 40);
        }

        if (empty($referer)) {
            return 'direct';
        }

        $host = parse_url($referer, PHP_URL_HOST) ?? '';
        $host = strtolower($host);

        if (Str::contains($host, ['facebook.com', 'fb.com', 'fb.me', 'm.facebook.com'])) return 'facebook';
        if (Str::contains($host, ['instagram.com', 'ig.me'])) return 'instagram';
        if (Str::contains($host, ['tiktok.com'])) return 'tiktok';
        if (Str::contains($host, ['google.'])) return 'google';
        if (Str::contains($host, ['youtube.com', 'youtu.be'])) return 'youtube';
        if (Str::contains($host, ['whatsapp.com', 'wa.me'])) return 'whatsapp';
        if (Str::contains($host, ['linktr.ee'])) return 'linktree';
        if (Str::contains($host, ['twitter.com', 'x.com'])) return 'x_twitter';
        if (Str::contains($host, ['bing.com'])) return 'bing';

        return 'referral';
    }

    /**
     * Determine device type from User-Agent.
     */
    public static function detectDevice(string $userAgent): string
    {
        $ua = strtolower($userAgent);

        if (Str::contains($ua, ['ipad', 'tablet', 'kindle', 'playbook', 'silk'])) {
            return 'tablet';
        }

        if (Str::contains($ua, ['mobile', 'android', 'iphone', 'ipod', 'blackberry', 'opera mini', 'windows phone'])) {
            return 'mobile';
        }

        return 'desktop';
    }

    /**
     * Determine browser from User-Agent.
     */
    public static function detectBrowser(string $userAgent): string
    {
        $ua = strtolower($userAgent);

        if (Str::contains($ua, ['edg', 'edge'])) return 'Edge';
        if (Str::contains($ua, ['chrome', 'crios']) && !Str::contains($ua, ['edg', 'opr', 'opera'])) return 'Chrome';
        if (Str::contains($ua, ['safari']) && !Str::contains($ua, ['chrome', 'crios', 'android'])) return 'Safari';
        if (Str::contains($ua, ['firefox', 'fxios'])) return 'Firefox';
        if (Str::contains($ua, ['opr', 'opera'])) return 'Opera';
        if (Str::contains($ua, ['samsungbrowser'])) return 'Samsung Internet';

        return 'Other';
    }
}

