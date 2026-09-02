<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class ImageOptimizerService
{
    /**
     * Optimize and convert an uploaded image to WebP format.
     *
     * @param UploadedFile|string $file
     * @param string $folder Relative path inside storage/app/public (e.g. 'products', 'categories', 'banners')
     * @param int $maxWidth Max allowed width (default 1200px)
     * @param int $quality WebP quality level (0-100, default 82)
     * @return string Relative path for storage (e.g. 'products/prod_64bf_123.webp')
     */
    public static function optimizeAndSave($file, string $folder = 'uploads', int $maxWidth = 1200, int $quality = 82): string
    {
        $targetDir = storage_path('app/public/' . trim($folder, '/'));
        if (!file_exists($targetDir)) {
            @mkdir($targetDir, 0755, true);
        }

        $filename = Str::slug(pathinfo($file instanceof UploadedFile ? $file->getClientOriginalName() : basename($file), PATHINFO_FILENAME));
        $uniqueName = ($filename ? substr($filename, 0, 30) . '_' : '') . time() . '_' . Str::random(8) . '.webp';
        $destinationPath = $targetDir . DIRECTORY_SEPARATOR . $uniqueName;

        $sourcePath = $file instanceof UploadedFile ? $file->getRealPath() : $file;

        if (!file_exists($sourcePath)) {
            // Fallback: if not an existing file, try storing standard
            if ($file instanceof UploadedFile) {
                return $file->store($folder, 'public');
            }
            return '';
        }

        // Check image info
        $imageInfo = @getimagesize($sourcePath);
        if (!$imageInfo) {
            // If not a valid image format for GD, fallback to standard copy
            if ($file instanceof UploadedFile) {
                return $file->store($folder, 'public');
            }
            return '';
        }

        $width = $imageInfo[0];
        $height = $imageInfo[1];
        $mime = $imageInfo['mime'];

        // Load image resource based on mime type
        $sourceImage = null;
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $sourceImage = @imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $sourceImage = @imagecreatefrompng($sourcePath);
                break;
            case 'image/webp':
                if (function_exists('imagecreatefromwebp')) {
                    $sourceImage = @imagecreatefromwebp($sourcePath);
                }
                break;
            case 'image/gif':
                $sourceImage = @imagecreatefromgif($sourcePath);
                break;
            case 'image/bmp':
            case 'image/x-ms-bmp':
                if (function_exists('imagecreatefrombmp')) {
                    $sourceImage = @imagecreatefrombmp($sourcePath);
                }
                break;
        }

        if (!$sourceImage) {
            // Fallback if GD couldn't parse
            if ($file instanceof UploadedFile) {
                return $file->store($folder, 'public');
            }
            return '';
        }

        // Fix Orientation from EXIF if JPEG
        if (function_exists('exif_read_data') && ($mime === 'image/jpeg' || $mime === 'image/jpg')) {
            try {
                $exif = @exif_read_data($sourcePath);
                if (!empty($exif['Orientation'])) {
                    switch ($exif['Orientation']) {
                        case 3:
                            $sourceImage = imagerotate($sourceImage, 180, 0);
                            break;
                        case 6:
                            $sourceImage = imagerotate($sourceImage, -90, 0);
                            $temp = $width;
                            $width = $height;
                            $height = $temp;
                            break;
                        case 8:
                            $sourceImage = imagerotate($sourceImage, 90, 0);
                            $temp = $width;
                            $width = $height;
                            $height = $temp;
                            break;
                    }
                }
            } catch (\Throwable $e) {}
        }

        // Calculate proportional dimensions
        $newWidth = $width;
        $newHeight = $height;

        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int)round(($height / $width) * $maxWidth);
        }

        // Create canvas with truecolor
        $targetImage = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve alpha transparency for PNG, WebP, GIF
        imagealphablending($targetImage, false);
        imagesavealpha($targetImage, true);
        $transparent = imagecolorallocatealpha($targetImage, 255, 255, 255, 127);
        imagefilledrectangle($targetImage, 0, 0, $newWidth, $newHeight, $transparent);

        // Resample with high quality interpolation
        imagecopyresampled($targetImage, $sourceImage, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        // Save as WebP if supported, otherwise fallback to JPEG
        if (function_exists('imagewebp')) {
            imagewebp($targetImage, $destinationPath, $quality);
        } else {
            $uniqueName = str_replace('.webp', '.jpg', $uniqueName);
            $destinationPath = $targetDir . DIRECTORY_SEPARATOR . $uniqueName;
            imagejpeg($targetImage, $destinationPath, $quality);
        }

        // Free memory
        imagedestroy($sourceImage);
        imagedestroy($targetImage);

        return trim($folder, '/') . '/' . $uniqueName;
    }

    /**
     * Delete an old image safely from storage if exists.
     */
    public static function deleteOldImage(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        // Strip prefix if any
        $cleanPath = str_replace(['storage/', '/storage/'], '', $path);
        $fullPath = storage_path('app/public/' . $cleanPath);

        if (file_exists($fullPath) && is_file($fullPath)) {
            @unlink($fullPath);
        }
    }
}
