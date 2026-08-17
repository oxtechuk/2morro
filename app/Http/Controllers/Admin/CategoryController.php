<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $category = new Category(); // Empty model for form reuse
        return view('admin.categories.form', compact('category'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['name', 'description']);
        $data['slug'] = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $data['image'] = $path;
        }

        Category::create($data);

        return redirect()->route('admin.categories.index')->with('success', 'تم إضافة التصنيف بنجاح.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.form', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->only(['name', 'description']);
        $data['slug'] = $request->filled('slug') ? Str::slug($request->slug) : Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        // Handle Image Upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $path = $request->file('image')->store('categories', 'public');
            $data['image'] = $path;
        }

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'تم تحديث التصنيف بنجاح.');
    }

    public function destroy(Category $category)
    {
        // Delete image if exists
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'تم حذف التصنيف بنجاح.');
    }
}
