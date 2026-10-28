@extends('admin.layouts.layout')

@section('title', 'تعديل كود الخصم: ' . $coupon->code . ' | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    
    <!-- Page Header & Breadcrumb -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-pencil-square text-primary me-2"></i> تعديل كود الخصم: <span class="font-monospace text-primary bg-primary bg-opacity-10 px-2 py-0.5 rounded">{{ $coupon->code }}</span>
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.coupon.index') }}">أكواد الخصم</a></li>
                        <li class="breadcrumb-item active" aria-current="page">تعديل كود: {{ $coupon->code }}</li>
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

    @php
        $currentType = strtolower($coupon->discount_type ?? $coupon->type?->value ?? 'percentage');
        $selectedCategoryIds = old('categories', $coupon->categories->pluck('id')->toArray());
        $selectedProductIds = old('products', $coupon->products->pluck('id')->toArray());
        $currentAppliesTo = old('applies_to', $coupon->applies_to ?? 'all');
    @endphp

    <form action="{{ route('admin.coupon.update', $coupon->id) }}" method="POST" id="editCouponForm">
        @csrf
        @method('PUT')
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
                        <p class="text-muted small mb-0">تحديث الرمز التعريفي ونوع وقيمة التخفيض المالي</p>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">رمز الكود (Promo Code) <span class="text-danger">*</span></label>
                                <input type="text" name="code" id="coupon_code" class="form-control text-uppercase font-monospace fw-bold @error('code') is-invalid @enderror" value="{{ old('code', $coupon->code) }}" placeholder="مثال: SAVE20" required autocomplete="off">
                                <div class="form-text small text-muted">الرمز الذي يدخله العميل في صفحة إتمام الطلب للحصول على الخصم.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">نوع الخصم <span class="text-danger">*</span></label>
                                <select name="discount_type" id="discount_type" class="form-select fw-bold" required>
                                    <option value="percentage" {{ old('discount_type', $currentType) === 'percentage' ? 'selected' : '' }}>نسبة مئوية (%)</option>
                                    <option value="fixed" {{ old('discount_type', $currentType) === 'fixed' ? 'selected' : '' }}>مبلغ ثابت (ج.م)</option>
                                </select>
                                <div class="form-text small text-muted">نسبة من إجمالي السلة أو خصم نقدي مباشر.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">قيمة الخصم <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0.01" name="discount" id="discount_value" class="form-control fw-bold @error('discount') is-invalid @enderror" value="{{ old('discount', $coupon->discount) }}" required>
                                    <span class="input-group-text fw-bold" id="discount_unit_label">{{ $currentType === 'percentage' ? '%' : 'ج.م' }}</span>
                                </div>
                            </div>

                            <div class="col-md-6" id="max_discount_container" style="{{ $currentType === 'percentage' ? '' : 'display:none;' }}">
                                <label class="form-label fw-bold">الحد الأقصى للخصم (سقف الخصم)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" name="max_discount_amount" id="max_discount_amount" class="form-control" value="{{ old('max_discount_amount', $coupon->max_discount_amount) }}" placeholder="مثال: 200 (اختياري)">
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
                                    <input type="number" step="0.01" min="0" name="min_order_amount" id="min_order_amount" class="form-control" value="{{ old('min_order_amount', $coupon->min_order_amount ?? $coupon->min_amount) }}" placeholder="0 = بدون حد أدنى">
                                    <span class="input-group-text">ج.م</span>
                                </div>
                                <div class="form-text small text-muted">أقل قيمة سلة لتفعيل الكود.</div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">الحد الأقصى للاستخدام إجمالاً</label>
                                <input type="number" step="1" min="1" name="total_usage_limit" id="total_usage_limit" class="form-control" value="{{ old('total_usage_limit', $coupon->total_usage_limit) }}" placeholder="مثال: 100 (اختياري)">
                                <div class="form-text small text-muted">فارغ = غير محدود لجميع العملاء.</div>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold">الحد لكل عميل</label>
                                <input type="number" step="1" min="1" name="limit_for_user" id="limit_for_user" class="form-control" value="{{ old('limit_for_user', $coupon->limit_for_user ?? 1) }}" placeholder="1">
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
                                            <input class="form-check-input" type="radio" name="applies_to" id="applies_all" value="all" {{ $currentAppliesTo === 'all' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold cursor-pointer text-dark d-block" for="applies_all">
                                                جميع منتجات المتجر
                                                <div class="text-muted small fw-normal mt-1">يطبق الخصم على أي طلب يستوفي الشروط</div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check p-3 border rounded-3 h-100 bg-light-subtle">
                                            <input class="form-check-input" type="radio" name="applies_to" id="applies_category" value="category" {{ $currentAppliesTo === 'category' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold cursor-pointer text-dark d-block" for="applies_category">
                                                فئات محددة فقط
                                                <div class="text-muted small fw-normal mt-1">يطبق فقط على المنتجات التابعة لفئات مختارة</div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-check p-3 border rounded-3 h-100 bg-light-subtle">
                                            <input class="form-check-input" type="radio" name="applies_to" id="applies_product" value="product" {{ $currentAppliesTo === 'product' ? 'checked' : '' }}>
                                            <label class="form-check-label fw-bold cursor-pointer text-dark d-block" for="applies_product">
                                                منتجات معينة فقط
                                                <div class="text-muted small fw-normal mt-1">يطبق حصرياً على منتجات معينة يتم تحديدها</div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Specific Categories Selector -->
                            <div class="col-12 {{ $currentAppliesTo === 'category' ? '' : 'd-none' }}" id="categories_selector_box">
                                <label class="form-label fw-bold">اختر الفئات المؤهلة للخصم:</label>
                                <select name="categories[]" class="form-select" multiple size="5" style="border-radius: 8px;">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategoryIds) ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ $category->products_count ?? $category->products()->count() }} منتج)
                                        </option>
                                    @endforeach
                                </select>
                                <div class="form-text small text-muted"><i class="bi bi-info-circle me-1"></i> اضغط مع الاستمرار على مفتاح <kbd>Ctrl</kbd> أو <kbd>Cmd</kbd> لتحديد أكثر من فئة.</div>
                            </div>

                            <!-- Specific Products Selector -->
                            <div class="col-12 {{ $currentAppliesTo === 'product' ? '' : 'd-none' }}" id="products_selector_box">
                                <label class="form-label fw-bold">اختر المنتجات المؤهلة للخصم:</label>
                                <select name="products[]" class="form-select" multiple size="7" style="border-radius: 8px;">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ in_array($product->id, $selectedProductIds) ? 'selected' : '' }}>
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
                                <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $coupon->start_date ? \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d') : '') }}">
                                <div class="form-text small text-muted">اتركه فارغاً ليعمل الكود فور الحفظ مباشرة.</div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">تاريخ الانتهاء (اختياري)</label>
                                <input type="date" name="expired_date" id="expired_date" class="form-control" value="{{ old('expired_date', $coupon->expired_date ? \Carbon\Carbon::parse($coupon->expired_date)->format('Y-m-d') : '') }}">
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
                            <span class="fw-bold fs-6"><i class="bi bi-eye me-1"></i> معاينة الكود</span>
                            <span class="badge bg-white text-primary fw-bold">{{ $coupon->is_active ? 'نشط' : 'معطل' }}</span>
                        </div>
                        <div class="card-body p-4 text-center bg-light">
                            <div class="p-3 bg-white rounded-3 border border-2 border-dashed border-primary shadow-xs mb-3 position-relative">
                                <span class="badge bg-danger text-white position-absolute top-0 start-50 translate-middle px-3 py-1 rounded-pill" id="preview_badge_discount">
                                    خصم {{ $coupon->discount }}{{ $currentType === 'percentage' ? '%' : ' ج.م' }}
                                </span>
                                <div class="display-6 fw-black font-monospace text-primary text-uppercase mt-2 mb-1" id="preview_code">
                                    {{ $coupon->code }}
                                </div>
                                <div class="text-muted small" id="preview_description">
                                    {{ $coupon->applies_to === 'category' ? 'يطبق على فئات محددة' : ($coupon->applies_to === 'product' ? 'يطبق على منتجات محددة' : 'يطبق على جميع المنتجات') }}
                                </div>
                            </div>

                            <ul class="list-unstyled text-start small mb-0 border-top pt-3">
                                <li class="d-flex justify-content-between py-1 text-muted">
                                    <span>مرات الاستخدام الفعلية:</span>
                                    <strong class="text-primary">{{ $coupon->times_used ?? 0 }} مرة</strong>
                                </li>
                                <li class="d-flex justify-content-between py-1 text-muted">
                                    <span>الحد الأدنى:</span>
                                    <strong class="text-dark" id="preview_min_order">
                                        {{ $coupon->min_order_amount > 0 ? number_format($coupon->min_order_amount, 2) . ' ج.م' : 'بدون حد أدنى' }}
                                    </strong>
                                </li>
                                <li class="d-flex justify-content-between py-1 text-muted" id="preview_max_row">
                                    <span>سقف الخصم:</span>
                                    <strong class="text-dark" id="preview_max_discount">
                                        {{ $coupon->max_discount_amount > 0 ? number_format($coupon->max_discount_amount, 2) . ' ج.م' : 'بدون سقف' }}
                                    </strong>
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
                        <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-save2 me-1"></i> حفظ التعديلات</h6>
                        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold mb-2 shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-check-lg fs-5"></i>
                            <span>حفظ التعديلات</span>
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
        const code = inputCode.value.trim().toUpperCase();
        previewCode.textContent = code ? code : 'PROMOCODE';

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

        const minOrder = parseFloat(minOrderInput.value) || 0;
        previewMinOrder.textContent = minOrder > 0 ? minOrder.toLocaleString('ar-EG') + ' ج.م' : 'بدون حد أدنى';

        const maxDisc = parseFloat(maxDiscountInput.value) || 0;
        previewMaxDiscount.textContent = maxDisc > 0 ? maxDisc.toLocaleString('ar-EG') + ' ج.م' : 'بدون سقف';

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

    [inputCode, discountVal, discountType, maxDiscountInput, minOrderInput, startDate, expiredDate].forEach(el => {
        if (el) {
            el.addEventListener('input', updatePreview);
            el.addEventListener('change', updatePreview);
        }
    });

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

    updatePreview();
});
</script>
@endsection
