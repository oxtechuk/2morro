<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DoctorVideo;
use App\Models\AgeGroup;
use App\Models\Need;
use App\Models\Product;
use App\Services\ImageOptimizerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DoctorVideoController extends Controller
{
    /**
     * Display a listing of doctor videos and reels with KPI stats.
     */
    public function index(Request $request)
    {
        $query = DoctorVideo::with(['ageGroup', 'need'])->withCount('products');

        // Filters
        if ($request->filled('type') && in_array($request->type, ['reel', 'standard'])) {
            $query->where('video_type', $request->type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'paid') {
                $query->where('is_paid', true);
            } elseif ($request->status === 'free') {
                $query->where('is_paid', false);
            }
        }

        if ($request->filled('age_group_id')) {
            $query->where('age_group_id', $request->age_group_id);
        }

        if ($request->filled('need_id')) {
            $query->where('need_id', $request->need_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $videos = $query->latest('id')->paginate(15)->withQueryString();

        // KPIs
        $stats = [
            'total'      => DoctorVideo::count(),
            'reels'      => DoctorVideo::reels()->count(),
            'standard'   => DoctorVideo::standard()->count(),
            'paid'       => DoctorVideo::paid()->count(),
            'free'       => DoctorVideo::free()->count(),
            'views'      => DoctorVideo::sum('views_count'),
            'revenue'    => DB::table('doctor_video_access')->sum('price_paid') ?? 0,
        ];

        $ageGroups = AgeGroup::all();
        $needs     = Need::all();

        return view('admin.doctor-videos.index', compact('videos', 'stats', 'ageGroups', 'needs'));
    }

    /**
     * Show form for creating a new video or reel.
     */
    public function create()
    {
        $ageGroups = AgeGroup::orderBy('min_age', 'asc')->get();
        $needs     = Need::orderBy('name', 'asc')->get();
        $products  = Product::where('is_active', true)->select('id', 'name', 'images', 'price')->get();

        return view('admin.doctor-videos.create', compact('ageGroups', 'needs', 'products'));
    }

    /**
     * Store newly created video.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'video_type'      => 'required|in:reel,standard',
            'video_source'    => 'required|in:upload,url,youtube,vimeo',
            'video_file'      => 'nullable|file|mimes:mp4,mov,ogg,qt,webm|max:512000',
            'video_url'       => 'nullable|string|max:1000',
            'thumbnail_file'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'thumbnail_url'   => 'nullable|string|max:1000',
            'duration'        => 'nullable|string|max:50',
            'age_group_id'    => 'nullable|exists:age_groups,id',
            'need_id'         => 'nullable|exists:needs,id',
            'is_paid'         => 'nullable|boolean',
            'price'           => 'nullable|numeric|min:0',
            'preview_seconds' => 'nullable|integer|min:0',
            'is_published'    => 'nullable|boolean',
            'related_products'=> 'nullable|array',
            'related_products.*' => 'exists:products,id',
        ]);

        $videoPath = null;
        if ($validated['video_source'] === 'upload' && $request->hasFile('video_file')) {
            $videoPath = $request->file('video_file')->store('doctor_videos', 'public');
        } else {
            $videoPath = $validated['video_url'] ?? null;
        }

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail_file')) {
            $thumbnailPath = ImageOptimizerService::optimizeAndSave($request->file('thumbnail_file'), 'doctor_thumbnails', 1280, 85);
        } elseif (!empty($validated['thumbnail_url'])) {
            $thumbnailPath = $validated['thumbnail_url'];
        }

        $isPaid = $request->boolean('is_paid', false);
        $price = $isPaid ? ($validated['price'] ?? 0) : 0;

        $video = DoctorVideo::create([
            'title'           => $validated['title'],
            'description'     => $validated['description'] ?? null,
            'video_type'      => $validated['video_type'],
            'video_source'    => $validated['video_source'],
            'video_path'      => $videoPath,
            'thumbnail'       => $thumbnailPath,
            'duration'        => $validated['duration'] ?? null,
            'age_group_id'    => $validated['age_group_id'] ?? null,
            'need_id'         => $validated['need_id'] ?? null,
            'is_paid'         => $isPaid,
            'price'           => $price,
            'preview_seconds' => $isPaid ? ($validated['preview_seconds'] ?? 45) : 0,
            'is_published'    => $request->boolean('is_published', true),
        ]);

        if (!empty($validated['related_products'])) {
            $video->products()->sync($validated['related_products']);
        }

        return redirect()->route('admin.doctor-videos.index')->with('success', 'تم رفع وإضافة الفيديو بنجاح!');
    }

    /**
     * Show form for editing an existing video.
     */
    public function edit(DoctorVideo $doctorVideo)
    {
        $doctorVideo->load('products');
        $ageGroups = AgeGroup::orderBy('min_age', 'asc')->get();
        $needs     = Need::orderBy('name', 'asc')->get();
        $products  = Product::where('is_active', true)->select('id', 'name', 'images', 'price')->get();

        return view('admin.doctor-videos.edit', compact('doctorVideo', 'ageGroups', 'needs', 'products'));
    }

    /**
     * Update an existing video.
     */
    public function update(Request $request, DoctorVideo $doctorVideo)
    {
        $validated = $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'nullable|string',
            'video_type'      => 'required|in:reel,standard',
            'video_source'    => 'required|in:upload,url,youtube,vimeo',
            'video_file'      => 'nullable|file|mimes:mp4,mov,ogg,qt,webm|max:512000',
            'video_url'       => 'nullable|string|max:1000',
            'thumbnail_file'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'thumbnail_url'   => 'nullable|string|max:1000',
            'duration'        => 'nullable|string|max:50',
            'age_group_id'    => 'nullable|exists:age_groups,id',
            'need_id'         => 'nullable|exists:needs,id',
            'is_paid'         => 'nullable|boolean',
            'price'           => 'nullable|numeric|min:0',
            'preview_seconds' => 'nullable|integer|min:0',
            'is_published'    => 'nullable|boolean',
            'related_products'=> 'nullable|array',
            'related_products.*' => 'exists:products,id',
        ]);

        $videoPath = $doctorVideo->video_path;
        if ($validated['video_source'] === 'upload' && $request->hasFile('video_file')) {
            // Delete old file if local
            if (!empty($videoPath) && !Str::startsWith($videoPath, ['http://', 'https://'])) {
                Storage::disk('public')->delete($videoPath);
            }
            $videoPath = $request->file('video_file')->store('doctor_videos', 'public');
        } elseif ($validated['video_source'] !== 'upload' && !empty($validated['video_url'])) {
            $videoPath = $validated['video_url'];
        }

        $thumbnailPath = $doctorVideo->thumbnail;
        if ($request->hasFile('thumbnail_file')) {
            ImageOptimizerService::deleteOldImage($thumbnailPath);
            $thumbnailPath = ImageOptimizerService::optimizeAndSave($request->file('thumbnail_file'), 'doctor_thumbnails', 1280, 85);
        } elseif (!empty($validated['thumbnail_url'])) {
            $thumbnailPath = $validated['thumbnail_url'];
        }

        $isPaid = $request->boolean('is_paid', false);
        $price = $isPaid ? ($validated['price'] ?? 0) : 0;

        $doctorVideo->update([
            'title'           => $validated['title'],
            'description'     => $validated['description'] ?? null,
            'video_type'      => $validated['video_type'],
            'video_source'    => $validated['video_source'],
            'video_path'      => $videoPath,
            'thumbnail'       => $thumbnailPath,
            'duration'        => $validated['duration'] ?? null,
            'age_group_id'    => $validated['age_group_id'] ?? null,
            'need_id'         => $validated['need_id'] ?? null,
            'is_paid'         => $isPaid,
            'price'           => $price,
            'preview_seconds' => $isPaid ? ($validated['preview_seconds'] ?? 45) : 0,
            'is_published'    => $request->boolean('is_published', true),
        ]);

        $doctorVideo->products()->sync($validated['related_products'] ?? []);

        return redirect()->route('admin.doctor-videos.index')->with('success', 'تم تحديث بيانات الفيديو بنجاح!');
    }

    /**
     * Delete video and its files.
     */
    public function destroy(DoctorVideo $doctorVideo)
    {
        if (!empty($doctorVideo->video_path) && !Str::startsWith($doctorVideo->video_path, ['http://', 'https://'])) {
            Storage::disk('public')->delete($doctorVideo->video_path);
        }
        ImageOptimizerService::deleteOldImage($doctorVideo->thumbnail);

        $doctorVideo->products()->detach();
        $doctorVideo->delete();

        return redirect()->route('admin.doctor-videos.index')->with('success', 'تم حذف الفيديو بنجاح.');
    }

    /**
     * Toggle published status via AJAX.
     */
    public function toggleStatus(DoctorVideo $doctorVideo)
    {
        $doctorVideo->update([
            'is_published' => !$doctorVideo->is_published
        ]);

        return response()->json([
            'success'      => true,
            'is_published' => $doctorVideo->is_published,
            'message'      => $doctorVideo->is_published ? 'تم نشر الفيديو للجمهور.' : 'تم تحويل الفيديو إلى مسودة.'
        ]);
    }

    /**
     * Media Gallery View (Thumbnails & Videos).
     */
    public function gallery(Request $request)
    {
        $videos = DoctorVideo::select('id', 'title', 'thumbnail', 'video_path', 'video_type', 'duration', 'created_at')
            ->latest('id')
            ->paginate(24);

        return view('admin.doctor-videos.gallery', compact('videos'));
    }

    /**
     * Upload quick media via AJAX to the gallery.
     */
    public function uploadMedia(Request $request)
    {
        $request->validate([
            'media_file' => 'required|file|mimes:jpeg,png,jpg,webp,mp4,mov,webm|max:512000'
        ]);

        $file = $request->file('media_file');
        $mime = $file->getMimeType();

        if (Str::startsWith($mime, 'image/')) {
            $path = ImageOptimizerService::optimizeAndSave($file, 'doctor_thumbnails', 1280, 85);
            $type = 'image';
        } else {
            $path = $file->store('doctor_videos', 'public');
            $type = 'video';
        }

        return response()->json([
            'success' => true,
            'type'    => $type,
            'path'    => $path,
            'url'     => asset('storage/' . $path),
            'message' => 'تم رفع الملف إلى المعرض بنجاح!'
        ]);
    }

    /**
     * Purchases & Subscriptions List.
     */
    public function purchases(Request $request)
    {
        $purchases = DB::table('doctor_video_access')
            ->join('users', 'doctor_video_access.user_id', '=', 'users.id')
            ->join('doctor_videos', 'doctor_video_access.doctor_video_id', '=', 'doctor_videos.id')
            ->leftJoin('orders', 'doctor_video_access.order_id', '=', 'orders.id')
            ->select(
                'doctor_video_access.*',
                'users.name as user_name',
                'users.email as user_email',
                'users.phone as user_phone',
                'doctor_videos.title as video_title',
                'doctor_videos.price as video_price',
                'orders.order_number'
            )
            ->orderBy('doctor_video_access.created_at', 'desc')
            ->paginate(20);

        $totalRevenue = DB::table('doctor_video_access')->sum('price_paid');
        $totalSubscribers = DB::table('doctor_video_access')->distinct('user_id')->count('user_id');

        return view('admin.doctor-videos.purchases', compact('purchases', 'totalRevenue', 'totalSubscribers'));
    }
}

