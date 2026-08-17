<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CustomerProfile;
use App\Models\CrmLog;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CrmController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()
            ->where('email', '!=', 'admin@2morro.com')
            ->where('email', 'not like', '%@2morro.com');

        // Eager load profile
        $query->with(['profile']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('orders', function($oQ) use ($search) {
                      $oQ->where('customer_phone', 'like', "%{$search}%")
                         ->orWhere('customer_name', 'like', "%{$search}%");
                  });
            });
        }

        // Segment filter
        if ($request->filled('segment')) {
            $query->whereHas('profile', function($q) use ($request) {
                $q->where('segment', $request->segment);
            });
        }

        // Aggregate orders stats
        $query->withCount(['orders' => function($q) {
            $q->where('status', '!=', 'cancelled');
        }]);

        $query->withSum(['orders as total_spent' => function($q) {
            $q->where('payment_status', 'paid');
        }], 'total');

        // Sorting
        $sort = $request->get('sort', 'latest');
        if ($sort === 'spent') {
            $query->orderByDesc('total_spent');
        } elseif ($sort === 'orders') {
            $query->orderByDesc('orders_count');
        } else {
            $query->orderByDesc('created_at');
        }

        $customers = $query->paginate(10)->withQueryString();

        return view('admin.crm.index', compact('customers'));
    }

    public function show(User $user)
    {
        // Prevent accessing admin profiles
        if ($user->isAdmin() && $user->email !== Auth::user()->email) {
            abort(403, 'غير مصرح بعرض ملفات المشرفين الآخرين.');
        }

        // Ensure profile exists
        if (!$user->profile) {
            $user->profile()->create([
                'segment' => 'parent'
            ]);
            $user->load('profile');
        }

        // Load CRM logs, orders, and digital downloads
        $crmLogs = $user->crmLogs()->with('admin')->latest()->get();
        $orders = $user->orders()->latest()->get();
        $downloads = $user->downloads()->with('product')->latest()->get();

        return view('admin.crm.show', compact('user', 'crmLogs', 'orders', 'downloads'));
    }

    public function storeNote(Request $request, User $user)
    {
        $request->validate([
            'type' => 'required|in:note,call,whatsapp,email',
            'details' => 'required|string|max:1000',
        ]);

        // Create log
        $user->crmLogs()->create([
            'admin_id' => Auth::id(),
            'type' => $request->type,
            'details' => $request->details,
        ]);

        // Update last contacted
        $user->profile()->update([
            'last_contacted_at' => now()
        ]);

        return redirect()->back()->with('success', 'تم إضافة ملاحظة التواصل بنجاح.');
    }

    public function updateSegment(Request $request, User $user)
    {
        $request->validate([
            'segment' => 'required|in:parent,specialist,nursery,school',
        ]);

        $oldSegment = $user->profile->segment ?? 'parent';
        
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            ['segment' => $request->segment]
        );

        $segmentLabels = CustomerProfile::$segments;
        $oldLabel = $segmentLabels[$oldSegment] ?? $oldSegment;
        $newLabel = $segmentLabels[$request->segment] ?? $request->segment;

        // Log this system action
        $user->crmLogs()->create([
            'admin_id' => Auth::id(),
            'type' => 'system',
            'details' => "تعديل تصنيف العميل من [{$oldLabel}] إلى [{$newLabel}].",
        ]);

        return redirect()->back()->with('success', 'تم تعديل تصنيف العميل بنجاح.');
    }

    public function resetDownload(Request $request, User $user, Download $download)
    {
        // Double check download owner
        if ($download->user_id !== $user->id) {
            abort(403);
        }

        $request->validate([
            'action' => 'required|in:reset_count,add_downloads,extend_time',
        ]);

        $productName = $download->product->name ?? 'الملف الرقمي';

        if ($request->action === 'reset_count') {
            $download->update(['download_count' => 0]);
            $details = "تصفير عداد تنزيل ملف: {$productName}";
        } elseif ($request->action === 'add_downloads') {
            $download->increment('max_downloads', 5);
            $details = "إضافة +5 محاولات تحميل إضافية لملف: {$productName}";
        } elseif ($request->action === 'extend_time') {
            $download->update([
                'expires_at' => ($download->expires_at && $download->expires_at->isFuture()) 
                    ? $download->expires_at->addDays(30) 
                    : now()->addDays(30)
            ]);
            $details = "تمديد تاريخ صلاحية تحميل ملف: {$productName} لمدة 30 يوماً إضافية";
        }

        // Log this system action
        $user->crmLogs()->create([
            'admin_id' => Auth::id(),
            'type' => 'system',
            'details' => $details,
        ]);

        return redirect()->back()->with('success', 'تم تعديل صلاحيات الملف الرقمي للعميل بنجاح.');
    }
}
