@extends('shared.vertical', ['title' => 'Gallery'])



@section('styles')
    @vite(['node_modules/glightbox/dist/css/glightbox.min.css'])
@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Menu', 'title' => 'Gallery'])


    <div class="w-full filters-group-wrap mb-3">
        <ul class="filter-options flex flex-wrap gap-4">
            <li class="active" data-group="all"><a class="btn" href="javascript:void(0)">All
                    Items</a></li>
            <li data-group="design"><a class="btn" href="javascript:void(0)">Design</a></li>
            <li data-group="creative"><a class="btn" href="javascript:void(0)">Creative</a>
            </li>
            <li data-group="digital"><a class="btn" href="javascript:void(0)">Digital</a>
            </li>
            <li data-group="photography"><a class="btn" href="javascript:void(0)">Photography</a>
            </li>
        </ul>
    </div>
    <div class="flex justify-center" id="gallery-wrapper">
        <div class="xl:w-1/4 lg:w-1/3 p-3 picture-item" data-groups='["creative", "photography"]'>
            <a class="image-popup" href="{{ asset('images/small/img-1.jpg') }}">
                <div class="relative block overflow-hidden rounded group transition-all duration-500">
                    <img alt="work-image" class="rounded transition-all duration-500 group-hover:scale-105"
                         src="{{ asset('images/small/img-1.jpg') }}"/>
                    <div
                        class="absolute inset-3 flex items-end cursor-pointer rounded bg-white p-3 opacity-0 transition-all duration-500 group-hover:opacity-80">
                        <div>
                            <p class="text-sm text-default-400">Media, Icons</p>
                            <h6 class="text-base text-black font-medium">Open Imagination</h6>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="xl:w-1/4 lg:w-1/3 p-3 picture-item" data-groups='["design", "digital"]'>
            <a class="image-popup" href="{{ asset('images/small/img-2.jpg') }}">
                <div class="relative block overflow-hidden rounded group transition-all duration-500">
                    <img alt="work-image" class="rounded transition-all duration-500 group-hover:scale-105"
                         src="{{ asset('images/small/img-2.jpg') }}"/>
                    <div
                        class="absolute inset-3 flex items-end cursor-pointer rounded bg-white p-3 opacity-0 transition-all duration-500 group-hover:opacity-80">
                        <div>
                            <p class="text-sm text-default-400">Illustrations</p>
                            <h6 class="text-base text-black font-medium">Locked Steel Gate</h6>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="xl:w-1/4 lg:w-1/3 p-3 picture-item" data-groups='["creative", "photography"]'>
            <a class="image-popup" href="{{ asset('images/small/img-3.jpg') }}">
                <div class="relative block overflow-hidden rounded group transition-all duration-500">
                    <img alt="work-image" class="rounded transition-all duration-500 group-hover:scale-105"
                         src="{{ asset('images/small/img-3.jpg') }}"/>
                    <div
                        class="absolute inset-3 flex items-end cursor-pointer rounded bg-white p-3 opacity-0 transition-all duration-500 group-hover:opacity-80">
                        <div>
                            <p class="text-sm text-default-400">Graphics, UI Elements</p>
                            <h6 class="text-base text-black font-medium">Mac Sunglasses</h6>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="xl:w-1/4 lg:w-1/3 p-3 picture-item" data-groups='["design", "photography"]'>
            <a class="image-popup" href="{{ asset('images/small/img-4.jpg') }}">
                <div class="relative block overflow-hidden rounded group transition-all duration-500">
                    <img alt="work-image" class="rounded transition-all duration-500 group-hover:scale-105"
                         src="{{ asset('images/small/img-4.jpg') }}"/>
                    <div
                        class="absolute inset-3 flex items-end cursor-pointer rounded bg-white p-3 opacity-0 transition-all duration-500 group-hover:opacity-80">
                        <div>
                            <p class="text-sm text-default-400">Icons, Illustrations</p>
                            <h6 class="text-base text-black font-medium">Morning Dew</h6>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="xl:w-1/4 lg:w-1/3 p-3 picture-item" data-groups='["photography", "design"]'>
            <a class="image-popup" href="{{ asset('images/small/img-5.jpg') }}">
                <div class="relative block overflow-hidden rounded group transition-all duration-500">
                    <img alt="work-image" class="rounded transition-all duration-500 group-hover:scale-105"
                         src="{{ asset('images/small/img-5.jpg') }}"/>
                    <div
                        class="absolute inset-3 flex items-end cursor-pointer rounded bg-white p-3 opacity-0 transition-all duration-500 group-hover:opacity-80">
                        <div>
                            <p class="text-sm text-default-400">UI Elements, Media</p>
                            <h6 class="text-base text-black font-medium">Console Activity</h6>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="xl:w-1/4 lg:w-1/3 p-3 picture-item" data-groups='["digital", "creative"]'>
            <a class="image-popup" href="{{ asset('images/small/img-6.jpg') }}">
                <div class="relative block overflow-hidden rounded group transition-all duration-500">
                    <img alt="work-image" class="rounded transition-all duration-500 group-hover:scale-105"
                         src="{{ asset('images/small/img-6.jpg') }}"/>
                    <div
                        class="absolute inset-3 flex items-end cursor-pointer rounded bg-white p-3 opacity-0 transition-all duration-500 group-hover:opacity-80">
                        <div>
                            <p class="text-sm text-default-400">Graphics</p>
                            <h6 class="text-base text-black font-medium">Sunset Bulb Glow</h6>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="xl:w-1/4 lg:w-1/3 p-3 picture-item" data-groups='["creative", "digital"]'>
            <a class="image-popup" href="{{ asset('images/small/img-7.jpg') }}">
                <div class="relative block overflow-hidden rounded group transition-all duration-500">
                    <img alt="work-image" class="rounded transition-all duration-500 group-hover:scale-105"
                         src="{{ asset('images/small/img-7.jpg') }}"/>
                    <div
                        class="absolute inset-3 flex items-end cursor-pointer rounded bg-white p-3 opacity-0 transition-all duration-500 group-hover:opacity-80">
                        <div>
                            <p class="text-sm text-default-400">Icons, Illustrations</p>
                            <h6 class="text-base text-black font-medium">Morning Dew</h6>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="xl:w-1/4 lg:w-1/3 p-3 picture-item" data-groups='["design", "digital"]'>
            <a class="image-popup" href="{{ asset('images/small/img-5.jpg') }}">
                <div class="relative block overflow-hidden rounded group transition-all duration-500">
                    <img alt="work-image" class="rounded transition-all duration-500 group-hover:scale-105"
                         src="{{ asset('images/small/img-5.jpg') }}"/>
                    <div
                        class="absolute inset-3 flex items-end cursor-pointer rounded bg-white p-3 opacity-0 transition-all duration-500 group-hover:opacity-80">
                        <div>
                            <p class="text-sm text-default-400">Illustrations</p>
                            <h6 class="text-base text-black font-medium">Locked Steel Gate</h6>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('scripts')
    @vite(['resources/js/pages/gallery.js'])
@endsection
