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
            'store_logo' => 'images/logo.png',
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

            // Hero Banner Dynamic Settings
            'hero_title' => 'أدوات تعليمية تنمي مهارات طفلك',
            'hero_title_highlight' => 'تنمي مهارات طفلك',
            'hero_subtitle' => 'تعلَم.. استمتع.. وتطور كل يوم مع وسائل وأدوات تعليمية مختارة بعناية.',
            'hero_btn1_text' => 'تسوق الآن',
            'hero_btn1_link' => '/search',
            'hero_btn2_text' => 'اختر حسب احتياج طفلك',
            'hero_btn2_link' => '/search',
            'hero_image' => 'images/hero-child.jpg',
            'hero_badge_text' => '🚀 انطلاقة التعلم والذكاء',

            // Catalog & Search Page Banner Settings
            'catalog_banner_image' => 'images/hero-child.jpg',
            'catalog_banner_title' => 'استكشف أفضل الأدوات والأنشطة التعليمية',
            'catalog_banner_subtitle' => 'اختر ما يناسب عمر واحتياج طفلك لتطوير مهاراته خطوة بخطوة وبأفضل الوسائل التفاعلية.',

            // Auth Page (Login / Register) Settings
            'auth_video_url' => 'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'auth_banner_title' => 'انضم إلى عائلة تمورو التعليمية ✨',
            'auth_banner_subtitle' => 'نوفر لطفلك أفضل بيئة تفاعلية لتطوير قدراته واكتشاف مهاراته خطوة بخطوة.',
        ];

        // Merge defaults
        $settings = array_merge($defaults, $settings);

        $banners = \App\Models\Banner::orderBy('sort_order', 'asc')->get();

        return view('admin.settings.index', compact('settings', 'banners'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        // Handle Store Logo upload
        if ($request->hasFile('store_logo_file')) {
            $file = $request->file('store_logo_file');
            $filename = \Illuminate\Support\Str::random(40) . '.' . ($file->getClientOriginalExtension() ?: 'png');
            $file->move(storage_path('app/public/logo'), $filename);
            $data['store_logo'] = 'storage/logo/' . $filename;
            unset($data['store_logo_file']);
        }

        // Handle Hero Image upload for primary slide
        if ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $filename = \Illuminate\Support\Str::random(40) . '.' . ($file->getClientOriginalExtension() ?: 'jpg');
            $file->move(storage_path('app/public/banners'), $filename);
            $data['hero_image'] = 'storage/banners/' . $filename;
            unset($data['hero_image_file']);
        }

        // Handle Catalog Page Banner Image upload
        if ($request->hasFile('catalog_banner_file')) {
            $file = $request->file('catalog_banner_file');
            $filename = \Illuminate\Support\Str::random(40) . '.' . ($file->getClientOriginalExtension() ?: 'jpg');
            $file->move(storage_path('app/public/banners'), $filename);
            $data['catalog_banner_image'] = 'storage/banners/' . $filename;
            unset($data['catalog_banner_file']);
        }

        // Handle adding a brand new banner directly from settings page
        if ($request->hasFile('new_banner_image')) {
            $file = $request->file('new_banner_image');
            $filename = \Illuminate\Support\Str::random(40) . '.' . ($file->getClientOriginalExtension() ?: 'jpg');
            $file->move(storage_path('app/public/banners'), $filename);
            \App\Models\Banner::create([
                'title' => $request->input('new_banner_title'),
                'subtitle' => $request->input('new_banner_subtitle'),
                'badge_text' => $request->input('new_banner_badge', '🚀 جديد وحصري'),
                'image' => 'storage/banners/' . $filename,
                'button_text' => $request->input('new_banner_btn_text', 'تسوق الآن'),
                'button_link' => $request->input('new_banner_btn_link', '/search'),
                'text_position' => 'right',
                'sort_order' => (\App\Models\Banner::max('sort_order') ?? 0) + 1,
                'is_active' => true,
            ]);
            unset($data['new_banner_image'], $data['new_banner_title'], $data['new_banner_subtitle'], $data['new_banner_badge'], $data['new_banner_btn_text'], $data['new_banner_btn_link']);
        }

        // Clean and format YouTube video URL for auth pages
        if (isset($data['auth_video_url']) && !empty($data['auth_video_url'])) {
            $url = $data['auth_video_url'];
            if (preg_match('/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/', $url, $matches)) {
                $data['auth_video_url'] = 'https://www.youtube.com/embed/' . $matches[1];
            }
        }

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
            Setting::set($key, (string) $value);
        }

        // Sync with primary Banner in Hero Slider
        $heroImage = Setting::get('hero_image');
        $firstBanner = \App\Models\Banner::orderBy('sort_order', 'asc')->first();
        if ($firstBanner && $heroImage) {
            $firstBanner->update([
                'image' => $heroImage,
                'title' => Setting::get('hero_title', $firstBanner->title),
                'subtitle' => Setting::get('hero_subtitle', $firstBanner->subtitle),
                'button_text' => Setting::get('hero_btn1_text', $firstBanner->button_text),
                'button_link' => Setting::get('hero_btn1_link', $firstBanner->button_link),
                'secondary_button_text' => Setting::get('hero_btn2_text', $firstBanner->secondary_button_text),
                'secondary_button_link' => Setting::get('hero_btn2_link', $firstBanner->secondary_button_link),
            ]);
        }

        return redirect()->back()->with('success', 'تم حفظ وتحديث كافة الإعدادات والبانرات بنجاح!');
    }
}
