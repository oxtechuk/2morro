<!-- Start Sidebar -->
<aside
    class="w-sidenav min-w-sidenav bg-white shadow overflow-y-auto hs-overlay fixed inset-y-0 start-0 z-60 hidden -translate-x-full transform transition-all duration-200 hs-overlay-open:translate-x-0 lg:bottom-0 lg:end-auto lg:z-30 lg:block lg:translate-x-0 rtl:translate-x-full rtl:hs-overlay-open:translate-x-0 rtl:lg:translate-x-0 print:hidden [--body-scroll:true] [--overlay-backdrop:true] lg:[--overlay-backdrop:false]"
    id="app-menu">
    <div class="flex flex-col h-full">
        <!-- Sidenav Logo -->
        <div class="sticky top-0 flex h-topbar items-center justify-center px-6">
            <a href="{{ url('/') }}">
                <img alt="logo" class="flex h-6" src="{{ asset('images/logo-dark.png') }}"/>
            </a>
        </div>
        <div class="p-4 h-[calc(100%-theme('spacing.topbar'))] flex-grow" data-simplebar="">
            <!-- Menu -->
            <ul class="admin-menu hs-accordion-group flex w-full flex-col gap-1">
                <li class="px-3 py-2 text-xs uppercase font-medium text-default-500">Menu</li>
                <li class="menu-item hs-accordion">
                    <a class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5 hs-accordion-active:bg-primary/5 hs-accordion-active:text-primary"
                       href="javascript:void(0)">
                        <i class="iconify lucide--layout-grid size-5"></i>
                        <span class="menu-text"> Dashboards </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300">
                        <ul class="mt-1 space-y-1">
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/') }}">
                                    <i class="menu-dot"></i>
                                    Dashboard
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="px-3 py-2 text-xs uppercase font-medium text-default-500">Apps</li>
                <li class="menu-item">
                    <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                       href="{{ url('/apps/calendar') }}">
                        <i class="iconify lucide--calendar size-5"></i>
                        Calendar
                    </a>
                </li>
                <li class="menu-item">
                    <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                       href="{{ url('/apps/gallery') }}">
                        <i class="iconify lucide--image size-5"></i>
                        Images Gallery
                    </a>
                </li>
                <li class="menu-item">
                    <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                       href="{{ url('/apps/plans') }}">
                        <i class="iconify lucide--circle-dollar-sign size-5"></i>
                        Pricing Plans
                    </a>
                </li>
                <li class="menu-item">
                    <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                       href="{{ url('/apps/contacts') }}">
                        <i class="iconify lucide--user-circle size-5"></i>
                        Contacts
                    </a>
                </li>
                <li class="px-3 py-2 text-xs uppercase font-medium text-default-500">Pages</li>
                <li class="menu-item">
                    <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                       href="{{ url('/pages/starter-page') }}">
                        <i class="iconify lucide--clipboard size-5"></i>
                        <span class="menu-text"> Starter Pages </span>
                    </a>
                </li>
                <li class="menu-item hs-accordion">
                    <a class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5 hs-accordion-active:bg-primary/5 hs-accordion-active:text-primary"
                       href="javascript:void(0)">
                        <i class="iconify lucide--log-in size-5"></i>
                        <span class="menu-text"> Auth Pages </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300">
                        <ul class="mt-1 space-y-1">
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/auth/login') }}">
                                    <i class="menu-dot"></i>
                                    Log In
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/auth/register') }}">
                                    <i class="menu-dot"></i>
                                    Register
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/auth/recoverpw') }}">
                                    <i class="menu-dot"></i>
                                    Recover Password
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/auth/lock-screen') }}">
                                    <i class="menu-dot"></i>
                                    Lock Screen
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="menu-item hs-accordion">
                    <a class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5 hs-accordion-active:bg-primary/5 hs-accordion-active:text-primary"
                       href="javascript:void(0)">
                        <i class="iconify lucide--construction size-5"></i>
                        <span class="menu-text"> Error Pages </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300">
                        <ul class="mt-1 space-y-1">
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/pages/404') }}">
                                    <i class="menu-dot"></i>
                                    Error 404
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/pages/500') }}">
                                    <i class="menu-dot"></i>
                                    Error 500
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="px-3 py-2 text-xs uppercase font-medium text-default-500">Elements</li>
                <li class="menu-item hs-accordion">
                    <a class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5 hs-accordion-active:bg-primary/5 hs-accordion-active:text-primary"
                       href="javascript:void(0)">
                        <i class="iconify lucide--layout size-5"></i>
                        <span class="menu-text"> Components </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300">
                        <ul class="mt-1 space-y-1">
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/accordion') }}">
                                    <i class="menu-dot"></i>
                                    Accordion
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/alerts') }}">
                                    <i class="menu-dot"></i>
                                    Alert
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/avatars') }}">
                                    <i class="menu-dot"></i>
                                    Avatars
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/buttons') }}">
                                    <i class="menu-dot"></i>
                                    Buttons
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/badges') }}">
                                    <i class="menu-dot"></i>
                                    Badges
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/breadcrumbs') }}">
                                    <i class="menu-dot"></i>
                                    Breadcrumbs
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/cards') }}">
                                    <i class="menu-dot"></i>
                                    Cards
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/collapse') }}">
                                    <i class="menu-dot"></i>
                                    Collapse
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/dropdowns') }}">
                                    <i class="menu-dot"></i>
                                    Dropdowns
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/progress') }}">
                                    <i class="menu-dot"></i>
                                    Progress
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/spinners') }}">
                                    <i class="menu-dot"></i>
                                    Spinners
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/skeleton') }}">
                                    <i class="menu-dot"></i>
                                    Skeleton
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/ratio') }}">
                                    <i class="menu-dot"></i>
                                    Ratio
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/modals') }}">
                                    <i class="menu-dot"></i>
                                    Modals
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/offcanvas') }}">
                                    <i class="menu-dot"></i>
                                    Offcanvas
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/popovers') }}">
                                    <i class="menu-dot"></i>
                                    Popovers
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/tooltips') }}">
                                    <i class="menu-dot"></i>
                                    Tooltips
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/ui/typography') }}">
                                    <i class="menu-dot"></i>
                                    Typography
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="menu-item hs-accordion">
                    <a class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5 hs-accordion-active:bg-primary/5 hs-accordion-active:text-primary"
                       href="javascript:void(0)">
                        <i class="iconify lucide--check-square size-5"></i>
                        <span class="menu-text"> Forms </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300">
                        <ul class="mt-1 space-y-1">
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/forms/inputs') }}">
                                    <i class="menu-dot"></i>
                                    <span class="menu-text">Inputs</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/forms/check-radio') }}">
                                    <i class="menu-dot"></i>
                                    <span class="menu-text">Checkbox &amp; Radio</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/forms/masks') }}">
                                    <i class="menu-dot"></i>
                                    <span class="menu-text">Input Masks</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/forms/file-upload') }}">
                                    <i class="menu-dot"></i>
                                    <span class="menu-text">File Upload</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/forms/editor') }}">
                                    <i class="menu-dot"></i>
                                    <span class="menu-text">Editor</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/forms/validation') }}">
                                    <i class="menu-dot"></i>
                                    <span class="menu-text">Validation</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="{{ url('/forms/layout') }}">
                                    <i class="menu-dot"></i>
                                    <span class="menu-text">Form Layout</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="menu-item">
                    <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                       href="{{ url('/maps/vector') }}">
                        <i class="iconify lucide--map-pin size-5"></i>
                        <span class="menu-text"> Maps </span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5 hs-accordion-active:bg-primary/5 hs-accordion-active:text-primary"
                       href="{{ url('/tables/basic') }}">
                        <i class="iconify lucide--table size-5"></i>
                        <span class="menu-text"> Tables </span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5 hs-accordion-active:bg-primary/5 hs-accordion-active:text-primary"
                       href="{{ url('/charts/apex') }}">
                        <i class="iconify tabler--chart-donut-2 size-5"></i>
                        <span class="menu-text"> Chart </span>
                    </a>
                </li>
                <li class="menu-item">
                    <a class="group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                       href="{{ url('/pages/icons') }}">
                        <i class="iconify lucide--palette size-5"></i>
                        <span class="menu-text"> Icons </span>
                    </a>
                </li>
                <li class="menu-item hs-accordion">
                    <a class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5 hs-accordion-active:bg-primary/5 hs-accordion-active:text-primary"
                       href="javascript:void(0)">
                        <i class="iconify lucide--list size-5"></i>
                        <span class="menu-text"> Level </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                         id="sidenavLevel">
                        <ul class="mt-1 space-y-1">
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="javascript: void(0)">
                                    <i class="menu-dot"></i>
                                    <span class="menu-text">Item 1</span>
                                </a>
                            </li>
                            <li class="menu-item">
                                <a class="flex items-center gap-x-3.5 rounded-md px-3 py-1.5 text-sm font-medium text-default-600 transition-all hover:bg-primary/5"
                                   href="javascript: void(0)">
                                    <i class="menu-dot"></i>
                                    <span class="menu-text">Item 2</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="menu-item">
                    <a class="hs-accordion-toggle group flex items-center gap-x-3.5 rounded-md px-3 py-2 text-sm font-medium text-default-600 transition-all hover:bg-primary/5 hs-accordion-active:bg-primary/5 hs-accordion-active:text-primary"
                       href="javascript:void(0)">
                        <i class="iconify lucide--star size-5"></i>
                        <span class="menu-text"> Badge Items </span>
                        <span
                            class="ms-auto inline-flex items-center gap-x-1.5 py-0.5 px-2 rounded-full font-bold text-xs bg-red-500 text-white">Hot</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
<!-- End Sidebar -->
