@extends('shared.vertical', ['title' => 'Dashboard'])



@section('styles')

@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Components', 'title' => 'Dropdown'])

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header">
                <div class="">
                    <h5 class="text-lg font-medium text-default-950 capitalize mb-1">Default Dropdowns
                    </h5>
                    <p class="text-default-600 text-sm font-medium">The default dropdown menu
                        appearance.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="flex flex-wrap items-center gap-2">
                    <div class="hs-dropdown relative">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-flex items-center justify-center font-semibold tracking-wide border align-middle duration-500 text-sm text-center bg-primary hover:bg-primary-600 border-primary hover:border-primary-600 text-white rounded-md"
                            id="hs-dropdown-default" type="button">
                            Primary <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hs-dropdown relative">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-flex items-center justify-center font-semibold tracking-wide border align-middle duration-500 text-sm text-center bg-default-500 hover:bg-default-600 border-default-500 hover:border-default-600 text-white rounded-md"
                            id="hs-dropdown-default" type="button">
                            Gray <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="">
                    <h5 class="text-lg font-medium text-default-950 capitalize mb-1">Menu alignment</h5>
                    <p class="text-default-600 text-sm font-medium">Dropdown menu alignments.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="flex flex-wrap gap-2">
                    <div class="hs-dropdown relative [--placement:right-top]">
                        <button
                            class="py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-default-900 bg-default-100 hover:bg-default-200 border-default-100 hover:border-default-200 rounded-md"
                            type="button">
                            Dropdown Right <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hs-dropdown relative [--placement:left-top]">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-default-900 bg-default-100 hover:bg-default-200 border-default-100 hover:border-default-200 rounded-md"
                            type="button">
                            Dropdown left <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hs-dropdown relative [--placement:top]">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-default-900 bg-default-100 hover:bg-default-200 border-default-100 hover:border-default-200 rounded-md"
                            type="button">
                            Dropdown Top <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hs-dropdown relative [--placement:bottom]">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-default-900 bg-default-100 hover:bg-default-200 border-default-100 hover:border-default-200 rounded-md"
                            type="button">
                            Dropdown Bottom <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hs-dropdown relative [--placement:top-left]">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-default-900 bg-default-100 hover:bg-default-200 border-default-100 hover:border-default-200 rounded-md"
                            type="button">
                            Top Left <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hs-dropdown relative [--placement:top-right]">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-default-900 bg-default-100 hover:bg-default-200 border-default-100 hover:border-default-200 rounded-md"
                            type="button">
                            Top Right <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="">
                    <h5 class="text-lg font-medium text-default-950 capitalize mb-1">Color Variant</h5>
                    <p class="text-default-600 text-sm font-medium">Dropdown menu alignments.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="flex flex-wrap gap-2">
                    <div class="hs-dropdown relative">
                        <button
                            class="py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-white bg-primary hover:bg-primary-600 border-primary hover:border-primary-600 rounded-md"
                            type="button">
                            Primary <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hs-dropdown relative">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-white bg-default-500 hover:bg-default-600 border-default-500 hover:border-default-600 rounded-md"
                            type="button">
                            Gray <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hs-dropdown relative">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-white bg-teal-500 hover:bg-teal-600 border-teal-500 hover:border-teal-600 rounded-md"
                            type="button">
                            Teal <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hs-dropdown relative">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-white bg-primary-500 hover:bg-primary-600 border-primary-500 hover:border-primary-600 rounded-md"
                            type="button">
                            Blue <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hs-dropdown relative">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-white bg-amber-500 hover:bg-amber-600 border-amber-500 hover:border-amber-600 rounded-md"
                            type="button">
                            Yellow <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hs-dropdown relative">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-white bg-cyan-500 hover:bg-cyan-600 border-cyan-500 hover:border-cyan-600 rounded-md"
                            type="button">
                            Cyan <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hs-dropdown relative">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-white bg-primary-500 hover:bg-primary-600 border-primary-500 hover:border-primary-600 rounded-md"
                            type="button">
                            sky <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hs-dropdown relative">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-white bg-indigo-500 hover:bg-indigo-600 border-indigo-500 hover:border-indigo-600 rounded-md"
                            type="button">
                            Indigo <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="hs-dropdown relative">
                        <button
                            class="hs-dropdown-toggle py-2 px-5 inline-block font-medium tracking-wide border align-middle duration-500 text-sm text-center text-white bg-purple-500 hover:bg-purple-600 border-purple-500 hover:border-purple-600 rounded-md"
                            type="button">
                            Purple <i class="iconify tabler--chevron-down ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <ul class="flex flex-col gap-1">
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li>
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-400/10 rounded"
                                       href="#">Somthing else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <div class="">
                    <h5 class="text-lg font-medium text-default-950 capitalize mb-1">Variant</h5>
                    <p class="text-default-600 text-sm font-medium">Dropdown menu alignments.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="flex flex-wrap gap-2">
                    <div class="hs-dropdown [--auto-close:inside]">
                        <button
                            class="hs-dropdown-toggle inline-flex items-center gap-2 py-2 px-6 text-base text-center bg-primary hover:bg-primary-700 text-white rounded-md transition-all duration-500"
                            type="button">
                            Radio <i class="h-4 w-4 ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <div
                                class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-100 rounded">
                                <div class="flex items-center">
                                    <input
                                        class="h-4 w-4 border-default-200 bg-default-50 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary/60 focus:ring-offset-0"
                                        id="default-radio" name="default-radio" type="radio"/>
                                    <label class="text-sm text-default-600 ms-2" for="default-radio">Default
                                        radio</label>
                                </div>
                            </div>
                            <div
                                class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-100 rounded">
                                <div class="flex items-center">
                                    <input checked=""
                                           class="h-4 w-4 border-default-200 bg-default-50 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary/60 focus:ring-offset-0"
                                           id="checked-radio" name="default-radio" type="radio"/>
                                    <label class="text-sm text-default-600 ms-2" for="checked-radio">Checked
                                        radio</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hs-dropdown [--auto-close:inside]">
                        <button
                            class="hs-dropdown-toggle inline-flex items-center gap-2 py-2 px-6 text-base text-center bg-primary hover:bg-primary-700 text-white rounded-md transition-all duration-500"
                            type="button">
                            CheckBox <i class="iconify tabler--chevron-down h-4 w-4 ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-1.5 hidden">
                            <div
                                class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-100 rounded">
                                <div class="flex items-center">
                                    <input
                                        class="h-4 w-4 rounded border-default-200 bg-default-50 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary/60 focus:ring-offset-0"
                                        id="default-checkbox" type="checkbox"/>
                                    <label class="text-sm text-default-600 ms-2" for="default-checkbox">Default
                                        checkbox</label>
                                </div>
                            </div>
                            <div
                                class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-100 rounded">
                                <div class="flex items-center">
                                    <input checked=""
                                           class="h-4 w-4 rounded border-default-200 bg-default-50 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary/60 focus:ring-offset-0"
                                           id="checked-checkbox" type="checkbox"/>
                                    <label class="text-sm text-default-600 ms-2" for="checked-checkbox">Checked
                                        checkbox</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hs-dropdown [--auto-close:inside]">
                        <button
                            class="hs-dropdown-toggle inline-flex items-center gap-2 py-2 px-6 text-base text-center bg-primary hover:bg-primary-700 text-white rounded-md transition-all duration-500"
                            type="button">
                            Form <i class="h-4 w-4 ms-1"></i>
                        </button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 p-4 hidden">
                            <form class="">
                                <div class="mb-3 space-y-1">
                                    <label class="text-default-800 font-medium" for="exampleInputEmail1">Email
                                        address</label>
                                    <input aria-describedby="emailHelp"
                                           class="block w-full rounded py-1.5 px-3 bg-transparent border-default-200 text-default-900 focus:ring-transparent focus:border-default-200"
                                           id="exampleInputEmail1" placeholder="Enter email" type="email"/>
                                    <span class="inline-block"><small class="form-text text-sm text-default-700"
                                                                      id="emailHelp">We'll never share
                                                        your email with anyone else.</small></span>
                                </div>
                                <div class="mb-3 space-y-1">
                                    <label class="text-default-800 font-medium"
                                           for="exampleInputPassword1">Password</label>
                                    <input
                                        class="block w-full rounded py-1.5 px-3 bg-transparent border-default-200 text-default-900 focus:ring-transparent focus:border-default-200"
                                        id="exampleInputPassword1" placeholder="Password" type="password"/>
                                </div>
                                <div class="flex items-center gap-2 mb-3">
                                    <input
                                        class="h-4 w-4 rounded border-default-200 bg-default-50 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary/60 focus:ring-offset-0"
                                        id="checkmeout0" type="checkbox"/>
                                    <label class="text-default-800 text-sm font-medium inline-block" for="checkmeout0">Check
                                        me out !</label>
                                </div>
                                <button
                                    class="inline-block py-2 px-4 text-sm text-center bg-primary hover:bg-primary-700 text-white rounded transition-all duration-500"
                                    type="submit">Submit
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="hs-dropdown">
                        <button
                            class="hs-dropdown-toggle h-10 w-10 inline-flex items-center justify-center bg-primary text-white rounded-md transition-all duration-500 hover:bg-primary-700">
                            <i class="h-4 w-4" data-ti="more-vertical"></i></button>
                        <div
                            class="hs-dropdown-menu hs-dropdown-open:opacity-100 min-w-48 transition-[opacity,margin] mt-4 opacity-0 z-10 bg-white shadow-lg rounded-lg border border-default-100 hidden">
                            <ul class="flex flex-col gap-1 py-1.5">
                                <li class="mx-1.5">
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-100 rounded"
                                       href="#">Action</a>
                                </li>
                                <li class="mx-1.5">
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-100 rounded"
                                       href="#">Another Action</a>
                                </li>
                                <li class="mx-1.5">
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-100 rounded"
                                       href="#">Menu Item</a>
                                </li>
                                <hr class="border-default-200"/>
                                <li class="mx-1.5">
                                    <a class="flex items-center font-normal text-default-600 py-2 px-3 transition-all hover:text-default-700 hover:bg-default-100 rounded"
                                       href="#">Something else here</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
