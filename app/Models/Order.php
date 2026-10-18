<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Support\Str;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use App\Models\Scopes\PosOrderFalse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Get all of the products for the Order.
     */
    // public function products(): BelongsToMany
    // {
    //     return $this->belongsToMany(Product::class, 'order_products')->withPivot('quantity', 'price', 'unit')->withoutGlobalScopes();
    // }


    public function products(): BelongsToMany
    {
        $pivotTable = Schema::hasTable('order_products') ? 'order_products' : 'order_items';
        $pivotColumns = ['quantity', 'price'];

        if (Schema::hasColumn($pivotTable, 'unit')) {
            $pivotColumns[] = 'unit';
        }
        if (Schema::hasColumn($pivotTable, 'sku')) {
            $pivotColumns[] = 'sku';
        }
        $rel = $this->belongsToMany(Product::class, $pivotTable)
            ->withPivot($pivotColumns);

        if (Schema::hasTable('orders') && Schema::hasColumn('orders', 'currency_rate') && Schema::hasColumn('orders', 'currency_symbol')) {
            $rel->join('orders', 'orders.id', '=', $pivotTable . '.order_id')
                ->addSelect('products.*', 'orders.currency_rate', 'orders.currency_symbol');
        }

        return $rel->withoutGlobalScopes();
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function productStockOuts(): ?HasMany
    {
        if (function_exists('module_exists') && module_exists('Purchase')) {
            return $this->hasMany(\Modules\Purchase\App\Models\ProductStockOut::class);
        }
        return null;
    }



    /**
     * Get all of the vat taxes for the Order.
     */
    public function vatTaxes(): HasMany
    {
        return $this->hasMany(OrderVatTax::class, 'order_id');
    }

    /**
     * Get the customer that owns the Order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the shop for the Order.
     */
    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    /**
     * Get the coupon for the Order.
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class, 'coupon_id')->withTrashed();
    }

    /**
     * Get the address for the Order.
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    /**
     * Get the payments for the Order.
     */
    public function payments(): BelongsToMany
    {
        return $this->belongsToMany(Payment::class, 'order_payments');
    }

    /**
     * Get the driver order for the Order.
     */
    public function driverOrder(): BelongsTo
    {
        return $this->belongsTo(DriverOrder::class, 'id', 'order_id');
    }

    /**
     * apply global scope
     */
    protected static function booted()
    {
        static::addGlobalScope(new PosOrderFalse);
    }

    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            self::clearOrderCache();
        });

        static::updated(function () {
            self::clearOrderCache();
        });

        static::deleted(function () {
            self::clearOrderCache();
        });
    }

    protected static function clearOrderCache()
    {
        $cacheKeys = [
            'admin_all_orders',
            'shop_all_orders',
        ];

        foreach (OrderStatus::cases() as $status) {
            $cacheKeys[] = 'admin_status_' . Str::camel($status->value);
            $cacheKeys[] = 'shop_status_' . Str::camel($status->value);
        }

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }
    }


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('order_code', 'like', '%' . $search . '%')
                    ->orwhereRaw("CONCAT(COALESCE(prefix, ''), order_code) LIKE ?", ["%{$search}%"])
                    ->orWhere('payment_method', 'like', '%' . $search . '%')
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->WhereHas('user', function ($q) use ($search) {
                            $q->where('name', 'like', '%' . $search . '%')
                                ->orWhere('email', 'like', '%' . $search . '%')
                                ->orWhere('phone', 'like', '%' . $search . '%');
                        });
                    });
            });
        });
    }

    public function scopeCompleted($query)
    {
        return $query->where('order_status','Delivered');
    }
    public function scopeCancelled($query)
    {
        return $query->where('order_status','Cancelled');
    }

    public function getOrderCodeAttribute()
    {
        return $this->attributes['order_code'] ?? ($this->attributes['order_number'] ?? (string) $this->id);
    }

    public function getTotalAmountAttribute()
    {
        return $this->attributes['total_amount'] ?? ($this->attributes['subtotal'] ?? ($this->attributes['total'] ?? 0));
    }

    public function getPayableAmountAttribute()
    {
        return $this->attributes['payable_amount'] ?? ($this->attributes['total'] ?? 0);
    }

    public function getDeliveryChargeAttribute()
    {
        return $this->attributes['delivery_charge'] ?? ($this->attributes['shipping_fee'] ?? 0);
    }

    public function getOrderStatusAttribute($value)
    {
        if ($value instanceof \App\Enums\OrderStatus) {
            return $value;
        }
        $val = $value ?: ($this->attributes['status'] ?? 'pending');
        foreach (\App\Enums\OrderStatus::cases() as $case) {
            if (strcasecmp($case->value, $val) === 0 || strcasecmp($case->name, $val) === 0) {
                return $case;
            }
        }
        return \App\Enums\OrderStatus::PENDING;
    }

    public function getPaymentStatusAttribute($value)
    {
        $val = $value ?: ($this->attributes['payment_status'] ?? 'pending');
        foreach (\App\Enums\PaymentStatus::cases() as $case) {
            if (strcasecmp($case->value, $val) === 0 || strcasecmp($case->name, $val) === 0) {
                return $case->value;
            }
        }
        return ucfirst($val);
    }

    public function getPaymentMethodAttribute($value)
    {
        $val = $value ?: ($this->attributes['payment_method'] ?? 'cod');
        foreach (\App\Enums\PaymentMethod::cases() as $case) {
            if (strcasecmp($case->value, $val) === 0 || strcasecmp($case->name, $val) === 0) {
                return $case->value;
            }
        }
        return ucfirst($val);
    }
}
