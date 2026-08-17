<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        // Load settings
        $settings = [];
        foreach (Setting::all() as $setting) {
            $settings[$setting->key] = $setting->value;
        }

        // Default settings if empty
        $defaults = [
            'store_name' => 'تمورو',
            'store_email' => 'contact@2morro.com',
            'store_phone' => '+201000000000',
            'store_whatsapp' => '201000000000',
            'store_address' => 'القاهرة، مصر',
            'meta_title' => 'متجر تمورو | أدوات تعليمية للأطفال',
            'meta_description' => 'أدوات وشيتات تعليمية للأطفال لتنمية مهارات التخاطب والتركيز',
            
            'payment_cod_enabled' => '1',
            'payment_paymob_enabled' => '0',
            'payment_paymob_api_key' => '',
            'payment_paymob_integration_id' => '',
            'payment_paymob_iframe_id' => '',
            
            'shipping_cairo_giza' => '40',
            'shipping_alexandria' => '50',
            'shipping_delta' => '60',
            'shipping_upper_egypt' => '80',
            'shipping_free_limit' => '550',
            
            'digital_max_downloads' => '5',
            'digital_expiry_days' => '30',
            
            'whatsapp_gateway_enabled' => '0',
            'whatsapp_api_url' => '',
            'whatsapp_api_token' => '',
        ];

        // Merge defaults
        $settings = array_merge($defaults, $settings);

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        // Handle toggles which are not sent if unchecked
        $toggles = [
            'payment_cod_enabled',
            'payment_paymob_enabled',
            'whatsapp_gateway_enabled'
        ];

        foreach ($toggles as $toggle) {
            if (!isset($data[$toggle])) {
                $data[$toggle] = '0';
            }
        }

        // Save settings
        foreach ($data as $key => $value) {
            // Null check and convert value to string if array/object
            if (is_array($value)) {
                $value = json_encode($value);
            }
            Setting::set($key, $value);
        }

        return redirect()->route('admin.settings.index')->with('success', 'تم حفظ إعدادات المتجر بنجاح.');
    }
}
