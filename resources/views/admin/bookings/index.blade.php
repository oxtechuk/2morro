@extends('admin.layouts.layout')

@section('title', 'إدارة الحجوزات والاستشارات')

@section('content')
<div class="container-fluid">
    
    <!-- Header with Action Buttons -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="bi bi-calendar-check-fill text-primary me-2"></i> إدارة الحجوزات ومواعيد الاستشارات</h3>
            <p class="text-muted small mb-0">متابعة مواعيد التقييمات والجلسات، فحص سكرين شوت الدفع، وتأكيد المواعيد.</p>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.bookings.settings') }}" class="btn btn-warning fw-bold text-dark shadow-sm d-flex align-items-center gap-2">
                <i class="bi bi-gear-fill"></i>
                <span>إعدادات الفروع والمواعيد والأسعار</span>
            </a>
            <button type="button" class="btn btn-primary fw-bold shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#newBookingModal">
                <i class="bi bi-plus-circle-fill"></i>
                <span>إضافة حجز يدوياً</span>
            </button>
            <a href="{{ route('booking.index') }}" target="_blank" class="btn btn-outline-secondary fw-bold d-flex align-items-center gap-1.5">
                <i class="bi bi-eye"></i>
                <span>صفحة الحجز بالمتجر</span>
            </a>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card stat-card bg-primary text-white border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="small opacity-75 fw-bold">إجمالي الحجوزات</span>
                            <h3 class="fw-black mb-0 mt-1">{{ number_format($stats['total']) }}</h3>
                        </div>
                        <div class="rounded-3 p-3 bg-white bg-opacity-25">
                            <i class="bi bi-calendar-week-fill fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card stat-card bg-warning text-dark border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="small opacity-75 fw-bold">قيد المراجعة</span>
                            <h3 class="fw-black mb-0 mt-1">{{ number_format($stats['pending']) }}</h3>
                        </div>
                        <div class="rounded-3 p-3 bg-black bg-opacity-10">
                            <i class="bi bi-hourglass-split fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card stat-card bg-success text-white border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="small opacity-75 fw-bold">مدفوعة ومؤكدة</span>
                            <h3 class="fw-black mb-0 mt-1">{{ number_format($stats['paid']) }}</h3>
                        </div>
                        <div class="rounded-3 p-3 bg-white bg-opacity-25">
                            <i class="bi bi-check-circle-fill fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card stat-card bg-info text-white border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="small opacity-75 fw-bold">إجمالي تحصيلات الحجوزات</span>
                            <h3 class="fw-black mb-0 mt-1">{{ number_format($stats['total_revenue'], 2) }} <small class="fs-6">ج.م</small></h3>
                        </div>
                        <div class="rounded-3 p-3 bg-white bg-opacity-25">
                            <i class="bi bi-cash-stack fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Bar -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('admin.bookings.index') }}" method="GET" class="row g-3 align-items-end">
                
                <div class="col-lg-3 col-md-6 col-12">
                    <label class="form-label small fw-bold text-muted">بحث (رقم الحجز، الاسم، أو الهاتف)</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" value="{{ request('search') }}" placeholder="ابحث بالاسم أو رقم الهاتف...">
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <label class="form-label small fw-bold text-muted">حالة الحجز</label>
                    <select name="status" class="form-select">
                        <option value="all">الكل</option>
                        @foreach($statuses as $k => $label)
                            <option value="{{ $k }}" {{ request('status') === $k ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-3 col-6">
                    <label class="form-label small fw-bold text-muted">حالة الدفع</label>
                    <select name="payment_status" class="form-select">
                        <option value="all">كل حالات الدفع</option>
                        @foreach($paymentStatuses as $k => $label)
                            <option value="{{ $k }}" {{ request('payment_status') === $k ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-4 col-6">
                    <label class="form-label small fw-bold text-muted">الفرع</label>
                    <select name="branch" class="form-select">
                        <option value="all">كل الفروع</option>
                        @foreach($branchesList as $b)
                            <option value="{{ $b->slug }}" {{ request('branch') == $b->slug ? 'selected' : '' }}>{{ $b->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-2 col-md-4 col-6">
                    <label class="form-label small fw-bold text-muted">تاريخ الحجز</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                </div>

                <div class="col-lg-1 col-md-4 col-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold" title="تطبيق الفلترة">
                        <i class="bi bi-funnel-fill"></i>
                    </button>
                    @if(request()->hasAny(['search', 'status', 'payment_status', 'branch', 'date']))
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary" title="إلغاء الفلترة">
                            <i class="bi bi-x-lg"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </div>

    <!-- Bookings Table Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-0 d-flex align-items-center justify-content-between">
            <h5 class="mb-0 fw-bold text-dark">جدول الحجوزات ومراجعة الدفع</h5>
            <span class="badge bg-light text-dark border">{{ $bookings->total() }} موعد مسجل</span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light text-muted small fw-bold">
                    <tr>
                        <th class="ps-4">رقم الحجز</th>
                        <th>الطفل وعمره</th>
                        <th>ولي الأمر والتواصل</th>
                        <th>الخدمة والفرع</th>
                        <th>الموعد</th>
                        <th>السعر والدفع</th>
                        <th>إشعار الدفع (Screenshot)</th>
                        <th>حالة الحجز</th>
                        <th class="text-center pe-4">إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        <tr>
                            <td class="ps-4">
                                <span class="fw-bold font-mono text-primary d-block">#{{ $booking->booking_number }}</span>
                                @if($booking->created_by_admin)
                                    <span class="badge bg-light text-secondary border mt-1" style="font-size: 10px;">تسجيل يدوي</span>
                                @endif
                            </td>

                            <td>
                                <span class="fw-bold text-dark d-block">{{ $booking->child_name }}</span>
                                <span class="text-muted small">عمره: {{ $booking->child_age }}</span>
                            </td>

                            <td>
                                <span class="fw-bold text-dark d-block">{{ $booking->parent_name }}</span>
                                <div class="d-flex align-items-center gap-1.5 mt-0.5">
                                    <a href="tel:{{ $booking->parent_phone }}" class="text-muted small" dir="ltr">{{ $booking->parent_phone }}</a>
                                    <a href="https://wa.me/2{{ preg_replace('/[^0-9]/', '', $booking->parent_phone) }}" target="_blank" class="text-success" title="محادثة واتساب">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border fw-semibold d-block mb-1" style="max-width: 170px; white-space: normal;">{{ $booking->service_type_label }}</span>
                                <span class="small fw-bold text-primary">{{ $booking->branch_label }}</span>
                            </td>

                            <td>
                                <span class="fw-bold text-dark d-block">{{ $booking->booking_date ? $booking->booking_date->format('Y/m/d') : '-' }}</span>
                                <span class="text-muted small">{{ $booking->booking_time }}</span>
                            </td>

                            <td>
                                <span class="fw-black text-success fs-6 d-block">{{ number_format($booking->price, 2) }} ج.م</span>
                                <span class="badge {{ $booking->payment_status_badge }} px-2 py-0.5 mt-1 small">
                                    {{ $booking->payment_status_label }}
                                </span>
                                <span class="text-muted small d-block mt-0.5" style="font-size: 11px;">{{ $booking->payment_method_label }}</span>
                            </td>

                            <!-- Payment Receipt Screenshot -->
                            <td>
                                @if($booking->receipt_url)
                                    <a href="{{ $booking->receipt_url }}" target="_blank" class="d-inline-flex align-items-center gap-1.5 p-1 bg-light rounded-3 border text-decoration-none hover-shadow" title="معاينة إشعار الدفع بالحجم الكامل">
                                        <img src="{{ $booking->receipt_url }}" alt="إيصال الدفع" class="rounded-2 object-cover" style="width: 44px; height: 44px; object-fit: cover;">
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small">
                                            <i class="bi bi-eye"></i> سكرين شوت
                                        </span>
                                    </a>
                                @elseif($booking->payment_method === 'at_center')
                                    <span class="badge bg-light text-muted border">دفع بالمركز</span>
                                @else
                                    <span class="text-muted small">لا يوجد إشعار</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge {{ $booking->status_badge }} px-2.5 py-1.5">{{ $booking->status_label }}</span>
                            </td>

                            <td class="text-center pe-4">
                                <div class="d-inline-flex gap-1.5">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary" title="عرض وتعديل وتأكيد الحجز">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    @if($booking->user_id)
                                        <a href="{{ route('admin.crm.show', $booking->user_id) }}" class="btn btn-sm btn-outline-info" title="الملف التعريفي للعميل بالـ CRM">
                                            <i class="bi bi-person-lines-fill"></i>
                                        </a>
                                    @endif

                                    <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا الحجز نهائياً؟');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف الحجز">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-calendar-x fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                <span>لا توجد أي حجوزات تطابق معايير البحث الحالية.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($bookings->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Modal: New Manual Booking -->
<div class="modal fade" id="newBookingModal" tabindex="-1" aria-labelledby="newBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            
            <form action="{{ route('admin.bookings.store') }}" method="POST">
                @csrf
                
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="newBookingModalLabel"><i class="bi bi-plus-circle me-2"></i> إضافة حجز استشارة أو تسجيل عميل يدوياً</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                    <div class="row g-3">
                        
                        <!-- 1. Client Link -->
                        <div class="col-12">
                            <label class="form-label fw-bold small">ربط بعميل مسجل مسبقاً (اختياري)</label>
                            <select name="existing_user_id" class="form-select" onchange="if(this.value){ document.getElementById('parent_name_input').value = this.options[this.selectedIndex].getAttribute('data-name'); document.getElementById('parent_email_input').value = this.options[this.selectedIndex].getAttribute('data-email'); }">
                                <option value="">-- عميل جديد أو غير مسجل --</option>
                                @foreach($users as $u)
                                    <option value="{{ $u->id }}" data-name="{{ $u->name }}" data-email="{{ $u->email }}">
                                        {{ $u->name }} ({{ $u->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 2. Parent details -->
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold small">اسم ولي الأمر <span class="text-danger">*</span></label>
                            <input type="text" name="parent_name" id="parent_name_input" class="form-control" required placeholder="اسم ولي الأمر">
                        </div>

                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold small">رقم الهاتف / الواتساب <span class="text-danger">*</span></label>
                            <input type="tel" name="parent_phone" id="parent_phone_input" class="form-control text-start" dir="ltr" required placeholder="010xxxxxxxx">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small">البريد الإلكتروني (اختياري)</label>
                            <input type="email" name="parent_email" id="parent_email_input" class="form-control text-start" dir="ltr" placeholder="email@example.com">
                        </div>

                        <hr class="my-2 text-muted">

                        <!-- 3. Child details -->
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold small">اسم الطفل <span class="text-danger">*</span></label>
                            <input type="text" name="child_name" class="form-control" required placeholder="اسم الطفل">
                        </div>

                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold small">عمر الطفل <span class="text-danger">*</span></label>
                            <input type="text" name="child_age" class="form-control" required placeholder="مثال: 5 سنوات">
                        </div>

                        <!-- 4. Session & Branch -->
                        <div class="col-12">
                            <label class="form-label fw-bold small">نوع الخدمة / الجلسة <span class="text-danger">*</span></label>
                            <select name="service_type" class="form-select" required>
                                @foreach($services as $k => $sName)
                                    <option value="{{ $k }}">{{ $sName }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold small">طريقة المقابلة <span class="text-danger">*</span></label>
                            <select name="session_format" id="admin_session_format" class="form-select" onchange="toggleAdminBranchField()" required>
                                <option value="in_center">🏥 في مقر المركز</option>
                                <option value="online">💻 أونلاين عن بُعد</option>
                            </select>
                        </div>

                        <div class="col-md-6 col-12" id="admin_branch_col">
                            <label class="form-label fw-bold small">الفرع المختار <span class="text-danger">*</span></label>
                            <select name="booking_branch_id" id="admin_branch" class="form-select" onchange="updatePriceFromBranch(this)">
                                @foreach($branchesList as $b)
                                    @if(!$b->is_online)
                                        <option value="{{ $b->id }}" data-price="{{ $b->price }}">{{ $b->name }} - ({{ number_format($b->price) }} ج.م)</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <!-- 5. Price & Payment Details -->
                        <div class="col-md-4 col-12">
                            <label class="form-label fw-bold small">سعر الاستشارة (ج.م) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" name="price" id="admin_price" class="form-control fw-bold" value="300.00" required>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label fw-bold small">طريقة الدفع</label>
                            <select name="payment_method" class="form-select">
                                @foreach($paymentMethods as $k => $pmLabel)
                                    <option value="{{ $k }}">{{ $pmLabel }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label fw-bold small">حالة الدفع</label>
                            <select name="payment_status" class="form-select">
                                @foreach($paymentStatuses as $k => $psLabel)
                                    <option value="{{ $k }}">{{ $psLabel }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 6. Date, Time & Status -->
                        <div class="col-md-4 col-12">
                            <label class="form-label fw-bold small">تاريخ الموعد <span class="text-danger">*</span></label>
                            <input type="date" name="booking_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label fw-bold small">الفترة / الوقت <span class="text-danger">*</span></label>
                            <input type="text" name="booking_time" class="form-control" value="12:00 PM - 02:00 PM" required placeholder="مثال: 04:00 PM">
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label fw-bold small">حالة الحجز <span class="text-danger">*</span></label>
                            <select name="status" class="form-select" required>
                                @foreach($statuses as $k => $statusLabel)
                                    <option value="{{ $k }}" {{ $k === 'confirmed' ? 'selected' : '' }}>{{ $statusLabel }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 7. Notes -->
                        <div class="col-12">
                            <label class="form-label fw-bold small">ملاحظات ولي الأمر والشكوى</label>
                            <textarea name="notes" rows="2" class="form-control" placeholder="تفاصيل إضافية عن الطفل..."></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small">ملاحظات الإدارة والأخصائي (داخلية)</label>
                            <textarea name="admin_notes" rows="2" class="form-control" placeholder="ملاحظات سرية للإدارة والأخصائي فقط..."></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">
                        <i class="bi bi-check-circle-fill me-1"></i> حفظ وتسجيل الحجز
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<script>
    function toggleAdminBranchField() {
        const format = document.getElementById('admin_session_format');
        const branchCol = document.getElementById('admin_branch_col');
        const branchSelect = document.getElementById('admin_branch');

        if (!format || !branchCol) return;

        if (format.value === 'online') {
            branchCol.classList.add('d-none');
            branchSelect.removeAttribute('required');
            branchSelect.disabled = true;
        } else {
            branchCol.classList.remove('d-none');
            branchSelect.setAttribute('required', 'required');
            branchSelect.disabled = false;
        }
    }

    function updatePriceFromBranch(select) {
        const priceInput = document.getElementById('admin_price');
        const selectedOption = select.options[select.selectedIndex];
        if (selectedOption && selectedOption.dataset.price) {
            priceInput.value = selectedOption.dataset.price;
        }
    }
</script>
@endsection
