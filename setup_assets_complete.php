<?php

// Directories
$cssDir = __DIR__ . '/public/assets/css';
$jsDir = __DIR__ . '/public/assets/scripts';
$iconsDir = __DIR__ . '/public/assets/icons-admin';
$defaultDir = __DIR__ . '/public/default';

@mkdir($cssDir, 0755, true);
@mkdir($jsDir, 0755, true);
@mkdir($iconsDir, 0755, true);
@mkdir($defaultDir, 0755, true);

function fetchUrl($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $data = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($httpCode >= 200 && $httpCode < 300 && !empty($data)) {
        return $data;
    }
    return false;
}

echo "=== Downloading CSS Assets ===\n";

$cssFiles = [
    'bootstrap.min.css' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
    'font-awesome.min.css' => 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
    'sweetalert2.min.css' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css',
    'select2.min.css' => 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
    'quill.snow.css' => 'https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.snow.css',
    'toastr.min.css' => 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.css',
    'cropper.min.css' => 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css',
    'jquery.timepicker.min.css' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.3.5/jquery.timepicker.min.css',
    'jquery-ui.css' => 'https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css',
    'daterangepicker.css' => 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css',
    'simplePagination.css' => 'https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/simplePagination.min.css',
    'jsTree.css' => 'https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.16/themes/default/style.min.css',
    'venobox.min.css' => 'https://cdnjs.cloudflare.com/ajax/libs/venobox/2.1.8/venobox.min.css',
    'login.css' => '/* login styles */',
    'error.css' => '/* error styles */',
];

foreach ($cssFiles as $filename => $source) {
    $target = "$cssDir/$filename";
    if (str_starts_with($source, 'http')) {
        echo "Fetching $filename... ";
        $content = fetchUrl($source);
        if ($content) {
            file_put_contents($target, $content);
            echo "OK (" . strlen($content) . " bytes)\n";
        } else {
            echo "FAILED (creating fallback)\n";
            file_put_contents($target, "/* fallback $filename */");
        }
    } else {
        file_put_contents($target, $source);
        echo "Created static $filename\n";
    }
}

// style.css and responsive.css from ArchitectUI
$architectMainCss = __DIR__ . '/architectui_temp/architectui-html-free/assets/styles/main.css';
if (file_exists($architectMainCss)) {
    echo "Using extracted ArchitectUI main.css for style.css\n";
    $archCss = file_get_contents($architectMainCss);
    
    // Custom app overrides for admin dashboard
    $customStyles = "
/* Custom Admin Dashboard Overrides */
:root {
    --theme-color: #EE456B;
    --theme-hover-bg: #FEE5E8;
}
.branding-logo { padding: 15px; text-align: center; }
.branding-logo img { max-height: 48px; max-width: 100%; object-fit: contain; }
.vertical-nav-menu { list-style: none; padding: 0 10px; margin: 0; }
.vertical-nav-menu li { margin-bottom: 4px; }
.vertical-nav-menu li a.menu { display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; color: #475569; text-decoration: none; border-radius: 8px; font-weight: 500; font-size: 0.9rem; transition: all 0.2s; }
.vertical-nav-menu li a.menu:hover, .vertical-nav-menu li a.menu.active { background: var(--theme-hover-bg, #FEE5E8); color: var(--theme-color, #EE456B); }
.vertical-nav-menu .menu-icon { width: 20px; height: 20px; margin-inline-end: 10px; vertical-align: middle; }
.vertical-nav-menu .downIcon { width: 14px; height: 14px; transition: transform 0.2s; }
.vertical-nav-menu a[aria-expanded='true'] .downIcon { transform: rotate(180deg); }
.vertical-nav-menu .dropdownMenuCollapse .listBar { padding-inline-start: 32px; display: flex; flex-direction: column; gap: 4px; margin-top: 4px; }
.vertical-nav-menu .subMenu { padding: 6px 12px; color: #64748b; text-decoration: none; font-size: 0.85rem; border-radius: 6px; transition: all 0.15s; }
.vertical-nav-menu .subMenu:hover, .vertical-nav-menu .subMenu.active { color: var(--theme-color, #EE456B); background: #f8fafc; font-weight: 600; }
.menu-divider { padding: 12px 14px 4px; font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; letter-spacing: 0.05em; display: flex; align-items: center; justify-content: space-between; }
.menu-divider .devider_line { flex: 1; height: 1px; background: #e2e8f0; margin-inline-start: 8px; }
.sideBarfooter { position: sticky; bottom: 0; background: #fff; border-top: 1px solid #f1f5f9; padding: 10px 15px; display: flex; align-items: center; justify-content: space-around; }
.sideBarfooter .fullbtn { background: none; border: none; cursor: pointer; padding: 6px; border-radius: 6px; }
.sideBarfooter .fullbtn:hover { background: #f1f5f9; }
.sideBarfooter .fullbtn img { width: 20px; height: 20px; }
.app-header-left, .app-header-right { display: flex; align-items: center; }
.app-header { display: flex; align-items: center; justify-content: space-between; height: 60px; padding: 0 20px; background: #fff; border-bottom: 1px solid #e2e8f0; }
.app-main { display: flex; }
.app-sidebar { width: 260px; flex-shrink: 0; background: #fff; border-inline-end: 1px solid #e2e8f0; min-height: 100vh; }
.app-main-outer { flex: 1; min-width: 0; background: #f8fafc; min-height: calc(100vh - 60px); }
.app-main-inner { padding: 24px; }
.closed-sidebar .app-sidebar { width: 70px; }
.closed-sidebar .vertical-nav-menu .menu span:not(.menu-icon), .closed-sidebar .downIcon, .closed-sidebar .menu-divider, .closed-sidebar .dropdownMenuCollapse { display: none !important; }
.closed-sidebar .branding-logo { display: none; }
.closed-sidebar .branding-logo-forMobile { display: block; padding: 15px; text-align: center; }
.profilePic { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }
";
    file_put_contents("$cssDir/style.css", $archCss . "\n" . $customStyles);
} else {
    echo "ArchitectUI css not found, using CDN fallback for style.css\n";
    file_put_contents("$cssDir/style.css", "/* style.css */");
}

file_put_contents("$cssDir/responsive.css", "
/* Responsive Overrides */
@media (max-width: 991.98px) {
    .app-sidebar { position: fixed; left: -260px; top: 0; bottom: 0; z-index: 1050; transition: left 0.3s ease; }
    [dir='rtl'] .app-sidebar { left: auto; right: -260px; transition: right 0.3s ease; }
    .sidebar-mobile-open .app-sidebar { left: 0 !important; }
    [dir='rtl'] .sidebar-mobile-open .app-sidebar { right: 0 !important; }
    .app-main-outer { padding-top: 60px; }
}
");

echo "\n=== Downloading JavaScript Assets ===\n";

$jsFiles = [
    'jquery-3.6.3.min.js' => 'https://code.jquery.com/jquery-3.6.3.min.js',
    'bootstrap.bundle.min.js' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
    'select2.min.js' => 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
    'sweetalert2.min.js' => 'https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js',
    'quill.js' => 'https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js',
    'jQuery.print.min.js' => 'https://cdnjs.cloudflare.com/ajax/libs/jQuery.print/1.6.2/jQuery.print.min.js',
    'toastr.min.js' => 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.4/toastr.min.js',
    'jquery.timepicker.min.js' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.3.5/jquery.timepicker.min.js',
    'jquery-ui.js' => 'https://code.jquery.com/ui/1.13.2/jquery-ui.min.js',
    'cropper.min.js' => 'https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js',
    'moment.min.js' => 'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js',
    'daterangepicker.min.js' => 'https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js',
    'jstree.min.js' => 'https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.16/jstree.min.js',
    'Sortable.min.js' => 'https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js',
    'venobox.min.js' => 'https://cdnjs.cloudflare.com/ajax/libs/venobox/2.1.8/venobox.min.js',
    'drop-zone.js' => '/* dropzone dummy */',
    'jquery.simplePagination.js' => 'https://cdnjs.cloudflare.com/ajax/libs/simplePagination.js/1.6/jquery.simplePagination.min.js',
];

foreach ($jsFiles as $filename => $source) {
    $target = "$jsDir/$filename";
    if (str_starts_with($source, 'http')) {
        echo "Fetching $filename... ";
        $content = fetchUrl($source);
        if ($content) {
            file_put_contents($target, $content);
            echo "OK (" . strlen($content) . " bytes)\n";
        } else {
            echo "FAILED (creating fallback)\n";
            file_put_contents($target, "/* fallback $filename */");
        }
    } else {
        file_put_contents($target, $source);
        echo "Created static $filename\n";
    }
}

// Fullscreen toggle script
file_put_contents("$jsDir/full-screen.js", "
function toggleFullScreen(elem) {
    elem = elem || document.documentElement;
    if (!document.fullscreenElement && !document.mozFullScreenElement &&
        !document.webkitFullscreenElement && !document.msFullscreenElement) {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
        } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        }
    }
}
");

// main.js - Sidebar toggle & core interactions
file_put_contents("$jsDir/main.js", "
document.addEventListener('DOMContentLoaded', function() {
    // Mobile sidebar toggle
    var mobileToggle = document.querySelector('.mobile-toggle-nav');
    if (mobileToggle) {
        mobileToggle.addEventListener('click', function() {
            var app = document.querySelector('.app-container');
            if (app) app.classList.toggle('sidebar-mobile-open');
        });
    }

    // Desktop sidebar toggle
    var closeSidebarBtns = document.querySelectorAll('.close-sidebar-btn');
    closeSidebarBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var app = document.querySelector('.app-container');
            if (app) {
                var toggleClass = btn.getAttribute('data-class') || 'closed-sidebar';
                app.classList.toggle(toggleClass);
                btn.classList.toggle('is-active');
            }
        });
    });

    // Mobile header nav toggle
    var headerToggle = document.querySelector('.mobile-toggle-header-nav');
    if (headerToggle) {
        headerToggle.addEventListener('click', function() {
            var headerContent = document.querySelector('.app-header-content');
            if (headerContent) headerContent.classList.toggle('header-mobile-open');
        });
    }
});
");

// script.js
file_put_contents("$jsDir/script.js", "
// General app script
$(document).ready(function() {
    // Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle=\"tooltip\"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Logout click handler
    $(document).on('click', '.logout', function(e) {
        e.preventDefault();
        $('#logoutForm').submit();
    });
});
");

// galleryFilemanager.js
file_put_contents("$jsDir/galleryFilemanager.js", "
function openGalleryModal(callback) {
    if ($('#galleryModal').length) {
        $('#galleryModal').modal('show');
    }
}
");

echo "\n=== Setting Up SVG Icons ===\n";

$existingIconsDir = __DIR__ . '/public/assets/icons';

// All icons referenced in views
$allIcons = [
    'ads.svg', 'arrow.svg', 'arrow-export.svg', 'attribute.svg', 'blog.svg', 'box-check.svg',
    'brand.svg', 'business.svg', 'caret-down.svg', 'category.svg', 'chart-trend-up-green.svg',
    'clock.svg', 'color.svg', 'coupon-percent.svg', 'credit-card-convert.svg', 'credit-card-orange.svg',
    'crown.svg', 'customer.svg', 'dashboard-customer.svg', 'dashboard-order.svg', 'dashboard-product.svg',
    'dashboard-shop.svg', 'delivery-cart-arrow-up.svg', 'download.svg', 'download-alt.svg', 'edit.svg',
    'employee.svg', 'expand.svg', 'eye.svg', 'file-settings.svg', 'flash.svg', 'folder-upload.svg',
    'intelligence.svg', 'intelligence_new.svg', 'Language.svg', 'language-2.svg', 'log-out.svg',
    'message.svg', 'moon.svg', 'notes.svg', 'notification.svg', 'orders.svg', 'overview.svg',
    'palette.svg', 'pos.svg', 'pos-sale.svg', 'product.svg', 'promotional.svg', 'query.svg',
    'role-permission.svg', 'rotate.svg', 'rotate-circle.svg', 'scanner.svg', 'search.svg',
    'settings.svg', 'shop.svg', 'shopping-cart-check.svg', 'shopping-cart-times.svg', 'sun.svg',
    'tool.svg', 'trash.svg', 'truck.svg', 'truck-fill.svg', 'user-circle.svg', 'vendor.svg',
    'wallet.svg', 'whatsapp.svg', 'withdraw.svg', 'withdraw-reject.svg'
];

// Mapping for known existing icons in /assets/icons/
$iconMappings = [
    'clock.svg' => 'clock.svg',
    'wallet.svg' => 'card.svg',
    'box-check.svg' => 'box-tick.svg',
    'shopping-cart-check.svg' => 'bag-2.svg',
    'shopping-cart-times.svg' => 'bag.svg',
    'orders.svg' => 'shopping-bag.svg',
    'truck.svg' => 'bike.svg',
    'truck-fill.svg' => 'bike2.svg',
    'user-circle.svg' => 'profile.svg',
    'dashboard-customer.svg' => 'profile.svg',
    'customer.svg' => 'profile.svg',
    'settings.svg' => 'widgets.svg',
    'file-settings.svg' => 'widgets.svg',
    'overview.svg' => 'widgets.svg',
    'Language.svg' => 'language.svg',
    'language-2.svg' => 'language.svg',
    'search.svg' => 'search.svg',
    'message.svg' => 'support.svg',
    'notification.svg' => 'bell-on.svg',
    'credit-card-orange.svg' => 'card.svg',
    'credit-card-convert.svg' => 'card.svg',
    'withdraw.svg' => 'money.svg',
    'withdraw-reject.svg' => 'money-2.svg',
    'log-out.svg' => 'logoutWhite.svg',
    'arrow.svg' => 'chevron-right.svg',
    'caret-down.svg' => 'arrowDown.svg',
    'expand.svg' => 'widgets.svg',
];

// Template for clean, SVG icons
function generateSvg($name) {
    return '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
    <rect width="18" height="18" x="3" y="3" rx="4"/>
    <circle cx="12" cy="12" r="3"/>
</svg>';
}

$copied = 0;
$created = 0;

foreach ($allIcons as $iconName) {
    $targetFile = "$iconsDir/$iconName";

    // 1. Check exact match in public/assets/icons/
    if (file_exists("$existingIconsDir/$iconName")) {
        copy("$existingIconsDir/$iconName", $targetFile);
        $copied++;
        continue;
    }

    // 2. Check mapped name in public/assets/icons/
    if (isset($iconMappings[$iconName]) && file_exists("$existingIconsDir/{$iconMappings[$iconName]}")) {
        copy("$existingIconsDir/{$iconMappings[$iconName]}", $targetFile);
        $copied++;
        continue;
    }

    // 3. Specific SVG shapes
    $svg = '';
    if ($iconName === 'caret-down.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="m6 9 6 6 6-6"/></svg>';
    } elseif ($iconName === 'overview.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>';
    } elseif ($iconName === 'pos.svg' || $iconName === 'pos-sale.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>';
    } elseif ($iconName === 'eye.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>';
    } elseif ($iconName === 'edit.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/></svg>';
    } elseif ($iconName === 'trash.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>';
    } elseif ($iconName === 'rotate.svg' || $iconName === 'rotate-circle.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M21 12a9 9 0 0 0-9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"/><path d="M3 3v5h5"/><path d="M3 12a9 9 0 0 0 9 9 9.75 9.75 0 0 0 6.74-2.74L21 16"/><path d="M16 16h5v5"/></svg>';
    } elseif ($iconName === 'download.svg' || $iconName === 'download-alt.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" x2="12" y1="15" y2="3"/></svg>';
    } elseif ($iconName === 'arrow-export.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M7 17l9.2-9.2M17 17V8H8"/></svg>';
    } elseif ($iconName === 'chart-trend-up-green.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>';
    } elseif ($iconName === 'product.svg' || $iconName === 'dashboard-product.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>';
    } elseif ($iconName === 'dashboard-order.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>';
    } elseif ($iconName === 'shop.svg' || $iconName === 'dashboard-shop.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/></svg>';
    } elseif ($iconName === 'category.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>';
    } elseif ($iconName === 'palette.svg') {
        $svg = '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#475569" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg"><circle cx="13.5" cy="6.5" r=".5" fill="#475569"/><circle cx="17.5" cy="10.5" r=".5" fill="#475569"/><circle cx="8.5" cy="7.5" r=".5" fill="#475569"/><circle cx="6.5" cy="12.5" r=".5" fill="#475569"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>';
    } else {
        $svg = generateSvg($iconName);
    }

    file_put_contents($targetFile, $svg);
    $created++;
}

echo "Icons setup: $copied mapped/copied, $created generated.\n";

// Default placeholder image
if (!file_exists("$defaultDir/default.jpg")) {
    $avatarSvg = '<svg width="128" height="128" viewBox="0 0 128 128" xmlns="http://www.w3.org/2000/svg">
        <rect width="128" height="128" fill="#e2e8f0"/>
        <circle cx="64" cy="50" r="24" fill="#94a3b8"/>
        <path d="M24 112c0-22 18-40 40-40s40 18 40 40z" fill="#94a3b8"/>
    </svg>';
    // If GD is available, make a genuine 128x128 JPEG
    if (extension_loaded('gd')) {
        $img = imagecreatetruecolor(128, 128);
        $bg = imagecolorallocate($img, 226, 232, 240);
        $fg = imagecolorallocate($img, 148, 163, 184);
        imagefilledrectangle($img, 0, 0, 128, 128, $bg);
        imagefilledellipse($img, 64, 48, 44, 44, $fg);
        imagefilledarc($img, 64, 120, 80, 80, 180, 360, $fg, IMG_ARC_PIE);
        imagejpeg($img, "$defaultDir/default.jpg", 90);
        imagedestroy($img);
        echo "Created genuine JPEG $defaultDir/default.jpg with GD\n";
    } else {
        file_put_contents("$defaultDir/default.jpg", $avatarSvg);
        echo "Created SVG fallback for default.jpg\n";
    }
}

echo "\n=== Done setting up all assets! ===\n";
