<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\BookingBranch;
use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\CrmLog;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // List all bookings with search, filters, and stats
    public function index(Request $request)
    {
        $query = Booking::query()->with('bookingBranch')->latest();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhere('parent_name', 'like', "%{$search}%")
                  ->orWhere('parent_phone', 'like', "%{$search}%")
                  ->orWhere('child_name', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Payment status filter
        if ($request->filled('payment_status') && $request->payment_status !== 'all') {
            $query->where('payment_status', $request->payment_status);
        }

        // Branch filter
        if ($request->filled('branch') && $request->branch !== 'all') {
            $query->where(function ($q) use ($request) {
                $q->where('branch', $request->branch)
                  ->orWhere('booking_branch_id', $request->branch);
            });
        }

        // Date filter
        if ($request->filled('date')) {
            $query->whereDate('booking_date', $request->date);
        }

        $bookings = $query->paginate(15)->withQueryString();

        // Statistics
        $stats = [
            'total' => Booking::count(),
            'today' => Booking::whereDate('booking_date', today())->count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'paid' => Booking::where('payment_status', 'paid')->count(),
            'total_revenue' => Booking::where('payment_status', 'paid')->sum('price'),
        ];

        $services = Booking::$services;
        $branchesList = BookingBranch::orderBy('sort_order')->get();
        $branches = [];
        foreach ($branchesList as $b) {
            $branches[$b->slug] = $b->name . ($b->address ? ' (' . $b->address . ')' : '');
        }
        $statuses = Booking::$statuses;
        $paymentStatuses = Booking::$paymentStatuses;
        $paymentMethods = Booking::$paymentMethods;

        $users = User::where('email', '!=', 'admin@2morro.com')
            ->where('email', 'not like', '%@2morro.com')
            ->select('id', 'name', 'email')
            ->get();

        return view('admin.bookings.index', compact(
            'bookings',
            'stats',
            'services',
            'branches',
            'branchesList',
            'statuses',
            'paymentStatuses',
            'paymentMethods',
            'users'
        ));
    }

    // View specific booking details
    public function show(Booking $booking)
    {
        $services = Booking::$services;
        $branchesList = BookingBranch::orderBy('sort_order')->get();
        $branches = [];
        foreach ($branchesList as $b) {
            $branches[$b->slug] = $b->name;
        }
        $statuses = Booking::$statuses;
        $paymentStatuses = Booking::$paymentStatuses;
        $paymentMethods = Booking::$paymentMethods;

        $booking->load(['user.customerProfile', 'bookingBranch']);

        return view('admin.bookings.show', compact(
            'booking',
            'services',
            'branches',
            'branchesList',
            'statuses',
            'paymentStatuses',
            'paymentMethods'
        ));
    }

    // Create a manual booking from Admin dashboard
    public function store(Request $request)
    {
        $validated = $request->validate([
            'existing_user_id' => 'nullable|exists:users,id',
            'parent_name' => 'required|string|max:190',
            'parent_phone' => 'required|string|max:30',
            'parent_email' => 'nullable|email|max:190',
            'child_name' => 'required|string|max:190',
            'child_age' => 'required|string|max:50',
            'service_type' => 'required|string',
            'session_format' => 'required|string|in:in_center,online',
            'branch' => 'nullable|string',
            'booking_branch_id' => 'nullable|exists:booking_branches,id',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string|max:100',
            'price' => 'nullable|numeric|min:0',
            'payment_method' => 'nullable|string|in:vodafone_cash,instapay,bank_transfer,at_center',
            'payment_status' => 'nullable|string|in:pending,paid,at_center',
            'status' => 'required|string|in:pending,confirmed,completed,cancelled',
            'notes' => 'nullable|string',
            'admin_notes' => 'nullable|string',
        ]);

        // Link with selected user or find/create
        $userId = $validated['existing_user_id'] ?? null;
        if (!$userId) {
            $user = !empty($validated['parent_email']) ? User::where('email', $validated['parent_email'])->first() : null;
            if (!$user) {
                $email = $validated['parent_email'] ?: 'client_' . time() . '_' . rand(100, 999) . '@2morro.center';
                $user = User::create([
                    'name' => $validated['parent_name'],
                    'email' => $email,
                    'password' => bcrypt(Str::random(16)),
                ]);
            }
            $userId = $user->id;
        }

        // Ensure CRM profile
        CustomerProfile::firstOrCreate(
            ['user_id' => $userId],
            ['segment' => 'parent']
        );

        $branchModel = null;
        if (!empty($validated['booking_branch_id'])) {
            $branchModel = BookingBranch::find($validated['booking_branch_id']);
        } elseif (!empty($validated['branch'])) {
            $branchModel = BookingBranch::where('slug', $validated['branch'])->first();
        }

        $price = isset($validated['price']) ? (float)$validated['price'] : ($branchModel ? $branchModel->price : 300.00);
        $finalBranch = $branchModel ? $branchModel->slug : ($validated['session_format'] === 'online' ? 'online' : ($validated['branch'] ?? 'ibrahimiya'));
        $branchId = $branchModel ? $branchModel->id : null;

        $bookingNumber = 'BK-ADM-' . date('ymd') . '-' . rand(100, 999);

        $booking = Booking::create([
            'booking_number' => $bookingNumber,
            'user_id' => $userId,
            'booking_branch_id' => $branchId,
            'parent_name' => $validated['parent_name'],
            'parent_phone' => $validated['parent_phone'],
            'parent_email' => $validated['parent_email'] ?? null,
            'child_name' => $validated['child_name'],
            'child_age' => $validated['child_age'],
            'service_type' => $validated['service_type'],
            'session_format' => $validated['session_format'],
            'branch' => $finalBranch,
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'price' => $price,
            'payment_method' => $validated['payment_method'] ?? 'at_center',
            'payment_status' => $validated['payment_status'] ?? 'pending',
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
            'admin_notes' => $validated['admin_notes'] ?? null,
            'created_by_admin' => true,
        ]);

        // CRM Log
        CrmLog::create([
            'user_id' => $userId,
            'admin_id' => Auth::id(),
            'type' => 'note',
            'details' => 'تم إنشاء حجز استشارة يدوي من لوحة التحكم برقم #' . $booking->booking_number . ' للطفل: ' . $booking->child_name . ' - السعر: ' . number_format($price, 2) . ' ج.م',
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'تم إضافة وتسجيل الحجز بنجاح!');
    }

    // Update booking status and details
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,confirmed,completed,cancelled',
            'payment_status' => 'required|string|in:pending,paid,at_center',
            'price' => 'required|numeric|min:0',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string|max:100',
            'booking_branch_id' => 'nullable|exists:booking_branches,id',
            'service_type' => 'required|string',
            'admin_notes' => 'nullable|string',
        ]);

        $oldStatus = $booking->status;
        $oldPaymentStatus = $booking->payment_status;

        if (!empty($validated['booking_branch_id'])) {
            $branchModel = BookingBranch::find($validated['booking_branch_id']);
            if ($branchModel) {
                $validated['branch'] = $branchModel->slug;
            }
        }

        $booking->update($validated);

        // Activity log for status change
        if (($oldStatus !== $validated['status'] || $oldPaymentStatus !== $validated['payment_status']) && $booking->user_id) {
            CrmLog::create([
                'user_id' => $booking->user_id,
                'admin_id' => Auth::id(),
                'type' => 'system',
                'details' => 'تم تحديث حجز الاستشارة #' . $booking->booking_number . ' [الحالة: ' . $booking->status_label . ' | الدفع: ' . $booking->payment_status_label . ']',
            ]);
        }

        return redirect()->back()->with('success', 'تم تحديث بيانات وموعد وتفاصيل الحجز والدفع بنجاح!');
    }

    // Delete booking
    public function destroy(Booking $booking)
    {
        $bookingNumber = $booking->booking_number;
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'تم حذف الحجز #' . $bookingNumber . ' بنجاح.');
    }

    // Branches & Booking Settings Page (إدارة الفروع، المواعيد، الأسعار، وطرق الدفع)
    public function settings()
    {
        $branches = BookingBranch::orderBy('sort_order')->get();
        $allDays = BookingBranch::$allDays;
        $scheduleConfig = Booking::getScheduleConfig();

        $paymentSettings = [
            'vodafone_cash' => Setting::get('booking_vodafone_cash', '01550504512'),
            'instapay' => Setting::get('booking_instapay', '2morro@instapay'),
            'bank_details' => Setting::get('booking_bank_details', ''),
            'instructions' => Setting::get('booking_payment_instructions', 'يرجى تحويل قيمة الحجز عبر فودافون كاش أو إنستاباي، ثم إرفاق صورة إشعار التحويل (سكرين شوت) لتأكيد حجز الموعد مباشرة.'),
            'allow_cash_at_center' => Setting::get('booking_allow_cash_at_center', '1') === '1',
            'booking_image' => Setting::get('booking_image', 'images/hero-child.jpg'),
            'booking_page_title' => Setting::get('booking_page_title', 'حجز استشارة وتقييم مهارات الطفل'),
            'booking_page_subtitle' => Setting::get('booking_page_subtitle', 'مركز 2morro المتخصص في رعاية وتأهيل وتنمية قدرات الأطفال بإشراف أ. هبة الله أكرم.'),
            'booking_page_quote' => Setting::get('booking_page_quote', '« عندما تشعرين بأن طفلك بحاجة لدعم وتأهيل في مهاراته اللغوية أو السلوكية أو الحركية، فإن التدخل المبكر يصنع الفارق في مستقبله »'),
            'session_duration' => Setting::get('booking_session_duration', '45 دقيقة'),
        ];

        return view('admin.bookings.settings', compact('branches', 'allDays', 'paymentSettings', 'scheduleConfig'));
    }

    // Save Booking Payment and General Settings
    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'booking_vodafone_cash' => 'nullable|string|max:100',
            'booking_instapay' => 'nullable|string|max:100',
            'booking_bank_details' => 'nullable|string|max:1000',
            'booking_payment_instructions' => 'nullable|string|max:1000',
            'booking_allow_cash_at_center' => 'nullable|in:0,1',
            'booking_page_title' => 'nullable|string|max:255',
            'booking_page_subtitle' => 'nullable|string|max:500',
            'booking_page_quote' => 'nullable|string|max:500',
            'booking_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'booking_session_duration' => 'nullable|string|max:100',

            // Normal service
            'booking_normal_price' => 'nullable|numeric|min:0',
            'booking_normal_desc' => 'nullable|string|max:255',
            'booking_normal_days' => 'nullable|array',
            'booking_normal_slots' => 'nullable|string',
            'booking_normal_slot_capacity' => 'nullable|integer|min:1',
            'booking_normal_specific_dates' => 'nullable|string',
            'booking_normal_off_dates' => 'nullable|string',

            // Urgent service
            'booking_urgent_price' => 'nullable|numeric|min:0',
            'booking_urgent_desc' => 'nullable|string|max:255',
            'booking_urgent_days' => 'nullable|array',
            'booking_urgent_slots' => 'nullable|string',
            'booking_urgent_slot_capacity' => 'nullable|integer|min:1',
            'booking_urgent_max_days_ahead' => 'nullable|integer|min:1|max:7',
            'booking_urgent_specific_dates' => 'nullable|string',
            'booking_urgent_off_dates' => 'nullable|string',

            // Online service
            'booking_online_price' => 'nullable|numeric|min:0',
            'booking_online_desc' => 'nullable|string|max:255',
            'booking_online_days' => 'nullable|array',
            'booking_online_slots' => 'nullable|string',
            'booking_online_slot_capacity' => 'nullable|integer|min:1',
            'booking_online_platform' => 'nullable|string|max:100',
            'booking_online_specific_dates' => 'nullable|string',
            'booking_online_off_dates' => 'nullable|string',
        ]);

        $formatList = function ($val) {
            if (empty($val)) return json_encode([]);
            $arr = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $val))));
            return json_encode($arr);
        };

        Setting::set('booking_vodafone_cash', $validated['booking_vodafone_cash'] ?? '');
        Setting::set('booking_instapay', $validated['booking_instapay'] ?? '');
        Setting::set('booking_bank_details', $validated['booking_bank_details'] ?? '');
        Setting::set('booking_payment_instructions', $validated['booking_payment_instructions'] ?? '');
        Setting::set('booking_allow_cash_at_center', $request->has('booking_allow_cash_at_center') ? '1' : '0');
        Setting::set('booking_page_title', $validated['booking_page_title'] ?? 'حجز استشارة وتقييم مهارات الطفل');
        Setting::set('booking_page_subtitle', $validated['booking_page_subtitle'] ?? '');
        Setting::set('booking_page_quote', $validated['booking_page_quote'] ?? '');
        Setting::set('booking_session_duration', $validated['booking_session_duration'] ?? '45 دقيقة');

        // Normal Service Settings
        Setting::set('booking_normal_enabled', $request->has('booking_normal_enabled') ? '1' : '0');
        Setting::set('booking_normal_price', $validated['booking_normal_price'] ?? '300.00');
        Setting::set('booking_normal_desc', $validated['booking_normal_desc'] ?? '');
        Setting::set('booking_normal_days', json_encode($request->input('booking_normal_days', ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'])));
        Setting::set('booking_normal_slots', $formatList($request->input('booking_normal_slots')));
        Setting::set('booking_normal_slot_capacity', (string) ($validated['booking_normal_slot_capacity'] ?? 1));
        Setting::set('booking_normal_specific_dates', $formatList($request->input('booking_normal_specific_dates')));
        Setting::set('booking_normal_off_dates', $formatList($request->input('booking_normal_off_dates')));

        // Urgent Service Settings
        Setting::set('booking_urgent_enabled', $request->has('booking_urgent_enabled') ? '1' : '0');
        Setting::set('booking_urgent_price', $validated['booking_urgent_price'] ?? '450.00');
        Setting::set('booking_urgent_desc', $validated['booking_urgent_desc'] ?? '');
        Setting::set('booking_urgent_days', json_encode($request->input('booking_urgent_days', ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'])));
        Setting::set('booking_urgent_slots', $formatList($request->input('booking_urgent_slots')));
        Setting::set('booking_urgent_slot_capacity', (string) ($validated['booking_urgent_slot_capacity'] ?? 1));
        Setting::set('booking_urgent_max_days_ahead', (string) ($validated['booking_urgent_max_days_ahead'] ?? 2));
        Setting::set('booking_urgent_specific_dates', $formatList($request->input('booking_urgent_specific_dates')));
        Setting::set('booking_urgent_off_dates', $formatList($request->input('booking_urgent_off_dates')));

        // Online Service Settings
        Setting::set('booking_online_enabled', $request->has('booking_online_enabled') ? '1' : '0');
        Setting::set('booking_online_price', $validated['booking_online_price'] ?? '350.00');
        Setting::set('booking_online_desc', $validated['booking_online_desc'] ?? '');
        Setting::set('booking_online_days', json_encode($request->input('booking_online_days', ['Saturday', 'Sunday', 'Tuesday', 'Thursday', 'Friday'])));
        Setting::set('booking_online_slots', $formatList($request->input('booking_online_slots')));
        Setting::set('booking_online_slot_capacity', (string) ($validated['booking_online_slot_capacity'] ?? 1));
        Setting::set('booking_online_platform', $validated['booking_online_platform'] ?? 'Zoom / Google Meet');
        Setting::set('booking_online_specific_dates', $formatList($request->input('booking_online_specific_dates')));
        Setting::set('booking_online_off_dates', $formatList($request->input('booking_online_off_dates')));

        if ($request->hasFile('booking_image')) {
            $path = $request->file('booking_image')->store('bookings', 'public');
            Setting::set('booking_image', 'storage/' . $path);
        }

        return redirect()->back()->with('success', 'تم حفظ إعدادات أنواع الحجوزات والمواعيد والتقويم بنجاح!');
    }

    // Store New Branch
    public function storeBranch(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:190',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'urgent_price' => 'nullable|numeric|min:0',
            'available_days' => 'required|array|min:1',
            'urgent_days' => 'nullable|array',
            'specific_dates' => 'nullable|string',
            'urgent_dates' => 'nullable|string',
            'time_slots' => 'required|string',
            'is_online' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ], [
            'name.required' => 'اسم الفرع مطلوب.',
            'price.required' => 'يرجى تحديد سعر الكشف / الاستشارة للفرع.',
            'available_days.required' => 'يرجى اختيار يوم واحد على الأقل من أيام العمل المتاحة.',
            'time_slots.required' => 'يرجى إدخال المواعيد والفترات المتاحة للفرع.',
        ]);

        $slotsArray = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['time_slots']))));
        $specificDatesArray = !empty($validated['specific_dates']) ? array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['specific_dates'])))) : null;
        $urgentDatesArray = !empty($validated['urgent_dates']) ? array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['urgent_dates'])))) : null;

        $slug = Str::slug($validated['name'], '-');
        if (empty($slug) || BookingBranch::where('slug', $slug)->exists()) {
            $slug = 'branch-' . time();
        }

        BookingBranch::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'price' => $validated['price'],
            'urgent_price' => !empty($validated['urgent_price']) ? $validated['urgent_price'] : null,
            'available_days' => $validated['available_days'],
            'urgent_days' => !empty($validated['urgent_days']) ? $validated['urgent_days'] : $validated['available_days'],
            'specific_dates' => $specificDatesArray,
            'urgent_dates' => $urgentDatesArray,
            'time_slots' => $slotsArray,
            'is_online' => $request->has('is_online'),
            'is_active' => $request->has('is_active'),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->back()->with('success', 'تمت إضافة الفرع ومواعيده وأسعاره بنجاح!');
    }

    // Update Existing Branch
    public function updateBranch(Request $request, BookingBranch $branch)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:190',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'price' => 'required|numeric|min:0',
            'urgent_price' => 'nullable|numeric|min:0',
            'available_days' => 'required|array|min:1',
            'urgent_days' => 'nullable|array',
            'specific_dates' => 'nullable|string',
            'urgent_dates' => 'nullable|string',
            'time_slots' => 'required|string',
            'is_online' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $slotsArray = array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['time_slots']))));
        $specificDatesArray = !empty($validated['specific_dates']) ? array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['specific_dates'])))) : null;
        $urgentDatesArray = !empty($validated['urgent_dates']) ? array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', $validated['urgent_dates'])))) : null;

        $branch->update([
            'name' => $validated['name'],
            'address' => $validated['address'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'price' => $validated['price'],
            'urgent_price' => !empty($validated['urgent_price']) ? $validated['urgent_price'] : null,
            'available_days' => $validated['available_days'],
            'urgent_days' => !empty($validated['urgent_days']) ? $validated['urgent_days'] : $validated['available_days'],
            'specific_dates' => $specificDatesArray,
            'urgent_dates' => $urgentDatesArray,
            'time_slots' => $slotsArray,
            'is_online' => $request->has('is_online'),
            'is_active' => $request->has('is_active'),
            'sort_order' => $validated['sort_order'] ?? $branch->sort_order,
        ]);

        return redirect()->back()->with('success', 'تم تحديث بيانات الفرع ومواعيده وأسعاره بنجاح!');
    }

    // Delete Branch
    public function destroyBranch(BookingBranch $branch)
    {
        $name = $branch->name;
        $branch->delete();

        return redirect()->back()->with('success', 'تم حذف الفرع [' . $name . '] بنجاح.');
    }
}
