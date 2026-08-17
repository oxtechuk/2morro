<!DOCTYPE html>
<html lang="ar" dir="rtl" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', 'لوحة التحكم | تمورو')</title>

    <!-- Google Fonts: Cairo -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 RTL CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f4f7fa;
            color: #2F3E4E;
            overflow-x: hidden;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            right: 0;
            background-color: #ffffff;
            border-left: 1px solid #e3e8ef;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        .sidebar-brand {
            padding: 20px 24px;
            font-size: 1.25rem;
            font-weight: 700;
            color: #102a63;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .sidebar-menu {
            padding: 20px 14px;
            list-style: none;
            margin: 0;
        }

        .menu-title {
            font-size: 0.75rem;
            text-transform: uppercase;
            font-weight: 700;
            color: #94a3b8;
            padding: 10px 10px 5px;
            letter-spacing: 0.5px;
        }

        .menu-item {
            margin-bottom: 4px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            color: #475569;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.95rem;
            transition: all 0.2s ease;
        }

        .menu-link:hover {
            background-color: #f1f5f9;
            color: #102a63;
        }

        .menu-link.active {
            background-color: #eef2ff;
            color: #4f46e5;
            font-weight: 600;
        }

        .menu-link i {
            font-size: 1.2rem;
        }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-right: 260px;
            min-height: 100vh;
            transition: all 0.3s ease;
        }

        /* Top Header Styling */
        .top-header {
            height: 70px;
            background-color: #ffffff;
            border-bottom: 1px solid #e3e8ef;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        .header-search {
            width: 300px;
            position: relative;
        }

        .header-search input {
            padding-right: 35px;
            background-color: #f8fafc;
            border-color: #e2e8f0;
            border-radius: 20px;
            font-size: 0.85rem;
        }

        .header-search i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
        }

        /* Premium Dashboard Cards */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px 0 rgba(0,0,0,0.05), 0 1px 2px 0 rgba(0,0,0,0.03);
            background-color: #ffffff;
            margin-bottom: 24px;
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #f1f5f9;
            padding: 16px 24px;
            font-weight: 600;
            color: #1e293b;
        }

        .card-body {
            padding: 24px;
        }

        /* Stat Card Variants */
        .stat-card {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            transition: transform 0.2s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
        }

        .stat-card::after {
            content: '';
            position: absolute;
            width: 120px;
            height: 120px;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 100%);
            border-radius: 50%;
            top: -40px;
            left: -40px;
        }

        /* Dark Mode support */
        [data-bs-theme="dark"] {
            body {
                background-color: #111827;
                color: #e5e7eb;
            }
            .sidebar {
                background-color: #1f2937;
                border-left-color: #374151;
            }
            .sidebar-brand {
                color: #ffffff;
                border-bottom-color: #374151;
            }
            .menu-link {
                color: #9ca3af;
            }
            .menu-link:hover {
                background-color: #374151;
                color: #ffffff;
            }
            .menu-link.active {
                background-color: #312e81;
                color: #a5b4fc;
            }
            .top-header {
                background-color: #1f2937;
                border-bottom-color: #374151;
            }
            .header-search input {
                background-color: #111827;
                border-color: #4b5563;
                color: #ffffff;
            }
            .card {
                background-color: #1f2937;
            }
            .card-header {
                border-bottom-color: #374151;
                color: #ffffff;
            }
            .table {
                color: #e5e7eb;
            }
            .table-striped tbody tr:nth-of-type(odd) {
                background-color: rgba(255,255,255,0.03);
            }
            .border-bottom {
                border-bottom-color: #374151 !important;
            }
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .sidebar {
                right: -260px;
            }
            .sidebar.active {
                right: 0;
            }
            .main-wrapper {
                margin-right: 0;
            }
            .top-header {
                padding: 0 15px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <span class="fs-4 text-primary"><i class="bi bi-compass-fill"></i></span>
            <span>تمورو الأدمن</span>
        </a>
        <ul class="sidebar-menu">
            <li class="menu-title">لوحة التحكم</li>
            <li class="menu-item">
                <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-fill"></i>
                    <span>الرئيسية</span>
                </a>
            </li>
            
            <li class="menu-title">إدارة العملاء</li>
            <li class="menu-item">
                <a href="{{ route('admin.crm.index') }}" class="menu-link {{ request()->routeIs('admin.crm.*') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>
                    <span>إدارة العملاء (CRM)</span>
                </a>
            </li>

            <li class="menu-title">إدارة المتجر</li>
            <li class="menu-item">
                <a href="{{ route('admin.products.index') }}" class="menu-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>إدارة المنتجات</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.categories.index') }}" class="menu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="bi bi-tags-fill"></i>
                    <span>تصنيفات المتجر</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.orders.index') }}" class="menu-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="bi bi-cart-fill"></i>
                    <span>إدارة الطلبات</span>
                </a>
            </li>
            <li class="menu-item">
                <a href="{{ route('admin.reviews.index') }}" class="menu-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                    <i class="bi bi-star-half"></i>
                    <span>تقييمات العملاء</span>
                </a>
            </li>

            <li class="menu-title">المتجر العام</li>
            <li class="menu-item">
                <a href="{{ route('home') }}" target="_blank" class="menu-link">
                    <i class="bi bi-shop"></i>
                    <span>عرض المتجر</span>
                </a>
            </li>

            <li class="menu-title">تكوين النظام</li>
            <li class="menu-item">
                <a href="{{ route('admin.settings.index') }}" class="menu-link {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                    <i class="bi bi-sliders"></i>
                    <span>إعدادات المتجر</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper" id="main-wrapper">
        
        <!-- Header -->
        <header class="top-header">
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light d-lg-none" id="sidebar-toggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="header-search d-none d-md-block">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control form-control-sm" placeholder="البحث السريع (Ctrl + K)...">
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <!-- Light/Dark Mode Toggle -->
                <button class="btn btn-link text-secondary p-1 fs-5" id="theme-toggle" title="تبديل الوضع الليلي">
                    <i class="bi bi-sun-fill" id="theme-icon"></i>
                </button>
                
                <!-- Notifications -->
                <div class="dropdown">
                    <button class="btn btn-link text-secondary p-1 fs-5 position-relative" data-bs-toggle="dropdown">
                        <i class="bi bi-bell-fill"></i>
                        <span class="position-absolute top-2 start-100 translate-middle p-1 bg-danger border border-light rounded-circle"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" style="width: 280px;">
                        <li class="dropdown-header">تنبيهات النظام</li>
                        <li><a class="dropdown-item py-2" href="#"><i class="bi bi-info-circle text-primary me-2"></i> لا توجد تنبيهات جديدة حالياً</a></li>
                    </ul>
                </div>
                
                <!-- Divider -->
                <div class="vr bg-gray-300 my-2" style="height: 24px;"></div>
                
                <!-- Admin Profile -->
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle text-dark" data-bs-toggle="dropdown">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-weight: 700;">
                            {{ mb_substr(Auth::user()->name ?? 'م', 0, 1) }}
                        </div>
                        <div class="d-none d-sm-block">
                            <div class="fw-semibold" style="font-size: 0.85rem;">{{ Auth::user()->name ?? 'المدير العام' }}</div>
                            <div class="text-muted" style="font-size: 0.7rem;">مسؤول النظام</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2">
                                    <i class="bi bi-box-arrow-right me-2"></i> تسجيل الخروج
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-check-circle-fill"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button type="submit" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('active');
            });
        }

        // Theme Toggle (Light / Dark Mode)
        const themeToggle = document.getElementById('theme-toggle');
        const themeIcon = document.getElementById('theme-icon');
        const html = document.documentElement;

        // Load saved theme
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
                themeIcon.className = 'bi bi-moon-stars-fill';
            } else {
                themeIcon.className = 'bi bi-sun-fill';
            }
        }
    </script>
    @yield('scripts')
</body>
</html>
