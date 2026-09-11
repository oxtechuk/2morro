<!DOCTYPE html>
<html lang="ar" dir="rtl" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'لوحة التحكم | تمورو')</title>

    <!-- Favicon (Store Logo) -->
    @php
        $favLogo = \App\Models\Setting::get('store_logo', 'images/logo.png');
        $favVersion = file_exists(public_path($favLogo)) ? filemtime(public_path($favLogo)) : time();
    @endphp
    <link rel="icon" type="image/png" href="{{ asset($favLogo) }}?v={{ $favVersion }}">
    <link rel="shortcut icon" href="{{ asset($favLogo) }}?v={{ $favVersion }}">
    <link rel="apple-touch-icon" href="{{ asset($favLogo) }}?v={{ $favVersion }}">

    <!-- Google Fonts: Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --app-bg: #f4f6f9;
            --card-bg: #ffffff;
            --border-subtle: #e2e8f0;
            --text-main: #0f172a;
            --text-muted: #475569;
            --primary-accent: #1d4ed8;
            --primary-soft: #eff6ff;
            --sidebar-width: 265px;
            --sidebar-collapsed-width: 76px;
            --header-height: 64px;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--app-bg);
            color: var(--text-main);
            overflow-x: hidden;
            font-size: 0.95rem;
            line-height: 1.6;
            letter-spacing: -0.01em;
            transition: background-color 0.25s ease, color 0.25s ease;
        }

        /* ------------------ Sidebar Styling (Calm & Accessible) ------------------ */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            top: 0;
            right: 0;
            background-color: var(--card-bg);
            border-left: 1px solid var(--border-subtle);
            z-index: 1040;
            transition: width 0.25s cubic-bezier(0.4, 0, 0.2, 1), right 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.02);
        }

        .sidebar::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 4px;
        }

        .sidebar-brand {
            height: var(--header-height);
            padding: 0 20px;
            border-bottom: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 12px;
            text-decoration: none;
            color: var(--primary-accent);
            transition: all 0.25s ease;
        }

        .sidebar-brand-logo {
            max-height: 42px;
            width: auto;
            object-fit: contain;
            transition: all 0.25s ease;
        }

        .sidebar-brand-icon {
            display: none;
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #1d4ed8, #2563eb);
            color: #ffffff;
            border-radius: 10px;
            font-weight: 800;
            font-size: 1.25rem;
            align-items: center;
            justify-content: center;
        }

        .sidebar-menu {
            padding: 16px 14px;
            list-style: none;
            margin: 0;
            flex-grow: 1;
        }

        .menu-title {
            font-size: 0.78rem;
            text-transform: uppercase;
            font-weight: 800;
            color: #64748b;
            padding: 16px 12px 6px;
            letter-spacing: 0.5px;
            white-space: nowrap;
            transition: opacity 0.2s ease;
        }

        .menu-item {
            margin-bottom: 4px;
            position: relative;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            color: #334155;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s ease;
            white-space: nowrap;
            width: 100%;
            background: transparent;
            border: none;
            text-align: right;
            cursor: pointer;
        }

        .menu-link:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .menu-link.active {
            background-color: #eff6ff;
            color: #1d4ed8;
            font-weight: 700;
            box-shadow: inset 3px 0 0 #1d4ed8;
        }

        .menu-link i.menu-icon {
            font-size: 1.2rem;
            width: 26px;
            text-align: center;
            flex-shrink: 0;
            color: #64748b;
            transition: all 0.2s ease;
        }

        .menu-link:hover i.menu-icon {
            color: #1d4ed8;
            transform: scale(1.08);
        }

        .menu-link.active i.menu-icon {
            color: #1d4ed8;
        }

        .menu-arrow {
            font-size: 0.75rem;
            transition: transform 0.25s ease;
            color: #94a3b8;
            margin-right: auto;
            margin-left: 0;
        }

        .menu-link:not(.collapsed) .menu-arrow {
            transform: rotate(180deg);
            color: #1d4ed8;
        }

        /* Submenu Accordion Items */
        .submenu {
            list-style: none;
            padding: 4px 18px 4px 0;
            margin: 4px 0 6px 0;
            position: relative;
        }

        .submenu::before {
            content: '';
            position: absolute;
            right: 26px;
            top: 6px;
            bottom: 6px;
            width: 2px;
            background-color: #e2e8f0;
            border-radius: 2px;
        }

        .submenu-item {
            margin-bottom: 2px;
        }

        .submenu-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 14px 7px 12px;
            color: #475569;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.88rem;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .submenu-link:hover {
            color: #0f172a;
            background-color: #f1f5f9;
        }

        .submenu-link.active {
            color: #1d4ed8;
            background-color: #eff6ff;
            font-weight: 700;
        }

        .submenu-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background-color: #cbd5e1;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }

        .submenu-link:hover .submenu-dot {
            background-color: #1d4ed8;
            transform: scale(1.3);
        }

        .submenu-link.active .submenu-dot {
            background-color: #1d4ed8;
            box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.2);
        }

        .sidebar-footer {
            padding: 10px 14px;
            background-color: var(--card-bg);
            border-top: 1px solid var(--border-subtle);
        }

        .sidebar-collapse-btn {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #475569;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            transition: all 0.2s ease;
        }

        .sidebar-collapse-btn:hover {
            background: #eff6ff;
            color: #1d4ed8;
            border-color: #bfdbfe;
        }

        /* ------------------ Collapsed Sidebar State ------------------ */
        body.sidebar-collapsed .sidebar {
            width: var(--sidebar-collapsed-width);
        }

        body.sidebar-collapsed .sidebar-brand {
            padding: 0;
            justify-content: center;
        }

        body.sidebar-collapsed .sidebar-brand-logo {
            display: none;
        }

        body.sidebar-collapsed .sidebar-brand-icon {
            display: flex;
        }

        body.sidebar-collapsed .menu-title {
            height: 1px;
            padding: 0;
            margin: 12px 8px;
            background-color: var(--border-subtle);
            font-size: 0;
            overflow: hidden;
            border: none;
        }

        body.sidebar-collapsed .menu-link {
            padding: 10px 0;
            justify-content: center;
            position: relative;
        }

        body.sidebar-collapsed .menu-link .menu-text,
        body.sidebar-collapsed .menu-arrow,
        body.sidebar-collapsed .submenu {
            display: none !important;
        }

        body.sidebar-collapsed .sidebar-collapse-btn span {
            display: none;
        }

        body.sidebar-collapsed .menu-link .badge {
            position: absolute;
            top: 4px;
            left: 10px;
            padding: 0.2rem 0.4rem;
            font-size: 0.65rem;
        }

        body.sidebar-collapsed .main-wrapper {
            margin-right: var(--sidebar-collapsed-width);
        }

        /* Tooltip hint on hover in collapsed mode */
        body.sidebar-collapsed .menu-item:hover::after {
            content: attr(data-tooltip);
            position: absolute;
            right: calc(100% + 8px);
            top: 50%;
            transform: translateY(-50%);
            background: #0f172a;
            color: #ffffff;
            padding: 6px 14px;
            font-size: 0.85rem;
            font-weight: 600;
            border-radius: 8px;
            white-space: nowrap;
            z-index: 1060;
            box-shadow: 0 4px 14px rgba(0,0,0,0.18);
            pointer-events: none;
        }

        /* ------------------ Main Wrapper & Top Header ------------------ */
        .main-wrapper {
            margin-right: var(--sidebar-width);
            min-height: 100vh;
            transition: margin-right 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
        }

        .top-header {
            height: var(--header-height);
            background-color: var(--card-bg);
            border-bottom: 1px solid var(--border-subtle);
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 1020;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.02);
        }

        .header-btn {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            background-color: #f1f5f9;
            border: 1px solid transparent;
            transition: all 0.2s ease;
        }

        .header-btn:hover {
            color: var(--primary-accent);
            background-color: var(--primary-soft);
            border-color: rgba(37, 99, 235, 0.15);
        }

        .header-search {
            width: 280px;
            position: relative;
        }

        .header-search input {
            padding-right: 36px;
            background-color: #f1f5f9;
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            font-size: 0.85rem;
            color: var(--text-main);
            transition: all 0.2s ease;
        }

        .header-search input:focus {
            background-color: #ffffff;
            border-color: var(--primary-accent);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .header-search i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        /* ------------------ Calm Component Elements ------------------ */
        .card {
            border: 1px solid var(--border-subtle);
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0,0,0,0.03), 0 1px 2px 0 rgba(0,0,0,0.02);
            background-color: var(--card-bg);
            margin-bottom: 20px;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid var(--border-subtle);
            padding: 14px 20px;
            font-weight: 700;
            color: var(--text-main);
        }

        .card-body {
            padding: 20px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            border: none;
            border-radius: 8px;
            padding: 8px 18px;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.2);
            transition: all 0.2s ease;
        }

        .btn-primary:hover, .btn-primary:focus {
            background: linear-gradient(135deg, #1d4ed8, #1e40af);
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
            transform: translateY(-1px);
        }

        .btn-outline-secondary {
            border-color: var(--border-subtle);
            color: var(--text-muted);
            border-radius: 8px;
            font-weight: 600;
            background-color: var(--card-bg);
        }

        .btn-outline-secondary:hover {
            background-color: #f1f5f9;
            color: var(--text-main);
            border-color: #cbd5e1;
        }

        .table {
            color: var(--text-main);
            vertical-align: middle;
        }

        .table-light {
            background-color: #f8fafc;
            color: #475569;
            font-weight: 700;
            border-bottom: 2px solid var(--border-subtle);
        }

        .badge {
            font-weight: 600;
            letter-spacing: 0.2px;
        }

        .w-11 {
            width: 44px !important;
        }
        .h-11 {
            height: 44px !important;
        }
        .shadow-xs {
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04) !important;
        }
        .fs-8 {
            font-size: 0.75rem !important;
        }

        /* ------------------ Dark Mode Support ------------------ */
        [data-bs-theme="dark"] {
            --app-bg: #0f172a;
            --card-bg: #1e293b;
            --border-subtle: #334155;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --primary-accent: #3b82f6;
            --primary-soft: rgba(59, 130, 246, 0.15);
        }

        [data-bs-theme="dark"] .sidebar {
            background-color: var(--card-bg);
            border-left-color: var(--border-subtle);
        }

        [data-bs-theme="dark"] .top-header {
            background-color: var(--card-bg);
            border-bottom-color: var(--border-subtle);
        }

        [data-bs-theme="dark"] .menu-link {
            color: #94a3b8;
        }

        [data-bs-theme="dark"] .menu-link:hover {
            background-color: #334155;
            color: #f8fafc;
        }

        [data-bs-theme="dark"] .menu-link.active {
            background-color: rgba(59, 130, 246, 0.18);
            color: #60a5fa;
        }

        [data-bs-theme="dark"] .header-btn {
            background-color: #334155;
            color: #94a3b8;
        }

        [data-bs-theme="dark"] .header-btn:hover {
            color: #60a5fa;
            background-color: rgba(59, 130, 246, 0.2);
        }

        [data-bs-theme="dark"] .header-search input {
            background-color: #0f172a;
            border-color: var(--border-subtle);
            color: #f8fafc;
        }

        [data-bs-theme="dark"] .table-light {
            background-color: #1e293b;
            color: #cbd5e1;
            border-bottom-color: #334155;
        }

        /* ------------------ Mobile Drawer & Backdrop ------------------ */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(2px);
            z-index: 1030;
        }

        @media (max-width: 991.98px) {
            .sidebar {
                right: calc(var(--sidebar-width) * -1);
                box-shadow: -4px 0 24px rgba(0,0,0,0.15);
            }
            .sidebar.mobile-open {
                right: 0;
            }
            .sidebar-backdrop.active {
                display: block;
            }
            .main-wrapper {
                margin-right: 0 !important;
            }
            .top-header {
                padding: 0 16px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Mobile Backdrop -->
    <div class="sidebar-backdrop" id="sidebar-backdrop"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            @php
                $adminLogo = \App\Models\Setting::get('store_logo', 'images/logo.png');
                $adminLogoVersion = file_exists(public_path($adminLogo)) ? filemtime(public_path($adminLogo)) : time();
            @endphp
            <img src="{{ asset($adminLogo) }}?v={{ $adminLogoVersion }}" alt="2morro Admin" class="sidebar-brand-logo">
            <div class="sidebar-brand-icon">2M</div>
        </a>
        <ul class="sidebar-menu">
            <li class="menu-title">لوحة التحكم</li>
            <li class="menu-item" data-tooltip="الرئيسية">
                <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill menu-icon"></i>
                    <span class="menu-text">الرئيسية</span>
                </a>
            </li>
            
            <li class="menu-title">العمليات والخدمات</li>
            
            <!-- Collapsible Group 1: العملاء والاستشارات -->
            @php
                $isCustomerGroupActive = request()->routeIs('admin.bookings.*') || request()->routeIs('admin.crm.*');
            @endphp
            <li class="menu-item" data-tooltip="العملاء والاستشارات">
                <button type="button" class="menu-link {{ $isCustomerGroupActive ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#menu-customers" aria-expanded="{{ $isCustomerGroupActive ? 'true' : 'false' }}">
                    <i class="bi bi-people-fill menu-icon"></i>
                    <span class="menu-text">العملاء والاستشارات</span>
                    <i class="bi bi-chevron-down menu-arrow"></i>
                </button>
                <div class="collapse {{ $isCustomerGroupActive ? 'show' : '' }}" id="menu-customers">
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a href="{{ route('admin.bookings.index') }}" class="submenu-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                                <span class="submenu-dot"></span>
                                <span>إدارة الحجوزات</span>
                                @php
                                    $pendingBookingsCount = \App\Models\Booking::whereIn('status', ['new', 'pending'])->count();
                                @endphp
                                @if($pendingBookingsCount > 0)
                                    <span class="badge ms-auto fw-black fs-8 px-2 py-0.5 rounded-pill" style="background-color: #fef08a; color: #854d0e;">{{ $pendingBookingsCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="submenu-item">
                            <a href="{{ route('admin.crm.index') }}" class="submenu-link {{ request()->routeIs('admin.crm.*') ? 'active' : '' }}">
                                <span class="submenu-dot"></span>
                                <span>سجل العملاء (CRM)</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Collapsible Group 2: المتجر والمنتجات -->
            @php
                $isStoreGroupActive = request()->routeIs('admin.products.*') || request()->routeIs('admin.taxonomy.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.brands.*') || request()->routeIs('admin.banners.*');
            @endphp
            <li class="menu-item" data-tooltip="المتجر والمنتجات">
                <button type="button" class="menu-link {{ $isStoreGroupActive ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#menu-store" aria-expanded="{{ $isStoreGroupActive ? 'true' : 'false' }}">
                    <i class="bi bi-box-seam-fill menu-icon"></i>
                    <span class="menu-text">المتجر والمنتجات</span>
                    <i class="bi bi-chevron-down menu-arrow"></i>
                </button>
                <div class="collapse {{ $isStoreGroupActive ? 'show' : '' }}" id="menu-store">
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a href="{{ route('admin.products.index') }}" class="submenu-link {{ (request()->routeIs('admin.products.index') || request()->routeIs('admin.products.create') || request()->routeIs('admin.products.edit') || request()->routeIs('admin.products.show')) && !request()->routeIs('admin.products.importExport') ? 'active' : '' }}">
                                <span class="submenu-dot"></span>
                                <span>إدارة المنتجات</span>
                            </a>
                        </li>
                        <li class="submenu-item">
                            <a href="{{ route('admin.products.importExport') }}" class="submenu-link {{ request()->routeIs('admin.products.importExport') ? 'active' : '' }}">
                                <span class="submenu-dot"></span>
                                <span>استيراد وتصدير إكسيل</span>
                            </a>
                        </li>
                        <li class="submenu-item">
                            <a href="{{ route('admin.taxonomy.index') }}" class="submenu-link {{ request()->routeIs('admin.taxonomy.*') || request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                                <span class="submenu-dot"></span>
                                <span>التصنيفات والفلاتر</span>
                            </a>
                        </li>
                        <li class="submenu-item">
                            <a href="{{ route('admin.brands.index') }}" class="submenu-link {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                                <span class="submenu-dot"></span>
                                <span>البراندات والشركاء</span>
                            </a>
                        </li>
                        <li class="submenu-item">
                            <a href="{{ route('admin.banners.index') }}" class="submenu-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
                                <span class="submenu-dot"></span>
                                <span>بانرات السليدر</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Collapsible Group 3: الطلبات والمبيعات -->
            @php
                $isOrdersGroupActive = request()->routeIs('admin.orders.*') || request()->routeIs('admin.reviews.*');
            @endphp
            <li class="menu-item" data-tooltip="الطلبات والمبيعات">
                <button type="button" class="menu-link {{ $isOrdersGroupActive ? '' : 'collapsed' }}" data-bs-toggle="collapse" data-bs-target="#menu-orders" aria-expanded="{{ $isOrdersGroupActive ? 'true' : 'false' }}">
                    <i class="bi bi-cart-fill menu-icon"></i>
                    <span class="menu-text">الطلبات والمبيعات</span>
                    <i class="bi bi-chevron-down menu-arrow"></i>
                </button>
                <div class="collapse {{ $isOrdersGroupActive ? 'show' : '' }}" id="menu-orders">
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a href="{{ route('admin.orders.index') }}" class="submenu-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                                <span class="submenu-dot"></span>
                                <span>إدارة الطلبات</span>
                                @php
                                    $pendingOrdersBadge = \App\Models\Order::whereIn('status', ['pending', 'processing'])->count();
                                @endphp
                                @if($pendingOrdersBadge > 0)
                                    <span class="badge bg-danger text-white ms-auto fw-black fs-8 px-2 py-0.5 rounded-pill">{{ $pendingOrdersBadge }}</span>
                                @endif
                            </a>
                        </li>
                        <li class="submenu-item">
                            <a href="{{ route('admin.reviews.index') }}" class="submenu-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                                <span class="submenu-dot"></span>
                                <span>تقييمات ومراجعات</span>
                                @php
                                    $unapprovedReviews = \App\Models\Review::where('is_approved', false)->count();
                                @endphp
                                @if($unapprovedReviews > 0)
                                    <span class="badge bg-danger text-white ms-auto fw-black fs-8 px-2 py-0.5 rounded-pill">{{ $unapprovedReviews }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="menu-title">المتجر والنظام</li>
            <li class="menu-item" data-tooltip="عرض المتجر">
                <a href="{{ route('home') }}" target="_blank" class="menu-link">
                    <i class="bi bi-shop menu-icon"></i>
                    <span class="menu-text">عرض المتجر المباشر</span>
                    <i class="bi bi-arrow-up-left ms-auto fs-8 text-muted"></i>
                </a>
            </li>

            <li class="menu-item" data-tooltip="إعدادات المتجر">
                <a href="{{ route('admin.settings.index') }}" class="menu-link {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                    <i class="bi bi-sliders menu-icon"></i>
                    <span class="menu-text">إعدادات النظام</span>
                </a>
            </li>
        </ul>

        <!-- Sidebar Footer Toggle -->
        <div class="sidebar-footer">
            <button type="button" class="sidebar-collapse-btn" id="sidebar-footer-collapse-btn" title="طي / توسيع القائمة">
                <i class="bi bi-arrow-bar-right fs-5" id="footer-toggle-icon"></i>
                <span>طي القائمة الجانبية</span>
            </button>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper" id="main-wrapper">
        
        <!-- Top Header -->
        <header class="top-header">
            <div class="d-flex align-items-center gap-2">
                <!-- Collapse / Expand Button (Desktop + Mobile) -->
                <button type="button" class="header-btn" id="sidebar-toggle-btn" title="طي / توسيع القائمة الجانبية">
                    <i class="bi bi-layout-sidebar-reverse fs-5" id="toggle-icon"></i>
                </button>

                <div class="header-search d-none d-md-block ms-2">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control form-control-sm" placeholder="البحث السريع (Ctrl + K)...">
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <!-- Light/Dark Mode Toggle -->
                <button type="button" class="header-btn" id="theme-toggle" title="تبديل الوضع الليلي">
                    <i class="bi bi-sun-fill" id="theme-icon"></i>
                </button>
                
                <!-- Notifications -->
                <div class="dropdown">
                    <button type="button" class="header-btn position-relative" data-bs-toggle="dropdown" title="التنبيهات">
                        <i class="bi bi-bell-fill"></i>
                        <span class="position-absolute top-1 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" style="width: 8px; height: 8px;"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2" style="width: 280px;">
                        <li class="dropdown-header fw-bold">تنبيهات النظام</li>
                        <li><a class="dropdown-item py-2 text-muted small" href="#"><i class="bi bi-info-circle text-primary me-2"></i> لا توجد تنبيهات جديدة حالياً</a></li>
                    </ul>
                </div>
                
                <!-- Divider -->
                <div class="vr bg-secondary opacity-25 mx-1" style="height: 24px;"></div>
                
                <!-- Admin Profile -->
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle px-2 py-1 rounded-3" data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center shadow-xs" style="width: 34px; height: 34px; font-weight: 700; font-size: 0.9rem;">
                            {{ mb_substr(Auth::user()->name ?? 'م', 0, 1) }}
                        </div>
                        <div class="d-none d-sm-block text-start">
                            <div class="fw-bold text-dark" style="font-size: 0.85rem; line-height: 1.2;">{{ Auth::user()->name ?? 'المدير العام' }}</div>
                            <div class="text-muted small" style="font-size: 0.7rem;">مسؤول النظام</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2 d-flex align-items-center gap-2">
                                    <i class="bi bi-box-arrow-right"></i> تسجيل الخروج
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-4 flex-grow-1">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-xs mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                        <span class="fw-bold">{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // 1. Collapsible Sidebar Logic
        const sidebar = document.getElementById('sidebar');
        const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
        const sidebarFooterCollapseBtn = document.getElementById('sidebar-footer-collapse-btn');
        const backdrop = document.getElementById('sidebar-backdrop');
        const toggleIcon = document.getElementById('toggle-icon');
        const footerToggleIcon = document.getElementById('footer-toggle-icon');

        function toggleSidebarState() {
            if (window.innerWidth < 992) {
                // Mobile Drawer toggle
                sidebar.classList.toggle('mobile-open');
                backdrop.classList.toggle('active');
            } else {
                // Desktop Collapse toggle
                document.body.classList.toggle('sidebar-collapsed');
                const currentlyCollapsed = document.body.classList.contains('sidebar-collapsed');
                localStorage.setItem('admin_sidebar_collapsed', currentlyCollapsed);
                updateSidebarCollapseUI(currentlyCollapsed);
            }
        }

        function updateSidebarCollapseUI(collapsed) {
            if (footerToggleIcon) {
                footerToggleIcon.className = collapsed ? 'bi bi-arrow-bar-left fs-5' : 'bi bi-arrow-bar-right fs-5';
            }
        }

        // Check stored collapse state on desktop
        const isCollapsed = localStorage.getItem('admin_sidebar_collapsed') === 'true';
        if (isCollapsed && window.innerWidth >= 992) {
            document.body.classList.add('sidebar-collapsed');
            updateSidebarCollapseUI(true);
        }

        if (sidebarToggleBtn) {
            sidebarToggleBtn.addEventListener('click', toggleSidebarState);
        }

        if (sidebarFooterCollapseBtn) {
            sidebarFooterCollapseBtn.addEventListener('click', toggleSidebarState);
        }

        if (backdrop) {
            backdrop.addEventListener('click', () => {
                sidebar.classList.remove('mobile-open');
                backdrop.classList.remove('active');
            });
        }

        // If in collapsed sidebar mode and user clicks a menu toggle, auto-expand sidebar
        document.querySelectorAll('.sidebar-menu button[data-bs-toggle="collapse"]').forEach(btn => {
            btn.addEventListener('click', () => {
                if (document.body.classList.contains('sidebar-collapsed')) {
                    document.body.classList.remove('sidebar-collapsed');
                    localStorage.setItem('admin_sidebar_collapsed', 'false');
                    updateSidebarCollapseUI(false);
                }
            });
        });

        // 2. Light / Dark Theme Toggle
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', savedTheme);
        updateThemeIcon(savedTheme);

        themeToggle.addEventListener('click', () => {
            const currentTheme = html.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            html.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });

        function updateThemeIcon(theme) {
            if (theme === 'dark') {
                themeIcon.className = 'bi bi-moon-stars-fill text-warning';
            } else {
                themeIcon.className = 'bi bi-sun-fill text-secondary';
            }
        }
    </script>
    @yield('scripts')
</body>
</html>

