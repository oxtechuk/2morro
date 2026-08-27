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
            'store_phone' => '01550504512',
            'store_whatsapp' => '201550504512',
            'store_address' => 'الإسكندرية (الإبراهيمية - أول البيطاش - سيدي بشر)',
            'linktree_url' => 'https://linktr.ee/hebaalla?subscribe',
            'supervisor_name' => 'أ. هبة الله أكرم',
            'working_hours' => 'من 12:00 ظهراً إلى 9:00 مساءً (ماعدا الجمعة)',
            'meta_title' => 'متجر ومركز تمورو | تنمية مهارات الطفل وتخاطب وتأهيل',
            'meta_description' => 'مركز ومتجر تمورو لتنمية مهارات الطفل، جلسات تخاطب وتعديل سلوك وتدخل مبكر وأدوات وشيتات تعليمية بإشراف أ. هبة الله أكرم',
            
            'payment_cod_enabled' => '1',
            'payment_instapay_address' => 'hebaalla@instapay',
            'payment_wallet_number' => '01098861354',
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

            // Promo Deals & Highlighted Products Section (Section 3)
            'promo_deals_title' => 'عروض الأسبوع',
            'promo_deals_subtitle' => 'خصومات تصل إلي',
            'promo_deals_discount' => '30%',
            'promo_deals_btn_text' => 'تسوق الآن',
            'promo_deals_btn_link' => '/search?category=educational-bundles',
            'promo_deals_image' => 'images/promo-gift.jpg',
            'promo_deals_gradient' => 'blue',

            'promo_group1_title' => 'الأكثر مبيعاً',
            'promo_group1_link' => '/search',
            'promo_group1_source' => 'bestsellers',
            'promo_group1_product_ids' => '[]',

            'promo_group2_title' => 'الجديد لدينا',
            'promo_group2_link' => '/search',
            'promo_group2_source' => 'newest',
            'promo_group2_product_ids' => '[]',

            // Booking Consultation Page Settings
            'booking_image' => 'images/hero-child.jpg',
            'booking_page_title' => 'حجز استشارة وتقييم مهارات الطفل',
            'booking_page_subtitle' => 'صرح متخصص في رعاية وتأهيل وتنمية قدرات الأطفال وتوفير أفضل الألعاب والأدوات التعليمية بإشراف أ. هبة الله أكرم.',
            'booking_page_quote' => '« عندما تشعرين بأن طفلك بحاجة لدعم وتأهيل في مهاراته اللغوية أو السلوكية أو الحركية، فإن التدخل المبكر يصنع الفارق في مستقبله »',

            // Homepage Bottom Banner Settings (Simple sleek banner with 2 buttons)
            'home_bottom_banner_image' => 'images/hero-child.jpg',
            'home_bottom_banner_title' => 'مركز 2morro لتنمية مهارات الطفل',
            'home_bottom_banner_subtitle' => 'جلسات تخاطب وتعديل سلوك وتدخل مبكر وتقييمات شاملة في المركز وأونلاين بإشراف أ. هبة الله أكرم',
            'home_bottom_banner_btn1_text' => 'حجز استشارة وتقييم',
            'home_bottom_banner_btn1_link' => '/booking',
            'home_bottom_banner_btn2_text' => 'تواصل واتساب',
            'home_bottom_banner_btn2_link' => 'https://wa.me/201550504512',

            // Homepage Triple Feature Cards (Card 1: Blue, Card 2: Teal, Card 3: Red)
            'feature_card_1_title' => 'ألعاب تنمية المهارات',
            'feature_card_1_subtitle' => 'عروض وتخفيضات مذهلة على ألعاب الطفل!',
            'feature_card_1_btn_text' => 'عرض المجموعة',
            'feature_card_1_btn_link' => '/search?category=educational-tools',
            'feature_card_1_image' => 'images/card-truck.jpg',
            'feature_card_1_bg' => '#0052CC',

            'feature_card_2_title' => 'مجموعة تنمية الذكاء',
            'feature_card_2_subtitle' => 'خصم 15% على أدوات وألعاب الطفل!',
            'feature_card_2_btn_text' => 'عرض المجموعة',
            'feature_card_2_btn_link' => '/search?category=educational-bundles',
            'feature_card_2_image' => 'images/card-blocks.jpg',
            'feature_card_2_bg' => '#00A896',

            'feature_card_3_title' => 'باقات وعروض التوفير',
            'feature_card_3_subtitle' => 'خصم 15% على الأدوات والوسائل التعليمية!',
            'feature_card_3_btn_text' => 'عرض المجموعة',
            'feature_card_3_btn_link' => '/search?category=digital-worksheets',
            'feature_card_3_image' => 'images/card-dino.jpg',
            'feature_card_3_bg' => '#e96e1e',
        ];

        // Merge defaults
        $settings = array_merge($defaults, $settings);

        $banners = \App\Models\Banner::orderBy('sort_order', 'asc')->get();
        $products = \App\Models\Product::where('is_active', true)->select('id', 'name', 'price', 'images')->get();

        return view('admin.settings.index', compact('settings', 'banners', 'products'));
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

        // Handle Promo Deals Banner Image upload
        if ($request->hasFile('promo_deals_image_file')) {
            $file = $request->file('promo_deals_image_file');
            $filename = \Illuminate\Support\Str::random(40) . '.' . ($file->getClientOriginalExtension() ?: 'jpg');
            $file->move(storage_path('app/public/banners'), $filename);
            $data['promo_deals_image'] = 'storage/banners/' . $filename;
            unset($data['promo_deals_image_file']);
        }

        // Handle Booking Page Sidebar Image upload
        if ($request->hasFile('booking_image_file')) {
            $file = $request->file('booking_image_file');
            $filename = \Illuminate\Support\Str::random(40) . '.' . ($file->getClientOriginalExtension() ?: 'jpg');
            $file->move(storage_path('app/public/banners'), $filename);
            $data['booking_image'] = 'storage/banners/' . $filename;
            unset($data['booking_image_file']);
        }

        // Handle Homepage Bottom Banner Image upload
        if ($request->hasFile('home_bottom_banner_file')) {
            $file = $request->file('home_bottom_banner_file');
            $filename = 'bottom_banner_' . time() . '.' . ($file->getClientOriginalExtension() ?: 'jpg');
            $file->move(storage_path('app/public/banners'), $filename);
            $data['home_bottom_banner_image'] = 'storage/banners/' . $filename;
            unset($data['home_bottom_banner_file']);
        }

        // Handle Homepage 3 Feature Cards Image uploads
        foreach ([1, 2, 3] as $cardIndex) {
            $fieldName = "feature_card_{$cardIndex}_file";
            if ($request->hasFile($fieldName)) {
                $file = $request->file($fieldName);
                $filename = "feature_card_{$cardIndex}_" . time() . '.' . ($file->getClientOriginalExtension() ?: 'jpg');
                $file->move(storage_path('app/public/banners'), $filename);
                $data["feature_card_{$cardIndex}_image"] = 'storage/banners/' . $filename;
                unset($data[$fieldName]);
            }
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
