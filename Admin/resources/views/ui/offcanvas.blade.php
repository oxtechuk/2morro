@extends('shared.vertical', ['title' => 'Dashboard'])



@section('styles')

@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Components', 'title' => 'Modal'])

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="">
                    <h5 class="text-lg font-medium text-default-950 capitalize mb-1">Example</h5>
                    <p class="text-default-600 text-sm font-medium">The default form of a offcanvas
                        dialog
                        with slide start animation.</p>
                </div>
            </div>
            <div class="card-body">
                <button class="btn bg-primary text-white" data-hs-overlay="#hs-overlay-example" type="button">
                    Open Offcanvas
                </button>
                <div aria-overlay="true"
                     class="hs-overlay hs-overlay-open:translate-x-0 -translate-x-full fixed top-0 left-0 transition-all duration-300 transform h-full max-w-xs w-full z-70 bg-white border-e border-default-200 hidden"
                     id="hs-overlay-example" tabindex="-1">
                    <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                        <h3 class="text-lg font-medium text-default-600">
                            Offcanvas title
                        </h3>
                        <button class="hover:text-default-900 transition-all" data-hs-overlay="#hs-overlay-example"
                                type="button">
                            <span class="sr-only">Close modal</span>
                            <i class="iconify tabler--x text-lg"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <p class="text-default-600 mt-1">
                            Some text as placeholder. In real life you can have the elements you have
                            chosen. Like, text, images, lists, etc.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="">
                    <h5 class="text-lg font-medium text-default-950 capitalize mb-1">Placement</h5>
                    <p class="text-default-600 text-sm font-medium">Try the top, right, and bottom
                        examples
                        out below.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="flex flex-wrap items-center gap-2">
                    <div>
                        <button class="btn bg-primary text-white" data-hs-overlay="#overlay-top" type="button">
                            Toggle top offcanvas
                        </button>
                        <div
                            class="hs-overlay hs-overlay-open:translate-y-0 -translate-y-full fixed top-0 inset-x-0 transition-all duration-300 transform max-h-40 h-full w-full z-70 bg-white border-b border-default-200 hidden"
                            id="overlay-top">
                            <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                <h3 class="text-lg font-medium text-default-600">
                                    Offcanvas title
                                </h3>
                                <button class="hover:text-default-900" data-hs-overlay="#overlay-top" type="button">
                                    <span class="sr-only">Close modal</span>
                                    <i class="iconify tabler--x text-lg"></i>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-default-600 mt-1">
                                    Some text as placeholder. In real life you can have the elements you
                                    have chosen. Like, text, images, lists, etc.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn bg-primary text-white" data-hs-overlay="#overlay-right" type="button">
                            Toggle right offcanvas
                        </button>
                        <div
                            class="hs-overlay hs-overlay-open:translate-x-0 translate-x-full fixed top-0 right-0 transition-all duration-300 transform h-full max-w-xs w-full z-70 bg-white border-s border-default-200 hidden"
                            id="overlay-right" tabindex="-1">
                            <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                <h3 class="text-lg font-medium text-default-600">
                                    Offcanvas title
                                </h3>
                                <button class="hover:text-default-900" data-hs-overlay="#overlay-right" type="button">
                                    <span class="sr-only">Close modal</span>
                                    <i class="iconify tabler--x text-lg"></i>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-default-600 mt-1">
                                    Some text as placeholder. In real life you can have the elements you
                                    have chosen. Like, text, images, lists, etc.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn bg-primary text-white" data-hs-overlay="#overlay-bottom" type="button">
                            Toggle bottom offcanvas
                        </button>
                        <div
                            class="hs-overlay hs-overlay-open:translate-y-0 translate-y-full fixed bottom-0 inset-x-0 transition-all duration-300 transform max-h-40 h-full w-full z-70 bg-white border-t border-default-200 hidden"
                            id="overlay-bottom" tabindex="-1">
                            <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                <h3 class="text-lg font-medium text-default-600">
                                    Offcanvas title
                                </h3>
                                <button class="hover:text-default-900" data-hs-overlay="#overlay-bottom" type="button">
                                    <span class="sr-only">Close modal</span>
                                    <i class="iconify tabler--x text-lg"></i>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-default-600 mt-1">
                                    Some text as placeholder. In real life you can have the elements you
                                    have chosen. Like, text, images, lists, etc.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="">
                    <h5 class="text-lg font-medium text-default-950 capitalize mb-1">Backdrop</h5>
                    <p class="text-default-600 text-sm font-medium">Use the <code class="text-primary">[--body-scroll:true]</code>
                        attribute to toggle <code class="text-primary">body</code> scrolling and <code
                            class="text-primary">[--overlay-backdrop:false]</code> to toggle the
                        backdrop.
                    </p>
                </div>
            </div>
            <div class="card-body">
                <div class="flex flex-wrap items-center gap-2">
                    <div>
                        <button class="btn bg-primary text-white" data-hs-overlay="#hs-overlay-body-scrolling"
                                type="button">
                            Enable body scrolling
                        </button>
                        <div
                            class="hs-overlay hs-overlay-open:translate-x-0 hidden -translate-x-full fixed top-0 left-0 transition-all duration-300 transform h-full max-w-xs w-full z-70 bg-white border-e border-default-200 [--body-scroll:true] [--overlay-backdrop:false]"
                            id="hs-overlay-body-scrolling" tabindex="-1">
                            <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                <h3 class="text-lg font-medium text-default-600">
                                    Offcanvas with body scrolling
                                </h3>
                                <button class="hover:text-default-900" data-hs-overlay="#hs-overlay-body-scrolling"
                                        type="button">
                                    <span class="sr-only">Close modal</span>
                                    <i class="iconify tabler--x text-lg"></i>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-default-600 mt-1">
                                    Try scrolling the rest of the page to see this option in action.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn bg-primary text-white" data-hs-overlay="#hs-overlay-backdrop-default"
                                type="button">
                            Enable backdrop (default)
                        </button>
                        <div
                            class="hs-overlay hs-overlay-open:translate-x-0 hidden -translate-x-full fixed top-0 left-0 transition-all duration-300 transform h-full max-w-xs w-full z-70 bg-white border-e border-default-200"
                            id="hs-overlay-backdrop-default" tabindex="-1">
                            <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                <h3 class="text-lg font-medium text-default-600">
                                    Offcanvas with backdrop
                                </h3>
                                <button class="hover:text-default-900" data-hs-overlay="#hs-overlay-backdrop-default"
                                        type="button">
                                    <span class="sr-only">Close modal</span>
                                    <i class="iconify tabler--x text-lg"></i>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-default-600 mt-1">
                                    ...
                                </p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn bg-primary text-white" data-hs-overlay="#hs-overlay-backdrop-with-scrolling"
                                type="button">
                            Enable both scrolling &amp; backdrop
                        </button>
                        <div
                            class="hs-overlay hs-overlay-open:translate-x-0 hidden -translate-x-full fixed top-0 left-0 transition-all duration-300 transform h-full max-w-xs w-full z-70 bg-white border-e border-default-200"
                            data-hs-overlay-scroll="true" id="hs-overlay-backdrop-with-scrolling" tabindex="-1">
                            <div class="flex justify-between items-center py-3 px-4 border-b border-default-200">
                                <h3 class="text-lg font-medium text-default-600">
                                    Backdrop with scrolling
                                </h3>
                                <button class="hover:text-default-900"
                                        data-hs-overlay="#hs-overlay-backdrop-with-scrolling" type="button">
                                    <span class="sr-only">Close modal</span>
                                    <i class="iconify tabler--x text-lg"></i>
                                </button>
                            </div>
                            <div class="p-4">
                                <p class="text-default-600 mt-1">
                                    Try scrolling the rest of the page to see this option in action.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
