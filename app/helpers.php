<?php

use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Currency;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DeliveryCharge;
use Illuminate\Support\Number;
use App\Models\CartAccessToken;
use App\Models\GeneraleSetting;
use App\Models\Shop;
use Nwidart\Modules\Facades\Module;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\PersonalAccessToken;

if (! class_exists(\Abedin\Maker\Repositories\Repository::class, false)) {
    $makerFallback = __DIR__ . '/Maker/Repositories/Repository.php';
    if (file_exists($makerFallback)) {
        require_once $makerFallback;
    }
}

if (! function_exists('getDistance')) {
    /**
     * Calculate the distance between two geographical coordinates.
     *
     * @param  array  $firstLatLng  The first [latitude, longitude] coordinates
     * @param  array  $secondLatLng  The second [latitude, longitude] coordinates
     * @return float The distance between the two coordinates in kilometers
     */
    function getDistance(array $firstLatLng, array $secondLatLng): float
    {
        if (empty($firstLatLng) || empty($secondLatLng)) {
            return 0;
        }

        $theta = ($firstLatLng[1] - $secondLatLng[1]);
        $dist = sin(deg2rad($firstLatLng[0])) *
            sin(deg2rad($secondLatLng[0])) +
            cos(deg2rad($firstLatLng[0])) *
            cos(deg2rad($secondLatLng[0])) *
            cos(deg2rad($theta));

        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        return $miles * 1.609344;
    }
}

if (! function_exists('generaleSetting')) {
    /**
     * Get the generale setting Or shop Or default currency.
     *
     * @param  string|null  $type  = 'setting|shop|rootShop|defaultCurrency'
     *
     * @type setting|shop|rootShop|defaultCurrency
     *
     * @default GeneraleSetting
     *
     * @return GeneraleSetting|Shop|Currency
     *
     * @throws \Exception
     */
    function generaleSetting($type = null, $authUser = null)
    {
        // Ensure class definition is loaded before unserialize gets called on cached models
        class_exists(GeneraleSetting::class);

        // Cache general setting data for 30 days
        $generaleSetting = Cache::remember('generale_setting', 60 * 24 * 30, function () {
            if (Schema::hasTable('generate_settings')) {
                return GeneraleSetting::first();
            }
            return (object) [
                'id' => 1,
                'name' => '2morro Store',
                'title' => '2morro Store',
                'currency' => 'ج.م',
                'currency_position' => 'suffix',
                'shop_type' => 'single',
                'show_top_header' => false,
                'top_header_text' => null,
                'top_header_bg_color' => '#2563ea',
                'top_header_text_color' => '#ffffff',
                'top_header_link' => null,
                'instapay_enabled' => false,
                'vodafone_cash_enabled' => false,
                'bank_transfer_enabled' => false,
                'cash_on_delivery' => true,
                'online_payment' => true,
            ];
        });

        // Guard against serialized incomplete objects from prior cache
        if ($generaleSetting instanceof \__PHP_Incomplete_Class) {
            Cache::forget('generale_setting');
            $generaleSetting = Schema::hasTable('generate_settings') ? GeneraleSetting::first() : null;
        }

        if ($type == 'setting' || $type == null) {
            return $generaleSetting;
        }

        if ($type == 'rootShop') {
            class_exists(Shop::class);
            $rootShop = Cache::remember('admin_shop', 60 * 24 * 7, function () {
                if (Schema::hasTable('shops')) {
                    return Shop::first();
                }
                return null;
            });

            if ($rootShop instanceof \__PHP_Incomplete_Class) {
                Cache::forget('admin_shop');
                $rootShop = Schema::hasTable('shops') ? Shop::first() : null;
            }

            return $rootShop;
        }

        if ($type == 'shop') {
            if ($generaleSetting?->shop_type == 'single') {
                $shop = Schema::hasTable('shops') ? Shop::first() : null;
            } else {
                /** @var User */
                $user = $authUser ?? auth()->user();
                $shop = $user?->shop ?? $user?->myShop;
            }

            if (! $shop && Schema::hasTable('shops')) {
                $shop = Shop::first();
            }

            return $shop;
        }

        if ($type == 'defaultCurrency') {
            class_exists(Currency::class);
            $defaultCurrency = Cache::remember('default_currency', 60 * 24 * 30, function () {
                if (Schema::hasTable('currencies')) {
                    return Currency::where('is_default', 1)->first();
                }
                return (object) ['id' => 1, 'name' => 'EGP', 'symbol' => 'ج.م', 'rate' => 1];
            });

            if ($defaultCurrency instanceof \__PHP_Incomplete_Class) {
                Cache::forget('default_currency');
                $defaultCurrency = Schema::hasTable('currencies') ? Currency::where('is_default', 1)->first() : null;
            }

            return $defaultCurrency;
        }

        return $generaleSetting;
    }
}

if (! function_exists('showCurrency')) {

    /**
     * Show the currency in the given amount.
     *
     * @param  float  $amount
     */
    function showCurrency($amount = null): string
    {
        $generaleSetting = generaleSetting('setting');

        $currency = $generaleSetting?->currency ?? '$';

        $amount = ($amount == 0 || $amount == null) ? 0 : $amount;

        if ($generaleSetting?->currency_position == 'suffix') {
            return $amount . $currency;
        }

        return $currency . $amount;
    }
}

if (! function_exists('getDeliveryCharge')) {

    /**
     * get the delivery charge.
     *
     * @param  int  $orderQuantity
     */
    function getDeliveryCharge($orderQuantity): float
    {
        $deliveryCharge = DeliveryCharge::where('min_qty', '<=', $orderQuantity)
            ->where('max_qty', '>=', $orderQuantity)
            ->first();

        return $deliveryCharge?->charge ?? 0;
    }
}

if (! function_exists('getPreOrderDeliveryCharge')) {

    /**
     * Delivery charge for a pre-order, matching this project's checkout.
     * Grocery uses the quantity-based delivery charge (same as normal checkout).
     */
    function getPreOrderDeliveryCharge($product, $request): float
    {
        return getDeliveryCharge($request->quantity);
    }
}

if (! function_exists('permissionName')) {

    /**
     * get the permission name for the customer readable.
     *
     * @param  string  $permission
     */
    function permissionName($permission): string
    {
        $customerReadAbleNames = config('acl.customerReadableNames');

        if (isset($customerReadAbleNames[$permission])) {
            return trans($customerReadAbleNames[$permission]);
        }

        return trans($permission);
    }
}

if (! function_exists('getYear')) {
    function diffInLargestUnit(Carbon $from, ?Carbon $to = null): string
    {
        $to = $to ?? now();

        $diff = $from->diff($to);

        if ($diff->y >= 1) {
            return $diff->y . ' year' . ($diff->y > 1 ? 's' : '');
        }

        if ($diff->m >= 1) {
            return $diff->m . ' month' . ($diff->m > 1 ? 's' : '');
        }

        if ($diff->d >= 1) {
            return $diff->d . ' day' . ($diff->d > 1 ? 's' : '');
        }

        if ($diff->h >= 1) {
            return $diff->h . ' hour' . ($diff->h > 1 ? 's' : '');
        }

        if ($diff->i >= 1) {
            return $diff->i . ' minute' . ($diff->i > 1 ? 's' : '');
        }

        return $diff->s . ' second' . ($diff->s !== 1 ? 's' : '');
    }
}

if (! function_exists('daysToLargestUnit')) {
    function daysToLargestUnit(int $days): string
    {
        if ($days >= 365) {
            $years = floor($days / 365);
            return $years . ' year' . ($years > 1 ? 's' : '');
        }

        if ($days >= 30) {
            $months = floor($days / 30);
            return $months . ' month' . ($months > 1 ? 's' : '');
        }

        if ($days >= 7) {
            $weeks = floor($days / 7);
            return $weeks . ' week' . ($weeks > 1 ? 's' : '');
        }

        return $days . ' day' . ($days > 1 ? 's' : '');
    }
}



if (! function_exists('currencyData')) {

    /**
     * Show the currency in the given amount.
     *
     * @param  float  $amount
     */
    function currencyData($id)
    {
        $currency = Currency::find($id);

        return  [
            'id' => $currency?->id,
            'symbol' => $currency?->symbol,
            'rate' => $currency?->rate
        ];
    }
}

if (!function_exists('module_exists')) {
    /**
     * Check if a given module exists either by folder or in config/modules.php
     *
     * @param  string  $moduleName
     * @return bool
     */
    function module_exists(string $moduleName): bool
    {
        $moduleName = ucfirst($moduleName);
        $modulePath = base_path("Modules/{$moduleName}");
        $configPath = config_path('modules.php');

        if (class_exists(Module::class) && Module::has($moduleName) && Module::isEnabled($moduleName) && File::isDirectory($modulePath) && File::exists($configPath)) {
            return true;
        }
        // Otherwise, module not found
        return false;
    }
}


if (! function_exists('cartAccessToken')) {

    /**
     * Retrieve customer_id or guest access_token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    function cartAccessToken(Request $request): array
    {
        $user = auth()->user();

        $customerId = $user->customer->id ?? null;
        $accessTokenValue = $request->header('X-Guest-Token') ?? $request->access_token;
        $guestToken = CartAccessToken::where('access_token', $accessTokenValue)->first();
        $isAuth = false;

        if ($request->bearerToken() && class_exists(PersonalAccessToken::class)) {
            $accessToken = PersonalAccessToken::findToken($request->bearerToken());
            if ($accessToken) {
                $user = $accessToken->tokenable;
                $customerId = $user->customer->id ?? null;
                $isAuth = true;
            }
        }

        if (!$isAuth && $guestToken) {
            $customerId = $guestToken->customer_id ?? null;
        }

        return [
            'customer_id' => $customerId ?? null,
            'access_token' => $guestToken->access_token ?? null,
            'is_auth' => $isAuth
        ];
    }
}

if (! function_exists('userCart')) {
    function userCart(Request $request)
    {
        $tokens = cartAccessToken($request);
        $query = Cart::query();
        if ($tokens['access_token'] && $tokens['customer_id']) {
            // if both exist prefer guest cart via access_token
            $query->where('access_token', $tokens['access_token']);
        } elseif ($tokens['customer_id']) {
            $query->where('customer_id', $tokens['customer_id']);
        } elseif ($tokens['access_token']) {
            $query->where('access_token', $tokens['access_token']);
        } else {
            $query->whereRaw('1 = 0');
        }
        return $query;
    }
}


if (! function_exists('formatAmount')) {
    function formatAmount($amount)
    {
        return Number::abbreviate($amount ?? 0,2);
    }
}
