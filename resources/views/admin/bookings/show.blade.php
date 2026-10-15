@extends('admin.layouts.layout')

@section('title', 'تفاصيل الحجز #' . $booking->booking_number)

@section('content')
<div class="container-fluid">
    
    <!-- Top Action Bar -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-right"></i> العودة لقائمة الحجوزات
                </a>
                <h4 class="fw-bold mb-0">حجز استشارة #{{ $booking->booking_number }}</h4>
                <span class="badge {{ $booking->status_badge }} px-2.5 py-1.5">{{ $booking->status_label }}</span>
                <span class="badge {{ $booking->payment_status_badge }} px-2.5 py-1.5">{{ $booking->payment_status_label }}</span>
            </div>
            <span class="text-muted small">تم الإنشاء في: {{ $booking->created_at->format('Y/m/d - h:i A') }} ({{ $booking->created_by_admin ? 'تسجيل يدوي بواسطة الإدارة' : 'حجز عبر المتجر الإلكتروني' }})</span>
        </div>

        @php
            $waMsg = "مرحباً أستاذ(ة) {$booking->parent_name}، بخصوص حجز الاستشارة برقم ({$booking->booking_number}) لطفلكم ({$booking->child_name}) - خدمة: ({$booking->service_type_label}) المجدول بتاريخ: ({$booking->booking_date->format('Y/m/d')} - {$booking->booking_time}) بفرع ({$booking->branch_label}). نود تأكيد حضوركم وسنكون بانتظاركم.";
            $cleanPhone = preg_replace('/[^0-9]/', '', $booking->parent_phone);
            if (str_starts_with($cleanPhone, '01')) {
                $cleanPhone = '2' . $cleanPhone;
            }
            $waUrl = "https://wa.me/{$cleanPhone}?text=" . urlencode($waMsg);
        @endphp

        <div class="d-flex gap-2">
            <a href="{{ $waUrl }}" target="_blank" class="btn btn-success fw-bold d-flex align-items-center gap-1.5 shadow-sm">
                <i class="bi bi-whatsapp"></i>
                <span>إرسال تذكير بالموعد (واتساب)</span>
            </a>
            <a href="tel:{{ $booking->parent_phone }}" class="btn btn-outline-primary fw-bold d-flex align-items-center gap-1.5">
                <i class="bi bi-telephone-fill"></i>
                <span>اتصال هاتفي</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        
        <!-- Left: Update & Management Form -->
        <div class="col-lg-7 col-12">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-sliders me-2 text-primary"></i> إدارة وتعديل تفاصيل الموعد والدفع</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            
                            <!-- Status Update -->
                            <div class="col-md-6 col-12">
                                <label class="form-label fw-bold small">حالة الموعد</label>
                                <select name="status" class="form-select fw-bold" required>
                                    @foreach($statuses as $k => $sLabel)
                                        <option value="{{ $k }}" {{ $booking->status === $k ? 'selected' : '' }}>{{ $sLabel }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Payment Status Update -->
                            <div class="col-md-6 col-12">
                                <label class="form-label fw-bold small">حالة الدفع</label>
                                <select name="payment_status" class="form-select fw-bold" required>
                                    @foreach($paymentStatuses as $k => $psLabel)
                                        <option value="{{ $k }}" {{ $booking->payment_status === $k ? 'selected' : '' }}>{{ $psLabel }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Price -->
                            <div class="col-md-6 col-12">
                                <label class="form-label fw-bold small">سعر الاستشارة / الجلسة (ج.م) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01" name="price" value="{{ old('price', $booking->price) }}" class="form-control fw-bold fs-6 text-success" required>
                                    <span class="input-group-text">ج.م</span>
                                </div>
                            </div>

                            <!-- Branch Update -->
                            <div class="col-md-6 col-12">
                                <label class="form-label fw-bold small">الفرع المخصص</label>
                                <select name="booking_branch_id" class="form-select" required>
                                    @foreach($branchesList as $b)
                                        <option value="{{ $b->id }}" {{ ($booking->booking_branch_id == $b->id || $booking->branch == $b->slug) ? 'selected' : '' }}>
                                            {{ $b->name }} ({{ number_format($b->price) }} ج.م)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Service Type -->
                            <div class="col-12">
                                <label class="form-label fw-bold small">نوع الخدمة / الجلسة</label>
                                <select name="service_type" class="form-select" required>
                                    @foreach($services as $k => $sName)
                                        <option value="{{ $k }}" {{ $booking->service_type === $k ? 'selected' : '' }}>{{ $sName }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Date & Time -->
                            <div class="col-md-6 col-12">
                                <label class="form-label fw-bold small">تاريخ الجلسة</label>
                                <input type="date" name="booking_date" class="form-control" value="{{ $booking->booking_date->format('Y-m-d') }}" required>
                            </div>

                            <div class="col-md-6 col-12">
                                <label class="form-label fw-bold small">الفترة / الوقت</label>
                                <input type="text" name="booking_time" class="form-control" value="{{ $booking->booking_time }}" required>
                            </div>

                            <!-- Admin Internal Notes -->
                            <div class="col-12">
                                <label class="form-label fw-bold small text-primary">ملاحظات الإدارة والأخصائي (تقرير الجلسة والمتابعة)</label>
                                <textarea name="admin_notes" rows="3" class="form-control" placeholder="اكتب هنا التقييم، التوصيات، أو تقرير متابعة الجلسة مع الطفل...">{{ $booking->admin_notes }}</textarea>
                                <small class="text-muted">هذه الملاحظات سرية وتظهر فقط في لوحة التحكم للأخصائيين والإدارة.</small>
                            </div>

                            <div class="col-12 text-end pt-3">
                                <button type="submit" class="btn btn-primary px-4 fw-bold shadow-sm">
                                    <i class="bi bi-save-fill me-1"></i> حفظ وتحديث تفاصيل الحجز
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right: Payment Receipt, Client & Child Info Cards -->
        <div class="col-lg-5 col-12">
            
            <!-- Payment Proof Receipt Screenshot Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-receipt me-2 text-success"></i> إشعار الدفع وسكرين شوت التحويل</h6>
                    <span class="badge {{ $booking->payment_status_badge }}">{{ $booking->payment_status_label }}</span>
                </div>
                <div class="card-body p-4">
                    
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small d-block">طريقة الدفع المحددة:</span>
                            <span class="fw-bold text-dark">{{ $booking->payment_method_label }}</span>
                        </div>
                        <div class="text-end">
                            <span class="text-muted small d-block">المبلغ المطلوب:</span>
                            <span class="fw-black text-success fs-5">{{ number_format($booking->price, 2) }} ج.م</span>
                        </div>
                    </div>

                    @if($booking->payment_reference)
                        <div class="p-2.5 rounded-3 bg-light border mb-3 small">
                            <span class="text-muted">رقم العملية / الملاحظة:</span>
                            <span class="fw-bold font-mono text-dark">{{ $booking->payment_reference }}</span>
                        </div>
                    @endif

                    <!-- Receipt Image Preview -->
                    @if($booking->receipt_url)
                        <div class="border rounded-4 p-2 bg-light text-center">
                            <a href="{{ $booking->receipt_url }}" target="_blank" title="اضغط للتكبير">
                                <img src="{{ $booking->receipt_url }}" alt="سكرين شوت إيصال الدفع" class="img-fluid rounded-3 shadow-xs" style="max-height: 320px; object-fit: contain;">
                            </a>
                            <div class="mt-2.5">
                                <a href="{{ $booking->receipt_url }}" target="_blank" class="btn btn-sm btn-outline-primary fw-bold w-full">
                                    <i class="bi bi-arrows-fullscreen me-1"></i> فتح سكرين شوت الدفع بالحجم الكامل
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="p-4 bg-light rounded-4 text-center border border-dashed">
                            <i class="bi bi-file-earmark-x fs-1 text-muted opacity-50 d-block mb-1"></i>
                            <span class="text-muted small">لم يتم رفع صورة إشعار تحويل لهذا الحجز.</span>
                            @if($booking->payment_method === 'at_center')
                                <div class="mt-2 text-info small fw-bold">العميل اختار الدفع عند الحضور في مقر المركز.</div>
                            @endif
                        </div>
                    @endif

                </div>
            </div>

            <!-- Child Details Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 border-0">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-person-heart me-2 text-danger"></i> بيانات الطفل والحالة</h6>
                </div>
                <div class="card-body p-4 pt-0">
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">اسم الطفل:</span>
                            <span class="fw-bold text-dark fs-6">{{ $booking->child_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">عمر الطفل:</span>
                            <span class="fw-bold text-dark">{{ $booking->child_age }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">طريقة المقابلة:</span>
                            <span class="badge bg-light text-dark border">{{ $booking->session_format_label }}</span>
                        </li>
                        <li class="list-group-item px-0 pt-3">
                            <span class="text-muted d-block mb-1 font-bold">شكوى ولي الأمر والملاحظات المدخلة:</span>
                            <div class="p-3 bg-light rounded border text-slate-700">
                                {{ $booking->notes ?: 'لا توجد ملاحظات إضافية مدخلة عند الحجز.' }}
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Parent & CRM Card -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 border-0 d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-people-fill me-2 text-primary"></i> بيانات ولي الأمر والـ CRM</h6>
                    @if($booking->user_id)
                        <a href="{{ route('admin.crm.show', $booking->user_id) }}" class="btn btn-sm btn-outline-primary fw-bold" style="font-size: 11px;">
                            عرض ملف الـ CRM ←
                        </a>
                    @endif
                </div>
                <div class="card-body p-4 pt-0">
                    <ul class="list-group list-group-flush small">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">ولي الأمر:</span>
                            <span class="fw-bold text-dark">{{ $booking->parent_name }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span class="text-muted">رقم الهاتف:</span>
                            <span class="fw-bold font-mono" dir="ltr">{{ $booking->parent_phone }}</span>
                        </li>
                        @if($booking->parent_email)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-muted">البريد الإلكتروني:</span>
                                <span class="font-mono" dir="ltr">{{ $booking->parent_email }}</span>
                            </li>
                        @endif
                        @if($booking->user?->customerProfile)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <span class="text-muted">تصنيف العميل بالـ CRM:</span>
                                <span class="badge bg-info text-dark">{{ $booking->user->customerProfile->segment_label }}</span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
