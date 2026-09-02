<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\AgeGroup;
use App\Models\Skill;
use App\Models\Need;
use App\Services\ImageOptimizerService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TaxonomyController extends Controller
{
    /**
     * Unified Dashboard for Categories & Filters
     */
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'categories');

        $categories = Category::withCount('products')->latest()->get();
        $ageGroups  = AgeGroup::withCount('products')->orderBy('min_age', 'asc')->get();
        $skills     = Skill::withCount('products')->latest()->get();
        $needs      = Need::withCount('products')->latest()->get();

        $stats = [
            'categories' => $categories->count(),
            'age_groups' => $ageGroups->count(),
            'skills'     => $skills->count(),
            'needs'      => $needs->count(),
        ];

        return view('admin.taxonomy.index', compact('activeTab', 'categories', 'ageGroups', 'skills', 'needs', 'stats'));
    }

    // ==========================================
    // 1. Categories Management
    // ==========================================
    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'is_active'   => 'nullable|boolean',
        ]);

        $data = [
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'slug'        => !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']),
            'is_active'   => $request->has('is_active') ? true : ($request->boolean('is_active', true)),
        ];

        if ($request->hasFile('image')) {
            $data['image'] = ImageOptimizerService::optimizeAndSave($request->file('image'), 'categories', 600, 82);
        }

        $category = Category::create($data);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تمت إضافة التصنيف بنجاح.',
                'item'    => $category,
            ]);
        }

        return redirect()->route('admin.taxonomy.index', ['tab' => 'categories'])->with('success', 'تمت إضافة التصنيف بنجاح.');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'is_active'   => 'nullable|boolean',
        ]);

        $data = [
            'name'        => $validated['name'],
            'description' => $validated['description'] ?? null,
            'slug'        => !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']),
            'is_active'   => $request->has('is_active'),
        ];

        if ($request->hasFile('image')) {
            ImageOptimizerService::deleteOldImage($category->image);
            $data['image'] = ImageOptimizerService::optimizeAndSave($request->file('image'), 'categories', 600, 82);
        }

        $category->update($data);

        return redirect()->route('admin.taxonomy.index', ['tab' => 'categories'])->with('success', 'تم تحديث بيانات التصنيف بنجاح.');
    }

    public function destroyCategory(Category $category)
    {
        ImageOptimizerService::deleteOldImage($category->image);
        $category->products()->detach();
        $category->delete();

        return redirect()->route('admin.taxonomy.index', ['tab' => 'categories'])->with('success', 'تم حذف التصنيف بنجاح.');
    }

    // ==========================================
    // 2. Age Groups Management
    // ==========================================
    public function storeAgeGroup(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'slug'    => 'nullable|string|max:255|unique:age_groups,slug',
            'min_age' => 'nullable|numeric|min:0',
            'max_age' => 'nullable|numeric|min:0',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        $ageGroup = AgeGroup::create($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تمت إضافة الفئة العمرية بنجاح.',
                'item'    => $ageGroup,
            ]);
        }

        return redirect()->route('admin.taxonomy.index', ['tab' => 'age_groups'])->with('success', 'تمت إضافة الفئة العمرية بنجاح.');
    }

    public function updateAgeGroup(Request $request, AgeGroup $ageGroup)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'slug'    => 'nullable|string|max:255|unique:age_groups,slug,' . $ageGroup->id,
            'min_age' => 'nullable|numeric|min:0',
            'max_age' => 'nullable|numeric|min:0',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        $ageGroup->update($validated);

        return redirect()->route('admin.taxonomy.index', ['tab' => 'age_groups'])->with('success', 'تم تحديث الفئة العمرية بنجاح.');
    }

    public function destroyAgeGroup(AgeGroup $ageGroup)
    {
        $ageGroup->products()->detach();
        $ageGroup->delete();

        return redirect()->route('admin.taxonomy.index', ['tab' => 'age_groups'])->with('success', 'تم حذف الفئة العمرية بنجاح.');
    }

    // ==========================================
    // 3. Skills Management
    // ==========================================
    public function storeSkill(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:skills,slug',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        $skill = Skill::create($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تمت إضافة المهارة بنجاح.',
                'item'    => $skill,
            ]);
        }

        return redirect()->route('admin.taxonomy.index', ['tab' => 'skills'])->with('success', 'تمت إضافة المهارة بنجاح.');
    }

    public function updateSkill(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:skills,slug,' . $skill->id,
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        $skill->update($validated);

        return redirect()->route('admin.taxonomy.index', ['tab' => 'skills'])->with('success', 'تم تحديث المهارة بنجاح.');
    }

    public function destroySkill(Skill $skill)
    {
        $skill->products()->detach();
        $skill->delete();

        return redirect()->route('admin.taxonomy.index', ['tab' => 'skills'])->with('success', 'تم حذف المهارة بنجاح.');
    }

    // ==========================================
    // 4. Needs Management
    // ==========================================
    public function storeNeed(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:needs,slug',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        $need = Need::create($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تمت إضافة الاحتياج الخاص بنجاح.',
                'item'    => $need,
            ]);
        }

        return redirect()->route('admin.taxonomy.index', ['tab' => 'needs'])->with('success', 'تمت إضافة الاحتياج الخاص بنجاح.');
    }

    public function updateNeed(Request $request, Need $need)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'slug'        => 'nullable|string|max:255|unique:needs,slug,' . $need->id,
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = !empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['name']);

        $need->update($validated);

        return redirect()->route('admin.taxonomy.index', ['tab' => 'needs'])->with('success', 'تم تحديث الاحتياج الخاص بنجاح.');
    }

    public function destroyNeed(Need $need)
    {
        $need->products()->detach();
        $need->delete();

        return redirect()->route('admin.taxonomy.index', ['tab' => 'needs'])->with('success', 'تم حذف الاحتياج الخاص بنجاح.');
    }
}
