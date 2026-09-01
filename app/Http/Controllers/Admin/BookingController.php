<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\CrmLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    // List all bookings with search, filters, and stats
    public function index(Request $request)
    {
        $query = Booking::query()->latest();

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

        // Branch filter
        if ($request->filled('branch') && $request->branch !== 'all') {
            $query->where('branch', $request->branch);
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
            'completed' => Booking::where('status', 'completed')->count(),
        ];

        $services = Booking::$services;
        $branches = Booking::$branches;
        $statuses = Booking::$statuses;
        $users = User::where('email', '!=', 'admin@2morro.com')
            ->where('email', 'not like', '%@2morro.com')
            ->select('id', 'name', 'email')
            ->get();

        return view('admin.bookings.index', compact(
            'bookings',
            'stats',
            'services',
            'branches',
            'statuses',
            'users'
        ));
    }

    // View specific booking details
    public function show(Booking $booking)
    {
        $services = Booking::$services;
        $branches = Booking::$branches;
        $statuses = Booking::$statuses;
        $booking->load('user.customerProfile');

        return view('admin.bookings.show', compact('booking', 'services', 'branches', 'statuses'));
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
            'branch' => 'required_if:session_format,in_center|nullable|string',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string|max:50',
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

        $bookingNumber = 'BK-ADM-' . date('ymd') . '-' . rand(100, 999);
        $finalBranch = ($validated['session_format'] === 'online') ? 'online' : ($validated['branch'] ?? 'ibrahimiya');

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
            'branch' => $finalBranch,
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
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
            'details' => 'تم إنشاء حجز استشارة يدوي من لوحة التحكم برقم #' . $booking->booking_number . ' للطفل: ' . $booking->child_name,
        ]);

        return redirect()->route('admin.bookings.index')->with('success', 'تم إضافة وتسجيل الحجز بنجاح!');
    }

    // Update booking status and details
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,confirmed,completed,cancelled',
            'booking_date' => 'required|date',
            'booking_time' => 'required|string|max:50',
            'branch' => 'required|string',
            'service_type' => 'required|string',
            'admin_notes' => 'nullable|string',
        ]);

        $oldStatus = $booking->status;
        $booking->update($validated);

        if ($oldStatus !== $validated['status'] && $booking->user_id) {
            CrmLog::create([
                'user_id' => $booking->user_id,
                'admin_id' => Auth::id(),
                'type' => 'system',
                'details' => 'تم تغيير حالة حجز الاستشارة #' . $booking->booking_number . ' من (' . (Booking::$statuses[$oldStatus] ?? $oldStatus) . ') إلى (' . $booking->status_label . ')',
            ]);
        }

        return redirect()->back()->with('success', 'تم تحديث بيانات وموعد الحجز بنجاح!');
    }

    // Delete booking
    public function destroy(Booking $booking)
    {
        $bookingNumber = $booking->booking_number;
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'تم حذف الحجز #' . $bookingNumber . ' بنجاح.');
    }
}
