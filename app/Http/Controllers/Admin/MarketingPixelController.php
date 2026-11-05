<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class MarketingPixelController extends Controller
{
    /**
     * Show Pixels & Marketing Tracking Settings Form.
     */
    public function index()
    {
        $settings = [
            'meta_pixel_enabled'   => Setting::get('meta_pixel_enabled', '0'),
            'meta_pixel_id'        => Setting::get('meta_pixel_id', ''),
            'tiktok_pixel_enabled' => Setting::get('tiktok_pixel_enabled', '0'),
            'tiktok_pixel_id'      => Setting::get('tiktok_pixel_id', ''),
            'ga4_enabled'          => Setting::get('ga4_enabled', '0'),
            'ga4_measurement_id'   => Setting::get('ga4_measurement_id', ''),
            'gtm_enabled'          => Setting::get('gtm_enabled', '0'),
            'gtm_container_id'     => Setting::get('gtm_container_id', ''),
            'adsense_enabled'      => Setting::get('adsense_enabled', '0'),
            'adsense_publisher_id' => Setting::get('adsense_publisher_id', ''),
            'adsense_auto_ads'     => Setting::get('adsense_auto_ads', '1'),
            'custom_head_scripts'  => Setting::get('custom_head_scripts', ''),
            'custom_body_scripts'  => Setting::get('custom_body_scripts', ''),
        ];

        return view('admin.marketing.pixels', compact('settings'));
    }

    /**
     * Update Pixels & Marketing Tracking Settings.
     */
    public function update(Request $request)
    {
        $request->validate([
            'meta_pixel_id'        => 'nullable|string|max:100',
            'tiktok_pixel_id'      => 'nullable|string|max:100',
            'ga4_measurement_id'   => 'nullable|string|max:100',
            'gtm_container_id'     => 'nullable|string|max:100',
            'adsense_publisher_id' => 'nullable|string|max:100',
            'custom_head_scripts'  => 'nullable|string',
            'custom_body_scripts'  => 'nullable|string',
        ]);

        Setting::set('meta_pixel_enabled', $request->has('meta_pixel_enabled') ? '1' : '0');
        Setting::set('meta_pixel_id', trim($request->get('meta_pixel_id', '')));

        Setting::set('tiktok_pixel_enabled', $request->has('tiktok_pixel_enabled') ? '1' : '0');
        Setting::set('tiktok_pixel_id', trim($request->get('tiktok_pixel_id', '')));

        Setting::set('ga4_enabled', $request->has('ga4_enabled') ? '1' : '0');
        Setting::set('ga4_measurement_id', trim($request->get('ga4_measurement_id', '')));

        Setting::set('gtm_enabled', $request->has('gtm_enabled') ? '1' : '0');
        Setting::set('gtm_container_id', trim($request->get('gtm_container_id', '')));

        Setting::set('adsense_enabled', $request->has('adsense_enabled') ? '1' : '0');
        Setting::set('adsense_publisher_id', trim($request->get('adsense_publisher_id', '')));
        Setting::set('adsense_auto_ads', $request->has('adsense_auto_ads') ? '1' : '0');

        Setting::set('custom_head_scripts', $request->get('custom_head_scripts', ''));
        Setting::set('custom_body_scripts', $request->get('custom_body_scripts', ''));

        return redirect()->back()->with('success', 'تم حفظ وتحديث إعدادات البكسلات والتتبع بنجاح!');
    }
}

