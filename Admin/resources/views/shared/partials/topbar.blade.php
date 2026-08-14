<!-- Topbar Start -->
<header class="app-header sticky top-0 z-50 p-4 pb-0 bg-white/5 backdrop-blur-sm">
    <div class="min-h-topbar flex items-center bg-white rounded-md shadow">
        <div class="px-6 w-full flex items-center justify-between gap-4">
            <div class="flex items-center gap-5">
                <!-- Sidenav Menu Toggle Button -->
                <button aria-label="Toggle navigation"
                        class="relative inline-flex items-center justify-center size-10 rounded bg-white border border-gray-200 hover:bg-gray-100 transition-all"
                        data-hs-overlay="#app-menu">
                    <i class="iconify lucide--align-left text-2xl"></i>
                </button>
                <!-- Topbar Brand Logo -->
                <a class="md:hidden flex" href="{{ url('/') }}">
                    <img alt="Small logo" class="h-5" src="{{ asset('images/logo-sm.png') }}"/>
                </a>
                <!-- Topbar Search -->
                <div class="md:flex hidden items-center relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <i class="iconify tabler--search text-base"></i>
                    </div>
                    <input
                        class="form-input px-10 rounded-lg bg-default-500/10 border-transparent focus:border-transparent w-80"
                        placeholder="Search..." type="search"/>
                    <button class="absolute inset-y-0 end-0 flex items-center pe-3" type="button">
                        <i class="iconify tabler--microphone text-base hover:text-black"></i>
                    </button>
                </div>
            </div>
            <div class="flex items-center gap-5">
                <!-- Language Dropdown Button -->
                <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
                    <button
                        class="hs-dropdown-toggle relative inline-flex items-center justify-center size-10 rounded bg-white border border-gray-200 hover:bg-gray-100 transition-all"
                        type="button">
                        <i class="iconify lucide--globe text-2xl"></i>
                    </button>
                    <div
                        class="hs-dropdown-menu duration mt-2 min-w-48 rounded-lg border border-default-200 bg-white p-2 opacity-0 shadow-md transition-[opacity,margin] hs-dropdown-open:opacity-100 hidden">
                        <a class="flex items-center gap-2.5 py-2 px-3 rounded-md text-sm text-default-800 hover:bg-default-100"
                           href="javascript:void(0);">
                            <img alt="user-image" class="h-4" src="{{ asset('images/flags/germany.jpg') }}"/>
                            <span class="align-middle">German</span>
                        </a>
                        <!-- item-->
                        <a class="flex items-center gap-2.5 py-2 px-3 rounded-md text-sm text-default-800 hover:bg-default-100"
                           href="javascript:void(0);">
                            <img alt="user-image" class="h-4" src="{{ asset('images/flags/italy.jpg') }}"/>
                            <span class="align-middle">Italian</span>
                        </a>
                        <!-- item-->
                        <a class="flex items-center gap-2.5 py-2 px-3 rounded-md text-sm text-default-800 hover:bg-default-100"
                           href="javascript:void(0);">
                            <img alt="user-image" class="h-4" src="{{ asset('images/flags/spain.jpg') }}"/>
                            <span class="align-middle">Spanish</span>
                        </a>
                        <!-- item-->
                        <a class="flex items-center gap-2.5 py-2 px-3 rounded-md text-sm text-default-800 hover:bg-default-100"
                           href="javascript:void(0);">
                            <img alt="user-image" class="h-4" src="{{ asset('images/flags/russia.jpg') }}"/>
                            <span class="align-middle">Russian</span>
                        </a>
                    </div>
                </div>
                <!-- Notification Dropdown -->
                <div class="hs-dropdown relative">
                    <!-- Button -->
                    <button
                        class="hs-dropdown-toggle relative inline-flex items-center justify-center size-10 rounded bg-white border border-gray-200 hover:bg-gray-100 transition-all">
                        <i class="iconify lucide--bell text-xl text-gray-600"></i>
                        <!-- Badge -->
                        <span
                            class="absolute -top-1 -inset-e-1 size-4 bg-red-500 text-white font-semibold text-[10px] flex items-center justify-center rounded-full">
                            4
                        </span>
                    </button>
                    <!-- Dropdown -->
                    <div
                        class="hs-dropdown-menu duration mt-2 min-w-96 rounded-lg border border-default-200 bg-white opacity-0 shadow-md transition-[opacity,margin] hs-dropdown-open:opacity-100 hidden">
                        <!-- Header -->
                        <div class="flex items-center justify-between px-5 py-4 border-b border-default-200">
                            <h4 class="font-semibold text-gray-800">Notifications</h4>
                            <span class="text-xs text-gray-400">4 New</span>
                        </div>
                        <!-- List -->
                        <div class="max-h-80 overflow-y-auto" data-simplebar="">
                            <div class="divide-y divide-default-200">
                                <!-- Item -->
                                <a class="flex gap-3 px-5 py-4 hover:bg-gray-100 transition group" href="#">
                                    <div class="relative">
                                        <img class="size-11 rounded-full object-cover"
                                             src="{{ asset('images/users/avatar-6.jpg') }}">
                                        <!-- Status -->
                                        <span
                                            class="absolute bottom-0 right-0 size-3 bg-green-500 border-2 border-white rounded-full"></span>
                                        </img></div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-600 leading-snug">
                                            <span class="font-semibold text-gray-900">Alex Johnson</span>
                                            triggered a system alert.
                                        </p>
                                        <span class="text-xs text-indigo-500">2 min ago</span>
                                    </div>
                                    <!-- Dot -->
                                    <span class="size-2 bg-indigo-500 rounded-full mt-2"></span>
                                </a>
                                <!-- Item -->
                                <a class="flex gap-3 px-5 py-4 hover:bg-gray-100 transition" href="#">
                                    <div class="relative">
                                        <img class="size-11 rounded-full"
                                             src="{{ asset('images/users/avatar-7.jpg') }}">
                                        <span
                                            class="absolute bottom-0 right-0 size-3 bg-indigo-500 border-2 border-white rounded-full"></span>
                                        </img></div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-semibold text-gray-900">Sarah Lee</span>
                                            shared a document.
                                        </p>
                                        <span class="text-xs text-indigo-500">5 min ago</span>
                                    </div>
                                </a>
                                <!-- Item -->
                                <a class="flex gap-3 px-5 py-4 hover:bg-gray-100 transition" href="#">
                                    <div class="relative">
                                        <img class="size-11 rounded-full"
                                             src="{{ asset('images/users/avatar-8.jpg') }}">
                                        <span
                                            class="absolute bottom-0 right-0 size-3 bg-purple-500 border-2 border-white rounded-full"></span>
                                        </img></div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-semibold text-gray-900">Michael</span>
                                            replied to your comment.
                                        </p>
                                        <span class="text-xs text-indigo-500">15 min ago</span>
                                    </div>
                                </a>
                                <!-- Item -->
                                <a class="flex gap-3 px-5 py-4 hover:bg-gray-100 transition" href="#">
                                    <div class="relative">
                                        <img class="size-11 rounded-full"
                                             src="{{ asset('images/users/avatar-9.jpg') }}">
                                        <span
                                            class="absolute bottom-0 right-0 size-3 bg-pink-500 border-2 border-white rounded-full"></span>
                                        </img></div>
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-600">
                                            <span class="font-semibold text-gray-900">Emma</span>
                                            reacted to your post.
                                        </p>
                                        <span class="text-xs text-indigo-500">30 min ago</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <!-- Footer -->
                        <div class="text-center py-3 border-t border-default-200">
                            <a class="text-sm font-medium text-indigo-600 hover:underline" href="#">
                                View all notifications
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Fullscreen Toggle Button -->
                <div class="md:flex hidden">
                    <button
                        class="hs-dropdown-toggle relative inline-flex items-center justify-center size-10 rounded bg-white border border-gray-200 hover:bg-gray-100 transition-all"
                        data-toggle="fullscreen" type="button">
                        <span class="sr-only">Fullscreen Mode</span>
                        <span class="flex items-center justify-center size-6">
<i class="iconify tabler--maximize text-xl inline-flex in-[.fullscreen]:hidden"></i>
<i class="iconify tabler--minimize text-xl hidden in-[.fullscreen]:inline-flex"></i>
</span>
                    </button>
                </div>
                <!-- Profile Dropdown -->
                <div class="hs-dropdown relative inline-flex [--placement:bottom-right]">
                    <!-- Button -->
                    <button class="hs-dropdown-toggle relative group" type="button">
                        <img
                            class="size-10 rounded-full object-cover ring-2 ring-white shadow-sm group-hover:shadow-xl transition"
                            src="{{ asset('images/users/avatar-8.jpg') }}">
                        <!-- Online dot -->
                        <span
                            class="absolute bottom-0 right-0 size-3 bg-green-500 border-2 border-white rounded-full"></span>
                        </img></button>
                    <!-- Dropdown -->
                    <div
                        class="hs-dropdown-menu duration mt-2 min-w-60 rounded-lg border border-default-200 bg-white opacity-0 shadow-md transition-[opacity,margin] hs-dropdown-open:opacity-100 hidden">
                        <!-- USER INFO -->
                        <div class="px-5 py-4 flex items-center gap-3 bg-gray-100/60">
                            <img class="size-11 rounded-full object-cover ring-2 ring-white shadow-sm"
                                 src="{{ asset('images/users/avatar-8.jpg') }}"/>
                            <div>
                                <h5 class="text-sm font-semibold text-gray-900">Michael Clark</h5>
                                <p class="text-xs text-gray-1000 flex items-center gap-1">
                                    <span class="size-1.5 bg-green-500 rounded-full"></span>
                                    Admin • Online
                                </p>
                            </div>
                        </div>
                        <!-- MENU -->
                        <div class="p-2">
                            <a class="flex items-center gap-3 rounded px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition-all"
                               href="#">
                                <i class="iconify lucide--user size-4 text-gray-400"></i>
                                My Profile
                            </a>
                            <a class="flex items-center gap-3 rounded px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition-all"
                               href="#">
                                <i class="iconify lucide--rss size-4 text-gray-400"></i>
                                Activity Feed
                            </a>
                            <a class="flex items-center gap-3 rounded px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition-all"
                               href="#">
                                <i class="iconify lucide--bar-chart-3 size-4 text-gray-400"></i>
                                Analytics
                            </a>
                            <a class="flex items-center gap-3 rounded px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition-all"
                               href="#">
                                <i class="iconify lucide--settings size-4 text-gray-400"></i>
                                Settings
                            </a>
                            <a class="flex items-center gap-3 rounded px-5 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition-all"
                               href="#">
                                <i class="iconify lucide--life-buoy size-4 text-gray-400"></i>
                                Support
                            </a>
                        </div>
                        <!-- DIVIDER -->
                        <div class="border-t border-gray-100"></div>
                        <!-- LOGOUT -->
                        <div class="p-2">
                            <a class="flex items-center gap-3 rounded px-5 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 transition-all"
                               href="#">
                                <i class="iconify lucide--log-out size-4"></i>
                                Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Topbar End -->
