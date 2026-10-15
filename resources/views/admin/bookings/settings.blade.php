@extends('admin.layouts.layout')

@section('title', 'إعدادات الفروع ومواعيد الحجز وطرق الدفع')

@section('content')
<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="bi bi-gear-fill text-primary me-2"></i> إعدادات الفروع، المواعيد، الأسعار، وطرق الدفع</h3>
            <p class="text-muted small mb-0">تحديد الفروع المتاحة، أيام وساعات العمل، أسعار الجلسات، وحسابات الدفع (فودافون كاش، إنستاباي).</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary fw-bold shadow-sm d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#newBranchModal">
                <i class="bi bi-plus-circle-fill"></i>
                <span>إضافة فرع جديد</span>
            </button>
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary fw-bold d-flex align-items-center gap-1.5">
                <i class="bi bi-calendar-check"></i>
                <span>قائمة الحجوزات</span>
            </a>
            <a href="{{ route('booking.index') }}" target="_blank" class="btn btn-outline-info fw-bold d-flex align-items-center gap-1.5">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>معاينة صفحة الحجز</span>
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4" role="alert">
            <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-triangle-fill me-2"></i> تنبيه: يرجى تصحيح الأخطاء التالية:</h6>
            <ul class="mb-0 small">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        
        <!-- Left Column: Branches & Schedules Management (Col 8) -->
        <div class="col-lg-8 col-12">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="fw-bold mb-0 text-slate-800"><i class="bi bi-geo-alt-fill text-danger me-2"></i> فروع المركز ومواعيد المقابلات المتاحة</h5>
                        <span class="text-muted small">يمكنك تعديل أيام وساعات العمل وسعر الاستشارة لكل فرع.</span>
                    </div>
                    <span class="badge bg-primary rounded-pill px-3 py-2 fw-bold">{{ $branches->count() }} فروع</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 text-nowrap">
                            <thead class="table-light text-muted small fw-bold">
                                <tr>
                                    <th class="ps-4">الفرع</th>
                                    <th>سعر الاستشارة</th>
                                    <th>أيام العمل المتاحة</th>
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
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="w-10 h-10 rounded-3 {{ $branch->is_online ? 'bg-info bg-opacity-10 text-info' : 'bg-primary bg-opacity-10 text-primary' }} d-flex align-items-center justify-content-center flex-shrink-0" style="width: 38px; height: 38px;">
                                                    <i class="bi {{ $branch->is_online ? 'bi-camera-video-fill' : 'bi-building' }} fs-5"></i>
                                                </div>
                                                <div>
                                                    <span class="fw-bold text-dark d-block">{{ $branch->name }}</span>
                                                    <span class="text-muted small text-truncate d-block" style="max-width: 200px;">{{ $branch->address ?: 'بدون عنوان محدد' }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="fw-bold text-success fs-6">{{ number_format($branch->price, 2) }}</span>
                                            <span class="text-muted small">ج.م</span>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1" style="max-width: 190px;">
                                                @foreach($branch->days_list as $day)
                                                    <span class="badge bg-light text-dark border small">{{ $day }}</span>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column gap-1" style="max-width: 180px;">
                                                @foreach(array_slice($branch->slots_list, 0, 2) as $slot)
                                                    <span class="badge bg-slate-100 text-slate-700 font-monospace small" style="background:#f1f5f9; color:#334155;">{{ $slot }}</span>
                                                @endforeach
                                                @if(count($branch->slots_list) > 2)
                                                    <span class="text-muted small">+ {{ count($branch->slots_list) - 2 }} فترات أخرى</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($branch->is_online)
                                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2 py-1">أونلاين 💻</span>
                                            @else
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-1">في المركز 🏥</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($branch->is_active)
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1"><i class="bi bi-check-circle me-1"></i> نشط</span>
                                            @else
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 px-2 py-1">معطل</span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="d-inline-flex gap-1">
                                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editBranchModal{{ $branch->id }}" title="تعديل الفرع والمواعيد">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <form action="{{ route('admin.bookings.branches.destroy', $branch) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من رغبتك في حذف هذا الفرع نهائياً؟');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف الفرع">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                            لم يتم إضافة أي فروع حتى الآن. قم بالضغط على "إضافة فرع جديد".
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Payment Methods & Storefront Settings (Col 4) -->
        <div class="col-lg-4 col-12">
            
            <form action="{{ route('admin.bookings.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Payment Methods Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-bold mb-0 text-slate-800"><i class="bi bi-credit-card-2-front-fill text-success me-2"></i> طرق الدفع وسكرين شوت الحجز</h5>
                        <span class="text-muted small">الحسابات التي تظهر لولي الأمر عند الحجز لرفع إشعار الدفع.</span>
                    </div>
                    <div class="card-body p-4 space-y-3">
                        
                        <!-- Vodafone Cash -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">
                                <span class="badge bg-danger text-white me-1">Vodafone</span> رقم فودافون كاش
                            </label>
                            <input type="text" name="booking_vodafone_cash" value="{{ old('booking_vodafone_cash', $paymentSettings['vodafone_cash']) }}" class="form-control" placeholder="010xxxxxxxx" dir="ltr">
                            <span class="form-text text-muted small">الرقم الذي سيتم تحويل قيمة الحجز إليه عبر كاش.</span>
                        </div>

                        <!-- InstaPay -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">
                                <span class="badge bg-primary text-white me-1">InstaPay</span> معرف أو هاتف إنستاباي
                            </label>
                            <input type="text" name="booking_instapay" value="{{ old('booking_instapay', $paymentSettings['instapay']) }}" class="form-control" placeholder="username@instapay أو 01xxxxxxxxx" dir="ltr">
                            <span class="form-text text-muted small">عنوان الدفع الفوري (IPA) أو رقم الهاتف المرتبط بإنستاباي.</span>
                        </div>

                        <!-- Bank Details -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">بيانات التحويل البنكي (اختياري)</label>
                            <textarea name="booking_bank_details" rows="2" class="form-control" placeholder="اسم البنك، رقم الحساب، أو IBAN">{{ old('booking_bank_details', $paymentSettings['bank_details']) }}</textarea>
                        </div>

                        <!-- Payment Instructions Note -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">إرشادات الدفع (تظهر لولي الأمر في صفحة الحجز)</label>
                            <textarea name="booking_payment_instructions" rows="3" class="form-control" placeholder="تعليمات التحويل...">{{ old('booking_payment_instructions', $paymentSettings['instructions']) }}</textarea>
                        </div>

                        <!-- Allow Cash at Center Option -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="booking_allow_cash_at_center" id="allowCash" value="1" {{ $paymentSettings['allow_cash_at_center'] ? 'checked' : '' }}>
                            <label class="form-check-label small fw-bold text-dark" for="allowCash">
                                إتاحة خيار "الدفع عند الحضور بالمركز" (للحجوزات الحضورية)
                            </label>
                        </div>

                    </div>
                </div>

                <!-- Booking Page Presentation Card -->
                <div class="card border-0 shadow-sm rounded-4 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="fw-bold mb-0 text-slate-800"><i class="bi bi-window-sidebar text-info me-2"></i> نصوص وصورة صفحة الحجز</h5>
                    </div>
                    <div class="card-body p-4 space-y-3">
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">عنوان الصفحة الرئيسي</label>
                            <input type="text" name="booking_page_title" value="{{ old('booking_page_title', $paymentSettings['booking_page_title']) }}" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">الوصف المختصر</label>
                            <textarea name="booking_page_subtitle" rows="2" class="form-control">{{ old('booking_page_subtitle', $paymentSettings['booking_page_subtitle']) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">المقولة / الرسالة البارزة (Quote)</label>
                            <textarea name="booking_page_quote" rows="2" class="form-control">{{ old('booking_page_quote', $paymentSettings['booking_page_quote']) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark">صورة الغلاف / كارت المركز</label>
                            @if(!empty($paymentSettings['booking_image']))
                                <div class="mb-2">
                                    <img src="{{ asset($paymentSettings['booking_image']) }}" alt="غلاف الحجز" class="img-thumbnail rounded-3" style="max-height: 100px;">
                                </div>
                            @endif
                            <input type="file" name="booking_image" accept="image/*" class="form-control">
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="btn btn-success fw-bold w-full d-flex align-items-center justify-content-center gap-2 shadow-sm py-2.5">
                                <i class="bi bi-check2-circle fs-5"></i>
                                <span>حفظ وتطبيق جميع الإعدادات</span>
                            </button>
                        </div>

                    </div>
                </div>

            </form>

        </div>

    </div>

</div>

<!-- Modal: Add New Branch -->
<div class="modal fade" id="newBranchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle-fill me-2"></i> إضافة فرع ومواعيد جديدة</h5>
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
                            <label class="form-label small fw-bold">سعر الاستشارة / الكشف (ج.م) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="price" required value="300.00" class="form-control fw-bold">
                                <span class="input-group-text">ج.م</span>
                            </div>
                        </div>

                        <div class="col-md-8 col-12">
                            <label class="form-label small fw-bold">العنوان وموقع الفرع</label>
                            <input type="text" name="address" placeholder="مثال: أول لاجتيه من شارع أبو قير - عمارة الأطباء" class="form-control">
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label small fw-bold">رقم هاتف الفرع (اختياري)</label>
                            <input type="text" name="phone" placeholder="01550504512" class="form-control" dir="ltr">
                        </div>

                        <!-- Available Days Checkboxes -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-dark d-block mb-2">أيام العمل المتاحة في هذا الفرع <span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap gap-2 p-3 bg-light rounded-3 border">
                                @foreach($allDays as $enDay => $arDay)
                                    <div class="form-check form-check-inline me-3">
                                        <input class="form-check-input" type="checkbox" name="available_days[]" value="{{ $arDay }}" id="newDay_{{ $enDay }}" {{ $arDay !== 'الجمعة' ? 'checked' : '' }}>
                                        <label class="form-check-label small fw-bold" for="newDay_{{ $enDay }}">{{ $arDay }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Time Slots Textarea -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-dark">الفترات الزمنية المتاحة للحجز (افصل بينها بسطر أو فاصلة) <span class="text-danger">*</span></label>
                            <textarea name="time_slots" rows="3" required class="form-control font-monospace" placeholder="12:00 PM - 02:00 PM&#10;02:00 PM - 04:00 PM&#10;04:00 PM - 06:30 PM&#10;06:30 PM - 09:00 PM">12:00 PM - 02:00 PM
02:00 PM - 04:00 PM
04:00 PM - 06:30 PM
06:30 PM - 09:00 PM</textarea>
                            <span class="form-text text-muted small">يمكنك كتابة الساعات باللغة الإنجليزية أو العربية، وستظهر لولي الأمر في القائمة المنسدلة عند اختيار هذا الفرع.</span>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-check form-switch pt-2">
                                <input class="form-check-input" type="checkbox" name="is_online" id="newIsOnline" value="1">
                                <label class="form-check-label small fw-bold" for="newIsOnline">
                                    هذا الفرع يقدم استشارات أونلاين فقط عن بُعد (Online Zoom)
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-check form-switch pt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="newIsActive" value="1" checked>
                                <label class="form-check-label small fw-bold text-success" for="newIsActive">
                                    تفعيل وإظهار هذا الفرع للعملاء في صفحة الحجز
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">إضافة وحفظ الفرع</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modals: Edit Each Branch -->
@foreach($branches as $branch)
<div class="modal fade" id="editBranchModal{{ $branch->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-dark text-white py-3">
                <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i> تعديل الفرع: {{ $branch->name }}</h5>
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
                            <label class="form-label small fw-bold">سعر الاستشارة / الكشف (ج.م) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="price" required value="{{ old('price', $branch->price) }}" class="form-control fw-bold">
                                <span class="input-group-text">ج.م</span>
                            </div>
                        </div>

                        <div class="col-md-8 col-12">
                            <label class="form-label small fw-bold">العنوان وموقع الفرع</label>
                            <input type="text" name="address" value="{{ old('address', $branch->address) }}" class="form-control">
                        </div>

                        <div class="col-md-4 col-12">
                            <label class="form-label small fw-bold">رقم هاتف الفرع</label>
                            <input type="text" name="phone" value="{{ old('phone', $branch->phone) }}" class="form-control" dir="ltr">
                        </div>

                        <!-- Available Days Checkboxes -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-dark d-block mb-2">أيام العمل المتاحة في هذا الفرع <span class="text-danger">*</span></label>
                            <div class="d-flex flex-wrap gap-2 p-3 bg-light rounded-3 border">
                                @php
                                    $branchDays = $branch->days_list;
                                @endphp
                                @foreach($allDays as $enDay => $arDay)
                                    <div class="form-check form-check-inline me-3">
                                        <input class="form-check-input" type="checkbox" name="available_days[]" value="{{ $arDay }}" id="editDay_{{ $branch->id }}_{{ $enDay }}" {{ in_array($arDay, $branchDays) ? 'checked' : '' }}>
                                        <label class="form-check-label small fw-bold" for="editDay_{{ $branch->id }}_{{ $enDay }}">{{ $arDay }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Time Slots Textarea -->
                        <div class="col-12">
                            <label class="form-label small fw-bold text-dark">الفترات الزمنية المتاحة للحجز (افصل بينها بسطر أو فاصلة) <span class="text-danger">*</span></label>
                            <textarea name="time_slots" rows="3" required class="form-control font-monospace">{{ implode("\n", $branch->slots_list) }}</textarea>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-check form-switch pt-2">
                                <input class="form-check-input" type="checkbox" name="is_online" id="editIsOnline{{ $branch->id }}" value="1" {{ $branch->is_online ? 'checked' : '' }}>
                                <label class="form-check-label small fw-bold" for="editIsOnline{{ $branch->id }}">
                                    استشارة أونلاين عن بُعد (Online Zoom)
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-check form-switch pt-2">
                                <input class="form-check-input" type="checkbox" name="is_active" id="editIsActive{{ $branch->id }}" value="1" {{ $branch->is_active ? 'checked' : '' }}>
                                <label class="form-check-label small fw-bold text-success" for="editIsActive{{ $branch->id }}">
                                    الفرع مفعل ومتاح في صفحة الحجز
                                </label>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer bg-light py-2">
                    <button type="button" class="btn btn-secondary fw-bold" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4">تحديث بيانات الفرع</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
