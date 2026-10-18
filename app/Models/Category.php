<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function translations(): HasMany
    {
        return $this->hasMany(TranslateUtility::class);
    }

    /**
     * Retrieves the products associated with this instance.
     *
     * @return BelongsToMany The products associated with this instance.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, Schema::hasTable('category_product') ? 'category_product' : 'product_categories');
    }

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class, 'category_id');
    }


     public function subCategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }


    protected static function booted()
    {
        static::saving(function ($category) {
            if (isset($category->is_active) && !isset($category->status)) {
                $category->status = $category->is_active ? 1 : 0;
            } elseif (isset($category->status) && !isset($category->is_active)) {
                $category->is_active = $category->status ? 1 : 0;
            }
        });
    }

    /**
     * Scopes a query to only include active records.
     *
     * @param  mixed  $query  The query parameter.
     * @return mixed The return value.
     */
    public function scopeActive($query)
    {
        if (Schema::hasColumn('categories', 'status')) {
            return $query->where('status', 1);
        }
        if (Schema::hasColumn('categories', 'is_active')) {
            return $query->where('is_active', 1);
        }
        return $query;
    }


    /**
     * Generates a thumbnail attribute for the media.
     *
     * @return Attribute The generated thumbnail attribute.
     */
    public function thumbnail(): Attribute
    {
        $thumbnail = asset('default/default.jpg');
        if ($this->image && Storage::exists($this->image)) {
            $thumbnail = Storage::url($this->image);
        }

        return Attribute::make(
            get: fn () => $thumbnail
        );
    }

    public function attributes(): HasMany
    {
        return $this->hasMany(CategoryAttribute::class, 'category_id')->valid();

    }
}
