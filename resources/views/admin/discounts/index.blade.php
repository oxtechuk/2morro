@extends('layouts.app')

@section('header-title', 'إدارة العروض والخصومات الجماعية')

@section('content')
<div class="container-fluid px-4 py-3">

    <!-- Header -->
    <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1 text-dark">
                <i class="bi bi-percent text-danger me-2"></i> إدارة العروض والخصومات الجماعية
            </h3>
            <p class="text-muted mb-0 small">تطبيق نسبة خصم مئوية فورية على فئة كاملة أو مجموعة منتجات، وإدارتها بضغطة زر</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.coupon.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-ticket-perforated me-1"></i> أكواد الخصم (البروموكود)
            </a>
            <a href="{{ route('offers') }}" target="_blank" class="btn btn-primary">
                <i class="bi bi-box-arrow-up-right me-1"></i> معاينة صفحة العروض في المتجر
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-xs border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-xs border-0 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-xs rounded-16 bg-white p-3 border-start border-4 border-danger">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">المنتجات عليها تخفيض حالياً</span>
                        <h2 class="fw-bold text-danger mb-0 mt-1">{{ $totalDiscountedCount }}</h2>
                    </div>
                    <div class="rounded-circle bg-danger bg-opacity-10 p-3 text-danger fs-3">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-xs rounded-16 bg-white p-3 border-start border-4 border-primary">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">إجمالي الفئات النشطة</span>
                        <h2 class="fw-bold text-primary mb-0 mt-1">{{ $categories->count() }}</h2>
                    </div>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-3 text-primary fs-3">
                        <i class="bi bi-folder-fill"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-xs rounded-16 bg-white p-3 border-start border-4 border-success">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <span class="text-muted small fw-semibold">رابط واجهة العروض للعملاء</span>
                        <h6 class="fw-bold text-success mb-0 mt-2">
                            <a href="{{ route('offers') }}" target="_blank" class="text-success text-decoration-none">
                                {{ url('/offers') }} <i class="bi bi-arrow-up-right"></i>
                            </a>
                        </h6>
                    </div>
                    <div class="rounded-circle bg-success bg-opacity-10 p-3 text-success fs-3">
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
            <div class="card border-0 shadow-xs rounded-16 h-100">
                <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-dark mb-1">
                        <i class="bi bi-lightning-charge-fill text-warning me-2"></i> تطبيق خصم مئوي جماعي
                    </h5>
                    <p class="text-muted small mb-0">اختر فئة معينة أو المتجر بالكامل، وحدد نسبة الخصم لتطبيقها على جميع المنتجات فوراً</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.discounts.apply') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">الفئة المستهدفة <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select" required>
                                    <option value="" disabled selected>-- اختر الفئة --</option>
                                    <option value="all" class="fw-bold text-primary">★ جميع فئات ومنتجات المتجر ★</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">
                                            {{ $category->name }} ({{ $category->products_count }} منتج)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold">نسبة الخصم المئوية (%) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="1" min="1" max="99" name="percentage" class="form-control" placeholder="مثال: 20" required>
                                    <span class="input-group-text bg-light fw-bold text-primary">%</span>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold">نص شارة العرض (Badge)</label>
                                <input type="text" name="badge" class="form-control" placeholder="اختياري - يترك فارغاً ليكون تلقائياً: 'خصم X%'">
                                <small class="text-muted">النص الذي يظهر على بطاقة المنتج مثل: "خصم 20%" أو "عرض العيد"</small>
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-danger px-4 py-2 fw-bold" onclick="return confirm('هل أنت متأكد من تطبيق هذا الخصم على جميع منتجات الفئة المحددة؟ سيتم تحديث الأسعار فوراً.')">
                                    <i class="bi bi-check2-circle me-1"></i> تطبيق الخصم فورياً
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reset Discount Tool -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-xs rounded-16 h-100 bg-light">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-dark mb-1">
                        <i class="bi bi-arrow-counterclockwise text-secondary me-2"></i> إلغاء العروض واستعادة الأسعار
                    </h5>
                    <p class="text-muted small mb-0">إلغاء الخصم وإرجاع المنتجات لأسعارها الأصلية عند انتهاء الحملة</p>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.discounts.reset') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">اختر الفئة لإلغاء التخفيض عنها</label>
                            <select name="category_id" class="form-select" required>
                                <option value="" disabled selected>-- اختر الفئة --</option>
                                <option value="all" class="fw-bold text-danger">⚠️ إلغاء كافة العروض في كل المتجر</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-4">
                            <button type="submit" class="btn btn-outline-danger w-100 fw-bold" onclick="return confirm('تأكيد: هل تود إلغاء التخفيض وإعادة الأسعار الأصلية لهذه الفئة؟')">
                                <i class="bi bi-x-circle me-1"></i> إلغاء التخفيض واستعادة السعر الأصلي
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Discounted Products Table -->
    <div class="card border-0 shadow-xs rounded-16">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h5 class="fw-bold text-dark mb-0">
                <i class="bi bi-list-stars text-danger me-2"></i> قائمة المنتجات المخفضة حالياً ({{ $totalDiscountedCount }})
            </h5>
            <span class="badge bg-danger bg-opacity-10 text-danger px-3 py-2 rounded-pill font-bold">
                تظهر هذه المنتجات في صفحة /offers تلقائياً
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light text-muted small">
                        <tr>
                            <th class="ps-4">المنتج</th>
                            <th>الفئة</th>
                            <th>السعر الأصلي</th>
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
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded overflow-hidden bg-light border" style="width: 44px; height: 44px;">
                                            @if($product->images && count($product->images) > 0)
                                                <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <div class="w-100 h-100 d-flex align-items-center justify-content-center text-muted small"><i class="bi bi-image"></i></div>
                                            @endif
                                        </div>
                                        <div>
                                            <a href="{{ route('product', $product->slug) }}" target="_blank" class="text-dark fw-bold text-decoration-none">
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
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><del class="text-muted">{{ number_format($product->price, 2) }} ج.م</del></td>
                                <td><span class="fw-bold text-danger fs-6">{{ number_format($product->sale_price, 2) }} ج.م</span></td>
                                <td>
                                    <span class="badge bg-danger text-white px-2 py-1">خصم {{ $percent }}%</span>
                                </td>
                                <td>
                                    <span class="text-success fw-bold">{{ number_format($savings, 2) }} ج.م</span>
                                </td>
                                <td>
                                    @if($product->badge)
                                        <span class="badge bg-warning text-dark">{{ $product->badge }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary" title="تعديل المنتج">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.discounts.product.reset', $product->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="إلغاء الخصم عن هذا المنتج فقط" onclick="return confirm('إلغاء الخصم عن هذا المنتج واستعادة السعر الأصلي؟')">
                                                <i class="bi bi-x-circle"></i> إلغاء
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-tag fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                    لا توجد منتجات عليها تخفيضات حالياً.<br>
                                    استخدم أداة التطبيق بالأعلى لإضافة خصم على أي فئة بنسبة مئوية بضغطة زر.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($discountedProducts->hasPages())
                <div class="p-3 border-top">
                    {{ $discountedProducts->links() }}
                </div>
            @endif
        </div>
    </div>

</div>
@endsection
