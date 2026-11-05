<?php

namespace App\Http\Controllers;

use App\Models\DoctorVideo;
use App\Models\AgeGroup;
use App\Models\Need;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DoctorVideoController extends Controller
{
    /**
     * Storefront YouTube-like Feed of Doctor Videos & Reels.
     */
    public function index(Request $request)
    {
        $selectedNeed     = $request->get('need');
        $selectedAgeGroup = $request->get('age_group');
        $selectedAccess   = $request->get('access'); // 'all', 'free', 'paid'
        $selectedType     = $request->get('type');   // 'all', 'reels', 'videos'
        $searchQuery      = $request->get('q');

        // 1. Fetch featured Reels for the Shorts Carousel (Top section)
        $reelsQuery = DoctorVideo::published()
            ->reels()
            ->with(['need', 'ageGroup']);

        if ($selectedNeed) {
            $reelsQuery->whereHas('need', fn($q) => $q->where('slug', $selectedNeed)->orWhere('id', $selectedNeed));
        }
        if ($selectedAgeGroup) {
            $reelsQuery->whereHas('ageGroup', fn($q) => $q->where('slug', $selectedAgeGroup)->orWhere('id', $selectedAgeGroup));
        }

        $reels = $reelsQuery->latest('id')->take(12)->get();

        // 2. Fetch Main Video Grid
        $videosQuery = DoctorVideo::published()
            ->with(['need', 'ageGroup'])
            ->withCount('products');

        if ($selectedType === 'reels') {
            $videosQuery->reels();
        } elseif ($selectedType === 'videos') {
            $videosQuery->standard();
        }

        if ($selectedAccess === 'free') {
            $videosQuery->free();
        } elseif ($selectedAccess === 'paid') {
            $videosQuery->paid();
        }

        if ($selectedNeed) {
            $videosQuery->whereHas('need', fn($q) => $q->where('slug', $selectedNeed)->orWhere('id', $selectedNeed));
        }

        if ($selectedAgeGroup) {
            $videosQuery->whereHas('ageGroup', fn($q) => $q->where('slug', $selectedAgeGroup)->orWhere('id', $selectedAgeGroup));
        }

        if ($searchQuery) {
            $videosQuery->where(function ($q) use ($searchQuery) {
                $q->where('title', 'like', "%{$searchQuery}%")
                  ->orWhere('description', 'like', "%{$searchQuery}%");
            });
        }

        $videos = $videosQuery->latest('id')->paginate(12)->withQueryString();

        // Taxonomies for Chips
        $needs = Need::withCount(['doctorVideos' => fn($q) => $q->published()])->get();
        $ageGroups = AgeGroup::withCount(['doctorVideos' => fn($q) => $q->published()])->orderBy('min_age', 'asc')->get();

        return view('storefront.doctor-videos.index', compact(
            'videos',
            'reels',
            'needs',
            'ageGroups',
            'selectedNeed',
            'selectedAgeGroup',
            'selectedAccess',
            'selectedType',
            'searchQuery'
        ));
    }

    /**
     * YouTube-like Watch Page.
     */
    public function watch($slug)
    {
        $video = DoctorVideo::published()
            ->where('slug', $slug)
            ->with(['need', 'ageGroup', 'products'])
            ->firstOrFail();

        // Increment Views Count safely
        $video->increment('views_count');

        // Check Access
        $hasAccess = $video->hasUserAccess(Auth::user());

        // Related Videos (Up Next - same problem or same age group)
        $relatedVideos = DoctorVideo::published()
            ->where('id', '!=', $video->id)
            ->where(function ($q) use ($video) {
                if ($video->need_id) {
                    $q->where('need_id', $video->need_id);
                }
                if ($video->age_group_id) {
                    $q->orWhere('age_group_id', $video->age_group_id);
                }
            })
            ->with(['need', 'ageGroup'])
            ->latest('id')
            ->take(8)
            ->get();

        if ($relatedVideos->isEmpty()) {
            $relatedVideos = DoctorVideo::published()
                ->where('id', '!=', $video->id)
                ->with(['need', 'ageGroup'])
                ->latest('id')
                ->take(8)
                ->get();
        }

        return view('storefront.doctor-videos.watch', compact('video', 'hasAccess', 'relatedVideos'));
    }

    /**
     * Unlock / Purchase Paid Video.
     */
    public function purchase(Request $request, $id)
    {
        $video = DoctorVideo::published()->findOrFail($id);
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'يرجى تسجيل الدخول أولاً لإتمام شراء الشرح.');
        }

        // Already unlocked?
        if ($video->hasUserAccess($user)) {
            return redirect()->route('doctor-videos.watch', $video->slug)->with('info', 'هذا الشرح متاح لك بالفعل!');
        }

        // Record purchase
        DB::table('doctor_video_access')->updateOrInsert(
            [
                'user_id'         => $user->id,
                'doctor_video_id' => $video->id,
            ],
            [
                'price_paid' => $video->price,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        return redirect()->route('doctor-videos.watch', $video->slug)
            ->with('success', 'مبروك! تم فتح الشرح وتوجيهات الدكتور بنجاح مدى الحياة.');
    }
}

