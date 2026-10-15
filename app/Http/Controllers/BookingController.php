<?php

namespace App\Http\Controllers;

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
    // Display Consultation Booking Page
    public function index()
    {
        $services = Booking::$services;
        $formats = Booking::$formats;

        // Fetch dynamic active branches from database
        $branchesList = BookingBranch::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        // Fallback array for legacy references if needed
        $branches = [];
        foreach ($branchesList as $b) {
            $branches[$b->slug] = $b->name . ($b->address ? ' (' . $b->address . ')' : '');
        }

        // Settings
        $bookingImage = Setting::get('booking_image', 'images/hero-child.jpg');
        $bookingTitle = Setting::get('booking_page_title', 'حجز استشارة وتقييم مهارات الطفل');
        $bookingSubtitle = Setting::get('booking_page_subtitle', 'مركز 2morro المتخصص في رعاية وتأهيل وتنمية قدرات الأطفال بإشراف أ. هبة الله أكرم.');
        $bookingQuote = Setting::get('booking_page_quote', '« عندما تشعرين بأن طفلك بحاجة لدعم وتأهيل في مهاراته اللغوية أو السلوكية أو الحركية، فإن التدخل المبكر يصنع الفارق في مستقبله »');

        // Payment Settings
        $paymentSettings = [
            'vodafone_cash' => Setting::get('booking_vodafone_cash', '01550504512'),
            'instapay' => Setting::get('booking_instapay', '2morro@instapay'),
            'instructions' => Setting::get('booking_payment_instructions', 'يرجى تحويل قيمة الحجز عبر فودافون كاش أو إنستاباي، ثم إرفاق صورة إشعار التحويل (سكرين شوت) لتأكيد حجز الموعد مباشرة.'),
        ];

        return view('storefront.booking', compact(
            'services',
            'branches',
            'branchesList',
            'formats',
            'bookingImage',
            'bookingTitle',
            'bookingSubtitle',
            'bookingQuote',
            'paymentSettings'
        ));
    }

    // Handle Booking Submission
    public function store(Request $request)
    {
        $validated = $request->validate([
            'parent_name' => 'required|string|max:190',
            'parent_phone' => 'required|string|max:30',
            'parent_email' => 'nullable|email|max:190',
            'child_name' => 'required|string|max:190',
            'child_age' => 'required|string|max:50',
            'service_type' => 'nullable|string',
            'session_format' => 'required|string|in:in_center,in_center_normal,in_center_urgent,online',
            'branch_id' => 'required_unless:session_format,online|nullable',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|string|max:100',
            'payment_method' => 'required|string|in:vodafone_cash,instapay',
            'payment_receipt' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'payment_reference' => 'nullable|string|max:190',
            'notes' => 'nullable|string|max:1000',
        ], [
            'parent_name.required' => 'يرجى إدخال اسم ولي الأمر.',
            'parent_phone.required' => 'يرجى إدخال رقم هاتف / واتساب للتواصل.',
            'child_name.required' => 'يرجى إدخال اسم الطفل.',
            'child_age.required' => 'يرجى إدخال عمر الطفل.',
            'branch_id.required_unless' => 'يرجى تحديد الفرع المفضل للمقابلة في المركز.',
            'booking_date.required' => 'يرجى اختيار التاريخ المناسب للحجز.',
            'booking_date.after_or_equal' => 'تاريخ الحجز يجب أن يكون اليوم أو تاريخاً قادماً.',
            'booking_time.required' => 'يرجى اختيار الفترة الزمنية المناسبة.',
            'payment_method.required' => 'يرجى اختيار طريقة الدفع المناسبة (فودافون كاش أو إنستاباي).',
            'payment_receipt.required' => 'يرجى رفع صورة سكرين شوت لإشعار تحويل الدفع لتأكيد الحجز.',
            'payment_receipt.image' => 'يجب أن يكون إشعار الدفع صورة صالحة (JPG, PNG, WEBP).',
            'payment_receipt.max' => 'حجم صورة الإشعار لا يجب أن يتجاوز 5 ميجابايت.',
        ]);

        // Default service type if not selected
        if (empty($validated['service_type'])) {
            $validated['service_type'] = 'general_evaluation';
        }

        // 1. Identify Branch & Price
        $branchModel = null;
        if ($validated['session_format'] === 'online') {
            $branchModel = BookingBranch::where('is_online', true)->first();
        } elseif (!empty($validated['branch_id'])) {
            $branchModel = is_numeric($validated['branch_id']) 
                ? BookingBranch::find($validated['branch_id']) 
                : BookingBranch::where('slug', $validated['branch_id'])->first();
        }

        if (!$branchModel) {
            $branchModel = BookingBranch::first();
        }

        $price = $branchModel ? (float) $branchModel->price : 300.00;

        // Apply urgent consultation fee (+150 EGP) if urgent in-center session chosen
        if ($validated['session_format'] === 'in_center_urgent') {
            $urgentFee = (float) Setting::get('booking_urgent_fee', '150.00');
            $price += $urgentFee;
        }

        $branchSlug = $branchModel ? $branchModel->slug : ($validated['session_format'] === 'online' ? 'online' : 'ibrahimiya');
        $branchId = $branchModel ? $branchModel->id : null;

        // 2. Upload Receipt Screenshot if provided
        $receiptPath = null;
        if ($request->hasFile('payment_receipt')) {
            $file = $request->file('payment_receipt');
            $filename = 'receipt_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $receiptPath = $file->storeAs('booking_receipts', $filename, 'public');
        }

        // 3. Identify or Create User for CRM tracking
        $userId = Auth::id();
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

        // 4. Ensure Customer Profile in CRM
        CustomerProfile::firstOrCreate(
            ['user_id' => $userId],
            ['segment' => 'parent', 'loyalty_points' => 10]
        );

        // 5. Generate unique Booking Number
        $bookingNumber = 'BK-' . date('ymd') . '-' . rand(1000, 9999);
        while (Booking::where('booking_number', $bookingNumber)->exists()) {
            $bookingNumber = 'BK-' . date('ymd') . '-' . rand(1000, 9999);
        }

        // 6. Payment status logic
        $paymentStatus = 'pending';

        // 7. Create the Booking Record
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
            'branch' => $branchSlug,
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'price' => $price,
            'payment_method' => $validated['payment_method'],
            'payment_status' => $paymentStatus,
            'payment_receipt' => $receiptPath,
            'payment_reference' => $validated['payment_reference'] ?? null,
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            'created_by_admin' => false,
        ]);

        // 8. Create CRM Activity Log
        CrmLog::create([
            'user_id' => $userId,
            'admin_id' => null,
            'type' => 'system',
            'details' => 'حجز استشارة / تقييم جديد (' . $booking->service_type_label . ') برقم حجز #' . $booking->booking_number . ' للطفل: ' . $booking->child_name . ' - الفرع: ' . $booking->branch_label . ' - السعر: ' . number_format($price, 2) . ' ج.م (' . $booking->payment_method_label . ')',
        ]);

        return redirect()->route('booking.success', $booking->booking_number)
            ->with('success', 'تم استلام طلب حجز الاستشارة بنجاح وإرفاق إشعار الدفع وسيتم مراجعته وتأكيد الموعد.');
    }

    // Booking Success Confirmation Page
    public function success($bookingNumber)
    {
        $booking = Booking::with('bookingBranch')->where('booking_number', $bookingNumber)->firstOrFail();

        return view('storefront.booking-success', compact('booking'));
    }
}
