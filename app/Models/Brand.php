<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'link',
        'filter_keyword',
        'row',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getTargetUrlAttribute(): string
    {
        if ($this->link) {
            return $this->link;
        }

        if ($this->filter_keyword) {
            return route('search', ['q' => $this->filter_keyword]);
        }

        return route('search', ['brand' => $this->slug]);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($brand) {
            if (empty($brand->slug)) {
                $brand->slug = Str::slug($brand->name) . '-' . rand(100, 999);
            }
        });
    }
}
