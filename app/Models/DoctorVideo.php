<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DoctorVideo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_paid' => 'boolean',
        'is_published' => 'boolean',
        'price' => 'decimal:2',
        'preview_seconds' => 'integer',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'order_index' => 'integer',
    ];

    /**
     * Boot model to automatically generate slug.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($video) {
            if (empty($video->slug)) {
                $baseSlug = Str::slug($video->title);
                if (empty($baseSlug)) {
                    $baseSlug = 'video-' . time();
                }
                $slug = $baseSlug;
                $counter = 1;
                while (static::where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $counter++;
                }
                $video->slug = $slug;
            }
        });
    }

    /**
     * Target Age Group Relationship
     */
    public function ageGroup()
    {
        return $this->belongsTo(AgeGroup::class);
    }

    /**
     * Target Need / Problem Condition Relationship
     */
    public function need()
    {
        return $this->belongsTo(Need::class);
    }

    /**
     * Related Products recommended for this condition
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'doctor_video_products');
    }

    /**
     * Users who bought access to this video
     */
    public function buyers()
    {
        return $this->belongsToMany(User::class, 'doctor_video_access')
                    ->withPivot('price_paid', 'order_id')
                    ->withTimestamps();
    }

    /**
     * Check if a specific user has purchased / unlocked access
     */
    public function hasUserAccess(?User $user = null): bool
    {
        // 1. Free videos are accessible to everyone
        if (!$this->is_paid || (float)$this->price <= 0) {
            return true;
        }

        // 2. Unauthenticated users don't have access to paid videos
        if (!$user) {
            return false;
        }

        // 3. Admin users always have access
        if (method_exists($user, 'isAdmin') && $user->isAdmin()) {
            return true;
        }

        // 4. Check if user exists in the access table
        return $this->buyers()->where('user_id', $user->id)->exists();
    }

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeReels($query)
    {
        return $query->where('video_type', 'reel');
    }

    public function scopeStandard($query)
    {
        return $query->where('video_type', 'standard');
    }

    public function scopeFree($query)
    {
        return $query->where('is_paid', false);
    }

    public function scopePaid($query)
    {
        return $query->where('is_paid', true);
    }

    /**
     * Accessor for full video URL
     */
    public function getVideoUrlAttribute(): ?string
    {
        if (empty($this->video_path)) {
            return null;
        }

        if (Str::startsWith($this->video_path, ['http://', 'https://'])) {
            return $this->video_path;
        }

        return asset('storage/' . ltrim($this->video_path, '/'));
    }

    /**
     * Accessor for full thumbnail URL
     */
    public function getThumbnailUrlAttribute(): string
    {
        if (!empty($this->thumbnail)) {
            if (Str::startsWith($this->thumbnail, ['http://', 'https://'])) {
                return $this->thumbnail;
            }
            return asset('storage/' . ltrim($this->thumbnail, '/'));
        }

        // Fallback default placeholder
        return asset('assets/icons-admin/video.svg');
    }

    /**
     * Parse YouTube ID / Embed URL if applicable
     */
    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        if ($this->video_source !== 'youtube' && !Str::contains($this->video_path ?? '', ['youtube.com', 'youtu.be'])) {
            return null;
        }

        $url = $this->video_path;
        $videoId = null;

        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $match)) {
            $videoId = $match[1];
        }

        return $videoId ? "https://www.youtube-nocookie.com/embed/{$videoId}" : null;
    }
}

