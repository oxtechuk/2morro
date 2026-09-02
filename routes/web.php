<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StorefrontController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DownloadController;
use Illuminate\Support\Facades\Route;

// Storefront routes
Route::get('/', [StorefrontController::class, 'index'])->name('home');
Route::get('/product/{product:slug}', [StorefrontController::class, 'product'])->name('product');
Route::get('/search', [StorefrontController::class, 'search'])->name('search');
Route::get('/sitemap.xml', [StorefrontController::class, 'sitemap']);

// Cart routes
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');

// Secure file download route
Route::get('/download/{token}', [DownloadController::class, 'download'])->name('download');

// Consultation & Assessment Booking Routes
use App\Http\Controllers\BookingController;
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/success/{bookingNumber}', [BookingController::class, 'success'])->name('booking.success');

// Breeze dashboard & auth profile routes
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin shortcut route
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Panel Routes
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CrmController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\TaxonomyController;
use App\Http\Controllers\Admin\ProductImportExportController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Consultation Bookings Management (إدارة الحجوزات والاستشارات)
    Route::resource('bookings', AdminBookingController::class);

    // Brands & Partners Management (إدارة البراندات والشركاء)
    Route::resource('brands', BrandController::class)->except(['show']);
    Route::post('/brands/{brand}/toggle-status', [BrandController::class, 'toggleStatus'])->name('brands.toggleStatus');

    // Store Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
    Route::match(['put', 'patch', 'delete'], '/settings', function () {
        return redirect()->route('admin.settings.index');
    });
    
    // Banners & Hero Slider Management
    Route::resource('banners', BannerController::class)->except(['show']);
    Route::post('/banners/{banner}/toggle-status', [BannerController::class, 'toggleStatus'])->name('banners.toggleStatus');

    // CRM Customers
    Route::get('/crm', [CrmController::class, 'index'])->name('crm.index');
    Route::get('/crm/customer/{user}', [CrmController::class, 'show'])->name('crm.show');
    Route::post('/crm/customer/{user}/note', [CrmController::class, 'storeNote'])->name('crm.storeNote');
    Route::post('/crm/customer/{user}/update-segment', [CrmController::class, 'updateSegment'])->name('crm.updateSegment');
    Route::post('/crm/customer/{user}/reset-download/{download}', [CrmController::class, 'resetDownload'])->name('crm.resetDownload');

    // Taxonomy & Filters Hub (مركز التصنيفات والفلاتر الموحد)
    Route::get('/taxonomy', [TaxonomyController::class, 'index'])->name('taxonomy.index');
    Route::post('/taxonomy/categories', [TaxonomyController::class, 'storeCategory'])->name('taxonomy.categories.store');
    Route::put('/taxonomy/categories/{category}', [TaxonomyController::class, 'updateCategory'])->name('taxonomy.categories.update');
    Route::delete('/taxonomy/categories/{category}', [TaxonomyController::class, 'destroyCategory'])->name('taxonomy.categories.destroy');

    Route::post('/taxonomy/age-groups', [TaxonomyController::class, 'storeAgeGroup'])->name('taxonomy.age-groups.store');
    Route::put('/taxonomy/age-groups/{ageGroup}', [TaxonomyController::class, 'updateAgeGroup'])->name('taxonomy.age-groups.update');
    Route::delete('/taxonomy/age-groups/{ageGroup}', [TaxonomyController::class, 'destroyAgeGroup'])->name('taxonomy.age-groups.destroy');

    Route::post('/taxonomy/skills', [TaxonomyController::class, 'storeSkill'])->name('taxonomy.skills.store');
    Route::put('/taxonomy/skills/{skill}', [TaxonomyController::class, 'updateSkill'])->name('taxonomy.skills.update');
    Route::delete('/taxonomy/skills/{skill}', [TaxonomyController::class, 'destroySkill'])->name('taxonomy.skills.destroy');

    Route::post('/taxonomy/needs', [TaxonomyController::class, 'storeNeed'])->name('taxonomy.needs.store');
    Route::put('/taxonomy/needs/{need}', [TaxonomyController::class, 'updateNeed'])->name('taxonomy.needs.update');
    Route::delete('/taxonomy/needs/{need}', [TaxonomyController::class, 'destroyNeed'])->name('taxonomy.needs.destroy');

    // Products Bulk Import & Export via Excel/CSV
    Route::get('/products/import-export', [ProductImportExportController::class, 'index'])->name('products.importExport');
    Route::get('/products/export', [ProductImportExportController::class, 'export'])->name('products.export');
    Route::get('/products/template', [ProductImportExportController::class, 'downloadTemplate'])->name('products.template');
    Route::post('/products/import', [ProductImportExportController::class, 'import'])->name('products.import');

    // Products CRUD
    Route::resource('products', ProductController::class);
    
    // Categories CRUD (Alias to Taxonomy categories)
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Orders Management
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

    // Reviews Management
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/toggle-approve', [ReviewController::class, 'toggleApprove'])->name('reviews.toggleApprove');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});

require __DIR__.'/auth.php';
