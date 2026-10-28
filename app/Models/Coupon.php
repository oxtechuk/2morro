<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'discount' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'start_date' => 'date',
        'expired_date' => 'date',
        'is_active' => 'boolean',
        'total_used' => 'integer',
        'limit_for_user' => 'integer',
        'total_usage_limit' => 'integer',
    ];

    protected static function booted()
    {
        static::saving(function ($coupon) {
            if (!empty($coupon->discount_type) && empty($coupon->type)) {
                $coupon->type = $coupon->discount_type;
            } elseif (!empty($coupon->type) && empty($coupon->discount_type)) {
                $coupon->discount_type = is_object($coupon->type) ? $coupon->type->value : (string)$coupon->type;
            }

            if (isset($coupon->min_order_amount) && !isset($coupon->min_amount)) {
                $coupon->min_amount = $coupon->min_order_amount;
            } elseif (isset($coupon->min_amount) && !isset($coupon->min_order_amount)) {
                $coupon->min_order_amount = $coupon->min_amount;
            }

            if (!empty($coupon->start_date) && empty($coupon->started_at)) {
                $coupon->started_at = $coupon->start_date;
            } elseif (!empty($coupon->started_at) && empty($coupon->start_date)) {
                $coupon->start_date = Carbon::parse($coupon->started_at)->toDateString();
            }

            if (!empty($coupon->expired_date) && empty($coupon->expired_at)) {
                $coupon->expired_at = $coupon->expired_date;
            } elseif (!empty($coupon->expired_at) && empty($coupon->expired_date)) {
                $coupon->expired_date = Carbon::parse($coupon->expired_at)->toDateString();
            }
        });
    }

    /**
     * Categories this coupon applies to (when applies_to === 'category')
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'coupon_category', 'coupon_id', 'category_id');
    }

    /**
     * Products this coupon applies to (when applies_to === 'product')
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'coupon_product', 'coupon_id', 'product_id');
    }

    /**
     * Scope a query to only include active coupons.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Check if coupon is currently valid by dates & limits.
     */
    public function isValidNow(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $today = Carbon::today();

        if ($this->start_date && $today->lt($this->start_date)) {
            return false;
        }

        if ($this->expired_date && $today->gt($this->expired_date)) {
            return false;
        }

        if ($this->total_usage_limit !== null && $this->total_used >= $this->total_usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount for given cart.
     *
     * @param float $subtotal
     * @param array $cartItems [ ['id' => product_id, 'price' => price, 'quantity' => qty], ... ]
     * @return array ['eligible' => bool, 'discount' => float, 'message' => string]
     */
    public function evaluateCart(float $subtotal, array $cartItems = []): array
    {
        if (!$this->isValidNow()) {
            return [
                'eligible' => false,
                'discount' => 0.0,
                'message' => 'كود الخصم غير صالح أو انتهت صلاحيته.',
            ];
        }

        if ($this->min_order_amount > 0 && $subtotal < $this->min_order_amount) {
            return [
                'eligible' => false,
                'discount' => 0.0,
                'message' => 'الحد الأدنى لتطبيق هذا الكوبون هو ' . number_format($this->min_order_amount, 2) . ' ج.م.',
            ];
        }

        // Determine eligible subtotal based on applies_to
        $eligibleSubtotal = 0.0;

        if ($this->applies_to === 'category') {
            $catIds = $this->categories()->pluck('categories.id')->toArray();
            foreach ($cartItems as $item) {
                $product = Product::find($item['id'] ?? null);
                if ($product && $product->categories()->whereIn('categories.id', $catIds)->exists()) {
                    $eligibleSubtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                }
            }
            if ($eligibleSubtotal <= 0) {
                return [
                    'eligible' => false,
                    'discount' => 0.0,
                    'message' => 'هذا الكود مخصص لمنتجات فئات محددة غير موجودة في سلتك.',
                ];
            }
        } elseif ($this->applies_to === 'product') {
            $prodIds = $this->products()->pluck('products.id')->toArray();
            foreach ($cartItems as $item) {
                if (in_array($item['id'] ?? null, $prodIds)) {
                    $eligibleSubtotal += ($item['price'] ?? 0) * ($item['quantity'] ?? 1);
                }
            }
            if ($eligibleSubtotal <= 0) {
                return [
                    'eligible' => false,
                    'discount' => 0.0,
                    'message' => 'هذا الكود مخصص لمنتجات معينة غير موجودة في سلتك.',
                ];
            }
        } else {
            // All products
            $eligibleSubtotal = $subtotal;
        }

        // Calculate discount
        $discountAmount = 0.0;
        $isPercentage = in_array(strtolower($this->discount_type), ['percentage', 'percent']);

        if ($isPercentage) {
            $discountAmount = ($eligibleSubtotal * (float)$this->discount) / 100.0;
            if ($this->max_discount_amount && $discountAmount > (float)$this->max_discount_amount) {
                $discountAmount = (float)$this->max_discount_amount;
            }
        } else {
            // Fixed amount
            $discountAmount = min((float)$this->discount, $eligibleSubtotal);
        }

        $discountAmount = round($discountAmount, 2);

        return [
            'eligible' => true,
            'discount' => $discountAmount,
            'message' => 'تم تطبيق كود الخصم بنجاح وفرت ' . number_format($discountAmount, 2) . ' ج.م.',
        ];
    }
}
