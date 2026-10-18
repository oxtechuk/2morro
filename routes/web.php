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
Route::get('/search/autocomplete', [StorefrontController::class, 'autocomplete'])->name('search.autocomplete');
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

// Language switcher route
Route::get('/change-language', function (\Illuminate\Http\Request $request) {
    $lang = $request->get('language', 'ar');
    session()->put('locale', $lang);
    app()->setLocale($lang);
    return back();
})->name('change.language');

// Shop Dashboard route
Route::get('/shop/dashboard', [\App\Http\Controllers\Shop\DashboardController::class, 'index'])->name('shop.dashboard.index');
Route::get('/shop/profile', [ProfileController::class, 'edit'])->name('shop.profile.index');
Route::get('/shop/profile/password', [ProfileController::class, 'edit'])->name('shop.profile.change-password');

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
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/dashboard/template', [DashboardController::class, 'templateDashboard'])->name('dashboard.template');
    Route::match(['get', 'post'], '/dashboard/statistics', [DashboardController::class, 'orderStatistics'])->name('dashboard.statistics');
    Route::get('/dashboard/notifications', [AdminNotificationController::class, 'index'])->name('dashboard.notification');

    // Profile & Settings aliases
    Route::get('/profile-setting', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.index');
    Route::get('/profile-password', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.change-password');
    Route::get('/generale-setting', [SettingController::class, 'index'])->name('generale-setting.index');
    
    // Consultation Bookings & Branch Schedules Management (إدارة الحجوزات، الفروع، المواعيد والأسعار)
    Route::get('bookings/settings', [AdminBookingController::class, 'settings'])->name('bookings.settings');
    Route::post('bookings/settings', [AdminBookingController::class, 'updateSettings'])->name('bookings.settings.update');
    Route::post('bookings/branches', [AdminBookingController::class, 'storeBranch'])->name('bookings.branches.store');
    Route::put('bookings/branches/{branch}', [AdminBookingController::class, 'updateBranch'])->name('bookings.branches.update');
    Route::delete('bookings/branches/{branch}', [AdminBookingController::class, 'destroyBranch'])->name('bookings.branches.destroy');
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

    // Products CRUD & Aliases
    Route::get('/product', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/approve/{product}', [ProductController::class, 'approve'])->name('product.approve');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::resource('products', ProductController::class);
    
    // Categories CRUD (Alias to Taxonomy categories)
    Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
    Route::resource('categories', CategoryController::class)->except(['show']);

    // Orders Management & Aliases (supporting both 2morro original dashboard and legacy links)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders-list', [OrderController::class, 'index']);
    Route::get('/orders/status/{status}', [OrderController::class, 'index'])->name('orders.status');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/order/show/{order}', [OrderController::class, 'show'])->name('order.show');
    Route::get('/orders/view/{order}', [OrderController::class, 'show']);
    Route::post('/orders/{order}/update-status', [OrderController::class, 'statusChange'])->name('orders.updateStatus');
    Route::get('/order/status-change/{order}', [OrderController::class, 'statusChange'])->name('order.status.change');
    Route::get('/order/payment-status-toggle/{order}', [OrderController::class, 'paymentStatusToggle'])->name('order.payment.status.toggle');
    Route::get('/orders/{order}/invoice', [OrderController::class, 'invoice'])->name('orders.invoice');

    // Reviews Management
    Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{review}/toggle-approve', [ReviewController::class, 'toggleApprove'])->name('reviews.toggleApprove');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Notifications
    Route::get('/notifications', [AdminNotificationController::class, 'show'])->name('notification.show');
    Route::get('/notifications/fetch', [AdminNotificationController::class, 'index'])->name('notification.index');
    Route::get('/notifications/read-all', [AdminNotificationController::class, 'markAllAsRead'])->name('notification.readAll');
    Route::get('/notifications/read/{notification}', [AdminNotificationController::class, 'markAsRead'])->name('notification.read');
    Route::delete('/notifications/{notification}', [AdminNotificationController::class, 'destroy'])->name('notification.destroy');
});

// Shop Notifications
Route::middleware(['auth'])->prefix('shop')->name('shop.')->group(function () {
    Route::get('/dashboard/notifications', [\App\Http\Controllers\Shop\NotificationController::class, 'index'])->name('dashboard.notification');
    Route::get('/notifications', [\App\Http\Controllers\Shop\NotificationController::class, 'show'])->name('notification.show');
    Route::get('/notifications/read-all', [\App\Http\Controllers\Shop\NotificationController::class, 'markAllAsRead'])->name('notification.readAll');
});

// User activity & messaging status endpoints
Route::post('/update/last/seen', function () {
    session(['last_online' => now()->toIso8601String()]);
    return response()->json(['status' => 'success']);
})->name('update.last.seen');

Route::get('/api/unread-messages', function () {
    return response()->json([
        'status' => 'success',
        'data' => [
            'unread_messages' => 0
        ]
    ]);
});

Route::get('/unread-messages', function () {
    return response()->json([
        'status' => 'success',
        'data' => [
            'unread_messages' => 0
        ]
    ]);
});

require __DIR__.'/auth.php';
