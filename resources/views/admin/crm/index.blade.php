@extends('admin.layouts.layout')

@section('title', 'إدارة العملاء CRM | لوحة التحكم')

@section('content')
<div class="container-fluid p-0">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div>
                <h4 class="fw-bold mb-1">إدارة علاقات العملاء (CRM)</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">سجل وبيانات العملاء</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.crm.index') }}" method="GET" class="row g-3 align-items-end">
                <!-- Search box -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <label class="form-label fw-semibold fs-7">البحث عن عميل</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="الاسم، البريد الإلكتروني، أو الهاتف..." value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Segment Filter -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label class="form-label fw-semibold fs-7">تصنيف الشريحة</label>
                    <select name="segment" class="form-select">
                        <option value="">كل الشرائح</option>
                        @foreach(\App\Models\CustomerProfile::$segments as $key => $label)
                            <option value="{{ $key }}" {{ request('segment') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort Filter -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label class="form-label fw-semibold fs-7">ترتيب حسب</label>
                    <select name="sort" class="form-select">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>تاريخ التسجيل (الأحدث)</option>
                        <option value="spent" {{ request('sort') === 'spent' ? 'selected' : '' }}>إجمالي المشتريات (الأعلى)</option>
                        <option value="orders" {{ request('sort') === 'orders' ? 'selected' : '' }}>عدد الطلبات (الأكثر)</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="col-lg-2 col-md-6 col-sm-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2"><i class="bi bi-funnel-fill"></i> تصفية</button>
                    @if(request()->anyFilled(['search', 'segment', 'sort']))
                        <a href="{{ route('admin.crm.index') }}" class="btn btn-light border py-2" title="إعادة تعيين الفلاتر"><i class="bi bi-arrow-counterclockwise"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Customer Directory Table -->
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">العميل</th>
                            <th>التصنيف / الشريحة</th>
                            <th>المدينة / المحافظة</th>
                            <th class="text-center">عدد الطلبات</th>
                            <th>إجمالي المشتريات</th>
                            <th>آخر تواصل</th>
                            <th class="pe-4 text-end">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-secondary-subtle text-secondary d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px; font-size: 1.1rem;">
                                            {{ mb_substr($customer->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold">{{ $customer->name }}</div>
                                            <small class="text-muted d-block">{{ $customer->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $segment = $customer->profile->segment ?? 'parent';
                                        $badgeClass = match($segment) {
                                            'specialist' => 'bg-info-subtle text-info',
                                            'nursery' => 'bg-warning-subtle text-warning-emphasis',
                                            'school' => 'bg-danger-subtle text-danger',
                                            default => 'bg-primary-subtle text-primary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }} fw-semibold">
                                        {{ $customer->profile ? $customer->profile->segment_label : 'ولي أمر' }}
                                    </span>
                                </td>
                                <td>
                                    <!-- Pull governorate from latest order -->
                                    @php
                                        $latestOrder = $customer->orders->first();
                                    @endphp
                                    {{ $latestOrder ? $latestOrder->shipping_governorate : 'غير محدد' }}
                                </td>
                                <td class="text-center fw-semibold">
                                    {{ $customer->orders_count }} طلبات
                                </td>
                                <td class="fw-bold text-success">
                                    {{ number_format($customer->total_spent ?? 0, 2) }} ج.م
                                </td>
                                <td>
                                    @if($customer->profile && $customer->profile->last_contacted_at)
                                        <span class="text-muted" title="{{ $customer->profile->last_contacted_at }}">{{ $customer->profile->last_contacted_at->diffForHumans() }}</span>
                                    @else
                                        <span class="text-muted-50 fs-7">لم يتصل بعد</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('admin.crm.show', $customer->id) }}" class="btn btn-sm btn-outline-primary px-3 fw-bold">
                                        <i class="bi bi-eye-fill me-1"></i> عرض الملف والملاحظات
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-3"></i> لا يوجد عملاء يطابقون خيارات البحث الحالية.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($customers->hasPages())
            <div class="card-footer bg-white py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="text-muted fs-7">يعرض {{ $customers->firstItem() }} إلى {{ $customers->lastItem() }} من إجمالي {{ $customers->total() }} عميل</span>
                    <div>
                        {!! $customers->links('pagination::bootstrap-5') !!}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
