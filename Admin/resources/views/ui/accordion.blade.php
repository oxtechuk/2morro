@extends('shared.vertical', ['title' => 'Dashboard'])



@section('styles')

@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Components', 'title' => 'Badge'])

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="">
                    <h5 class="text-lg font-medium text-default-950 capitalize mb-1">Example</h5>
                    <p class="text-default-600 text-sm font-medium">Click the accordions below to
                        expand/collapse the accordion content..</p>
                </div>
            </div>
            <div class="card-body">
                <div class="hs-accordion-group">
                    <div class="hs-accordion active" id="basic-heading-one">
                        <button aria-controls="hs-basic-collapse-one"
                                class="hs-accordion-toggle hs-accordion-active:text-primary group py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            <i class="iconify tabler--plus hs-accordion-active:hidden hs-accordion-active:text-primary-600 block w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            <i class="iconify tabler--minus hs-accordion-active:block hs-accordion-active:text-primary-600 hidden w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            Accordion #1
                        </button>
                        <div aria-labelledby="#basic-heading-one"
                             class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                             id="basic-collapse-one">
                            <p class="text-default-800">
                                <em>This is the third item's accordion body.</em> It is hidden by
                                default, until the collapse plugin adds the appropriate classes that we
                                use to style each element. These classes control the overall appearance,
                                as well as the showing and hiding via CSS transitions.
                            </p>
                        </div>
                    </div>
                    <div class="hs-accordion" id="basic-heading-two">
                        <button aria-controls="hs-basic-collapse-two"
                                class="hs-accordion-toggle hs-accordion-active:text-primary group py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            <i class="iconify tabler--plus hs-accordion-active:hidden hs-accordion-active:text-primary-600 block w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            <i class="iconify tabler--minus hs-accordion-active:block hs-accordion-active:text-primary-600 hidden w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            Accordion #2
                        </button>
                        <div aria-labelledby="#basic-heading-two"
                             class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                             id="basic-collapse-two">
                            <p class="text-default-800">
                                <em>This is the third item's accordion body.</em> It is hidden by
                                default, until the collapse plugin adds the appropriate classes that we
                                use to style each element. These classes control the overall appearance,
                                as well as the showing and hiding via CSS transitions.
                            </p>
                        </div>
                    </div>
                    <div class="hs-accordion" id="basic-heading-three">
                        <button aria-controls="hs-basic-collapse-three"
                                class="hs-accordion-toggle hs-accordion-active:text-primary group py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            <i class="iconify tabler--plus hs-accordion-active:hidden hs-accordion-active:text-primary-600 block w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            <i class="iconify tabler--minus hs-accordion-active:block hs-accordion-active:text-primary-600 hidden w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            Accordion #3
                        </button>
                        <div aria-labelledby="#basic-heading-three"
                             class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                             id="basic-collapse-three">
                            <p class="text-default-800">
                                <em>This is the third item's accordion body.</em> It is hidden by
                                default, until the collapse plugin adds the appropriate classes that we
                                use to style each element. These classes control the overall appearance,
                                as well as the showing and hiding via CSS transitions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="">
                    <h5 class="text-lg font-medium text-default-950 capitalize mb-1">Always open</h5>
                    <p class="text-default-600 text-sm font-medium">To make accordion items stay open
                        when another item is opened, use <code
                            class="text-primary">data-hs-accordion-always-open.</code></p>
                </div>
            </div>
            <div class="card-body">
                <div class="hs-accordion-group divide-y divide-default-200" data-hs-accordion-always-open="">
                    <div class="hs-accordion active" id="basic-always-open-heading-one">
                        <button aria-controls="hs-basic-always-open-collapse-one"
                                class="hs-accordion-toggle hs-accordion-active:text-primary py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            <i class="iconify tabler--plus hs-accordion-active:hidden hs-accordion-active:text-primary-600 block w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            <i class="iconify tabler--minus hs-accordion-active:block hs-accordion-active:text-primary-600 hidden w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            Accordion #1
                        </button>
                        <div aria-labelledby="#basic-always-open-heading-one"
                             class="hs-accordion-content w-full pb-3 overflow-hidden transition-[height] duration-300"
                             id="basic-always-open-collapse-one">
                            <p class="text-default-800">
                                <em>This is the second item's accordion body.</em> It is hidden by
                                default, until the collapse plugin adds the appropriate classes that we
                                use to style each element. These classes control the overall appearance,
                                as well as the showing and hiding via CSS transitions.
                            </p>
                        </div>
                    </div>
                    <div class="hs-accordion" id="basic-always-open-heading-two">
                        <button aria-controls="hs-basic-always-open-collapse-two"
                                class="hs-accordion-toggle hs-accordion-active:text-primary py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            <i class="iconify tabler--plus hs-accordion-active:hidden hs-accordion-active:text-primary-600 block w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            <i class="iconify tabler--minus hs-accordion-active:block hs-accordion-active:text-primary-600 hidden w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            Accordion #2
                        </button>
                        <div aria-labelledby="#basic-always-open-heading-two"
                             class="hs-accordion-content w-full pb-3 overflow-hidden transition-[height] duration-300 hidden"
                             id="basic-always-open-collapse-two">
                            <p class="text-default-800">
                                <em>This is the second item's accordion body.</em> It is hidden by
                                default, until the collapse plugin adds the appropriate classes that we
                                use to style each element. These classes control the overall appearance,
                                as well as the showing and hiding via CSS transitions.
                            </p>
                        </div>
                    </div>
                    <div class="hs-accordion" id="basic-always-open-heading-three">
                        <button aria-controls="hs-basic-always-open-collapse-three"
                                class="hs-accordion-toggle hs-accordion-active:text-primary py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            <i class="iconify tabler--plus hs-accordion-active:hidden hs-accordion-active:text-primary-600 block w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            <i class="iconify tabler--minus hs-accordion-active:block hs-accordion-active:text-primary-600 hidden w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            Accordion #3
                        </button>
                        <div aria-labelledby="#basic-always-open-heading-three"
                             class="hs-accordion-content w-full pb-3 overflow-hidden transition-[height] duration-300 hidden"
                             id="basic-always-open-collapse-three">
                            <p class="text-default-800">
                                <em>This is the first item's accordion body.</em> It is hidden by
                                default, until the collapse plugin adds the appropriate classes that we
                                use to style each element. These classes control the overall appearance,
                                as well as the showing and hiding via CSS transitions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="">
                    <h5 class="text-lg font-medium text-default-950 capitalize mb-1">Nested</h5>
                    <p class="text-default-600 text-sm font-medium">A basic form of the accordion with
                        sub menu.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="hs-accordion-group">
                    <div class="hs-accordion active" id="basic-nested-heading-one">
                        <button aria-controls="hs-basic-nested-collapse-one"
                                class="hs-accordion-toggle hs-accordion-active:text-primary py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            <i class="iconify tabler--plus hs-accordion-active:hidden hs-accordion-active:text-primary-600 block w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            <i class="iconify tabler--minus hs-accordion-active:block hs-accordion-active:text-primary-600 hidden w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            Accordion #1
                        </button>
                        <div aria-labelledby="#basic-nested-heading-one"
                             class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                             id="basic-nested-collapse-one">
                            <div class="hs-accordion-group pl-6">
                                <div class="hs-accordion active" id="basic-nested-sub-heading-one">
                                    <button aria-controls="hs-basic-nested-sub-collapse-one"
                                            class="hs-accordion-toggle hs-accordion-active:text-primary py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                                        <i class="hs-accordion-active:hidden hs-accordion-active:text-primary-600 block w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                                        <i class="hs-accordion-active:block hs-accordion-active:text-primary-600 hidden w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                                        Sub accordion #1
                                    </button>
                                    <div aria-labelledby="#hs-basic-nested-sub-heading-one"
                                         class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                                         id="basic-nested-sub-collapse-one">
                                        <p class="text-default-800">
                                            <em>This is the third item's accordion body.</em> It is
                                            hidden by default, until the collapse plugin adds the
                                            appropriate classes that we use to style each element. These
                                            classes control the overall appearance, as well as the
                                            showing and hiding via CSS transitions.
                                        </p>
                                    </div>
                                </div>
                                <div class="hs-accordion" id="basic-nested-sub-heading-two">
                                    <button aria-controls="hs-basic-nested-sub-collapse-two"
                                            class="hs-accordion-toggle hs-accordion-active:text-primary py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                                        <i class="hs-accordion-active:hidden hs-accordion-active:text-primary-600 block w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                                        <i class="hs-accordion-active:block hs-accordion-active:text-primary-600 hidden w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                                        Sub accordion #2
                                    </button>
                                    <div aria-labelledby="#basic-nested-sub-heading-two"
                                         class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                                         id="basic-nested-sub-collapse-two">
                                        <p class="text-default-800">
                                            <em>This is the second item's accordion body.</em> It is
                                            hidden by default, until the collapse plugin adds the
                                            appropriate classes that we use to style each element. These
                                            classes control the overall appearance, as well as the
                                            showing and hiding via CSS transitions.
                                        </p>
                                    </div>
                                </div>
                                <div class="hs-accordion" id="basic-nested-sub-heading-three">
                                    <button aria-controls="hs-basic-nested-sub-collapse-three"
                                            class="hs-accordion-toggle hs-accordion-active:text-primary py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                                        <i class="hs-accordion-active:hidden hs-accordion-active:text-primary-600 block w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                                        <i class="hs-accordion-active:block hs-accordion-active:text-primary-600 hidden w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                                        Sub accordion #3
                                    </button>
                                    <div aria-labelledby="#basic-nested-sub-heading-three"
                                         class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                                         id="basic-nested-sub-collapse-three">
                                        <p class="text-default-800">
                                            <em>This is the first item's accordion body.</em> It is
                                            hidden by default, until the collapse plugin adds the
                                            appropriate classes that we use to style each element. These
                                            classes control the overall appearance, as well as the
                                            showing and hiding via CSS transitions.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="hs-accordion" id="basic-nested-heading-two">
                        <button aria-controls="hs-basic-nested-collapse-two"
                                class="hs-accordion-toggle hs-accordion-active:text-primary py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            <i class="iconify tabler--plus hs-accordion-active:hidden hs-accordion-active:text-primary-600 block w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            <i class="iconify tabler--minus hs-accordion-active:block hs-accordion-active:text-primary-600 hidden w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            Accordion #2
                        </button>
                        <div aria-labelledby="#basic-nested-heading-two"
                             class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                             id="basic-nested-collapse-two">
                            <p class="text-default-800">
                                <em>This is the second item's accordion body.</em> It is hidden by
                                default, until the collapse plugin adds the appropriate classes that we
                                use to style each element. These classes control the overall appearance,
                                as well as the showing and hiding via CSS transitions.
                            </p>
                        </div>
                    </div>
                    <div class="hs-accordion" id="basic-nested-heading-three">
                        <button aria-controls="hs-basic-nested-collapse-three"
                                class="hs-accordion-toggle hs-accordion-active:text-primary py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            <i class="iconify tabler--plus hs-accordion-active:hidden hs-accordion-active:text-primary-600 block w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            <i class="iconify tabler--minus hs-accordion-active:block hs-accordion-active:text-primary-600 hidden w-3 h-3 text-default-600 group-hover:text-default-500"></i>
                            Accordion #3
                        </button>
                        <div aria-labelledby="#hs-basic-nested-heading-three"
                             class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                             id="basic-nested-collapse-three">
                            <p class="text-default-800">
                                <em>This is the first item's accordion body.</em> It is hidden by
                                default, until the collapse plugin adds the appropriate classes that we
                                use to style each element. These classes control the overall appearance,
                                as well as the showing and hiding via CSS transitions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="">
                    <h5 class="text-lg font-medium text-default-950 capitalize mb-1">No arrow</h5>
                    <p class="text-default-600 text-sm font-medium">Example with no arrow.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="hs-accordion-group">
                    <div class="hs-accordion active" id="basic-no-arrow-heading-one">
                        <button aria-controls="hs-basic-no-arrow-collapse-one"
                                class="hs-accordion-toggle hs-accordion-active:text-primary group py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            Accordion #1
                        </button>
                        <div aria-labelledby="#basic-no-arrow-heading-one"
                             class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                             id="basic-no-arrow-collapse-one">
                            <p class="text-default-800">
                                <em>This is the third item's accordion body.</em> It is hidden by
                                default, until the collapse plugin adds the appropriate classes that we
                                use to style each element. These classes control the overall appearance,
                                as well as the showing and hiding via CSS transitions.
                            </p>
                        </div>
                    </div>
                    <div class="hs-accordion" id="basic-no-arrow-heading-two">
                        <button aria-controls="hs-basic-no-arrow-collapse-two"
                                class="hs-accordion-toggle hs-accordion-active:text-primary group py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            Accordion #2
                        </button>
                        <div aria-labelledby="#basic-no-arrow-heading-two"
                             class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                             id="basic-no-arrow-collapse-two">
                            <p class="text-default-800">
                                <em>This is the third item's accordion body.</em> It is hidden by
                                default, until the collapse plugin adds the appropriate classes that we
                                use to style each element. These classes control the overall appearance,
                                as well as the showing and hiding via CSS transitions.
                            </p>
                        </div>
                    </div>
                    <div class="hs-accordion" id="basic-no-arrow-heading-three">
                        <button aria-controls="hs-basic-no-arrow-collapse-three"
                                class="hs-accordion-toggle hs-accordion-active:text-primary group py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            Accordion #3
                        </button>
                        <div aria-labelledby="#basic-no-arrow-heading-three"
                             class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                             id="basic-no-arrow-collapse-three">
                            <p class="text-default-800">
                                <em>This is the third item's accordion body.</em> It is hidden by
                                default, until the collapse plugin adds the appropriate classes that we
                                use to style each element. These classes control the overall appearance,
                                as well as the showing and hiding via CSS transitions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="">
                    <h5 class="text-lg font-medium text-default-950 capitalize mb-1">With arrow</h5>
                    <p class="text-default-600 text-sm font-medium">Example with arrow.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="hs-accordion-group">
                    <div class="hs-accordion active" id="basic-with-arrow-heading-one">
                        <button aria-controls="hs-basic-with-arrow-collapse-one"
                                class="hs-accordion-toggle hs-accordion-active:text-primary group py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            <i class="iconify tabler--chevron-down text-base transition-all hs-accordion-active:rotate-180"></i>
                            Accordion #1
                        </button>
                        <div aria-labelledby="#basic-with-arrow-heading-one"
                             class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                             id="basic-with-arrow-collapse-one">
                            <p class="text-default-800">
                                <em>This is the third item's accordion body.</em> It is hidden by
                                default, until the collapse plugin adds the appropriate classes that we
                                use to style each element. These classes control the overall appearance,
                                as well as the showing and hiding via CSS transitions.
                            </p>
                        </div>
                    </div>
                    <div class="hs-accordion" id="basic-with-arrow-heading-two">
                        <button aria-controls="hs-basic-with-arrow-collapse-two"
                                class="hs-accordion-toggle hs-accordion-active:text-primary group py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            <i class="iconify tabler--chevron-down text-base transition-all hs-accordion-active:rotate-180"></i>
                            Accordion #2
                        </button>
                        <div aria-labelledby="#basic-with-arrow-heading-two"
                             class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                             id="basic-with-arrow-collapse-two">
                            <p class="text-default-800">
                                <em>This is the third item's accordion body.</em> It is hidden by
                                default, until the collapse plugin adds the appropriate classes that we
                                use to style each element. These classes control the overall appearance,
                                as well as the showing and hiding via CSS transitions.
                            </p>
                        </div>
                    </div>
                    <div class="hs-accordion" id="basic-with-arrow-heading-three">
                        <button aria-controls="hs-basic-with-arrow-collapse-three"
                                class="hs-accordion-toggle hs-accordion-active:text-primary group py-3 inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition hover:text-default-500">
                            <i class="iconify tabler--chevron-down text-base transition-all hs-accordion-active:rotate-180"></i>
                            Accordion #3
                        </button>
                        <div aria-labelledby="#basic-with-arrow-heading-three"
                             class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                             id="basic-with-arrow-collapse-three">
                            <p class="text-default-800">
                                <em>This is the third item's accordion body.</em> It is hidden by
                                default, until the collapse plugin adds the appropriate classes that we
                                use to style each element. These classes control the overall appearance,
                                as well as the showing and hiding via CSS transitions.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <div class="">
                    <h5 class="text-lg font-medium text-default-950 capitalize mb-1">Bordered</h5>
                    <p class="text-default-600 text-sm font-medium">A basic form of the bordered
                        accordion.</p>
                </div>
            </div>
            <div class="card-body">
                <div class="hs-accordion-group">
                    <div
                        class="hs-accordion active bg-default-100 border border-default-200 -mt-px first:rounded-t-lg last:rounded-b-lg"
                        id="bordered-heading-one">
                        <button aria-controls="hs-basic-bordered-collapse-one"
                                class="hs-accordion-toggle hs-accordion-active:text-primary inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition py-4 px-5 hover:text-default-500">
                            <i class="iconify tabler--plus text-base block hs-accordion-active:hidden"></i>
                            <i class="iconify tabler--minus text-base hidden hs-accordion-active:block"></i>
                            Accordion #1
                        </button>
                        <div aria-labelledby="#bordered-heading-one"
                             class="hs-accordion-content w-full overflow-hidden transition-[height] duration-300"
                             id="basic-bordered-collapse-one">
                            <div class="pb-4 px-5">
                                <p class="text-default-800">
                                    <em>This is the third item's accordion body.</em> It is hidden by
                                    default, until the collapse plugin adds the appropriate classes that
                                    we use to style each element. These classes control the overall
                                    appearance, as well as the showing and hiding via CSS transitions.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="hs-accordion bg-default-100 border border-default-200 -mt-px first:rounded-t-lg last:rounded-b-lg"
                        id="bordered-heading-two">
                        <button aria-controls="hs-basic-bordered-collapse-two"
                                class="hs-accordion-toggle hs-accordion-active:text-primary inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition py-4 px-5 hover:text-default-500">
                            <i class="iconify tabler--plus text-base block hs-accordion-active:hidden"></i>
                            <i class="iconify tabler--minus text-base hidden hs-accordion-active:block"></i>
                            Accordion #2
                        </button>
                        <div aria-labelledby="#bordered-heading-two"
                             class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                             id="basic-bordered-collapse-two">
                            <div class="pb-4 px-5">
                                <p class="text-default-800">
                                    <em>This is the second item's accordion body.</em> It is hidden by
                                    default, until the collapse plugin adds the appropriate classes that
                                    we use to style each element. These classes control the overall
                                    appearance, as well as the showing and hiding via CSS transitions.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div
                        class="hs-accordion bg-default-100 border border-default-200 -mt-px first:rounded-t-lg last:rounded-b-lg"
                        id="bordered-heading-three">
                        <button aria-controls="hs-basic-bordered-collapse-three"
                                class="hs-accordion-toggle hs-accordion-active:text-primary inline-flex items-center gap-x-3 w-full font-semibold text-left text-default-800 transition py-4 px-5 hover:text-default-500">
                            <i class="iconify tabler--plus text-base block hs-accordion-active:hidden"></i>
                            <i class="iconify tabler--minus text-base hidden hs-accordion-active:block"></i>
                            Accordion #3
                        </button>
                        <div aria-labelledby="#bordered-heading-three"
                             class="hs-accordion-content hidden w-full overflow-hidden transition-[height] duration-300"
                             id="basic-bordered-collapse-three">
                            <div class="pb-4 px-5">
                                <p class="text-default-800">
                                    <em>This is the first item's accordion body.</em> It is hidden by
                                    default, until the collapse plugin adds the appropriate classes that
                                    we use to style each element. These classes control the overall
                                    appearance, as well as the showing and hiding via CSS transitions.
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
