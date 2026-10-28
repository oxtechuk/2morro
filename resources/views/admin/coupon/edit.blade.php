@extends('layouts.app')

@section('header-title', 'تعديل كود الخصم')

@section('content')
<div class="container-fluid px-3 py-2">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-md-11">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h4 class="fw-bold mb-1 text-dark">
                        <i class="bi bi-pencil-square text-primary me-2"></i> تعديل كود الخصم: <span class="font-monospace text-primary">{{ $coupon->code }}</span>
                    </h4>
                    <p class="text-muted small mb-0">تحديث شروط ونسب وتواريخ كود الخصم</p>
                </div>
                <a href="{{ route('admin.coupon.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right me-1"></i> العودة للقائمة
                </a>
            </div>

            @if($errors->any())
                <div class="alert alert-danger shadow-xs border-0 mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.coupon.update', $coupon->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card border-0 shadow-xs rounded-16 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-dark mb-0">بيانات الكود وقيمة الخصم</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">رمز الكود (Promo Code) <span class="text-danger">*</span></label>
                                <input type="text" name="code" class="form-control text-uppercase font-monospace fw-bold @error('code') is-invalid @enderror" value="{{ old('code', $coupon->code) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">نوع الخصم <span class="text-danger">*</span></label>
                                @php
                                    $currentType = strtolower($coupon->discount_type ?? $coupon->type?->value ?? 'percentage');
                                @endphp
                                <select name="discount_type" id="discount_type" class="form-select fw-bold" required>
                                    <option value="percentage" {{ old('discount_type', $currentType) === 'percentage' ? 'selected' : '' }}>نسبة مئوية (%)</option>
                                    <option value="fixed" {{ old('discount_type', $currentType) === 'fixed' ? 'selected' : '' }}>مبلغ ثابت (ج.م)</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">قيمة الخصم <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0.01" name="discount" class="form-control @error('discount') is-invalid @enderror" value="{{ old('discount', $coupon->discount) }}" required>
                                    <span class="input-group-text fw-bold" id="discount_unit_label">{{ $currentType === 'percentage' ? '%' : 'ج.م' }}</span>
                                </div>
                            </div>

                            <div class="col-md-6" id="max_discount_container" style="{{ $currentType === 'percentage' ? '' : 'display:none;' }}">
                                <label class="form-label fw-bold">الحد الأقصى للخصم (ج.م)</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" name="max_discount_amount" class="form-control" value="{{ old('max_discount_amount', $coupon->max_discount_amount) }}" placeholder="مثال: 200 (اختياري)">
                                    <span class="input-group-text">ج.م</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">الحد الأدنى للطلب لتفعيل الكود</label>
                                <div class="input-group">
                                    <input type="number" step="0.01" min="0" name="min_order_amount" class="form-control" value="{{ old('min_order_amount', $coupon->min_order_amount ?? $coupon->min_amount) }}">
                                    <span class="input-group-text">ج.م</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">الحد الأقصى لمرات استخدام الكود إجمالياً</label>
                                <input type="number" step="1" min="1" name="total_usage_limit" class="form-control" value="{{ old('total_usage_limit', $coupon->total_usage_limit) }}" placeholder="اتركه فارغاً للاستخدام غير المحدود">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Scope & Target Selection -->
                <div class="card border-0 shadow-xs rounded-16 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-dark mb-0">شمولية الكود والمنتجات المؤهلة</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-bold">يطبق هذا الكود على:</label>
                                <div class="d-flex flex-wrap gap-4 mt-1">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="applies_to" id="applies_all" value="all" {{ old('applies_to', $coupon->applies_to ?? 'all') === 'all' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold cursor-pointer" for="applies_all">
                                            جميع منتجات المتجر
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="applies_to" id="applies_category" value="category" {{ old('applies_to', $coupon->applies_to) === 'category' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold cursor-pointer" for="applies_category">
                                            فئات محددة فقط (Categories)
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="applies_to" id="applies_product" value="product" {{ old('applies_to', $coupon->applies_to) === 'product' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold cursor-pointer" for="applies_product">
                                            منتجات معينة فقط (Products)
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @php
                                $selectedCategoryIds = old('categories', $coupon->categories->pluck('id')->toArray());
                                $selectedProductIds = old('products', $coupon->products->pluck('id')->toArray());
                                $currentAppliesTo = old('applies_to', $coupon->applies_to ?? 'all');
                            @endphp

                            <!-- Specific Categories Selector -->
                            <div class="col-12 {{ $currentAppliesTo === 'category' ? '' : 'd-none' }}" id="categories_selector_box">
                                <label class="form-label fw-bold">اختر الفئات المؤهلة للخصم:</label>
                                <select name="categories[]" class="form-select" multiple size="5">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ in_array($category->id, $selectedCategoryIds) ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Specific Products Selector -->
                            <div class="col-12 {{ $currentAppliesTo === 'product' ? '' : 'd-none' }}" id="products_selector_box">
                                <label class="form-label fw-bold">اختر المنتجات المؤهلة للخصم:</label>
                                <select name="products[]" class="form-select" multiple size="6">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ in_array($product->id, $selectedProductIds) ? 'selected' : '' }}>
                                            {{ $product->name }} ({{ number_format($product->price, 2) }} ج.م)
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Validity Period -->
                <div class="card border-0 shadow-xs rounded-16 mb-4">
                    <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                        <h5 class="fw-bold text-dark mb-0">فترة سريان الكود</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">تاريخ البداية (اختياري)</label>
                                <input type="date" name="start_date" class="form-control" value="{{ old('start_date', $coupon->start_date ? \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d') : '') }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">تاريخ الانتهاء (اختياري)</label>
                                <input type="date" name="expired_date" class="form-control" value="{{ old('expired_date', $coupon->expired_date ? \Carbon\Carbon::parse($coupon->expired_date)->format('Y-m-d') : '') }}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-end gap-3 mb-5">
                    <a href="{{ route('admin.coupon.index') }}" class="btn btn-light px-4">إلغاء</a>
                    <button type="submit" class="btn btn-primary px-5 fw-bold">
                        <i class="bi bi-check-lg me-1"></i> حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const discountTypeSelect = document.getElementById('discount_type');
    const unitLabel = document.getElementById('discount_unit_label');
    const maxDiscountBox = document.getElementById('max_discount_container');

    if (discountTypeSelect && unitLabel) {
        discountTypeSelect.addEventListener('change', function() {
            if (this.value === 'percentage') {
                unitLabel.textContent = '%';
                if (maxDiscountBox) maxDiscountBox.style.display = '';
            } else {
                unitLabel.textContent = 'ج.م';
                if (maxDiscountBox) maxDiscountBox.style.display = 'none';
            }
        });
    }

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
        });
    });
});
</script>
@endsection
