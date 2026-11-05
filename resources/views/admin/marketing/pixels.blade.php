@extends('admin.layouts.layout')

@section('title', 'إدارة البكسلات وتتبع الإعلانات | لوحة التحكم تمورو')

@section('content')
<div class="container-fluid p-0">

    <!-- Header Hero -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" 
         style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #1e3a8a 100%); color: #ffffff;">
        <div class="card-body p-4 p-md-5 d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-4">
            <div>
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill bg-white bg-opacity-10 border border-white border-opacity-20 text-white fs-7 fw-bold mb-3 shadow-xs">
                    <span class="badge rounded-circle p-1 bg-success" style="width: 8px; height: 8px; display: inline-block;"></span>
                    <span>مركز تتبع الحملات الإعلانية ومحركات البكسل</span>
                </div>
                <h2 class="fw-black mb-1 text-white" style="font-size: 1.75rem;">إدارة بكسلات التتبع والإعلانات (Pixels Hub)</h2>
                <p class="text-white text-opacity-75 fs-6 mb-0">ربط وتعديل Meta Pixel (فيسبوك وإنستجرام)، TikTok Pixel، Google Analytics 4، و Google AdSense بسهولة وبدون تعديل الكود البرمجي.</p>
            </div>

            <div class="d-flex flex-wrap gap-2.5">
                <a href="{{ route('admin.analytics.index') }}" class="btn btn-primary fw-bold fs-7 rounded-3 px-3 py-2 shadow-sm d-flex align-items-center gap-2">
                    <i class="bi bi-graph-up-arrow"></i>
                    <span>لوحة تحليلات الترافيك</span>
                </a>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-outline-light bg-white bg-opacity-10 border-white border-opacity-25 fw-bold fs-7 rounded-3 px-3 py-2 text-white d-flex align-items-center gap-2">
                    <i class="bi bi-box-arrow-up-right"></i>
                    <span>فحص المتجر المباشر</span>
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 p-3 mb-4 d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill fs-5 text-success"></i>
            <span class="fw-bold fs-7">{{ session('success') }}</span>
        </div>
    @endif

    <form action="{{ route('admin.marketing.pixels.update') }}" method="POST">
        @csrf

        <div class="row g-4">
            
            <!-- 1. Meta / Facebook Pixel Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2.5">
                            <span class="p-2 rounded-3 text-white" style="background-color: #1877f2;">
                                <i class="bi bi-facebook fs-5"></i>
                            </span>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">Meta Pixel (فيسبوك وإنستجرام)</h6>
                                <small class="text-muted fs-8">Facebook Ads & Instagram Campaigns</small>
                            </div>
                        </div>

                        <div class="form-check form-switch p-0 m-0">
                            <input class="form-check-input ms-0 cursor-pointer" type="checkbox" role="switch" name="meta_pixel_enabled" id="meta_pixel_enabled" value="1" {{ $settings['meta_pixel_enabled'] === '1' ? 'checked' : '' }} style="width: 2.75rem; height: 1.4rem;">
                        </div>
                    </div>

                    <div class="card-body p-4 pt-1">
                        <div class="mb-3">
                            <label class="form-label fs-7 fw-bold text-muted">معرف البيكسل (Meta Pixel ID) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-fingerprint"></i></span>
                                <input type="text" name="meta_pixel_id" class="form-control font-monospace" value="{{ $settings['meta_pixel_id'] }}" placeholder="مثال: 123456789012345">
                            </div>
                            <small class="text-muted fs-8 mt-1 d-block">ستجده في مدير إعلانات ميتا (Meta Events Manager).</small>
                        </div>

                        <div class="p-3 bg-light rounded-3">
                            <div class="fw-bold fs-8 text-dark mb-1.5"><i class="bi bi-lightning-charge-fill text-warning me-1"></i> الأحداث المعيارية المفعلة تلقائياً:</div>
                            <div class="d-flex flex-wrap gap-1.5">
                                <span class="badge bg-white text-dark border rounded-pill px-2 py-1 fs-8">PageView</span>
                                <span class="badge bg-white text-dark border rounded-pill px-2 py-1 fs-8">ViewContent (المنتجات والشروحات)</span>
                                <span class="badge bg-white text-dark border rounded-pill px-2 py-1 fs-8">AddToCart (السلة)</span>
                                <span class="badge bg-white text-dark border rounded-pill px-2 py-1 fs-8">InitiateCheckout (الدفع)</span>
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-2 py-1 fs-8 fw-bold">Purchase (إتمام الشراء + القيمة بالجنيه)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. TikTok Pixel Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2.5">
                            <span class="p-2 rounded-3 text-white" style="background-color: #000000;">
                                <i class="bi bi-tiktok fs-5"></i>
                            </span>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">TikTok Pixel (تيك توك إعلانات وريلز)</h6>
                                <small class="text-muted fs-8">TikTok Ads Manager & Conversion Tracking</small>
                            </div>
                        </div>

                        <div class="form-check form-switch p-0 m-0">
                            <input class="form-check-input ms-0 cursor-pointer" type="checkbox" role="switch" name="tiktok_pixel_enabled" id="tiktok_pixel_enabled" value="1" {{ $settings['tiktok_pixel_enabled'] === '1' ? 'checked' : '' }} style="width: 2.75rem; height: 1.4rem;">
                        </div>
                    </div>

                    <div class="card-body p-4 pt-1">
                        <div class="mb-3">
                            <label class="form-label fs-7 fw-bold text-muted">معرف بيكسل تيك توk (TikTok Pixel ID) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="bi bi-fingerprint"></i></span>
                                <input type="text" name="tiktok_pixel_id" class="form-control font-monospace" value="{{ $settings['tiktok_pixel_id'] }}" placeholder="مثال: C1234567890ABCDEF">
                            </div>
                            <small class="text-muted fs-8 mt-1 d-block">ستجده في مركز إعلانات تيك توك (TikTok Events Manager).</small>
                        </div>

                        <div class="p-3 bg-light rounded-3">
                            <div class="fw-bold fs-8 text-dark mb-1.5"><i class="bi bi-lightning-charge-fill text-warning me-1"></i> الأحداث المعيارية المفعلة تلقائياً:</div>
                            <div class="d-flex flex-wrap gap-1.5">
                                <span class="badge bg-white text-dark border rounded-pill px-2 py-1 fs-8">Pageview</span>
                                <span class="badge bg-white text-dark border rounded-pill px-2 py-1 fs-8">ViewContent</span>
                                <span class="badge bg-white text-dark border rounded-pill px-2 py-1 fs-8">AddToCart</span>
                                <span class="badge bg-white text-dark border rounded-pill px-2 py-1 fs-8">InitiateCheckout</span>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-2 py-1 fs-8 fw-bold">CompletePayment (تأكيد الطلب)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Google Analytics 4 & Tag Manager -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2.5">
                            <span class="p-2 rounded-3 text-white" style="background-color: #f59e0b;">
                                <i class="bi bi-google fs-5"></i>
                            </span>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">Google Analytics 4 & Tag Manager</h6>
                                <small class="text-muted fs-8">إحصائيات جوجل وتحليل سلوك الزوار</small>
                            </div>
                        </div>

                        <div class="form-check form-switch p-0 m-0">
                            <input class="form-check-input ms-0 cursor-pointer" type="checkbox" role="switch" name="ga4_enabled" id="ga4_enabled" value="1" {{ $settings['ga4_enabled'] === '1' ? 'checked' : '' }} style="width: 2.75rem; height: 1.4rem;">
                        </div>
                    </div>

                    <div class="card-body p-4 pt-1">
                        <div class="mb-3">
                            <label class="form-label fs-7 fw-bold text-muted">معرف قياس GA4 (Measurement ID)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white font-monospace">G-</span>
                                <input type="text" name="ga4_measurement_id" class="form-control font-monospace" value="{{ $settings['ga4_measurement_id'] }}" placeholder="XXXXXXXXXX">
                            </div>
                            <small class="text-muted fs-8 mt-1 d-block">يبدأ بحرف G متبوعاً بأرقام وحروف من لوحة تحكم Google Analytics.</small>
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fs-7 fw-bold text-muted mb-0">Google Tag Manager (GTM Container ID)</label>
                                <div class="form-check form-switch p-0 m-0">
                                    <input class="form-check-input ms-0" type="checkbox" role="switch" name="gtm_enabled" id="gtm_enabled" value="1" {{ $settings['gtm_enabled'] === '1' ? 'checked' : '' }}>
                                </div>
                            </div>
                            <div class="input-group">
                                <span class="input-group-text bg-white font-monospace">GTM-</span>
                                <input type="text" name="gtm_container_id" class="form-control font-monospace" value="{{ $settings['gtm_container_id'] }}" placeholder="XXXXXXX">
                            </div>
                            <small class="text-muted fs-8 mt-1 d-block">اختياري في حال رغبتك في إدارة كافة التاجات عبر جوجل تاج مانجر.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. Google AdSense Card -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-0 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2.5">
                            <span class="p-2 rounded-3 text-white" style="background-color: #10b981;">
                                <i class="bi bi-badge-ad-fill fs-5"></i>
                            </span>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">Google AdSense (إعلانات جوجل أدسنس)</h6>
                                <small class="text-muted fs-8">تحقيق دخل إضافي من الزيارات والشروحات</small>
                            </div>
                        </div>

                        <div class="form-check form-switch p-0 m-0">
                            <input class="form-check-input ms-0 cursor-pointer" type="checkbox" role="switch" name="adsense_enabled" id="adsense_enabled" value="1" {{ $settings['adsense_enabled'] === '1' ? 'checked' : '' }} style="width: 2.75rem; height: 1.4rem;">
                        </div>
                    </div>

                    <div class="card-body p-4 pt-1">
                        <div class="mb-3">
                            <label class="form-label fs-7 fw-bold text-muted">معرف الناشر (AdSense Publisher ID) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white font-monospace">ca-pub-</span>
                                <input type="text" name="adsense_publisher_id" class="form-control font-monospace" value="{{ str_replace('ca-pub-', '', $settings['adsense_publisher_id']) }}" placeholder="1234567890123456">
                            </div>
                            <small class="text-muted fs-8 mt-1 d-block">ستجده في حسابك في Google AdSense في الصفحة الرئيسية أو كود التفعيل.</small>
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input cursor-pointer" type="checkbox" role="switch" name="adsense_auto_ads" id="adsense_auto_ads" value="1" {{ $settings['adsense_auto_ads'] === '1' ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold fs-7 cursor-pointer" for="adsense_auto_ads">
                                تفعيل الإعلانات التلقائية الذكية (Auto Ads)
                            </label>
                        </div>

                        <div class="alert alert-light border rounded-3 p-2.5 mb-0 fs-8 text-muted d-flex align-items-center gap-2">
                            <i class="bi bi-shield-check text-success fs-5"></i>
                            <span>نظام الحماية مفعل: يتم استثناء صفحات الدفع والسلة تلقائياً لضمان عدم إزعاج العميل أثناء الشراء.</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. Custom Header & Footer Scripts -->
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-0">
                        <h6 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                            <i class="bi bi-code-slash text-primary"></i>
                            <span>أكواد مخصصة إضافية (Custom Tracking & Web Scripts)</span>
                        </h6>
                    </div>
                    <div class="card-body p-4 pt-1">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fs-7 fw-bold text-muted">أكواد الهيدر Header Scripts (تُحقن داخل &lt;head&gt;)</label>
                                <textarea name="custom_head_scripts" rows="5" class="form-control font-monospace fs-8" placeholder="<!-- ضع هنا كود إثبات ملكية جوجل Search Console أو Snapchat Pixel أو أي سكريبت تحليلي... -->">{{ $settings['custom_head_scripts'] }}</textarea>
                                <small class="text-muted fs-8 mt-1 d-block">يتم تحميلها بأمان أعلى الصفحة.</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fs-7 fw-bold text-muted">أكواد الفوتر Footer Scripts (تُحقن قبل إغلاق &lt;/body&gt;)</label>
                                <textarea name="custom_body_scripts" rows="5" class="form-control font-monospace fs-8" placeholder="<!-- ضع هنا أكواد الشات بوت (Tawk.to) أو سكريبتات التتبع الخفيفة... -->">{{ $settings['custom_body_scripts'] }}</textarea>
                                <small class="text-muted fs-8 mt-1 d-block">يتم تحميلها في نهاية الصفحة لضمان أقصى سرعة للموقع.</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary fw-bold px-5 py-2.5 rounded-3 shadow-xs fs-6">
                    <i class="bi bi-check2-circle me-1"></i> حفظ وتحديث كافة الإعدادات
                </button>
            </div>

        </div>
    </form>

</div>
@endsection

