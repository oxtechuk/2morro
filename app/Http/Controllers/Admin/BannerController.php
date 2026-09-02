<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\ImageOptimizerService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order', 'asc')->latest()->paginate(15);
        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'badge_text' => 'nullable|string|max:100',
            'image' => 'required|image|max:10240',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_link' => 'nullable|string|max:255',
            'text_position' => 'required|in:right,center,left',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $path = ImageOptimizerService::optimizeAndSave($request->file('image'), 'banners', 1920, 88);
            $validated['image'] = 'storage/' . $path;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Banner::create($validated);

        return redirect()->route('admin.banners.index')->with('success', 'تمت إضافة البانر بنجاح إلى السليدر الرئيسي.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string',
            'badge_text' => 'nullable|string|max:100',
            'image' => 'nullable|image|max:10240',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'secondary_button_text' => 'nullable|string|max:100',
            'secondary_button_link' => 'nullable|string|max:255',
            'text_position' => 'required|in:right,center,left',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            ImageOptimizerService::deleteOldImage($banner->image);
            $path = ImageOptimizerService::optimizeAndSave($request->file('image'), 'banners', 1920, 88);
            $validated['image'] = 'storage/' . $path;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $banner->update($validated);

        return redirect()->route('admin.banners.index')->with('success', 'تم تعديل بيانات البانر بنجاح.');
    }

    public function destroy(Banner $banner)
    {
        ImageOptimizerService::deleteOldImage($banner->image);
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'تم حذف البانر بنجاح.');
    }

    public function toggleStatus(Banner $banner)
    {
        $banner->update(['is_active' => !$banner->is_active]);
        return back()->with('success', 'تم تغيير حالة البانر بنجاح.');
    }
}
