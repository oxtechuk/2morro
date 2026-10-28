@extends('admin.layouts.layout')

@section('title', 'العروض والخصومات الجماعية | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">

    <!-- Page Header & Actions -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="fw-bold mb-1">
                    <i class="bi bi-percent text-danger me-2"></i> إدارة العروض والخصومات الجماعية
                </h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">العروض والخصومات الجماعية</li>
                    </ol>
                </nav>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('admin.coupon.index') }}" class="btn btn-outline-primary fw-semibold d-inline-flex align-items-center gap-1.5 shadow-xs">
                    <i class="bi bi-ticket-perforated fs-6"></i>
                    <span>أكواد الخصم والبروموكود</span>
                </a>
                <a href="{{ route('offers') }}" target="_blank" class="btn btn-primary fw-bold d-inline-flex align-items-center gap-1.5 shadow-sm">
                    <i class="bi bi-box-arrow-up-right fs-6"></i>
                    <span>معاينة صفحة العروض في المتجر</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-xs mb-4 d-flex align-items-center justify-content-between" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill text-success fs-5"></i>
                <span class="fw-semibold">{{ session('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-xs mb-4 d-flex align-items-center justify-content-between" role="alert">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-5"></i>
                <span class="fw-semibold">{{ session('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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

    <!-- KPI Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-4">
            <div class="card border-0 shadow-xs rounded-3 p-3 h-100 border-start border-4 border-danger">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">المنتجات عليها تخفيض حالياً</span>
                        <h3 class="fw-bold text-danger mb-0">{{ number_format($totalDiscountedCount) }}</h3>
                    </div>
                    <div class="rounded-3 bg-danger bg-opacity-10 p-3 text-danger fs-4">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-4">
            <div class="card border-0 shadow-xs rounded-3 p-3 h-100 border-start border-4 border-primary">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">إجمالي الفئات المؤهلة</span>
                        <h3 class="fw-bold text-primary mb-0">{{ number_format($categories->count()) }}</h3>
                    </div>
                    <div class="rounded-3 bg-primary bg-opacity-10 p-3 text-primary fs-4">
                        <i class="bi bi-grid-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-xs rounded-3 p-3 h-100 border-start border-4 border-success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold d-block mb-1">رابط واجهة العروض بالمتجر</span>
                        <a href="{{ route('offers') }}" target="_blank" class="fw-bold text-success text-decoration-none d-inline-flex align-items-center gap-1 mt-1">
                            <span>{{ url('/offers') }}</span>
                            <i class="bi bi-arrow-up-right fs-6"></i>
                        </a>
                    </div>
                    <div class="rounded-3 bg-success bg-opacity-10 p-3 text-success fs-4">
                        <i class="bi bi-globe2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Row: Apply Discount & Clear Discount -->
    <div class="row g-4 mb-4">
        
        <!-- Apply Discount Tool -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-xs rounded-3 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-1">
                    <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                        <span class="badge bg-danger bg-opacity-10 text-danger p-2 rounded-2">
                            <i class="bi bi-lightning-charge-fill"></i>
                        </span>
                        تطبيق خصم مئوي جماعي فوري
                    </h5>
                    <p class="text-muted small mb-0">اختر فئة معينة أو كل المتجر وحدد نسبة الخصم لتطبيقها على الأسعار فوراً</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.discounts.apply') }}" method="POST" id="applyDiscountForm">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-7">
                                <label class="form-label fw-bold">الفئة المستهدفة <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select fw-semibold" required>
                                    <option value="" disabled selected>-- اختر الفئة المستهدفة --</option>
                                    <option value="all" class="fw-bold text-danger">★ جميع منتجات وفئات المتجر كاملة ★</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }} ({{ $category->products_count }} منتج نشط)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label fw-bold">نسبة الخصم المئوية <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="1" min="1" max="99" name="percentage" id="percentage_input" class="form-control fw-bold" placeholder="مثال: 20" required>
                                    <span class="input-group-text bg-light fw-bold text-danger">%</span>
                                </div>
                            </div>

                            <!-- Quick Preset Percentage Badges -->
                            <div class="col-12">
                                <span class="small text-muted me-2">نسب سريعة:</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 rounded-pill me-1" onclick="setPercent(10)">10%</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 rounded-pill me-1" onclick="setPercent(15)">15%</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 rounded-pill me-1" onclick="setPercent(20)">20%</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 rounded-pill me-1" onclick="setPercent(30)">30%</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2 rounded-pill me-1" onclick="setPercent(50)">50%</button>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">نص شارة العرض (Badge)</label>
                                <input type="text" name="badge" class="form-control" placeholder="اختياري — مثال: خصم خاص، عرض العيد، خصم 20%">
                                <div class="form-text small text-muted">اتركه فارغاً ليظهر تلقائياً بالشكل: «خصم X%» على بطاقات المنتجات.</div>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-danger btn-lg px-4 fw-bold shadow-sm d-inline-flex align-items-center gap-2" onclick="return confirm('تأكيد: هل أنت متأكد من تطبيق هذا الخصم؟ سيتم تحديث أسعار المنتجات في المتجر فوراً.')">
                                    <i class="bi bi-check2-circle fs-5"></i>
                                    <span>تطبيق الخصم فورياً</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reset Discount Tool -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-xs rounded-3 h-100 bg-light-subtle">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-1">
                    <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                        <span class="badge bg-secondary bg-opacity-10 text-secondary p-2 rounded-2">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </span>
                        إلغاء العروض واستعادة السعر الأصلي
                    </h5>
                    <p class="text-muted small mb-0">إلغاء الخصم وإرجاع أسعار المنتجات لطبيعتها عند انتهاء الحملة</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.discounts.reset') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">اختر الفئة لإلغاء التخفيض عنها</label>
                            <select name="category_id" class="form-select fw-semibold" required>
                                <option value="" disabled selected>-- اختر الفئة لإلغاء الخصم --</option>
                                <option value="all" class="fw-bold text-danger">⚠️ إلغاء كافة العروض في كل المتجر دفعة واحدة</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text small text-muted">سيتم مسح سعر التخفيض (sale_price) والشارة واستعادة السعر الأساسي.</div>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-outline-danger btn-lg w-100 fw-bold d-inline-flex align-items-center justify-content-center gap-2" onclick="return confirm('تأكيد الإلغاء: هل تود إلغاء التخفيض واستعادة الأسعار الأصلية؟')">
                                <i class="bi bi-x-circle fs-5"></i>
                                <span>إلغاء التخفيض واستعادة السعر</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Discounted Products Table -->
    <div class="card border-0 shadow-xs rounded-3 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                    <i class="bi bi-list-stars text-danger"></i>
                    <span>قائمة المنتجات المخفضة حالياً</span>
                    <span class="badge bg-danger rounded-pill px-2.5 py-1 text-white fs-7">{{ $totalDiscountedCount }}</span>
                </h5>
                <p class="text-muted small mb-0">تظهر هذه المنتجات في واجهة المتجر وقسم <a href="{{ route('offers') }}" target="_blank" class="text-decoration-none">العروض الحصرية</a></p>
            </div>

            <!-- Client Filter -->
            <div class="input-group" style="max-width: 280px;">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" id="filterDiscountsTable" class="form-control border-start-0" placeholder="بحث باسم المنتج...">
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="discountsTable">
                    <thead class="table-light text-muted small">
                        <tr>
                            <th class="ps-4">المنتج</th>
                            <th>الفئة</th>
                            <th>السعر الأساسي</th>
                            <th>سعر العرض</th>
                            <th>نسبة الخصم</th>
                            <th>قيمة التوفير</th>
                            <th>الشارة</th>
                            <th class="text-center pe-4">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($discountedProducts as $product)
                            @php
                                $savings = $product->price - $product->sale_price;
                                $percent = $product->price > 0 ? round(($savings / $product->price) * 100) : 0;
                            @endphp
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="rounded overflow-hidden bg-light border flex-shrink-0" style="width: 48px; height: 48px;">
                                            @if($product->images && count($product->images) > 0)
                                                <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small"><i class="bi bi-image"></i></div>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('product', $product->slug) }}" target="_blank" class="text-dark fw-bold text-decoration-none product-name-cell">
                                                {{ $product->name }}
                                            </a>
                                            <div class="text-muted small">SKU: {{ $product->sku ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($product->categories->isNotEmpty())
                                        <span class="badge bg-light text-dark border">{{ $product->categories->first()->name }}</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td><del class="text-muted fw-semibold">{{ number_format($product->price, 2) }} ج.م</del></td>
                                <td><span class="fw-bold text-danger fs-6">{{ number_format($product->sale_price, 2) }} ج.م</span></td>
                                <td>
                                    <span class="badge bg-danger text-white px-2 py-1 rounded-pill fw-bold">خصم {{ $percent }}%</span>
                                </td>
                                <td>
                                    <span class="text-success fw-bold">{{ number_format($savings, 2) }} ج.م</span>
                                </td>
                                <td>
                                    @if($product->badge)
                                        <span class="badge bg-warning text-dark fw-bold">{{ $product->badge }}</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary" title="تعديل المنتج">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.discounts.product.reset', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="إلغاء الخصم عن هذا المنتج واستعادة السعر الأصلي" onclick="return confirm('إلغاء الخصم عن هذا المنتج واستعادة السعر الأصلي؟')">
                                                <i class="bi bi-x-circle me-1"></i> استعادة
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="noRowsPlaceholder">
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-tag fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    <div class="fw-bold fs-6 mb-1">لا توجد منتجات عليها تخفيضات حالياً</div>
                                    <div class="small">استخدم أداة التطبيق بالأعلى لإضافة خصم على أي فئة بنسبة مئوية بضغطة زر.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($discountedProducts->hasPages())
                <div class="p-3 border-top d-flex justify-content-center">
                    {{ $discountedProducts->links() }}
                </div>
            @endif
        </div>
    </div>

</div>

<script>
function setPercent(val) {
    const input = document.getElementById('percentage_input');
    if (input) {
        input.value = val;
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('filterDiscountsTable');
    const table = document.getElementById('discountsTable');
    if (searchInput && table) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            const rows = table.querySelectorAll('tbody tr:not(#noRowsPlaceholder)');
            rows.forEach(row => {
                const nameEl = row.querySelector('.product-name-cell');
                const text = nameEl ? nameEl.textContent.toLowerCase() : row.textContent.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>
@endsection
