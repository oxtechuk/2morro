@extends('admin.layouts.layout')

@section('title', 'إنشاء كود خصم جديد | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    
    <!-- Page Header & Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-plus-circle text-primary me-2"></i> إنشاء كود خصم (بروموكود) جديد
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.coupon.index') }}">أكواد الخصم</a></li>
                        <li class="breadcrumb-item active" aria-current="page">إنشاء كود جديد</li>
                    </ol>
                </nav>
            </div>
            
            <a href="{{ route('admin.coupon.index') }}" class="btn btn-outline-secondary d-inline-flex align-items-center gap-2">
                <i class="bi bi-arrow-right"></i>
                <span>العودة للقائمة</span>
            </a>
        </div>
    </div>

    <!-- Errors Notification -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-xs mb-4" role="alert">
            <div class="d-flex align-items-start gap-2">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-5 mt-0.5"></i>
                <div>
                    <h6 class="fw-bold mb-1">يرجى تصحيح الأخطاء التالية:</h6>
                    <ul class="mb-0 ps-3 small">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('admin.coupon.store') }}" method="POST" id="createCouponForm">
        @csrf
        <div class="row g-4">
            
            <!-- Main Form Column -->
            <div class="col-lg-8">
                
                <!-- Card 1: Core Details -->
                <div class="card border-0 shadow-xs rounded-3 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-1">
                        <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                            <span class="badge bg-primary bg-opacity-10 text-primary p-2 rounded-2">
                                <i class="bi bi-ticket-perforated"></i>
                            </span>
                            بيانات الكود ونوع الخصم
                        </h5>
                        <p class="text-muted small mb-0">حدد الرمز التعريفي ونوع وقيمة التخفيض المالي</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">رمز الكود (Promo Code) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" name="code" id="coupon_code" class="form-control text-uppercase font-monospace fw-bold @error('code') is-invalid @enderror" value="{{ old('code') }}" placeholder="مثال: SAVE20 أو EID2026" required autocomplete="off">
                                    <button type="button" class="btn btn-outline-primary fw-semibold" id="btn_generate_code" title="توليد كود عشوائي">
                                        <i class="bi bi-magic me-1"></i> توليد
                                    </button>
                                </div>
                                <div class="form-text small text-muted">الرمز الذي يدخله العميل في صفحة إتمام الطلب للحصول على الخصم.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">نوع الخصم <span class="text-danger">*</span></label>
                                <select name="discount_type" id="discount_type" class="form-select fw-bold" required>
                                    <option value="percentage" {{ old('discount_type', 'percentage') === 'percentage' ? 'selected' : '' }}>نسبة مئوية (%)</option>
                                    <option value="fixed" {{ old('discount_type') === 'fixed' ? 'selected' : '' }}>مبلغ ثابت (ج.م)</option>
                                </select>
                                <div class="form-text small text-muted">نسبة من إجمالي السلة أو خصم نقدي مباشر.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">قيمة الخصم <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0.01" name="discount" id="discount_value" class="form-control fw-bold @error('discount') is-invalid @enderror" value="{{ old('discount') }}" placeholder="مثال: 20" required>
                                    <span class="input-group-text fw-bold" id="discount_unit_label">%</span>
                                </div>
                            </div>

                            <div class="col-md-6" id="max_discount_container">
                                <label class="form-label fw-bold">الحد الأقصى للخصم (سقف الخصم)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" name="max_discount_amount" id="max_discount_amount" class="form-control" value="{{ old('max_discount_amount') }}" placeholder="مثال: 200 (اختياري)">
                                    <span class="input-group-text">ج.م</span>
                                </div>
                                <div class="form-text small text-muted">لحماية الأرباح عند تطبيق نسب مئوية على طلبات بمبالغ ضخمة.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Conditions & Limits -->
                <div class="card border-0 shadow-xs rounded-3 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-1">
                        <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                            <span class="badge bg-warning bg-opacity-10 text-warning p-2 rounded-2">
                                <i class="bi bi-shield-check"></i>
                            </span>
                            شروط وحدود الاستخدام
                        </h5>
                        <p class="text-muted small mb-0">حدد الحد الأدنى للطلب وسقف مرات الاستخدام</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">الحد الأدنى لقيمة الطلب</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" name="min_order_amount" id="min_order_amount" class="form-control" value="{{ old('min_order_amount', '0') }}" placeholder="0 = بدون حد أدنى">
                                    <span class="input-group-text">ج.م</span>
                                </div>
                                <div class="form-text small text-muted">أقل قيمة سلة لتفعيل الكود.</div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">الحد الأقصى للاستخدام إجمالاً</label>
                                <input type="number" step="1" min="1" name="total_usage_limit" id="total_usage_limit" class="form-control" value="{{ old('total_usage_limit') }}" placeholder="مثال: 100 (اختياري)">
                                <div class="form-text small text-muted">فارغ = غير محدود لجميع العملاء.</div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">الحد لكل عميل</label>
                                <input type="number" step="1" min="1" name="limit_for_user" id="limit_for_user" class="form-control" value="{{ old('limit_for_user', 1) }}" placeholder="1">
                                <div class="form-text small text-muted">عدد مرات الاستخدام لنفس العميل.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Scope & Target Items -->
                <div class="card border-0 shadow-xs rounded-3 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-1">
                        <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                            <span class="badge bg-info bg-opacity-10 text-info p-2 rounded-2">
                                <i class="bi bi-bullseye"></i>
                            </span>
                            شمولية الكود والمنتجات المؤهلة
                        </h5>
                        <p class="text-muted small mb-0">تحديد هل يسري الكود على كل المتجر أم فئات/منتجات محددة</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">يطبق هذا الكود على:</label>
                                <div class="row g-3 mt-1">
                                    <div class="col-md-4">
                                        <div class="form-check p-3 border rounded-3 h-100 bg-light-subtle">
                                            <input class="form-check-input" type="radio" name="applies_to" id="applies_all" value="all" {{ old('applies_to', 'all') === 'all' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold cursor-pointer text-dark d-block" for="applies_all">
                                                جميع منتجات المتجر
                                                <div class="text-muted small fw-normal mt-1">يطبق الخصم على أي طلب يستوفي الشروط</div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check p-3 border rounded-3 h-100 bg-light-subtle">
                                            <input class="form-check-input" type="radio" name="applies_to" id="applies_category" value="category" {{ old('applies_to') === 'category' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold cursor-pointer text-dark d-block" for="applies_category">
                                                فئات محددة فقط
                                                <div class="text-muted small fw-normal mt-1">يطبق فقط على المنتجات التابعة لفئات مختارة</div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check p-3 border rounded-3 h-100 bg-light-subtle">
                                            <input class="form-check-input" type="radio" name="applies_to" id="applies_product" value="product" {{ old('applies_to') === 'product' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold cursor-pointer text-dark d-block" for="applies_product">
                                                منتجات معينة فقط
                                                <div class="text-muted small fw-normal mt-1">يطبق حصرياً على منتجات معينة يتم تحديدها</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Specific Categories Selector -->
                            <div class="col-12 {{ old('applies_to') === 'category' ? '' : 'd-none' }}" id="categories_selector_box">
                                <label class="form-label fw-bold">اختر الفئات المؤهلة للخصم:</label>
                                <select name="categories[]" class="form-select" multiple size="5" style="border-radius: 8px;">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ is_array(old('categories')) && in_array($category->id, old('categories')) ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ $category->products_count ?? $category->products()->count() }} منتج)
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text small text-muted"><i class="bi bi-info-circle me-1"></i> اضغط مع الاستمرار على مفتاح <kbd>Ctrl</kbd> أو <kbd>Cmd</kbd> لتحديد أكثر من فئة.</div>
                            </div>

                            <!-- Specific Products Selector -->
                            <div class="col-12 {{ old('applies_to') === 'product' ? '' : 'd-none' }}" id="products_selector_box">
                                <label class="form-label fw-bold">اختر المنتجات المؤهلة للخصم:</label>
                                <select name="products[]" class="form-select" multiple size="7" style="border-radius: 8px;">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ is_array(old('products')) && in_array($product->id, old('products')) ? 'selected' : '' }}>
                                            {{ $product->name }} — ({{ number_format($product->price, 2) }} ج.م)
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text small text-muted"><i class="bi bi-info-circle me-1"></i> اضغط مع الاستمرار على مفتاح <kbd>Ctrl</kbd> لتحديد أكثر من منتج.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Schedule & Validity Dates -->
                <div class="card border-0 shadow-xs rounded-3 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-1">
                        <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                            <span class="badge bg-success bg-opacity-10 text-success p-2 rounded-2">
                                <i class="bi bi-calendar-range"></i>
                            </span>
                            فترة صلاحية وسريان الكود
                        </h5>
                        <p class="text-muted small mb-0">تحديد متى يبدأ الكود ومتى ينتهي تلقائياً</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">تاريخ البداية (اختياري)</label>
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date') }}">
                                <div class="form-text small text-muted">اتركه فارغاً ليعمل الكود فور الحفظ مباشرة.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">تاريخ الانتهاء (اختياري)</label>
                                <input type="date" name="expired_date" id="expired_date" class="form-control" value="{{ old('expired_date') }}">
                                <div class="form-text small text-muted">اتركه فارغاً ليكون الكود مستمراً دون تاريخ انتهاء.</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Sidebar / Preview & Submit Column -->
            <div class="col-lg-4">
                <div class="sticky-top" style="top: 85px; z-index: 10;">
                    
                    <!-- Coupon Live Ticket Preview Card -->
                    <div class="card border-0 shadow-xs rounded-3 mb-4 overflow-hidden">
                        <div class="card-header bg-primary text-white py-3 px-4 d-flex align-items-center justify-content-between">
                            <span class="fw-bold fs-6"><i class="bi bi-eye me-1"></i> معاينة الكود المباشرة</span>
                            <span class="badge bg-white text-primary fw-bold" id="preview_status_badge">نشط</span>
                        </div>
                        <div class="card-body p-4 text-center bg-light">
                            <div class="p-3 bg-white rounded-3 border border-2 border-dashed border-primary shadow-xs mb-3 position-relative">
                                <span class="badge bg-danger text-white position-absolute top-0 start-50 translate-middle px-3 py-1 rounded-pill" id="preview_badge_discount">
                                    خصم 0%
                                </span>
                                <div class="display-6 fw-black font-monospace text-primary text-uppercase mt-2 mb-1" id="preview_code">
                                    PROMOCODE
                                </div>
                                <div class="text-muted small" id="preview_description">
                                    يطبق على جميع المنتجات
                                </div>
                            </div>

                            <ul class="list-unstyled text-start small mb-0 border-top pt-3">
                                <li class="d-flex justify-content-between py-1 text-muted">
                                    <span>الحد الأدنى:</span>
                                    <strong class="text-dark" id="preview_min_order">بدون حد أدنى</strong>
                                </li>
                                <li class="d-flex justify-content-between py-1 text-muted" id="preview_max_row">
                                    <span>سقف الخصم:</span>
                                    <strong class="text-dark" id="preview_max_discount">بدون سقف</strong>
                                </li>
                                <li class="d-flex justify-content-between py-1 text-muted">
                                    <span>فترة الصلاحية:</span>
                                    <strong class="text-dark" id="preview_dates">مستمر</strong>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Action Buttons Card -->
                    <div class="card border-0 shadow-xs rounded-3 p-4">
                        <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-save2 me-1"></i> تأكيد الحفظ</h6>
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold mb-2 shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-check-lg fs-5"></i>
                            <span>حفظ وتفعيل كود الخصم</span>
                        </button>
                        <a href="{{ route('admin.coupon.index') }}" class="btn btn-outline-secondary w-100">
                            إلغاء والعودة
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Generate Random Coupon Code
    const btnGen = document.getElementById('btn_generate_code');
    const inputCode = document.getElementById('coupon_code');
    const previewCode = document.getElementById('preview_code');
    const discountVal = document.getElementById('discount_value');
    const discountType = document.getElementById('discount_type');
    const unitLabel = document.getElementById('discount_unit_label');
    const maxDiscountBox = document.getElementById('max_discount_container');
    const maxDiscountInput = document.getElementById('max_discount_amount');
    const minOrderInput = document.getElementById('min_order_amount');
    const previewDiscountBadge = document.getElementById('preview_badge_discount');
    const previewMinOrder = document.getElementById('preview_min_order');
    const previewMaxDiscount = document.getElementById('preview_max_discount');
    const previewMaxRow = document.getElementById('preview_max_row');
    const previewScope = document.getElementById('preview_description');
    const previewDates = document.getElementById('preview_dates');
    const startDate = document.getElementById('start_date');
    const expiredDate = document.getElementById('expired_date');

    function updatePreview() {
        // Code text
        const code = inputCode.value.trim().toUpperCase();
        previewCode.textContent = code ? code : 'PROMOCODE';

        // Discount value & type
        const val = parseFloat(discountVal.value) || 0;
        const isPct = discountType.value === 'percentage';
        if (isPct) {
            unitLabel.textContent = '%';
            if (maxDiscountBox) maxDiscountBox.style.display = '';
            if (previewMaxRow) previewMaxRow.style.display = '';
            previewDiscountBadge.textContent = 'خصم ' + val + '%';
        } else {
            unitLabel.textContent = 'ج.م';
            if (maxDiscountBox) maxDiscountBox.style.display = 'none';
            if (previewMaxRow) previewMaxRow.style.display = 'none';
            previewDiscountBadge.textContent = 'خصم ' + val + ' ج.م';
        }

        // Min order
        const minOrder = parseFloat(minOrderInput.value) || 0;
        previewMinOrder.textContent = minOrder > 0 ? minOrder.toLocaleString('ar-EG') + ' ج.م' : 'بدون حد أدنى';

        // Max discount
        const maxDisc = parseFloat(maxDiscountInput.value) || 0;
        previewMaxDiscount.textContent = maxDisc > 0 ? maxDisc.toLocaleString('ar-EG') + ' ج.م' : 'بدون سقف';

        // Scope
        const selectedScope = document.querySelector('input[name="applies_to"]:checked');
        if (selectedScope) {
            if (selectedScope.value === 'category') {
                previewScope.textContent = 'يطبق على فئات محددة';
            } else if (selectedScope.value === 'product') {
                previewScope.textContent = 'يطبق على منتجات محددة';
            } else {
                previewScope.textContent = 'يطبق على جميع المنتجات';
            }
        }

        // Dates
        if (startDate.value && expiredDate.value) {
            previewDates.textContent = startDate.value + ' إلى ' + expiredDate.value;
        } else if (expiredDate.value) {
            previewDates.textContent = 'ينتهي في: ' + expiredDate.value;
        } else if (startDate.value) {
            previewDates.textContent = 'يبدأ من: ' + startDate.value;
        } else {
            previewDates.textContent = 'مستمر دائماً';
        }
    }

    if (btnGen && inputCode) {
        btnGen.addEventListener('click', function() {
            const chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            let res = 'PROMO';
            for (let i = 0; i < 4; i++) {
                res += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            inputCode.value = res;
            updatePreview();
        });
    }

    [inputCode, discountVal, discountType, maxDiscountInput, minOrderInput, startDate, expiredDate].forEach(el => {
        if (el) {
            el.addEventListener('input', updatePreview);
            el.addEventListener('change', updatePreview);
        }
    });

    // Toggle Scope Radios
    const appliesRadios = document.querySelectorAll('input[name="applies_to"]');
    const catBox = document.getElementById('categories_selector_box');
    const prodBox = document.getElementById('products_selector_box');

    appliesRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'category') {
                catBox.classList.remove('d-none');
                prodBox.classList.add('d-none');
            } else if (this.value === 'product') {
                catBox.classList.add('d-none');
                prodBox.classList.remove('d-none');
            } else {
                catBox.classList.add('d-none');
                prodBox.classList.add('d-none');
            }
            updatePreview();
        });
    });

    // Initialize Preview on page load
    updatePreview();
});
</script>
@endsection
