<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\CrmLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // Display Consultation Booking Page
    public function index()
    {
        $services = Booking::$services;
        $branches = Booking::$branches;
        $formats = Booking::$formats;

        $bookingImage = \App\Models\Setting::get('booking_image', 'images/hero-child.jpg');
        $bookingTitle = \App\Models\Setting::get('booking_page_title', 'حجز استشارة وتقييم مهارات الطفل');
        $bookingSubtitle = \App\Models\Setting::get('booking_page_subtitle', 'مركز 2morro المتخصص في رعاية وتأهيل وتنمية قدرات الأطفال بإشراف أ. هبة الله أكرم.');
        $bookingQuote = \App\Models\Setting::get('booking_page_quote', '« عندما تشعرين بأن طفلك بحاجة لدعم وتأهيل في مهاراته اللغوية أو السلوكية أو الحركية، فإن التدخل المبكر يصنع الفارق في مستقبله »');

        return view('storefront.booking', compact('services', 'branches', 'formats', 'bookingImage', 'bookingTitle', 'bookingSubtitle', 'bookingQuote'));
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
            'service_type' => 'required|string',
            'session_format' => 'required|string|in:in_center,online',
            'branch' => 'required|string',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|string|max:50',
            'notes' => 'nullable|string|max:1000',
        ], [
            'parent_name.required' => 'يرجى إدخال اسم ولي الأمر.',
            'parent_phone.required' => 'يرجى إدخال رقم هاتف / واتساب للتواصل.',
            'child_name.required' => 'يرجى إدخال اسم الطفل.',
            'child_age.required' => 'يرجى إدخال عمر الطفل.',
            'service_type.required' => 'يرجى اختيار نوع الاستشارة / الجلسة المطلوبة.',
            'booking_date.required' => 'يرجى اختيار التاريخ المناسب للحجز.',
            'booking_date.after_or_equal' => 'تاريخ الحجز يجب أن يكون اليوم أو تاريخاً قادماً.',
            'booking_time.required' => 'يرجى اختيار الفترة الزمنية المناسبة.',
        ]);

        // 1. Identify or Create User for CRM tracking
        $userId = Auth::id();
        if (!$userId) {
            $user = !empty($validated['parent_email']) ? User::where('email', $validated['parent_email'])->first() : null;

            if (!$user) {
                // Generate a temporary dummy email if not provided
                $email = $validated['parent_email'] ?: 'client_' . time() . '_' . rand(100, 999) . '@2morro.center';
                $user = User::create([
                    'name' => $validated['parent_name'],
                    'email' => $email,
                    'password' => bcrypt(Str::random(16)),
                ]);
            }
            $userId = $user->id;
        }

        // 2. Ensure Customer Profile in CRM
        $profile = CustomerProfile::firstOrCreate(
            ['user_id' => $userId],
            ['segment' => 'parent', 'loyalty_points' => 10]
        );

        // 3. Generate unique Booking Number (e.g. BK-260819-1234)
        $bookingNumber = 'BK-' . date('ymd') . '-' . rand(1000, 9999);
        while (Booking::where('booking_number', $bookingNumber)->exists()) {
            $bookingNumber = 'BK-' . date('ymd') . '-' . rand(1000, 9999);
        }

        // 4. Create the Booking Record
        $booking = Booking::create([
            'booking_number' => $bookingNumber,
            'user_id' => $userId,
            'parent_name' => $validated['parent_name'],
            'parent_phone' => $validated['parent_phone'],
            'parent_email' => $validated['parent_email'] ?? null,
            'child_name' => $validated['child_name'],
            'child_age' => $validated['child_age'],
            'service_type' => $validated['service_type'],
            'session_format' => $validated['session_format'],
            'branch' => $validated['branch'],
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'notes' => $validated['notes'] ?? null,
            'status' => 'pending',
            'created_by_admin' => false,
        ]);

        // 5. Create CRM Activity Log
        CrmLog::create([
            'user_id' => $userId,
            'admin_id' => null,
            'type' => 'system',
            'details' => 'حجز استشارة / تقييم جديد (' . $booking->service_type_label . ') برقم حجز #' . $booking->booking_number . ' للطفل: ' . $booking->child_name . ' - الفرع: ' . $booking->branch_label,
        ]);

        return redirect()->route('booking.success', $booking->booking_number)
            ->with('success', 'تم استلام طلب حجز الاستشارة بنجاح وسيتم التواصل معكم لتأكيد الموعد.');
    }

    // Booking Success Confirmation Page
    public function success($bookingNumber)
    {
        $booking = Booking::where('booking_number', $bookingNumber)->firstOrFail();

        return view('storefront.booking-success', compact('booking'));
    }
}
