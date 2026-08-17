@extends('admin.layouts.layout')

@section('title', 'تفاصيل المنتج: ' . $product->name . ' | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <!-- Breadcrumbs -->
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1">تفاصيل وحالة المنتج</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">المنتجات</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('product', $product->slug) }}" target="_blank" class="btn btn-light border fw-bold">
                    <i class="bi bi-shop me-1"></i> عرض بالمتجر
                </a>
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-info text-white fw-bold">
                    <i class="bi bi-pencil-fill me-1"></i> تعديل المنتج
                </a>
            </div>
        </div>
    </div>

    <!-- Product Header Card -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row align-items-center g-3">
                <div class="col-md-auto col-sm-12 text-center">
                    @if(is_array($product->images) && !empty($product->images))
                        <img src="{{ asset('storage/' . $product->images[0]) }}" class="rounded object-fit-cover border" style="width: 80px; height: 80px;" alt="{{ $product->name }}">
                    @else
                        <div class="rounded bg-light text-secondary d-flex align-items-center justify-content-center border" style="width: 80px; height: 80px;">
                            <i class="bi bi-box-seam fs-1"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md col-sm-12 text-center text-md-start">
                    <h4 class="fw-bold mb-1 text-dark-emphasis">{{ $product->name }}</h4>
                    <p class="text-muted mb-2">رمز SKU: <span class="fw-semibold text-dark">{{ $product->sku ?? 'غير معرف' }}</span></p>
                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
                        @php
                            $typeBadge = match($product->type) {
                                'digital' => 'bg-info-subtle text-info',
                                'course' => 'bg-success-subtle text-success',
                                'session' => 'bg-warning-subtle text-warning-emphasis',
                                default => 'bg-primary-subtle text-primary',
                            };
                            $typeLabel = match($product->type) {
                                'digital' => 'شيت رقمي (PDF)',
                                'course' => 'كورس تعليمي',
                                'session' => 'جلسة تواصل',
                                default => 'أداة مادية',
                            };
                        @endphp
                        <span class="badge {{ $typeBadge }} py-2 px-3 fw-semibold">
                            نوع المنتج: {{ $typeLabel }}
                        </span>
                        
                        @if($product->is_active)
                            <span class="badge bg-success-subtle text-success py-2 px-3 fw-semibold">
                                حالة الظهور: نشط (ظاهر بالمتجر)
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger py-2 px-3 fw-semibold">
                                حالة الظهور: معطل (مخفي)
                            </span>
                        @endif

                        @if($product->badge)
                            <span class="badge bg-brand-coral text-white py-2 px-3 fw-semibold">
                                الشارة: {{ $product->badge }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="col-md-auto col-sm-12 text-center">
                    <div class="p-3 bg-light rounded text-center border">
                        <span class="text-muted d-block fs-8 mb-1">سعر البيع النشط</span>
                        <h4 class="fw-black text-primary mb-0">
                            {{ number_format($product->sale_price ?: $product->price, 2) }} ج.م
                        </h4>
                        @if($product->sale_price)
                            <small class="text-muted line-through fs-8">قبل الخصم: {{ number_format($product->price, 2) }} ج.م</small>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product KPIs -->
    <div class="row">
        <!-- KPI 1: Sales Qty -->
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <div class="card h-100 py-2 border-start border-primary border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted d-block fs-8 fw-semibold mb-1">الكميات المبيعة</span>
                            <h3 class="fw-bold mb-0">{{ $totalSalesCount }} وحدة</h3>
                        </div>
                        <span class="fs-2 text-primary opacity-50"><i class="bi bi-cart-check-fill"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI 2: Revenue Generated -->
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <div class="card h-100 py-2 border-start border-success border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted d-block fs-8 fw-semibold mb-1">إجمالي الإيرادات</span>
                            <h3 class="fw-bold mb-0 text-success">{{ number_format($totalRevenue, 2) }} ج.م</h3>
                        </div>
                        <span class="fs-2 text-success opacity-50"><i class="bi bi-cash-stack"></i></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI 3: Stock Status -->
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            @php
                $stockColor = 'info';
                if ($product->type !== 'digital' && $product->type !== 'course') {
                    $stockColor = $product->stock <= 5 ? 'danger' : 'success';
                }
            @endphp
            <div class="card h-100 py-2 border-start border-{{ $stockColor }} border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted d-block fs-8 fw-semibold mb-1">حالة المخزون</span>
                            @if($product->type === 'digital' || $product->type === 'course')
                                <h3 class="fw-bold mb-0 text-info">غير محدود</h3>
                            @else
                                <h3 class="fw-bold mb-0 text-{{ $stockColor }}">{{ $product->stock }} وحدة</h3>
                            @endif
                        </div>
                        <span class="fs-2 text-{{ $stockColor }} opacity-50">
                            @if($product->type === 'digital')
                                <i class="bi bi-cloud-arrow-down-fill"></i>
                            @else
                                <i class="bi bi-box-seam-fill"></i>
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- KPI 4: Related Filters Count -->
        <div class="col-xl-3 col-md-6 col-sm-12 mb-4">
            <div class="card h-100 py-2 border-start border-warning border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted d-block fs-8 fw-semibold mb-1">فلاتر الربط النشطة</span>
                            @php
                                $filtersCount = $product->categories->count() + $product->ageGroups->count() + $product->skills->count() + $product->needs()->count();
                            @endphp
                            <h3 class="fw-bold mb-0 text-warning">{{ $filtersCount }} فلاتر</h3>
                        </div>
                        <span class="fs-2 text-warning opacity-50"><i class="bi bi-funnel-fill"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Column 1: Info & Specifications -->
        <div class="col-lg-6 col-md-12 mb-4">
            
            <!-- Description -->
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0 fw-bold"><i class="bi bi-card-text text-primary me-2"></i>الوصف والبيانات</h5></div>
                <div class="card-body">
                    <p class="fw-semibold text-dark-emphasis mb-2">وصف مختصر:</p>
                    <p class="text-muted mb-4">{{ $product->short_description ?: 'بدون وصف مختصر' }}</p>
                    
                    <p class="fw-semibold text-dark-emphasis mb-2">الوصف الكامل:</p>
                    <p class="text-muted whitespace-pre-line mb-0" style="font-size: 0.9rem;">{{ $product->description ?: 'بدون وصف مفصل' }}</p>
                </div>
            </div>

            <!-- Digital Worksheet Specific Settings -->
            @if($product->type === 'digital')
                <div class="card mb-4">
                    <div class="card-header bg-info-subtle"><h5 class="mb-0 fw-bold text-info-emphasis"><i class="bi bi-file-earmark-pdf-fill me-2"></i>ملف الترخيص الرقمي للشيت</h5></div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush fs-7">
                            <li class="list-group-item d-flex justify-content-between py-2.5">
                                <span class="text-muted">اسم الملف المرفوع:</span>
                                <span class="fw-bold text-dark">{{ $product->digital_file_name ?: 'غير مرفوع' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between py-2.5">
                                <span class="text-muted">مسار التخزين المحمي:</span>
                                <code class="text-danger fs-8 fw-semibold">{{ $product->digital_file_path ?: 'غير متوفر' }}</code>
                            </li>
                            <li class="list-group-item d-flex justify-content-between py-2.5">
                                <span class="text-muted">أقصى حد للتنزيل للعميل:</span>
                                <span class="fw-bold">{{ $product->digital_download_limit ? $product->digital_download_limit . ' مرات' : 'مفتوح' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between py-2.5">
                                <span class="text-muted">صلاحية الرابط (بعد الشراء):</span>
                                <span class="fw-bold">{{ $product->digital_expiry_days ? $product->digital_expiry_days . ' أيام' : 'دائم' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            @endif

            <!-- Usage Specs -->
            <div class="card">
                <div class="card-header"><h5 class="mb-0 fw-bold"><i class="bi bi-journal-check text-secondary me-2"></i>مواصفات التوجيه والاستخدام</h5></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 col-sm-12">
                            <p class="fw-semibold text-dark-emphasis mb-1">📦 محتويات العلبة:</p>
                            <p class="text-muted fs-7 mb-0">{{ $product->whats_included ?: 'غير محدد' }}</p>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <p class="fw-semibold text-dark-emphasis mb-1">🎯 الفئة المستهدفة:</p>
                            <p class="text-muted fs-7 mb-0">{{ $product->suitable_for ?: 'غير محدد' }}</p>
                        </div>
                        <hr class="my-3">
                        <div class="col-12">
                            <p class="fw-semibold text-success mb-2"><i class="bi bi-check2-circle me-1"></i>الفوائد والمهارات المكتسبة:</p>
                            @if(is_array($product->benefits) && !empty($product->benefits))
                                <ul class="list-unstyled d-flex flex-column gap-1 text-muted fs-7 ps-0">
                                    @foreach($product->benefits as $benefit)
                                        <li><i class="bi bi-dot text-success fs-5"></i>{{ $benefit }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="text-muted fs-7">لم يتم تسجيل فوائد محددة.</span>
                            @endif
                        </div>
                        <hr class="my-3">
                        <div class="col-12">
                            <p class="fw-semibold text-brand-coral mb-2"><i class="bi bi-arrow-right-short me-1"></i>طريقة التطبيق والاستخدام:</p>
                            @if(is_array($product->how_to_use) && !empty($product->how_to_use))
                                <ol class="text-muted fs-7 ps-3">
                                    @foreach($product->how_to_use as $step)
                                        <li class="mb-1">{{ $step }}</li>
                                    @endforeach
                                </ol>
                            @else
                                <span class="text-muted fs-7">لم يتم تسجيل خطوات استخدام.</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Column 2: Linked filters & purchase orders -->
        <div class="col-lg-6 col-md-12 mb-4">
            
            <!-- Linked Filters -->
            <div class="card mb-4">
                <div class="card-header"><h5 class="mb-0 fw-bold"><i class="bi bi-intersect text-secondary me-2"></i>فلاتر الربط النشطة بالمتجر</h5></div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3 fs-7">
                        <div>
                            <span class="text-muted d-block fs-8 mb-1">التصنيفات المربوط بها:</span>
                            <div class="d-flex flex-wrap gap-1">
                                @forelse($product->categories as $c)
                                    <span class="badge bg-primary-subtle text-primary">{{ $c->name }}</span>
                                @empty
                                    <span class="text-muted-50 fs-8">غير مربوط بتصنيف</span>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <span class="text-muted d-block fs-8 mb-1">المراحل العمرية المناسبة:</span>
                            <div class="d-flex flex-wrap gap-1">
                                @forelse($product->ageGroups as $a)
                                    <span class="badge bg-success-subtle text-success">{{ $a->name }}</span>
                                @empty
                                    <span class="text-muted-50 fs-8">غير مربوط بمرحلة عمرية</span>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <span class="text-muted d-block fs-8 mb-1">المهارات المستهدفة:</span>
                            <div class="d-flex flex-wrap gap-1">
                                @forelse($product->skills as $s)
                                    <span class="badge bg-warning-subtle text-warning-emphasis">{{ $s->name }}</span>
                                @empty
                                    <span class="text-muted-50 fs-8">غير مربوط بمهارة معينة</span>
                                @endforelse
                            </div>
                        </div>

                        <div>
                            <span class="text-muted d-block fs-8 mb-1">الاحتياجات والمشكلات المساعدة:</span>
                            <div class="d-flex flex-wrap gap-1">
                                @forelse($product->needs as $n)
                                    <span class="badge bg-danger-subtle text-danger">{{ $n->name }}</span>
                                @empty
                                    <span class="text-muted-50 fs-8">غير مربوط باحتياج خاص</span>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Digital Worksheet Downloads Control (Only if digital) -->
            @if($product->type === 'digital')
                <div class="card mb-4">
                    <div class="card-header"><h5 class="mb-0 fw-bold"><i class="bi bi-people-fill text-info me-2"></i>سجل تراخيص وتنزيلات العملاء</h5></div>
                    <div class="card-body p-0">
                        @if(!empty($downloadLicenses) && count($downloadLicenses) > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-hover align-middle mb-0 fs-7">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-3">العميل</th>
                                            <th class="text-center">التحميلات</th>
                                            <th>حالة الصلاحية</th>
                                            <th class="pe-3 text-end">إجراءات الإدارة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($downloadLicenses as $license)
                                            <tr>
                                                <td class="ps-3">
                                                    <div class="fw-bold">{{ $license->user->name ?? 'مستخدم محذوف' }}</div>
                                                    <small class="text-muted fs-8">طلب: #{{ $license->order->order_number ?? '-' }}</small>
                                                </td>
                                                <td class="text-center">
                                                    <span class="badge bg-secondary rounded-pill">
                                                        {{ $license->download_count }} / {{ $license->max_downloads }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($license->expires_at)
                                                        @if($license->expires_at->isPast())
                                                            <span class="text-danger fw-semibold"><i class="bi bi-x-circle me-1"></i>منتهية</span>
                                                        @else
                                                            <span class="text-success fw-semibold">{{ $license->expires_at->format('Y/m/d') }}</span>
                                                        @endif
                                                    @else
                                                        <span class="text-muted">مفتوح</span>
                                                    @endif
                                                </td>
                                                <td class="pe-3 text-end">
                                                    <!-- Actions Form -->
                                                    <form action="{{ route('admin.crm.resetDownload', ['user' => $license->user_id, 'download' => $license->id]) }}" method="POST" class="d-inline-flex gap-1">
                                                        @csrf
                                                        <button type="submit" name="action" value="reset_count" class="btn btn-xs btn-outline-warning" title="تصفير محاولات التنزيل">
                                                            تصفير
                                                        </button>
                                                        <button type="submit" name="action" value="add_downloads" class="btn btn-xs btn-outline-info" title="إضافة +5 مرات تحميل">
                                                            +5
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4 text-muted fs-7">
                                <i class="bi bi-file-earmark-lock fs-3 d-block mb-2"></i> لا توجد تراخيص تحميل منشأة لهذا الشيت بعد.
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Purchase Orders History -->
            <div class="card">
                <div class="card-header"><h5 class="mb-0 fw-bold"><i class="bi bi-cart3 text-success me-2"></i>طلبات الشراء التي شملت هذا المنتج</h5></div>
                <div class="card-body p-0">
                    @if($recentOrders->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-striped table-hover align-middle mb-0 fs-7">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-3">رقم الطلب</th>
                                        <th>العميل</th>
                                        <th>حالة الطلب</th>
                                        <th>حالة الدفع</th>
                                        <th class="pe-3 text-end">التاريخ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td class="ps-3 fw-bold text-primary">#{{ $order->order_number }}</td>
                                            <td>{{ $order->customer_name }}</td>
                                            <td>
                                                @if($order->status === 'delivered')
                                                    <span class="badge bg-success">تم التوصيل</span>
                                                @elseif($order->status === 'shipped')
                                                    <span class="badge bg-info">تم الشحن</span>
                                                @elseif($order->status === 'cancelled')
                                                    <span class="badge bg-danger">ملغي</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">قيد الإجراء</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($order->payment_status === 'paid')
                                                    <span class="badge bg-success-subtle text-success">مدفوع</span>
                                                @else
                                                    <span class="badge bg-warning-subtle text-warning">معلق</span>
                                                @endif
                                            </td>
                                            <td class="pe-3 text-end text-muted">{{ $order->created_at->format('Y/m/d') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted fs-7">
                            <i class="bi bi-cart-x fs-3 d-block mb-2"></i> لم يتم شراء هذا المنتج في أي طلب حتى الآن.
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
