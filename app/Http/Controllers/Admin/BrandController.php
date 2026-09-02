<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Services\ImageOptimizerService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('row', 'asc')->orderBy('sort_order', 'asc')->paginate(20);
        $topBrands = Brand::where('row', 'top')->orderBy('sort_order', 'asc')->get();
        $bottomBrands = Brand::where('row', 'bottom')->orderBy('sort_order', 'asc')->get();

        $stats = [
            'total' => Brand::count(),
            'active' => Brand::where('is_active', true)->count(),
            'top_row' => Brand::where('row', 'top')->count(),
            'bottom_row' => Brand::where('row', 'bottom')->count(),
        ];

        return view('admin.brands.index', compact('brands', 'topBrands', 'bottomBrands', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:190',
            'logo_file' => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'link' => 'nullable|string|max:255',
            'filter_keyword' => 'nullable|string|max:100',
            'row' => 'required|in:top,bottom',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $logoPath = 'images/logo.png';
        if ($request->hasFile('logo_file')) {
            $path = ImageOptimizerService::optimizeAndSave($request->file('logo_file'), 'brands', 500, 85);
            $logoPath = 'storage/' . $path;
        }

        $slug = Str::slug($validated['name']) . '-' . rand(100, 999);

        Brand::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'logo' => $logoPath,
            'link' => $validated['link'] ?? null,
            'filter_keyword' => $validated['filter_keyword'] ?? null,
            'row' => $validated['row'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'is_active' => $request->has('is_active') ? true : ($validated['is_active'] ?? true),
        ]);

        return redirect()->route('admin.brands.index')->with('success', 'تمت إضافة العلامة التجارية / البراند بنجاح!');
    }

    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:190',
            'logo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:5120',
            'link' => 'nullable|string|max:255',
            'filter_keyword' => 'nullable|string|max:100',
            'row' => 'required|in:top,bottom',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo_file')) {
            ImageOptimizerService::deleteOldImage($brand->logo);
            $path = ImageOptimizerService::optimizeAndSave($request->file('logo_file'), 'brands', 500, 85);
            $validated['logo'] = 'storage/' . $path;
        }

        $validated['is_active'] = $request->has('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $brand->update($validated);

        return redirect()->route('admin.brands.index')->with('success', 'تم تحديث بيانات البراند بنجاح!');
    }

    public function toggleStatus(Brand $brand)
    {
        $brand->update(['is_active' => !$brand->is_active]);
        return redirect()->back()->with('success', 'تم تغيير حالة التفعيل بنجاح!');
    }

    public function destroy(Brand $brand)
    {
        ImageOptimizerService::deleteOldImage($brand->logo);
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'تم حذف البراند بنجاح.');
    }
}
