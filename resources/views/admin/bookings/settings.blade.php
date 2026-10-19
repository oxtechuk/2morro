@extends('admin.layouts.layout')

@section('title', 'إعدادات أنواع الحجوزات والفروع وطرق الدفع')

@section('content')
<div class="container-fluid px-3 px-md-4 py-3">

    <!-- Page Header & Quick Navigation -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
        <div class="card-body p-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="w-12 h-12 rounded-4 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 52px; height: 52px; font-size: 26px;">
                        <i class="bi bi-sliders2-vertical"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                            <h3 class="fw-bold mb-0 text-dark">إعدادات الحجوزات، المواعيد، وطرق الدفع</h3>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-1.5 small fw-bold">
                                <i class="bi bi-check-circle-fill me-1"></i> النظام نشط
                            </span>
                        </div>
                        <p class="text-muted small mb-0">
                            تحديد وتخصيص أنواع الحجوزات (حجز عادي، حجز مستعجل، أونلاين)، أسعار الجلسات، مواعيد فروع المركز، وحسابات الدفع (فودافون كاش وإنستاباي).
                        </p>
                    </div>
                </div>
                
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <button type="button" class="btn btn-primary fw-bold shadow-sm rounded-3 px-3 py-2 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#newBranchModal">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>إضافة فرع جديد</span>
                    </button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary fw-bold rounded-3 px-3 py-2 d-flex align-items-center gap-2">
                        <i class="bi bi-calendar-check-fill text-primary"></i>
                        <span>قائمة الحجوزات</span>
                    </a>
                    <a href="{{ route('booking.index') }}" target="_blank" class="btn btn-outline-info fw-bold rounded-3 px-3 py-2 d-flex align-items-center gap-2">
                        <i class="bi bi-box-arrow-up-right"></i>
                        <span>معاينة صفحة الحجز</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Feedback Alerts -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4 d-flex align-items-center gap-2" role="alert">
            <i class="bi bi-check-circle-fill fs-5 text-success"></i>
            <span class="fw-bold">{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 p-3 mb-4" role="alert">
            <div class="d-flex align-items-center gap-2 mb-2">
                <i class="bi bi-exclamation-octagon-fill fs-5 text-danger"></i>
                <h6 class="fw-bold mb-0 text-danger">يرجى تصحيح الأخطاء التالية قبل الحفظ:</h6>
            </div>
            <ul class="mb-0 small ps-4">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Quick Stats Cards (Overview) -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold">فروع المركز</span>
                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2.5 py-1">متاحة</span>
                </div>
                <div class="d-flex align-items-baseline gap-2">
                    <h4 class="fw-bold mb-0 text-dark">{{ $branches->count() }}</h4>
                    <span class="text-muted small">فروع مسجلة</span>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 border-start border-4 border-success">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold">الحجز العادي (حضوري)</span>
                    <span class="badge {{ $scheduleConfig['normal']['enabled'] ? 'bg-success' : 'bg-secondary' }} bg-opacity-10 {{ $scheduleConfig['normal']['enabled'] ? 'text-success' : 'text-secondary' }} rounded-pill px-2.5 py-1">
                        {{ $scheduleConfig['normal']['enabled'] ? 'مفعل' : 'معطل' }}
                    </span>
                </div>
                <div class="d-flex align-items-baseline gap-1">
                    <h4 class="fw-bold mb-0 text-success">{{ number_format((float)$scheduleConfig['normal']['price']) }}</h4>
                    <span class="text-muted small">ج.م (سعر الجلسة)</span>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 border-start border-4 border-danger">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold">الحجز المستعجل (طوارئ)</span>
                    <span class="badge {{ $scheduleConfig['urgent']['enabled'] ? 'bg-danger' : 'bg-secondary' }} bg-opacity-10 {{ $scheduleConfig['urgent']['enabled'] ? 'text-danger' : 'text-secondary' }} rounded-pill px-2.5 py-1">
                        {{ $scheduleConfig['urgent']['enabled'] ? 'مفعل' : 'معطل' }}
                    </span>
                </div>
                <div class="d-flex align-items-baseline gap-1">
                    <h4 class="fw-bold mb-0 text-danger">{{ number_format((float)$scheduleConfig['urgent']['price']) }}</h4>
                    <span class="text-muted small">ج.م (سعر الجلسة)</span>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 border-start border-4 border-info">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-bold">حجز أونلاين (Zoom)</span>
                    <span class="badge {{ $scheduleConfig['online']['enabled'] ? 'bg-info' : 'bg-secondary' }} bg-opacity-10 {{ $scheduleConfig['online']['enabled'] ? 'text-info' : 'text-secondary' }} rounded-pill px-2.5 py-1">
                        {{ $scheduleConfig['online']['enabled'] ? 'مفعل' : 'معطل' }}
                    </span>
                </div>
                <div class="d-flex align-items-baseline gap-1">
                    <h4 class="fw-bold mb-0 text-info">{{ number_format((float)$scheduleConfig['online']['price']) }}</h4>
                    <span class="text-muted small">ج.م (للجلسة)</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Configuration Form (Settings & Booking Types) -->
    <form action="{{ route('admin.bookings.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- ======================================================== -->
        <!-- SECTION 1: Booking Types & Urgency (عادي / مستعجل / أونلاين) -->
        <!-- ======================================================== -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
            <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2">
                    <span class="w-8 h-8 rounded-3 bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                        <i class="bi bi-tags-fill fs-5"></i>
                    </span>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">تحديد وإعداد أنواع الحجوزات (عادي / مستعجل / أون لاين)</h5>
                        <span class="text-muted small">حدد الخيارات المتاحة لأولياء الأمور في صفحة الحجز مع أسعار ورسوم كل نوع ووصفه.</span>
                    </div>
                </div>
                <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1.5 rounded-pill fw-bold small">
                    <i class="bi bi-clock-history me-1"></i> مدة الجلسة: {{ $paymentSettings['session_duration'] }}
                </span>
            </div>

            <div class="card-body p-4">
                <div class="row g-4">
                    
                    <!-- 1. Normal Booking Card (حجز عادي حضوري) -->
                    <div class="col-lg-4 col-md-12 col-12">
                        <div class="card h-100 rounded-4 border-2 {{ $scheduleConfig['normal']['enabled'] ? 'border-success' : 'border-light-subtle' }} shadow-xs bg-body-tertiary p-3">
                            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="w-9 h-9 rounded-3 bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <i class="bi bi-calendar2-check-fill fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">1. حجز عادي (حضوري)</h6>
                                        <span class="text-muted small">تقويم وجدول المقابلات العادية بالمركز</span>
                                    </div>
                                </div>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input fs-5" type="checkbox" name="booking_normal_enabled" id="normalEnabled" value="1" {{ $scheduleConfig['normal']['enabled'] ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="form-label small fw-bold text-dark">السعر المعتمد للكشف (ج.م) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="booking_normal_price" value="{{ old('booking_normal_price', $scheduleConfig['normal']['price']) }}" class="form-control fw-bold" placeholder="300.00" required>
                                        <span class="input-group-text bg-light fw-bold">ج.م</span>
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label small fw-bold text-dark">الوصف المختصر بصفحة الحجز</label>
                                    <input type="text" name="booking_normal_desc" value="{{ old('booking_normal_desc', $scheduleConfig['normal']['desc']) }}" class="form-control small" placeholder="حضور في مقر المركز ومقابلة مباشرة وفق جدول الفترات المعتمدة">
                                </div>

                                <!-- Days of Week in Calendar -->
                                <div>
                                    <label class="form-label small fw-bold text-dark d-block">أيام الأسبوع المتاحة في التقويم:</label>
                                    <div class="d-flex flex-wrap gap-1.5 p-2 bg-white rounded-3 border">
                                        @foreach($allDays as $dayKey => $dayLabel)
                                            <label class="btn btn-xs btn-outline-success border-opacity-50 d-inline-flex align-items-center gap-1 rounded-pill px-2.5 py-1">
                                                <input type="checkbox" name="booking_normal_days[]" value="{{ $dayKey }}" class="form-check-input mt-0" {{ in_array($dayKey, $scheduleConfig['normal']['days']) ? 'checked' : '' }}>
                                                <span>{{ $dayLabel }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <span class="text-muted small d-block mt-1">الأيام المحددة فقط هي التي تضاء وتفتح في تقويم الحجز العادي.</span>
                                </div>

                                <!-- Time Slots for Normal -->
                                <div>
                                    <label class="form-label small fw-bold text-dark d-block">الساعات والفترات المتاحة (سطر لكل فترة):</label>
                                    <textarea name="booking_normal_slots" rows="4" class="form-control font-monospace small" placeholder="12:00 PM - 02:00 PM&#10;02:00 PM - 04:00 PM&#10;04:00 PM - 06:30 PM&#10;06:30 PM - 09:00 PM">{{ implode("\n", $scheduleConfig['normal']['slots']) }}</textarea>
                                    <span class="text-muted small d-block mt-1">تظهر هذه الساعات للعميل فور اختياره اليوم من التقويم.</span>
                                </div>

                                <!-- Slot Capacity -->
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-dark">أقصى عدد حجوزات في الساعة الواحدة (السعة):</label>
                                        <input type="number" min="1" max="20" name="booking_normal_slot_capacity" value="{{ old('booking_normal_slot_capacity', $scheduleConfig['normal']['slot_capacity']) }}" class="form-control text-center fw-bold" placeholder="1">
                                        <span class="text-muted small d-block mt-0.5">عند اكتمال العدد يتم حجب الفترة تلقائياً في التقويم.</span>
                                    </div>
                                </div>

                                <!-- Off Dates in Month (Exceptions) -->
                                <div>
                                    <label class="form-label small fw-bold text-dark">أيام مستثناة / إجازات في الشهر (YYYY-MM-DD):</label>
                                    <input type="text" name="booking_normal_off_dates" value="{{ implode(', ', $scheduleConfig['normal']['off_dates']) }}" class="form-control small font-monospace" placeholder="مثال: 2026-11-01, 2026-11-15">
                                    <span class="text-muted small d-block mt-0.5">تُعطّل هذه التواريخ في التقويم حتى لو كانت ضمن أيام العمل.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Urgent Booking Card (حجز مستعجل أولوية) -->
                    <div class="col-lg-4 col-md-12 col-12">
                        <div class="card h-100 rounded-4 border-2 {{ $scheduleConfig['urgent']['enabled'] ? 'border-danger' : 'border-light-subtle' }} shadow-xs bg-body-tertiary p-3">
                            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="w-9 h-9 rounded-3 bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <i class="bi bi-lightning-charge-fill fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">2. حجز مستعجل (طوارئ)</h6>
                                        <span class="text-danger small fw-bold">تقويم ومواعيد الأولوية السريعة ⚡</span>
                                    </div>
                                </div>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input fs-5" type="checkbox" name="booking_urgent_enabled" id="urgentEnabled" value="1" {{ $scheduleConfig['urgent']['enabled'] ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="form-label small fw-bold text-dark">السعر الإجمالي للكشف المستعجل (ج.م) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="booking_urgent_price" value="{{ old('booking_urgent_price', $scheduleConfig['urgent']['price']) }}" class="form-control fw-bold text-danger" placeholder="450.00" required>
                                        <span class="input-group-text bg-light fw-bold">ج.م</span>
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label small fw-bold text-dark">الوصف المختصر للعميل</label>
                                    <input type="text" name="booking_urgent_desc" value="{{ old('booking_urgent_desc', $scheduleConfig['urgent']['desc']) }}" class="form-control small" placeholder="كشف ومقابلة ذات أولوية قصوى خلال 24 إلى 48 ساعة">
                                </div>

                                <!-- Urgent Window Setting -->
                                <div>
                                    <label class="form-label small fw-bold text-dark">أقصى نافذة زمنية للتقويم المستعجل:</label>
                                    <div class="input-group">
                                        <input type="number" min="1" max="7" name="booking_urgent_max_days_ahead" value="{{ old('booking_urgent_max_days_ahead', $scheduleConfig['urgent']['max_days_ahead'] ?? 2) }}" class="form-control text-center fw-bold">
                                        <span class="input-group-text bg-light small">أيام من تاريخ اليوم</span>
                                    </div>
                                    <span class="text-muted small d-block mt-0.5">التقويم يفتح للعميل فقط خلال الـ 24 إلى 48 ساعة القادمة للحفاظ على الأولوية.</span>
                                </div>

                                <!-- Days of Week for Urgent -->
                                <div>
                                    <label class="form-label small fw-bold text-dark d-block">أيام استقبال الحالات المستعجلة:</label>
                                    <div class="d-flex flex-wrap gap-1.5 p-2 bg-white rounded-3 border">
                                        @foreach($allDays as $dayKey => $dayLabel)
                                            <label class="btn btn-xs btn-outline-danger border-opacity-50 d-inline-flex align-items-center gap-1 rounded-pill px-2.5 py-1">
                                                <input type="checkbox" name="booking_urgent_days[]" value="{{ $dayKey }}" class="form-check-input mt-0" {{ in_array($dayKey, $scheduleConfig['urgent']['days']) ? 'checked' : '' }}>
                                                <span>{{ $dayLabel }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Time Slots for Urgent -->
                                <div>
                                    <label class="form-label small fw-bold text-dark d-block">الساعات والفترات المخصصة للمستعجل:</label>
                                    <textarea name="booking_urgent_slots" rows="3" class="form-control font-monospace small" placeholder="10:00 AM - 11:30 AM&#10;01:00 PM - 02:30 PM&#10;08:00 PM - 09:30 PM">{{ implode("\n", $scheduleConfig['urgent']['slots']) }}</textarea>
                                </div>

                                <!-- Capacity -->
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-dark">سعة الفترة المستعجلة:</label>
                                        <input type="number" min="1" max="10" name="booking_urgent_slot_capacity" value="{{ old('booking_urgent_slot_capacity', $scheduleConfig['urgent']['slot_capacity']) }}" class="form-control text-center fw-bold" placeholder="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Online Booking Card (حجز أونلاين Zoom) -->
                    <div class="col-lg-4 col-md-12 col-12">
                        <div class="card h-100 rounded-4 border-2 {{ $scheduleConfig['online']['enabled'] ? 'border-info' : 'border-light-subtle' }} shadow-xs bg-body-tertiary p-3">
                            <div class="d-flex align-items-center justify-content-between mb-3 pb-2 border-bottom">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="w-9 h-9 rounded-3 bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <i class="bi bi-camera-video-fill fs-5"></i>
                                    </div>
                                    <div>
                                        <h6 class="fw-bold mb-0 text-dark">3. حجز أونلاين (عن بُعد)</h6>
                                        <span class="text-info small fw-bold">تقويم وساعات الاستشارات بالفيديو 💻</span>
                                    </div>
                                </div>
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input fs-5" type="checkbox" name="booking_online_enabled" id="onlineEnabled" value="1" {{ $scheduleConfig['online']['enabled'] ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <label class="form-label small fw-bold text-dark">سعر جلسة الاستشارة الأونلاين (ج.م) <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="number" step="0.01" name="booking_online_price" value="{{ old('booking_online_price', $scheduleConfig['online']['price']) }}" class="form-control fw-bold text-info" placeholder="350.00" required>
                                        <span class="input-group-text bg-light fw-bold">ج.م</span>
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label small fw-bold text-dark">الوصف المختصر للعميل</label>
                                    <input type="text" name="booking_online_desc" value="{{ old('booking_online_desc', $scheduleConfig['online']['desc']) }}" class="form-control small" placeholder="جلسة تقييم واستشارة بالفيديو عن بُعد عبر Zoom / Google Meet">
                                </div>

                                <div>
                                    <label class="form-label small fw-bold text-dark">المنصة الافتراضية للجلسة:</label>
                                    <input type="text" name="booking_online_platform" value="{{ old('booking_online_platform', $scheduleConfig['online']['platform'] ?? 'Zoom / Google Meet') }}" class="form-control small" placeholder="Zoom / Google Meet">
                                </div>

                                <!-- Days of Week for Online -->
                                <div>
                                    <label class="form-label small fw-bold text-dark d-block">أيام تقديم الجلسات الأونلاين:</label>
                                    <div class="d-flex flex-wrap gap-1.5 p-2 bg-white rounded-3 border">
                                        @foreach($allDays as $dayKey => $dayLabel)
                                            <label class="btn btn-xs btn-outline-info border-opacity-50 d-inline-flex align-items-center gap-1 rounded-pill px-2.5 py-1">
                                                <input type="checkbox" name="booking_online_days[]" value="{{ $dayKey }}" class="form-check-input mt-0" {{ in_array($dayKey, $scheduleConfig['online']['days']) ? 'checked' : '' }}>
                                                <span>{{ $dayLabel }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    <span class="text-muted small d-block mt-1">تتيح لك تحديد أيام مخصصة للأونلاين مستقلة عن أيام الحضور بالمركز.</span>
                                </div>

                                <!-- Time Slots for Online -->
                                <div>
                                    <label class="form-label small fw-bold text-dark d-block">الساعات والفترات المتاحة للأونلاين:</label>
                                    <textarea name="booking_online_slots" rows="3" class="form-control font-monospace small" placeholder="05:00 PM - 06:00 PM&#10;06:00 PM - 07:00 PM&#10;07:00 PM - 08:00 PM">{{ implode("\n", $scheduleConfig['online']['slots']) }}</textarea>
                                </div>

                                <!-- Capacity -->
                                <div class="row g-2">
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-dark">أقصى عدد حجوزات في الساعة (السعة):</label>
                                        <input type="number" min="1" max="10" name="booking_online_slot_capacity" value="{{ old('booking_online_slot_capacity', $scheduleConfig['online']['slot_capacity']) }}" class="form-control text-center fw-bold" placeholder="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Session Duration Setting -->
                    <div class="col-12 pt-2">
                        <div class="p-3 rounded-4 bg-light border d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="w-10 h-10 rounded-3 bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                                    <i class="bi bi-hourglass-split fs-5"></i>
                                </div>
                                <div>
                                    <label class="fw-bold mb-0 text-dark d-block">متوسط مدة الجلسة الاستشارية / الكشف</label>
                                    <span class="text-muted small">الوقت التقديري المخصص لكل جلسة حجز ويظهر للمراجعين وللجدول.</span>
                                </div>
                            </div>
                            <div style="min-width: 220px;">
                                <input type="text" name="booking_session_duration" value="{{ old('booking_session_duration', $paymentSettings['session_duration']) }}" class="form-control fw-bold text-center" placeholder="مثال: 45 دقيقة">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- ======================================================== -->
        <!-- SECTION 2 & 3: Payments Accounts & Storefront Presentation -->
        <!-- ======================================================== -->
        <div class="row g-4 mb-4">
            
            <!-- Left Card: Payment Accounts (Col 6) -->
            <div class="col-lg-6 col-12">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-2">
                        <span class="w-8 h-8 rounded-3 bg-success bg-opacity-10 text-success d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="bi bi-credit-card-2-front-fill fs-5"></i>
                        </span>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">طرق الدفع وحسابات التحويل (فودافون كاش وإنستاباي)</h5>
                            <span class="text-muted small">الحسابات التي تظهر لولي الأمر لتحويل قيمة الحجز ورفع الإشعار.</span>
                        </div>
                    </div>
                    
                    <div class="card-body p-4 space-y-3">
                        
                        <!-- Vodafone Cash -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark d-flex align-items-center gap-2">
                                <span class="badge bg-danger px-2 py-1 rounded">Vodafone Cash</span>
                                <span>رقم محفظة فودافون كاش</span>
                            </label>
                            <div class="input-group">
                                <input type="text" name="booking_vodafone_cash" value="{{ old('booking_vodafone_cash', $paymentSettings['vodafone_cash']) }}" class="form-control fw-bold font-monospace" placeholder="010xxxxxxxx" dir="ltr">
                                <span class="input-group-text"><i class="bi bi-phone"></i></span>
                            </div>
                            <span class="form-text text-muted small">الرقم المعتمد لتحويل كاش. يمكن لولي الأمر نسخه بنقرة واحدة.</span>
                        </div>

                        <!-- InstaPay -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark d-flex align-items-center gap-2">
                                <span class="badge bg-primary px-2 py-1 rounded">InstaPay</span>
                                <span>معرف أو هاتف إنستاباي (IPA)</span>
                            </label>
                            <div class="input-group">
                                <input type="text" name="booking_instapay" value="{{ old('booking_instapay', $paymentSettings['instapay']) }}" class="form-control fw-bold font-monospace" placeholder="username@instapay أو 01xxxxxxxxx" dir="ltr">
                                <span class="input-group-text"><i class="bi bi-send-check"></i></span>
                            </div>
                            <span class="form-text text-muted small">عنوان الدفع اللحظي عبر إنستاباي أو الهاتف المرتبط.</span>
                        </div>

                        <!-- Bank Details -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">بيانات التحويل البنكي (اختياري)</label>
                            <textarea name="booking_bank_details" rows="2" class="form-control small" placeholder="اسم البنك، اسم صاحب الحساب، رقم الحساب أو الآيبان IBAN...">{{ old('booking_bank_details', $paymentSettings['bank_details']) }}</textarea>
                        </div>

                        <!-- Payment Instructions Note -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">إرشادات التحويل (تظهر لولي الأمر بصفحة الحجز)</label>
                            <textarea name="booking_payment_instructions" rows="2" class="form-control small" placeholder="تعليمات التحويل وإرفاق السكرين شوت...">{{ old('booking_payment_instructions', $paymentSettings['instructions']) }}</textarea>
                        </div>

                        <!-- Allow Cash at Center Option -->
                        <div class="p-3 bg-light rounded-3 border">
                            <div class="form-check form-switch m-0">
                                <input class="form-check-input" type="checkbox" name="booking_allow_cash_at_center" id="allowCash" value="1" {{ $paymentSettings['allow_cash_at_center'] ? 'checked' : '' }}>
                                <label class="form-check-label small fw-bold text-dark ms-2" for="allowCash">
                                    إتاحة خيار "الدفع نقداً عند الحضور بالمركز" (للحجوزات الحضورية فقط)
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Right Card: Storefront Page Presentation (Col 6) -->
            <div class="col-lg-6 col-12">
                <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                    <div class="card-header bg-white border-bottom py-3 px-4 d-flex align-items-center gap-2">
                        <span class="w-8 h-8 rounded-3 bg-info bg-opacity-10 text-info d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                            <i class="bi bi-window-fullscreen fs-5"></i>
                        </span>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark">مظهر ونصوص صفحة الحجز العامة</h5>
                            <span class="text-muted small">العناوين والمقولة والرسالة الترحيبية المعروضة للجمهور.</span>
                        </div>
                    </div>
                    
                    <div class="card-body p-4 space-y-3">
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">العنوان الرئيسي لصفحة الحجز</label>
                            <input type="text" name="booking_page_title" value="{{ old('booking_page_title', $paymentSettings['booking_page_title']) }}" class="form-control fw-bold" placeholder="حجز استشارة وتقييم مهارات الطفل">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">الوصف التعريفي المختصر</label>
                            <textarea name="booking_page_subtitle" rows="2" class="form-control small" placeholder="مركز 2morro المتخصص في رعاية وتأهيل وتنمية قدرات الأطفال...">{{ old('booking_page_subtitle', $paymentSettings['booking_page_subtitle']) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">المقولة / الرسالة البارزة (Quote)</label>
                            <textarea name="booking_page_quote" rows="2" class="form-control small" placeholder="« عندما تشعرين بأن طفلك بحاجة لدعم وتأهيل... »">{{ old('booking_page_quote', $paymentSettings['booking_page_quote']) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">صورة الغلاف / كارت المركز</label>
                            @if(!empty($paymentSettings['booking_image']))
                                <div class="mb-2 d-flex align-items-center gap-3 p-2 bg-light rounded-3 border">
                                    <img src="{{ asset($paymentSettings['booking_image']) }}" alt="غلاف الحجز" class="rounded-3 shadow-2xs" style="width: 60px; height: 60px; object-fit: cover;">
                                    <div class="small">
                                        <span class="fw-bold d-block text-dark">الصورة الحالية</span>
                                        <span class="text-muted font-monospace" style="font-size: 11px;">{{ $paymentSettings['booking_image'] }}</span>
                                    </div>
                                </div>
                            @endif
                            <input type="file" name="booking_image" accept="image/*" class="form-control">
                            <span class="form-text text-muted small">يقبل صور PNG, JPG, WEBP بحجم أقصى 4MB.</span>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        <!-- Sticky / Primary Action Button Bar -->
        <div class="card border-0 shadow-sm rounded-4 mb-5 bg-white p-3">
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-info-circle-fill text-primary fs-5"></i>
                    <span class="text-muted small">عند الضغط على الحفظ، سيتم تحديث أسعار الحجز وطرق الدفع فوراً للموقع والعملاء.</span>
                </div>
                <button type="submit" class="btn btn-success fw-bold px-5 py-2.5 rounded-3 shadow-sm d-flex align-items-center gap-2">
                    <i class="bi bi-check2-circle fs-5"></i>
                    <span>حفظ وتطبيق جميع الإعدادات</span>
                </button>
            </div>
        </div>

    </form>

    <!-- ======================================================== -->
    <!-- SECTION 4: Center Branches & Time Slots Management       -->
    <!-- ======================================================== -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
        <div class="card-header bg-white border-bottom py-3 px-4 d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
            <div class="d-flex align-items-center gap-2">
                <span class="w-8 h-8 rounded-3 bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                    <i class="bi bi-geo-alt-fill fs-5"></i>
                </span>
                <div>
                    <h5 class="fw-bold mb-0 text-dark">فروع المركز ومواعيد المقابلات المتاحة</h5>
                    <span class="text-muted small">يمكنك تخصيص فروع المركز، أيام العمل الأسبوعية، الفترات الزمنية المتاحة، وسعر الجلسة لكل فرع.</span>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-primary rounded-pill px-3 py-2 fw-bold">{{ $branches->count() }} فروع مسجلة</span>
                <button type="button" class="btn btn-sm btn-primary fw-bold rounded-3 px-3 py-2 d-flex align-items-center gap-1.5" data-bs-toggle="modal" data-bs-target="#newBranchModal">
                    <i class="bi bi-plus-lg"></i>
                    <span>فرع جديد</span>
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="table-light text-muted small fw-bold">
                        <tr>
                            <th class="ps-4">اسم الفرع والموقع</th>
                            <th>سعر الاستشارة</th>
                            <th>أيام العمل المعتمدة</th>
                            <th>الفترات الزمنية</th>
                            <th>النوع</th>
                            <th>الحالة</th>
                            <th class="text-end pe-4">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($branches as $branch)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-3 {{ $branch->is_online ? 'bg-info bg-opacity-10 text-info' : 'bg-primary bg-opacity-10 text-primary' }} d-flex align-items-center justify-content-center flex-shrink-0" style="width: 42px; height: 42px;">
                                            <i class="bi {{ $branch->is_online ? 'bi-camera-video-fill' : 'bi-building' }} fs-5"></i>
                                        </div>
                                        <div>
                                            <span class="fw-bold text-dark d-block fs-6">{{ $branch->name }}</span>
                                            <span class="text-muted small text-truncate d-block" style="max-width: 240px;">
                                                <i class="bi bi-geo-alt me-1 text-danger"></i>
                                                {{ $branch->address ?: 'بدون عنوان محدد' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <span class="fw-bold text-success fs-6">{{ number_format($branch->price, 2) }}</span>
                                        <span class="text-muted small">ج.م (عادي)</span>
                                    </div>
                                    @if($branch->urgent_price)
                                        <div class="small mt-0.5">
                                            <span class="fw-bold text-danger">{{ number_format($branch->urgent_price, 2) }}</span>
                                            <span class="text-muted" style="font-size: 11px;">ج.م (مستعجل ⚡)</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1" style="max-width: 260px;">
                                        <div class="d-flex flex-wrap gap-1 align-items-center">
                                            <span class="text-muted small fw-bold me-1" style="font-size: 11px;">عادي:</span>
                                            @foreach($branch->days_list as $day)
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 small px-1.5 py-0.5">{{ $day }}</span>
                                            @endforeach
                                        </div>
                                        @if(!empty($branch->specific_dates_list))
                                            <div class="text-primary small" style="font-size: 11px;">
                                                <i class="bi bi-calendar-check text-primary me-1"></i>شهر: {{ implode(', ', $branch->specific_dates_list) }}
                                            </div>
                                        @endif
                                        @if(!empty($branch->urgent_dates_list))
                                            <div class="text-danger small" style="font-size: 11px;">
                                                <i class="bi bi-lightning-charge text-danger me-1"></i>طوارئ: {{ implode(', ', $branch->urgent_dates_list) }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1" style="max-width: 190px;">
                                        @foreach(array_slice($branch->slots_list, 0, 2) as $slot)
                                            <span class="badge bg-slate-100 text-slate-700 font-monospace small px-2 py-1" style="background:#f1f5f9; color:#334155;">{{ $slot }}</span>
                                        @endforeach
                                        @if(count($branch->slots_list) > 2)
                                            <span class="text-muted small" style="font-size: 11px;">+ {{ count($branch->slots_list) - 2 }} فترات زمنية أخرى</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($branch->is_online)
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2.5 py-1.5 rounded-pill small fw-bold">
                                            💻 أونلاين
                                        </span>
                                    @else
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1.5 rounded-pill small fw-bold">
                                            🏥 في المركز
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($branch->is_active)
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1.5 rounded-pill small fw-bold">
                                            <i class="bi bi-check-circle me-1"></i> نشط
                                        </span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2.5 py-1.5 rounded-pill small fw-bold">
                                            <i class="bi bi-pause-circle me-1"></i> معطل
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-inline-flex gap-1">
                                        <button type="button" class="btn btn-sm btn-outline-primary rounded-2" data-bs-toggle="modal" data-bs-target="#editBranchModal{{ $branch->id }}" title="تعديل بيانات ومواعيد الفرع">
                                            <i class="bi bi-pencil-square"></i>
                                            <span class="ms-1">تعديل</span>
                                        </button>
                                        <form action="{{ route('admin.bookings.branches.destroy', $branch) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف فرع ({{ $branch->name }}) نهائياً؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-2" title="حذف الفرع">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <div class="py-4">
                                        <i class="bi bi-inbox fs-1 d-block mb-2 text-slate-300"></i>
                                        <h6 class="fw-bold text-dark">لم يتم إضافة أي فروع حتى الآن</h6>
                                        <p class="text-muted small mb-3">قم بإضافة فروع المركز ليتمكن أولياء الأمور من اختيار الفرع المناسب وتحديد الموعد.</p>
                                        <button type="button" class="btn btn-primary fw-bold rounded-3 px-3 py-2" data-bs-toggle="modal" data-bs-target="#newBranchModal">
                                            <i class="bi bi-plus-circle me-1"></i> إضافة أول فرع
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- ============================================== -->
<!-- MODAL: Add New Branch                          -->
<!-- ============================================== -->
<div class="modal fade" id="newBranchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-primary text-white py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-plus-circle-fill fs-5"></i>
                    <h5 class="modal-title fw-bold">إضافة فرع ومواعيد جديدة</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.bookings.branches.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        
                        <div class="col-md-6 col-12">
                            <label class="form-label small fw-bold">اسم الفرع <span class="text-danger">*</span></label>
                            <input type="text" name="name" required placeholder="مثال: فرع الإبراهيمية" class="form-control">
                        </div>

                        <div class="col-md-6 col-12">
                            <label class="form-label small fw-bold">سعر الحجز العادي بالفرع (ج.م) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="price" required value="300.00" class="form-control fw-bold">
                                <span class="input-group-text bg-light fw-bold">ج.م</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label class="form-label small fw-bold">سعر الحجز المستعجل بالفرع (ج.م)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="urgent_price" placeholder="450.00" class="form-control fw-bold text-danger">
                                <span class="input-group-text bg-light fw-bold">ج.م</span>
                            </div>
                            <span class="text-muted small" style="font-size: 11px;">اتركه فارغاً لاستخدام السعر العام للخدمة المستعجلة.</span>
                        </div>

                        <div class="col-md-8 col-12">
                            <label class="form-label small fw-bold">العنوان وموقع الفرع</label>
                            <input type="text" name="address" placeholder="مثال: أول شارع لاجتيه من أبو قير - عمارة الأطباء" class="form-control">
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label small fw-bold">رقم هاتف الفرع (اختياري)</label>
                            <input type="text" name="phone" placeholder="01550504512" class="form-control" dir="ltr">
                        </div>

                        <!-- 1. Normal Schedule Section -->
                        <div class="col-12 p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold text-primary mb-2"><i class="bi bi-calendar3 me-1"></i> 1. جدول الحجز العادي (في المركز)</h6>
                            <label class="form-label small fw-bold text-dark d-block mb-1">أيام العمل الأسبوعية المعتمدة <span class="text-danger">*</span>:</label>
                            <div class="d-flex flex-wrap gap-2 mb-2.5">
                                @foreach($allDays as $enDay => $arDay)
                                    <div class="form-check form-check-inline me-2">
                                        <input class="form-check-input" type="checkbox" name="available_days[]" value="{{ $arDay }}" id="newDay_{{ $enDay }}" {{ $arDay !== 'الجمعة' ? 'checked' : '' }}>
                                        <label class="form-check-label small fw-bold" for="newDay_{{ $enDay }}">{{ $arDay }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <label class="form-label small fw-bold text-dark d-block mb-1">تواريخ محددة في الشهر للحجز العادي (اختياري):</label>
                            <textarea name="specific_dates" rows="2" class="form-control font-monospace small" placeholder="مثال: 2026-11-01&#10;2026-11-08"></textarea>
                            <span class="text-muted small" style="font-size: 11px;">إذا وضعت تواريخ محددة هنا، سيفتح التقويم هذه الأيام فقط في الشهر للعملاء (مثل: 1/11).</span>
                        </div>

                        <!-- 2. Urgent Schedule Section -->
                        <div class="col-12 p-3 bg-danger bg-opacity-10 rounded-3 border border-danger border-opacity-25">
                            <h6 class="fw-bold text-danger mb-2"><i class="bi bi-lightning-charge-fill me-1"></i> 2. جدول الحجز المستعجل (طوارئ ⚡)</h6>
                            <label class="form-label small fw-bold text-dark d-block mb-1">أيام العمل المتاحة للحالات المستعجلة:</label>
                            <div class="d-flex flex-wrap gap-2 mb-2.5">
                                @foreach($allDays as $enDay => $arDay)
                                    <div class="form-check form-check-inline me-2">
                                        <input class="form-check-input" type="checkbox" name="urgent_days[]" value="{{ $arDay }}" id="newUrgentDay_{{ $enDay }}" checked>
                                        <label class="form-check-label small fw-bold" for="newUrgentDay_{{ $enDay }}">{{ $arDay }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <label class="form-label small fw-bold text-dark d-block mb-1">تواريخ محددة في الشهر للحالات المستعجلة (اختياري):</label>
                            <textarea name="urgent_dates" rows="2" class="form-control font-monospace small" placeholder="مثال: 2026-10-25&#10;2026-10-22"></textarea>
                            <span class="text-muted small" style="font-size: 11px;">تفتح هذه التواريخ العاجلة مباشرة عند اختيار الحجز المستعجل لهذا الفرع (مثل: 25/10).</span>
                        </div>

                        <!-- Time Slots Textarea -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-dark">الفترات الزمنية المتاحة للحجز (افصل بينها بسطر) <span class="text-danger">*</span></label>
                            <textarea name="time_slots" rows="4" required class="form-control font-monospace small" placeholder="12:00 PM - 02:00 PM&#10;02:00 PM - 04:00 PM&#10;04:00 PM - 06:30 PM&#10;06:30 PM - 09:00 PM">12:00 PM - 02:00 PM
02:00 PM - 04:00 PM
04:00 PM - 06:30 PM
06:30 PM - 09:00 PM</textarea>
                            <span class="form-text text-muted small">ستظهر هذه الفترات في القائمة المنسدلة لولي الأمر عند اختيار هذا الفرع.</span>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="p-3 bg-light rounded-3 border">
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" name="is_online" id="newIsOnline" value="1">
                                    <label class="form-check-label small fw-bold" for="newIsOnline">
                                        استشارات أونلاين فقط عن بُعد (Online Zoom)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="p-3 bg-light rounded-3 border">
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="newIsActive" value="1" checked>
                                    <label class="form-check-label small fw-bold text-success" for="newIsActive">
                                        تفعيل الفرع وإظهاره للعملاء في صفحة الحجز
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer bg-light py-2.5 px-4">
                    <button type="button" class="btn btn-secondary fw-bold rounded-3" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4 rounded-3">إضافة وحفظ الفرع</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================== -->
<!-- MODALS: Edit Each Branch                       -->
<!-- ============================================== -->
@foreach($branches as $branch)
<div class="modal fade" id="editBranchModal{{ $branch->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-dark text-white py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-pencil-square fs-5"></i>
                    <h5 class="modal-title fw-bold">تعديل الفرع: {{ $branch->name }}</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.bookings.branches.update', $branch) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        
                        <div class="col-md-6 col-12">
                            <label class="form-label small fw-bold">اسم الفرع <span class="text-danger">*</span></label>
                            <input type="text" name="name" required value="{{ old('name', $branch->name) }}" class="form-control">
                        </div>

                        <div class="col-md-6 col-12">
                            <label class="form-label small fw-bold">سعر الحجز العادي بالفرع (ج.م) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="price" required value="{{ old('price', $branch->price) }}" class="form-control fw-bold">
                                <span class="input-group-text bg-light fw-bold">ج.م</span>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <label class="form-label small fw-bold">سعر الحجز المستعجل بالفرع (ج.م)</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="urgent_price" value="{{ old('urgent_price', $branch->urgent_price) }}" placeholder="450.00" class="form-control fw-bold text-danger">
                                <span class="input-group-text bg-light fw-bold">ج.م</span>
                            </div>
                            <span class="text-muted small" style="font-size: 11px;">اتركه فارغاً لاستخدام السعر العام للخدمة المستعجلة.</span>
                        </div>

                        <div class="col-md-8 col-12">
                            <label class="form-label small fw-bold">العنوان وموقع الفرع</label>
                            <input type="text" name="address" value="{{ old('address', $branch->address) }}" class="form-control">
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label small fw-bold">رقم هاتف الفرع</label>
                            <input type="text" name="phone" value="{{ old('phone', $branch->phone) }}" class="form-control" dir="ltr">
                        </div>

                        <!-- 1. Normal Schedule Section -->
                        <div class="col-12 p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold text-primary mb-2"><i class="bi bi-calendar3 me-1"></i> 1. جدول الحجز العادي (في المركز)</h6>
                            <label class="form-label small fw-bold text-dark d-block mb-1">أيام العمل الأسبوعية المعتمدة <span class="text-danger">*</span>:</label>
                            <div class="d-flex flex-wrap gap-2 mb-2.5">
                                @php
                                    $branchDays = $branch->days_list;
                                @endphp
                                @foreach($allDays as $enDay => $arDay)
                                    <div class="form-check form-check-inline me-2">
                                        <input class="form-check-input" type="checkbox" name="available_days[]" value="{{ $arDay }}" id="editDay_{{ $branch->id }}_{{ $enDay }}" {{ in_array($arDay, $branchDays) ? 'checked' : '' }}>
                                        <label class="form-check-label small fw-bold" for="editDay_{{ $branch->id }}_{{ $enDay }}">{{ $arDay }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <label class="form-label small fw-bold text-dark d-block mb-1">تواريخ محددة في الشهر للحجز العادي (اختياري):</label>
                            <textarea name="specific_dates" rows="2" class="form-control font-monospace small" placeholder="مثال: 2026-11-01&#10;2026-11-08">{{ implode("\n", $branch->specific_dates_list) }}</textarea>
                            <span class="text-muted small" style="font-size: 11px;">إذا وضعت تواريخ محددة هنا، سيفتح التقويم هذه الأيام فقط في الشهر للعملاء (مثل: 1/11).</span>
                        </div>

                        <!-- 2. Urgent Schedule Section -->
                        <div class="col-12 p-3 bg-danger bg-opacity-10 rounded-3 border border-danger border-opacity-25">
                            <h6 class="fw-bold text-danger mb-2"><i class="bi bi-lightning-charge-fill me-1"></i> 2. جدول الحجز المستعجل (طوارئ ⚡)</h6>
                            <label class="form-label small fw-bold text-dark d-block mb-1">أيام العمل المتاحة للحالات المستعجلة:</label>
                            <div class="d-flex flex-wrap gap-2 mb-2.5">
                                @php
                                    $branchUrgentDays = $branch->urgent_days_list;
                                @endphp
                                @foreach($allDays as $enDay => $arDay)
                                    <div class="form-check form-check-inline me-2">
                                        <input class="form-check-input" type="checkbox" name="urgent_days[]" value="{{ $arDay }}" id="editUrgentDay_{{ $branch->id }}_{{ $enDay }}" {{ in_array($arDay, $branchUrgentDays) ? 'checked' : '' }}>
                                        <label class="form-check-label small fw-bold" for="editUrgentDay_{{ $branch->id }}_{{ $enDay }}">{{ $arDay }}</label>
                                    </div>
                                @endforeach
                            </div>

                            <label class="form-label small fw-bold text-dark d-block mb-1">تواريخ محددة في الشهر للحالات المستعجلة (اختياري):</label>
                            <textarea name="urgent_dates" rows="2" class="form-control font-monospace small" placeholder="مثال: 2026-10-25&#10;2026-10-22">{{ implode("\n", $branch->urgent_dates_list) }}</textarea>
                            <span class="text-muted small" style="font-size: 11px;">تفتح هذه التواريخ العاجلة مباشرة عند اختيار الحجز المستعجل لهذا الفرع (مثل: 25/10).</span>
                        </div>

                        <!-- Time Slots Textarea -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-dark">الفترات الزمنية المتاحة للحجز (افصل بينها بسطر) <span class="text-danger">*</span></label>
                            <textarea name="time_slots" rows="4" required class="form-control font-monospace small">{{ implode("\n", $branch->slots_list) }}</textarea>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="p-3 bg-light rounded-3 border">
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" name="is_online" id="editIsOnline{{ $branch->id }}" value="1" {{ $branch->is_online ? 'checked' : '' }}>
                                    <label class="form-check-label small fw-bold" for="editIsOnline{{ $branch->id }}">
                                        استشارة أونلاين عن بُعد (Online Zoom)
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="p-3 bg-light rounded-3 border">
                                <div class="form-check form-switch m-0">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="editIsActive{{ $branch->id }}" value="1" {{ $branch->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label small fw-bold text-success" for="editIsActive{{ $branch->id }}">
                                        الفرع مفعل ومتاح في صفحة الحجز
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer bg-light py-2.5 px-4">
                    <button type="button" class="btn btn-secondary fw-bold rounded-3" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4 rounded-3">تحديث بيانات الفرع</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
