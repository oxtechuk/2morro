<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // List all reviews
    public function index(Request $request)
    {
        $query = Review::query()->with(['product', 'user'])->latest();

        // Search filter (product name, customer name, comment)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhereHas('product', function($prodQ) use ($search) {
                      $prodQ->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Approval status filter
        if ($request->filled('status')) {
            $query->where('is_approved', $request->status === 'approved');
        }

        $reviews = $query->paginate(15)->withQueryString();

        return view('admin.reviews.index', compact('reviews'));
    }

    // Toggle approval status (is_approved true/false)
    public function toggleApprove(Review $review)
    {
        $review->update([
            'is_approved' => !$review->is_approved
        ]);

        $statusMessage = $review->is_approved ? 'تم نشر التقييم بنجاح بالمتجر.' : 'تم حجب التقييم بنجاح.';

        return back()->with('success', $statusMessage);
    }

    // Delete review
    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'تم حذف التقييم بشكل نهائي.');
    }
}
