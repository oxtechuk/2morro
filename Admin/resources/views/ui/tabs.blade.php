@extends('shared.vertical', ['title' => 'Dashboard'])



@section('styles')

@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Apps', 'title' => 'Calendar'])

    <div class="grid 2xl:grid-cols-2 grid-cols-1 gap-6">
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Basic</h4>
                <div data-fc-type="tab">
                    <nav aria-label="Tabs" class="flex space-x-3 border-b">
                        <button
                            class="fc-tab-active:font-semibold fc-tab-active:border-primary fc-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-2 border-transparent -mb-px transition-all text-sm whitespace-nowrap text-default-500 hover:text-primary active"
                            data-fc-target="#tabs-with-underline-1" type="button">
                            Tab One
                        </button>
                        <button
                            class="fc-tab-active:font-semibold fc-tab-active:border-primary fc-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-2 border-transparent -mb-px transition-all text-sm whitespace-nowrap text-default-500 hover:text-primary"
                            data-fc-target="#tabs-with-underline-2" type="button">
                            Tab Two
                        </button>
                        <button
                            class="fc-tab-active:font-semibold fc-tab-active:border-primary fc-tab-active:text-primary py-4 px-1 inline-flex items-center gap-2 border-b-2 border-transparent -mb-px transition-all text-sm whitespace-nowrap text-default-500 hover:text-primary"
                            data-fc-target="#tabs-with-underline-3" type="button">
                            Tab Three
                        </button>
                    </nav>
                    <div class="mt-3 overflow-hidden">
                        <div aria-labelledby="tabs-with-underline-item-1"
                             class="active fc-tab-active:opacity-100 opacity-0 transition-all duration-300 transform"
                             id="tabs-with-underline-1" role="tabpanel">
                            <p class="text-default-500">
                                Tailwind is a utility-first CSS framework that offers an extensive range of
                                classes, including flex, pt-4, text-center, and rotate-90. These classes can
                                be
                                combined to construct any design directly in your markup, allowing you to
                                build
                                your next idea even faster. Along with its efficiency, Tailwind also
                                provides
                                beautifully designed, expertly crafted components and templates, making it
                                the
                                perfect starting point for your next project. With over 200+ professionally
                                designed, fully responsive, expertly crafted component examples at your
                                disposal, you can seamlessly integrate them into your Tailwind projects and
                                customize them according to your preferences.
                            </p>
                        </div>
                        <div aria-labelledby="tabs-with-underline-item-2"
                             class="hidden fc-tab-active:opacity-100 transition-all duration-300 transform opacity-0"
                             id="tabs-with-underline-2" role="tabpanel">
                            <p class="text-default-500">
                                Tailwind Elements simplifies the process of adding a dark mode to your
                                project.
                                By utilizing Tailwind's classes and a dark variant, you can effortlessly
                                integrate a dual-themed website. Our components come equipped with the dark
                                theme variant as a default feature. Furthermore, like any Tailwind project,
                                the
                                default theme can be personalized by modifying the project's color palette,
                                type
                                scale, fonts, breakpoints, border radius values, and other attributes
                                through
                                the tailwind.config.js configuration file.
                            </p>
                        </div>
                        <div aria-labelledby="tabs-with-underline-item-3"
                             class="hidden fc-tab-active:opacity-100 transition-all duration-300 transform opacity-0"
                             id="tabs-with-underline-3" role="tabpanel">
                            <p class="text-default-500">
                                Tailwind CSS offers a seamless way to build modern websites without having
                                to
                                leave your HTML. The framework functions by scanning all of your HTML files,
                                JavaScript components, and templates for class names, automatically
                                generating
                                corresponding styles, and writing them to a static CSS file. This approach
                                is
                                fast, flexible, and reliable, requiring zero runtime. Whether you need to
                                create
                                form layouts, tables, or modal dialogs, Tailwind CSS provides everything
                                necessary to design beautiful, responsive web applications. Additionally,
                                the
                                framework includes checkout forms, shopping carts, and product views, making
                                it
                                the ideal choice for developing your next e-commerce front-end.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Single Image Lightbox</h4>
                <div class="flex gap-3">
                    <div class="grid md:grid-cols-5 gap-5" data-fc-type="tab">
                        <nav aria-label="Tabs" class="flex md:flex-col gap-2 space-y-2" role="tablist">
                            <button aria-controls="vertical-tab-with-border-1"
                                    class="fc-tab-active:bg-primary fc-tab-active:text-white btn bg-transparent active"
                                    data-fc-target="#vertical-tab-with-border-1" id="vertical-tab-with-border-item-1"
                                    role="tab" type="button">
                                Tab 1
                            </button>
                            <button aria-controls="vertical-tab-with-border-2"
                                    class="fc-tab-active:bg-primary fc-tab-active:text-white btn bg-transparent"
                                    data-fc-target="#vertical-tab-with-border-2" id="vertical-tab-with-border-item-2"
                                    role="tab" type="button">
                                Tab 2
                            </button>
                            <button aria-controls="vertical-tab-with-border-3"
                                    class="fc-tab-active:bg-primary fc-tab-active:text-white btn bg-transparent"
                                    data-fc-target="#vertical-tab-with-border-3" id="vertical-tab-with-border-item-3"
                                    role="tab" type="button">
                                Tab 3
                            </button>
                        </nav>
                        <div class="md:col-span-4">
                            <div aria-labelledby="vertical-tab-with-border-item-1" id="vertical-tab-with-border-1"
                                 role="tabpanel">
                                <p class="text-default-500">
                                    Tailwind is a utility-first CSS framework that offers an extensive range
                                    of
                                    classes, including flex, pt-4, text-center, and rotate-90. These classes
                                    can be
                                    combined to construct any design directly in your markup, allowing you
                                    to build
                                    your next idea even faster. Along with its efficiency, Tailwind also
                                    provides
                                    beautifully designed, expertly crafted components and templates, making
                                    it the
                                    perfect starting point for your next project. With over 200+
                                    professionally
                                    designed, fully responsive, expertly crafted component examples at your
                                    disposal, you can seamlessly integrate them into your Tailwind projects
                                    and
                                    customize them according to your preferences.
                                </p>
                            </div>
                            <div aria-labelledby="vertical-tab-with-border-item-2" class="hidden"
                                 id="vertical-tab-with-border-2" role="tabpanel">
                                <p class="text-default-500">
                                    Tailwind Elements simplifies the process of adding a dark mode to your
                                    project.
                                    By utilizing Tailwind's classes and a dark variant, you can effortlessly
                                    integrate a dual-themed website. Our components come equipped with the
                                    dark
                                    theme variant as a default feature. Furthermore, like any Tailwind
                                    project, the
                                    default theme can be personalized by modifying the project's color
                                    palette, type
                                    scale, fonts, breakpoints, border radius values, and other attributes
                                    through
                                    the tailwind.config.js configuration file.
                                </p>
                            </div>
                            <div aria-labelledby="vertical-tab-with-border-item-3" class="hidden"
                                 id="vertical-tab-with-border-3" role="tabpanel">
                                <p class="text-default-500">
                                    Tailwind CSS offers a seamless way to build modern websites without
                                    having to
                                    leave your HTML. The framework functions by scanning all of your HTML
                                    files,
                                    JavaScript components, and templates for class names, automatically
                                    generating
                                    corresponding styles, and writing them to a static CSS file. This
                                    approach is
                                    fast, flexible, and reliable, requiring zero runtime. Whether you need
                                    to create
                                    form layouts, tables, or modal dialogs, Tailwind CSS provides everything
                                    necessary to design beautiful, responsive web applications.
                                    Additionally, the
                                    framework includes checkout forms, shopping carts, and product views,
                                    making it
                                    the ideal choice for developing your next e-commerce front-end.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Single Image Lightbox</h4>
                <div data-fc-type="tab">
                    <nav aria-label="Tabs" class="flex space-x-2 border-b border-default-200" role="tablist">
                        <button aria-controls="card-type-tab-1"
                                class="fc-tab-active:bg-white fc-tab-active:border-b-transparent fc-tab-active:text-primary -mb-px py-3 px-4 inline-flex items-center gap-2 bg-default-50 text-sm font-medium text-center border text-default-500 rounded-t-lg hover:text-default-700 active"
                                data-fc-target="#card-type-tab-1" id="card-type-tab-item-1" role="tab" type="button">
                            Tab 1
                        </button>
                        <button aria-controls="card-type-tab-2"
                                class="fc-tab-active:bg-white fc-tab-active:border-b-transparent fc-tab-active:text-primary -mb-px py-3 px-4 inline-flex items-center gap-2 bg-default-50 text-sm font-medium text-center border text-default-500 rounded-t-lg hover:text-default-700"
                                data-fc-target="#card-type-tab-2" id="card-type-tab-item-2" role="tab" type="button">
                            Tab 2
                        </button>
                        <button aria-controls="card-type-tab-3"
                                class="fc-tab-active:bg-white fc-tab-active:border-b-transparent fc-tab-active:text-primary -mb-px py-3 px-4 inline-flex items-center gap-2 bg-default-50 text-sm font-medium text-center border text-default-500 rounded-t-lg hover:text-default-700"
                                data-fc-target="#card-type-tab-3" id="card-type-tab-item-3" role="tab" type="button">
                            Tab 3
                        </button>
                    </nav>
                    <div class="mt-3">
                        <div aria-labelledby="card-type-tab-item-1" id="card-type-tab-1" role="tabpanel">
                            <p class="text-default-500">
                                Tailwind is a utility-first CSS framework that offers an extensive range of
                                classes,
                                including flex, pt-4, text-center, and rotate-90. These classes can be
                                combined to
                                construct any design directly in your markup, allowing you to build your
                                next idea
                                even faster. Along with its efficiency, Tailwind also provides beautifully
                                designed,
                                expertly crafted components and templates, making it the perfect starting
                                point for
                                your next project. With over 200+ professionally designed, fully responsive,
                                expertly crafted component examples at your disposal, you can seamlessly
                                integrate
                                them into your Tailwind projects and customize them according to your
                                preferences.
                            </p>
                        </div>
                        <div aria-labelledby="card-type-tab-item-2" class="hidden" id="card-type-tab-2" role="tabpanel">
                            <p class="text-default-500">
                                Tailwind Elements simplifies the process of adding a dark mode to your
                                project. By
                                utilizing Tailwind's classes and a dark variant, you can effortlessly
                                integrate a
                                dual-themed website. Our components come equipped with the dark theme
                                variant as a
                                default feature. Furthermore, like any Tailwind project, the default theme
                                can be
                                personalized by modifying the project's color palette, type scale, fonts,
                                breakpoints, border radius values, and other attributes through the
                                tailwind.config.js configuration file.
                            </p>
                        </div>
                        <div aria-labelledby="card-type-tab-item-3" class="hidden" id="card-type-tab-3" role="tabpanel">
                            <p class="text-default-500">
                                Tailwind CSS offers a seamless way to build modern websites without having
                                to leave
                                your HTML. The framework functions by scanning all of your HTML files,
                                JavaScript
                                components, and templates for class names, automatically generating
                                corresponding
                                styles, and writing them to a static CSS file. This approach is fast,
                                flexible, and
                                reliable, requiring zero runtime. Whether you need to create form layouts,
                                tables,
                                or modal dialogs, Tailwind CSS provides everything necessary to design
                                beautiful,
                                responsive web applications. Additionally, the framework includes checkout
                                forms,
                                shopping carts, and product views, making it the ideal choice for developing
                                your
                                next e-commerce front-end.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Single Image Lightbox</h4>
                <div data-fc-type="tab">
                    <nav aria-label="Tabs"
                         class="relative z-0 flex border border-default-200 rounded-xl overflow-hidden" role="tablist">
                        <button aria-controls="bar-with-underline-1"
                                class="fc-tab-active:border-b-primary fc-tab-active:text-default-900 relative min-w-0 flex-1 bg-white first:border-s-0 border-s border-default-200 border-b-2 py-4 px-4 text-default-500 hover:text-default-700 text-sm font-medium text-center overflow-hidden hover:bg-default-50 focus:z-10 active"
                                data-fc-target="#bar-with-underline-1" id="bar-with-underline-item-1" role="tab"
                                type="button">
                            Tab 1
                        </button>
                        <button aria-controls="bar-with-underline-2"
                                class="fc-tab-active:border-b-primary fc-tab-active:text-default-900 relative min-w-0 flex-1 bg-white first:border-s-0 border-s border-default-200 border-b-2 py-4 px-4 text-default-500 hover:text-default-700 text-sm font-medium text-center overflow-hidden hover:bg-default-50 focus:z-10"
                                data-fc-target="#bar-with-underline-2" id="bar-with-underline-item-2" role="tab"
                                type="button">
                            Tab 2
                        </button>
                        <button aria-controls="bar-with-underline-3"
                                class="fc-tab-active:border-b-primary fc-tab-active:text-default-900 relative min-w-0 flex-1 bg-white first:border-s-0 border-s border-default-200 border-b-2 py-4 px-4 text-default-500 hover:text-default-700 text-sm font-medium text-center overflow-hidden hover:bg-default-50 focus:z-10"
                                data-fc-target="#bar-with-underline-3" id="bar-with-underline-item-3" role="tab"
                                type="button">
                            Tab 3
                        </button>
                    </nav>
                    <div class="mt-3">
                        <div aria-labelledby="bar-with-underline-item-1" id="bar-with-underline-1" role="tabpanel">
                            <p class="text-default-500">
                                Tailwind is a utility-first CSS framework that offers an extensive range of
                                classes,
                                including flex, pt-4, text-center, and rotate-90. These classes can be
                                combined
                                to
                                construct any design directly in your markup, allowing you to build your
                                next
                                idea
                                even faster. Along with its efficiency, Tailwind also provides beautifully
                                designed,
                                expertly crafted components and templates, making it the perfect starting
                                point
                                for
                                your next project. With over 200+ professionally designed, fully responsive,
                                expertly crafted component examples at your disposal, you can seamlessly
                                integrate
                                them into your Tailwind projects and customize them according to your
                                preferences.
                            </p>
                        </div>
                        <div aria-labelledby="bar-with-underline-item-2" class="hidden" id="bar-with-underline-2"
                             role="tabpanel">
                            <p class="text-default-500">
                                Tailwind Elements simplifies the process of adding a dark mode to your
                                project.
                                By
                                utilizing Tailwind's classes and a dark variant, you can effortlessly
                                integrate
                                a
                                dual-themed website. Our components come equipped with the dark theme
                                variant as
                                a
                                default feature. Furthermore, like any Tailwind project, the default theme
                                can
                                be
                                personalized by modifying the project's color palette, type scale, fonts,
                                breakpoints, border radius values, and other attributes through the
                                tailwind.config.js configuration file.
                            </p>
                        </div>
                        <div aria-labelledby="bar-with-underline-item-3" class="hidden" id="bar-with-underline-3"
                             role="tabpanel">
                            <p class="text-default-500">
                                Tailwind CSS offers a seamless way to build modern websites without having
                                to
                                leave
                                your HTML. The framework functions by scanning all of your HTML files,
                                JavaScript
                                components, and templates for class names, automatically generating
                                corresponding
                                styles, and writing them to a static CSS file. This approach is fast,
                                flexible,
                                and
                                reliable, requiring zero runtime. Whether you need to create form layouts,
                                tables,
                                or modal dialogs, Tailwind CSS provides everything necessary to design
                                beautiful,
                                responsive web applications. Additionally, the framework includes checkout
                                forms,
                                shopping carts, and product views, making it the ideal choice for developing
                                your
                                next e-commerce front-end.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Single Image Lightbox</h4>
                <div data-fc-type="tab">
                    <nav aria-label="Tabs" class="flex space-x-2" role="tablist">
                        <button aria-controls="pills-with-brand-color-1"
                                class="fc-tab-active:bg-primary fc-tab-active:text-white py-3 px-4 inline-flex items-center gap-2 bg-transparent text-sm font-medium text-center text-default-500 rounded-lg hover:text-primary active"
                                data-fc-target="#pills-with-brand-color-1" id="pills-with-brand-color-item-1" role="tab"
                                type="button">
                            Tab 1
                        </button>
                        <button aria-controls="pills-with-brand-color-2"
                                class="fc-tab-active:bg-primary fc-tab-active:text-white py-3 px-4 inline-flex items-center gap-2 bg-transparent text-sm font-medium text-center text-default-500 rounded-lg hover:text-primary"
                                data-fc-target="#pills-with-brand-color-2" id="pills-with-brand-color-item-2" role="tab"
                                type="button">
                            Tab 2
                        </button>
                        <button aria-controls="pills-with-brand-color-3"
                                class="fc-tab-active:bg-primary fc-tab-active:text-white py-3 px-4 inline-flex items-center gap-2 bg-transparent text-sm font-medium text-center text-default-500 rounded-lg hover:text-primary"
                                data-fc-target="#pills-with-brand-color-3" id="pills-with-brand-color-item-3" role="tab"
                                type="button">
                            Tab 3
                        </button>
                    </nav>
                    <div class="mt-3">
                        <div aria-labelledby="pills-with-brand-color-item-1" id="pills-with-brand-color-1"
                             role="tabpanel">
                            <p class="text-default-500">
                                Tailwind is a utility-first CSS framework that offers an extensive range of
                                classes,
                                including flex, pt-4, text-center, and rotate-90. These classes can be
                                combined to
                                construct any design directly in your markup, allowing you to build your
                                next idea
                                even faster. Along with its efficiency, Tailwind also provides beautifully
                                designed,
                                expertly crafted components and templates, making it the perfect starting
                                point for
                                your next project. With over 200+ professionally designed, fully responsive,
                                expertly crafted component examples at your disposal, you can seamlessly
                                integrate
                                them into your Tailwind projects and customize them according to your
                                preferences.
                            </p>
                        </div>
                        <div aria-labelledby="pills-with-brand-color-item-2" class="hidden"
                             id="pills-with-brand-color-2" role="tabpanel">
                            <p class="text-default-500">
                                Tailwind Elements simplifies the process of adding a dark mode to your
                                project. By
                                utilizing Tailwind's classes and a dark variant, you can effortlessly
                                integrate a
                                dual-themed website. Our components come equipped with the dark theme
                                variant as a
                                default feature. Furthermore, like any Tailwind project, the default theme
                                can be
                                personalized by modifying the project's color palette, type scale, fonts,
                                breakpoints, border radius values, and other attributes through the
                                tailwind.config.js configuration file.
                            </p>
                        </div>
                        <div aria-labelledby="pills-with-brand-color-item-3" class="hidden"
                             id="pills-with-brand-color-3" role="tabpanel">
                            <p class="text-default-500">
                                Tailwind CSS offers a seamless way to build modern websites without having
                                to leave
                                your HTML. The framework functions by scanning all of your HTML files,
                                JavaScript
                                components, and templates for class names, automatically generating
                                corresponding
                                styles, and writing them to a static CSS file. This approach is fast,
                                flexible, and
                                reliable, requiring zero runtime. Whether you need to create form layouts,
                                tables,
                                or modal dialogs, Tailwind CSS provides everything necessary to design
                                beautiful,
                                responsive web applications. Additionally, the framework includes checkout
                                forms,
                                shopping carts, and product views, making it the ideal choice for developing
                                your
                                next e-commerce front-end.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="p-6">
                <h4 class="card-title mb-4">Single Image Lightbox</h4>
                <div data-fc-type="tab">
                    <nav aria-label="Tabs" class="flex space-x-2" role="tablist">
                        <button aria-controls="fill-and-justify-1"
                                class="fc-tab-active:bg-primary fc-tab-active:text-white flex-auto py-3 px-4 inline-flex justify-center items-center gap-2 bg-transparent text-center text-sm font-medium text-default-500 rounded-lg hover:text-primary active"
                                data-fc-target="#fill-and-justify-1" role="tab" type="button">
                            Tab 1
                        </button>
                        <button aria-controls="fill-and-justify-2"
                                class="fc-tab-active:bg-primary fc-tab-active:text-white flex-auto py-3 px-4 inline-flex justify-center items-center gap-2 bg-transparent text-center text-sm font-medium text-default-500 rounded-lg hover:text-primary"
                                data-fc-target="#fill-and-justify-2" role="tab" type="button">
                            This is the longest link I've seen
                        </button>
                        <button aria-controls="fill-and-justify-3"
                                class="fc-tab-active:bg-primary fc-tab-active:text-white flex-auto py-3 px-4 inline-flex justify-center items-center gap-2 bg-transparent text-center text-sm font-medium text-default-500 rounded-lg hover:text-primary"
                                data-fc-target="#fill-and-justify-3" role="tab" type="button">
                            Tab 3
                        </button>
                    </nav>
                    <div class="mt-3">
                        <div aria-labelledby="fill-and-justify-item-1" id="fill-and-justify-1" role="tabpanel">
                            <p class="text-default-500">
                                Tailwind is a utility-first CSS framework that offers an extensive range of
                                classes,
                                including flex, pt-4, text-center, and rotate-90. These classes can be
                                combined to
                                construct any design directly in your markup, allowing you to build your
                                next idea
                                even faster. Along with its efficiency, Tailwind also provides beautifully
                                designed,
                                expertly crafted components and templates, making it the perfect starting
                                point for
                                your next project. With over 200+ professionally designed, fully responsive,
                                expertly crafted component examples at your disposal, you can seamlessly
                                integrate
                                them into your Tailwind projects and customize them according to your
                                preferences.
                            </p>
                        </div>
                        <div aria-labelledby="fill-and-justify-item-2" class="hidden" id="fill-and-justify-2"
                             role="tabpanel">
                            <p class="text-default-500">
                                Tailwind Elements simplifies the process of adding a dark mode to your
                                project. By
                                utilizing Tailwind's classes and a dark variant, you can effortlessly
                                integrate a
                                dual-themed website. Our components come equipped with the dark theme
                                variant as a
                                default feature. Furthermore, like any Tailwind project, the default theme
                                can be
                                personalized by modifying the project's color palette, type scale, fonts,
                                breakpoints, border radius values, and other attributes through the
                                tailwind.config.js configuration file.
                            </p>
                        </div>
                        <div aria-labelledby="fill-and-justify-item-3" class="hidden" id="fill-and-justify-3"
                             role="tabpanel">
                            <p class="text-default-500">
                                Tailwind CSS offers a seamless way to build modern websites without having
                                to leave
                                your HTML. The framework functions by scanning all of your HTML files,
                                JavaScript
                                components, and templates for class names, automatically generating
                                corresponding
                                styles, and writing them to a static CSS file. This approach is fast,
                                flexible, and
                                reliable, requiring zero runtime. Whether you need to create form layouts,
                                tables,
                                or modal dialogs, Tailwind CSS provides everything necessary to design
                                beautiful,
                                responsive web applications. Additionally, the framework includes checkout
                                forms,
                                shopping carts, and product views, making it the ideal choice for developing
                                your
                                next e-commerce front-end.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
