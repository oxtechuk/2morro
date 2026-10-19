@extends('layouts.app')

@section('header-title', 'سجل وبيانات العملاء (CRM)')
@section('header-subtitle', 'إدارة علاقات العملاء والتواصل والملاحظات وتصنيف الشرائح')

@section('content')
<div class="container-fluid p-0">
    <!-- Top Action Breadcrumbs / Links -->
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
        <h4 class="fw-bold mb-0">إدارة علاقات العملاء (CRM)</h4>
        @if(Route::has('admin.customer.create'))
            <a href="{{ route('admin.customer.create') }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold">
                <i class="bi bi-person-plus me-1"></i> إضافة عميل جديد
            </a>
        @endif
    </div>

    <!-- Filters & Search -->
    <div class="card mb-4 border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('admin.crm.index') }}" method="GET" class="row g-3 align-items-end">
                <!-- Search box -->
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <label class="form-label fw-bold fs-7">البحث عن عميل</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="الاسم، البريد الإلكتروني، أو الهاتف..." value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Segment Filter -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label class="form-label fw-bold fs-7">تصنيف الشريحة</label>
                    <select name="segment" class="form-select">
                        <option value="">كل الشرائح</option>
                        @foreach(\App\Models\CustomerProfile::$segments as $key => $label)
                            <option value="{{ $key }}" {{ request('segment') === $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort Filter -->
                <div class="col-lg-3 col-md-6 col-sm-12">
                    <label class="form-label fw-bold fs-7">ترتيب حسب</label>
                    <select name="sort" class="form-select">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>تاريخ التسجيل (الأحدث)</option>
                        <option value="spent" {{ request('sort') === 'spent' ? 'selected' : '' }}>إجمالي المشتريات (الأعلى)</option>
                        <option value="orders" {{ request('sort') === 'orders' ? 'selected' : '' }}>عدد الطلبات (الأكثر)</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="col-lg-2 col-md-6 col-sm-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2"><i class="bi bi-funnel-fill me-1"></i> تصفية</button>
                    @if(request()->anyFilled(['search', 'segment', 'sort']))
                        <a href="{{ route('admin.crm.index') }}" class="btn btn-light border py-2" title="إعادة تعيين الفلاتر"><i class="bi bi-arrow-counterclockwise"></i></a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Customer Directory Table -->
    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light fs-7">
                        <tr>
                            <th class="ps-4">العميل</th>
                            <th>التصنيف / الشريحة</th>
                            <th>الهاتف والبريد</th>
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
                                        <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold shadow-xs" 
                                             style="width: 42px; height: 42px; font-size: 1.15rem; background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);">
                                            {{ mb_substr($customer->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.crm.show', $customer->id) }}" class="fw-bold text-dark text-decoration-none">
                                                {{ $customer->name }}
                                            </a>
                                            <small class="text-muted d-block font-monospace fs-8">#{{ $customer->id }}</small>
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
                                    <span class="badge {{ $badgeClass }} fw-semibold rounded-pill px-2.5 py-1">
                                        {{ $customer->profile ? $customer->profile->segment_label : 'ولي أمر' }}
                                    </span>
                                </td>
                                <td>
                                    @if($customer->phone)
                                        <div class="fs-8 fw-semibold text-dark"><i class="bi bi-telephone me-1 text-success"></i><span dir="ltr">{{ $customer->phone }}</span></div>
                                    @endif
                                    @if($customer->email)
                                        <small class="text-muted fs-8 d-block"><i class="bi bi-envelope me-1 text-primary"></i>{{ $customer->email }}</small>
                                    @endif
                                </td>
                                <td class="text-center fw-semibold">
                                    <span class="badge bg-light text-dark border rounded-pill px-2.5">
                                        {{ $customer->orders_count }} طلبات
                                    </span>
                                </td>
                                <td class="fw-bold text-success">
                                    {{ number_format($customer->total_spent ?? 0, 2) }} ج.م
                                </td>
                                <td>
                                    @if($customer->profile && $customer->profile->last_contacted_at)
                                        <span class="text-muted fs-8" title="{{ $customer->profile->last_contacted_at }}">{{ $customer->profile->last_contacted_at->diffForHumans() }}</span>
                                    @else
                                        <span class="text-muted fs-8">لم يتصل بعد</span>
                                    @endif
                                </td>
                                <td class="pe-4 text-end">
                                    <a href="{{ route('admin.crm.show', $customer->id) }}" class="btn btn-sm btn-outline-primary px-3 fw-bold rounded-pill">
                                        <i class="bi bi-person-lines-fill me-1"></i> عرض ملف العميل
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-3 text-secondary"></i> لا يوجد عملاء يطابقون خيارات البحث الحالية.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Pagination -->
        @if($customers->hasPages())
            <div class="card-footer bg-white py-3 border-0">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
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
