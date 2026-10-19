<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $request = Illuminate\Http\Request::create('/', 'GET');
    $controller = new App\Http\Controllers\StorefrontController();
    $response = $controller->index();
    $content = $response->render();
    echo "SUCCESS: Homepage rendered perfectly! Length: " . strlen($content) . " bytes\n";
    
    // Check if the squashed title is fixed and present
    if (str_contains($content, 'جميع المنتجات والأدوات التعليمية')) {
        echo "FOUND: Title 'جميع المنتجات والأدوات التعليمية' is present!\n";
    }
    // Check if age groups without products are NOT present in the top filter
    if (str_contains($content, 'من 9 إلى 12 سنة')) {
        echo "WARNING: 'من 9 إلى 12 سنة' should not be present!\n";
    } else {
        echo "VERIFIED: Age group without products ('من 9 إلى 12 سنة') is NOT present!\n";
    }
    // Check if categories without products are NOT present in the bottom filter
    if (str_contains($content, 'الكورسات') && str_contains($content, 'activeCategory === \'courses\'')) {
        echo "WARNING: 'الكورسات' should not be present in category filter!\n";
    } else {
        echo "VERIFIED: Category without products ('الكورسات') is NOT present in category filter!\n";
    }
    if (str_contains($content, 'الجلسات والخدمات') && str_contains($content, 'activeCategory === \'sessions\'')) {
        echo "WARNING: 'الجلسات والخدمات' should not be present in category filter!\n";
    } else {
        echo "VERIFIED: Category without products ('الجلسات والخدمات') is NOT present in category filter!\n";
    }
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
}
