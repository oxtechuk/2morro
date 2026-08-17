@extends('admin.layouts.layout')

@section('title', 'إعدادات المتجر | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold mb-1">إعدادات المتجر</h4>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                    <li class="breadcrumb-item active" aria-current="page">إعدادات النظام العامة</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Settings Tabs Header -->
                <div class="card mb-4">
                    <div class="card-body p-2">
                        <ul class="nav nav-pills nav-fill gap-2" id="settingsTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2" id="general-tab" data-bs-toggle="tab" data-bs-target="#general-pane" type="button" role="tab" aria-controls="general-pane" aria-selected="true">
                                    <i class="bi bi-info-circle-fill"></i> الإعدادات العامة
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2" id="payment-tab" data-bs-toggle="tab" data-bs-target="#payment-pane" type="button" role="tab" aria-controls="payment-pane" aria-selected="false">
                                    <i class="bi bi-credit-card-fill"></i> بوابات الدفع
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2" id="shipping-tab" data-bs-toggle="tab" data-bs-target="#shipping-pane" type="button" role="tab" aria-controls="shipping-pane" aria-selected="false">
                                    <i class="bi bi-truck"></i> الشحن والتوصيل
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2" id="digital-tab" data-bs-toggle="tab" data-bs-target="#digital-pane" type="button" role="tab" aria-controls="digital-pane" aria-selected="false">
                                    <i class="bi bi-file-earmark-pdf-fill"></i> الشيتات الرقمية
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link py-2.5 fw-semibold d-flex align-items-center justify-content-center gap-2" id="whatsapp-tab" data-bs-toggle="tab" data-bs-target="#whatsapp-pane" type="button" role="tab" aria-controls="whatsapp-pane" aria-selected="false">
                                    <i class="bi bi-whatsapp"></i> إشعارات الواتساب
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Settings Tabs Content -->
                <div class="tab-content" id="settingsTabContent">
                    
                    <!-- 1. General Settings Tab -->
                    <div class="tab-pane fade show active" id="general-pane" role="tabpanel" aria-labelledby="general-tab" tabindex="0">
                        <div class="card">
                            <div class="card-header"><h5 class="mb-0">بيانات متجر تمورو الأساسية</h5></div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="form-label fw-bold">اسم المتجر</label>
                                        <input type="text" name="store_name" class="form-control" value="{{ $settings['store_name'] }}">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="form-label fw-bold">البريد الإلكتروني للتواصل</label>
                                        <input type="email" name="store_email" class="form-control text-start" value="{{ $settings['store_email'] }}">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="form-label fw-bold">رقم الهاتف للاتصال</label>
                                        <input type="text" name="store_phone" class="form-control text-start" value="{{ $settings['store_phone'] }}">
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="form-label fw-bold">رقم الواتساب للعملاء</label>
                                        <input type="text" name="store_whatsapp" class="form-control text-start" value="{{ $settings['store_whatsapp'] }}" placeholder="مثال: 2010xxxxxxxx">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">عنوان المقر / الفروع</label>
                                        <input type="text" name="store_address" class="form-control" value="{{ $settings['store_address'] }}">
                                    </div>
                                    <hr class="my-4">
                                    <h6 class="fw-bold mb-2">بيانات تهيئة محركات البحث (SEO Settings)</h6>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">عنوان الميتا (Meta Title)</label>
                                        <input type="text" name="meta_title" class="form-control" value="{{ $settings['meta_title'] }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">وصف الميتا (Meta Description)</label>
                                        <textarea name="meta_description" class="form-control" rows="3">{{ $settings['meta_description'] }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Payment Settings Tab -->
                    <div class="tab-pane fade" id="payment-pane" role="tabpanel" aria-labelledby="payment-tab" tabindex="0">
                        <div class="card">
                            <div class="card-header"><h5 class="mb-0">خيارات الدفع وتحصيل الأموال</h5></div>
                            <div class="card-body">
                                <!-- Cash On Delivery -->
                                <div class="d-flex align-items-center justify-content-between mb-4 p-3 bg-light rounded">
                                    <div>
                                        <h6 class="fw-bold mb-1">الدفع عند الاستلام (COD)</h6>
                                        <p class="text-muted fs-7 mb-0">السماح للعملاء بالطلب والدفع نقداً عند التوصيل للمندوب.</p>
                                    </div>
                                    <div class="form-check form-switch fs-4">
                                        <input class="form-check-input" type="checkbox" name="payment_cod_enabled" value="1" id="codSwitch" {{ $settings['payment_cod_enabled'] == '1' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <!-- Paymob Electronic Payment -->
                                <div class="border rounded p-4">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            <h6 class="fw-bold mb-1"><i class="bi bi-wallet2 text-primary me-2"></i>بوابة دفع باي موب (Paymob Integration)</h6>
                                            <p class="text-muted fs-7 mb-0">قبول المدفوعات عبر كروت الائتمان ومحافظ الموبايل (فودافون كاش، اتصالات، إلخ).</p>
                                        </div>
                                        <div class="form-check form-switch fs-4">
                                            <input class="form-check-input" type="checkbox" name="payment_paymob_enabled" value="1" id="paymobSwitch" {{ $settings['payment_paymob_enabled'] == '1' ? 'checked' : '' }}>
                                        </div>
                                    </div>
                                    
                                    <div class="row g-3 mt-2" id="paymobFields">
                                        <div class="col-12">
                                            <label class="form-label fw-bold">مفتاح واجهة التطبيق (API Key)</label>
                                            <input type="text" name="payment_paymob_api_key" class="form-control text-start" value="{{ $settings['payment_paymob_api_key'] }}">
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <label class="form-label fw-bold">رقم التكامل للدفع (Integration ID)</label>
                                            <input type="text" name="payment_paymob_integration_id" class="form-control text-start" value="{{ $settings['payment_paymob_integration_id'] }}">
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <label class="form-label fw-bold">رقم إطار العرض للدفع (Iframe ID)</label>
                                            <input type="text" name="payment_paymob_iframe_id" class="form-control text-start" value="{{ $settings['payment_paymob_iframe_id'] }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Shipping Settings Tab -->
                    <div class="tab-pane fade" id="shipping-pane" role="tabpanel" aria-labelledby="shipping-tab" tabindex="0">
                        <div class="card">
                            <div class="card-header"><h5 class="mb-0">خيارات الشحن والتوصيل للمحافظات</h5></div>
                            <div class="card-body">
                                <div class="row g-3 mb-4">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="form-label fw-bold">حد الشحن المجاني للطلب (ج.م)</label>
                                        <div class="input-group">
                                            <input type="number" name="shipping_free_limit" class="form-control" value="{{ $settings['shipping_free_limit'] }}">
                                            <span class="input-group-text">ج.م</span>
                                        </div>
                                    </div>
                                </div>

                                <h6 class="fw-bold mb-3 border-bottom pb-2">تسعير الشحن حسب أقاليم جمهورية مصر العربية</h6>
                                <div class="row g-3">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="form-label fw-bold">القاهرة والجيزة</label>
                                        <div class="input-group">
                                            <input type="number" name="shipping_cairo_giza" class="form-control" value="{{ $settings['shipping_cairo_giza'] }}">
                                            <span class="input-group-text">ج.م</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="form-label fw-bold">الإسكندرية</label>
                                        <div class="input-group">
                                            <input type="number" name="shipping_alexandria" class="form-control" value="{{ $settings['shipping_alexandria'] }}">
                                            <span class="input-group-text">ج.م</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="form-label fw-bold">الوجه البحري والدلتا</label>
                                        <div class="input-group">
                                            <input type="number" name="shipping_delta" class="form-control" value="{{ $settings['shipping_delta'] }}">
                                            <span class="input-group-text">ج.م</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <label class="form-label fw-bold">الصعيد والوجه القبلي / مدن القناة</label>
                                        <div class="input-group">
                                            <input type="number" name="shipping_upper_egypt" class="form-control" value="{{ $settings['shipping_upper_egypt'] }}">
                                            <span class="input-group-text">ج.م</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Digital worksheets settings Tab -->
                    <div class="tab-pane fade" id="digital-pane" role="tabpanel" aria-labelledby="digital-tab" tabindex="0">
                        <div class="card">
                            <div class="card-header"><h5 class="mb-0">خيارات الشيتات الرقمية والتحميل الفوري</h5></div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6 col-sm-12">
                                        <label class="form-label fw-bold">الحد الأقصى لعدد مرات التحميل لكل ملف</label>
                                        <div class="input-group">
                                            <input type="number" name="digital_max_downloads" class="form-control" value="{{ $settings['digital_max_downloads'] }}">
                                            <span class="input-group-text">مرات تنزيل</span>
                                        </div>
                                        <small class="text-muted">يقوم النظام بإغلاق رابط التحميل للعميل عند الوصول لهذا الحد (تجنباً للمشاركة غير المصرح بها).</small>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <label class="form-label fw-bold">صلاحية رابط التحميل بعد الشراء</label>
                                        <div class="input-group">
                                            <input type="number" name="digital_expiry_days" class="form-control" value="{{ $settings['digital_expiry_days'] }}">
                                            <span class="input-group-text">أيام</span>
                                        </div>
                                        <small class="text-muted">تنتهي صلاحية الرابط تلقائياً بعد هذا العدد من الأيام.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 5. Whatsapp Notification Settings Tab -->
                    <div class="tab-pane fade" id="whatsapp-pane" role="tabpanel" aria-labelledby="whatsapp-tab" tabindex="0">
                        <div class="card">
                            <div class="card-header"><h5 class="mb-0">إعدادات إشعارات رسائل الواتساب للعملاء</h5></div>
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between mb-4 p-3 bg-light rounded">
                                    <div>
                                        <h6 class="fw-bold mb-1">تفعيل إشعارات الواتساب (WhatsApp Messages)</h6>
                                        <p class="text-muted fs-7 mb-0">إرسال رسائل تلقائية للعميل عند تأكيد الطلب، شحن الشحنة، أو إرسال روابط الشيتات الرقمية.</p>
                                    </div>
                                    <div class="form-check form-switch fs-4">
                                        <input class="form-check-input" type="checkbox" name="whatsapp_gateway_enabled" value="1" id="whatsappSwitch" {{ $settings['whatsapp_gateway_enabled'] == '1' ? 'checked' : '' }}>
                                    </div>
                                </div>

                                <div class="row g-3" id="whatsappFields">
                                    <div class="col-12">
                                        <label class="form-label fw-bold">عنوان رابط الخدمة (API Endpoint URL)</label>
                                        <input type="text" name="whatsapp_api_url" class="form-control text-start" value="{{ $settings['whatsapp_api_url'] }}" placeholder="مثال: https://api.ultramsg.com/instancexxxxx/messages/chat">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">رمز التحقق / المفتاح (API Access Token)</label>
                                        <input type="text" name="whatsapp_api_token" class="form-control text-start" value="{{ $settings['whatsapp_api_token'] }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Save Button -->
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary px-5 py-2.5 fw-bold shadow-sm">
                            <i class="bi bi-save-fill me-2"></i> حفظ التغييرات بالكامل
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
