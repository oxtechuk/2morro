<?php

namespace App\Http\Controllers;

use App\Models\Download;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    // Handle secure file download by token
    public function download($token)
    {
        // Find the download permission
        $download = Download::where('token', $token)->with('product')->firstOrFail();

        // Validate expiry and count limits
        if (!$download->isValid()) {
            return redirect()->route('home')
                ->with('error', 'عذراً، هذا الرابط منتهي الصلاحية أو تم استنفاد الحد الأقصى لمرات التحميل.');
        }

        $product = $download->product;

        if (!$product || !$product->digital_file_path) {
            abort(404, 'الملف غير متوفر حالياً.');
        }

        $filePath = $product->digital_file_path; // e.g. private_downloads/sample_worksheet.pdf
        $downloadName = $product->digital_file_name ?: basename($filePath);

        // Check various storage locations for maximum resilience
        $fullPath = null;
        if (Storage::disk('local')->exists($filePath)) {
            $fullPath = Storage::disk('local')->path($filePath);
        } elseif (file_exists(storage_path('app/' . $filePath))) {
            $fullPath = storage_path('app/' . $filePath);
        } elseif (file_exists(storage_path('app/private/' . $filePath))) {
            $fullPath = storage_path('app/private/' . $filePath);
        } elseif (Storage::disk('public')->exists($filePath)) {
            $fullPath = Storage::disk('public')->path($filePath);
        } elseif (file_exists(public_path($filePath))) {
            $fullPath = public_path($filePath);
        }

        if (!$fullPath || !file_exists($fullPath)) {
            abort(404, 'ملف التحميل غير موجود على الخادم. يرجى التواصل مع الدعم الفني.');
        }

        // Increment download counter
        $download->increment('download_count');

        // Return direct download response
        return response()->download($fullPath, $downloadName);
    }
}
