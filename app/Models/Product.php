<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'price',
        'sale_price',
        'sku',
        'type', // physical, digital, course, session
        'stock',
        'digital_file_path',
        'digital_file_name',
        'digital_download_limit',
        'digital_expiry_days',
        'video_url',
        'benefits',
        'how_to_use',
        'whats_included',
        'suitable_for',
        'badge',
        'images',
        'is_active',
    ];

    protected $casts = [
        'benefits' => 'array',
        'how_to_use' => 'array',
        'images' => 'array',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
        'stock' => 'integer',
        'digital_download_limit' => 'integer',
        'digital_expiry_days' => 'integer',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function ageGroups()
    {
        return $this->belongsToMany(AgeGroup::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function needs()
    {
        return $this->belongsToMany(Need::class);
    }

    // A bundle contains many products
    public function products()
    {
        return $this->belongsToMany(Product::class, 'bundle_product', 'bundle_id', 'product_id')
            ->withPivot('quantity');
    }

    // A product can be in many bundles
    public function bundles()
    {
        return $this->belongsToMany(Product::class, 'bundle_product', 'product_id', 'bundle_id')
            ->withPivot('quantity');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Helper helper to get current price (considering sale)
    public function getActivePriceAttribute()
    {
        return $this->sale_price !== null ? $this->sale_price : $this->price;
    }
}
