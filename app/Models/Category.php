<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected static function booted()
    {
        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name) ?: 'cat-' . time();
            } else {
                $category->slug = Str::slug($category->slug);
            }
            $baseSlug = $category->slug ?: 'cat-' . time();
            $slug = $baseSlug;
            $count = 1;
            while (static::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }
            $category->slug = $slug;
        });

        static::updating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name) ?: 'cat-' . $category->id;
            } else {
                $category->slug = Str::slug($category->slug);
            }
            if ($category->isDirty('slug')) {
                $baseSlug = $category->slug ?: 'cat-' . $category->id;
                $slug = $baseSlug;
                $count = 1;
                while (static::where('slug', $slug)->where('id', '!=', $category->id)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }
                $category->slug = $slug;
            }
        });
    }

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
