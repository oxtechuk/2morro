@extends('shared.vertical', ['title' => 'Dashboard'])



@section('styles')

@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Components', 'title' => 'Button'])

    <div class="grid 2xl:grid-cols-2 grid-cols-1 gap-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Default Buttons</h4>
            </div>
            <div class="p-5">
                <div class="flex flex-wrap items-center gap-3">
                    <button class="btn bg-primary text-white" type="button">Primary</button>
                    <button class="btn bg-success text-white" type="button">Success</button>
                    <button class="btn bg-info text-white" type="button">Info</button>
                    <button class="btn bg-warning text-white" type="button">Warning</button>
                    <button class="btn bg-danger text-white" type="button">Danger</button>
                    <button class="btn bg-dark text-white" type="button">Dark</button>
                    <button class="btn bg-secondary text-white" type="button">Secondary</button>
                    <button class="btn bg-light text-default-900" type="button">Light</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="p-5">
                <h4 class="card-title mb-4">Rounded Button</h4>
                <div class="flex flex-wrap items-center gap-3">
                    <button class="btn bg-primary text-white rounded-full" type="button">Primary</button>
                    <button class="btn bg-success text-white rounded-full" type="button">Success</button>
                    <button class="btn bg-info text-white rounded-full" type="button">Info</button>
                    <button class="btn bg-warning text-white rounded-full" type="button">Warning</button>
                    <button class="btn bg-danger text-white rounded-full" type="button">Danger</button>
                    <button class="btn bg-dark text-white rounded-full" type="button">Dark</button>
                    <button class="btn bg-secondary text-white rounded-full" type="button">Secondary</button>
                    <button class="btn bg-light text-default-900 rounded-full" type="button">Light</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="p-5">
                <h4 class="card-title mb-4">Otline Buttons</h4>
                <div class="flex flex-wrap items-center gap-3">
                    <button class="btn border-primary text-primary hover:bg-primary hover:text-white" type="button">
                        Primary
                    </button>
                    <button class="btn border-success text-success hover:bg-success hover:text-white" type="button">
                        Success
                    </button>
                    <button class="btn border-info text-info hover:bg-info hover:text-white" type="button">Info</button>
                    <button class="btn border-warning text-warning hover:bg-warning hover:text-white" type="button">
                        Warning
                    </button>
                    <button class="btn border-danger text-danger hover:bg-danger hover:text-white" type="button">
                        Danger
                    </button>
                    <button class="btn border-dark text-default-900 hover:bg-dark hover:text-white" type="button">Dark
                    </button>
                    <button class="btn border-secondary text-secondary hover:bg-secondary hover:text-white"
                            type="button">Secondary
                    </button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="p-5">
                <h4 class="card-title mb-4">Outline Rounded Buttons</h4>
                <div class="flex flex-wrap items-center gap-3">
                    <button
                        class="btn rounded-full border border-primary text-primary hover:bg-primary hover:text-white"
                        type="button">Primary
                    </button>
                    <button
                        class="btn rounded-full border border-success text-success hover:bg-success hover:text-white"
                        type="button">Success
                    </button>
                    <button class="btn rounded-full border border-info text-info hover:bg-info hover:text-white"
                            type="button">Info
                    </button>
                    <button
                        class="btn rounded-full border border-warning text-warning hover:bg-warning hover:text-white"
                        type="button">Warning
                    </button>
                    <button class="btn rounded-full border border-danger text-danger hover:bg-danger hover:text-white"
                            type="button">Danger
                    </button>
                    <button class="btn rounded-full border border-dark text-default-900 hover:bg-dark hover:text-white"
                            type="button">Dark
                    </button>
                    <button
                        class="btn rounded-full border border-secondary text-secondary hover:bg-secondary hover:text-white"
                        type="button">Secondary
                    </button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="p-5">
                <h4 class="card-title mb-4">Soft Buttons</h4>
                <div class="flex flex-wrap items-center gap-3">
                    <button class="btn bg-primary/25 text-primary hover:bg-primary hover:text-white" type="button">
                        Primary
                    </button>
                    <button class="btn bg-success/25 text-success hover:bg-success hover:text-white" type="button">
                        Success
                    </button>
                    <button class="btn bg-info/25 text-info hover:bg-info hover:text-white" type="button">Info</button>
                    <button class="btn bg-warning/25 text-warning hover:bg-warning hover:text-white" type="button">
                        Warning
                    </button>
                    <button class="btn bg-danger/25 text-danger hover:bg-danger hover:text-white" type="button">Danger
                    </button>
                    <button class="btn bg-dark/25 text-white hover:bg-dark" type="button">Dark</button>
                    <button class="btn bg-secondary/25 text-secondary hover:bg-secondary hover:text-white"
                            type="button">Secondary
                    </button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="p-5">
                <h4 class="card-title mb-4">Soft Rounded Buttons</h4>
                <div class="flex flex-wrap items-center gap-3">
                    <button class="btn rounded-full bg-primary/25 text-primary hover:bg-primary hover:text-white"
                            type="button">Primary
                    </button>
                    <button class="btn rounded-full bg-success/25 text-success hover:bg-success hover:text-white"
                            type="button">Success
                    </button>
                    <button class="btn rounded-full bg-info/25 text-info hover:bg-info hover:text-white" type="button">
                        Info
                    </button>
                    <button class="btn rounded-full bg-warning/25 text-warning hover:bg-warning hover:text-white"
                            type="button">Warning
                    </button>
                    <button class="btn rounded-full bg-danger/25 text-danger hover:bg-danger hover:text-white"
                            type="button">Danger
                    </button>
                    <button class="btn rounded-full bg-dark/25 text-default-900 hover:bg-dark hover:text-white"
                            type="button">Dark
                    </button>
                    <button class="btn rounded-full bg-secondary/25 text-secondary hover:bg-secondary hover:text-white"
                            type="button">Secondary
                    </button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="p-5">
                <h4 class="card-title mb-4">Buttons with Icon</h4>
                <div class="flex flex-wrap items-center gap-3">
                    <button class="btn bg-primary text-white" type="button">
                        <i class="iconify tabler--check text-base me-4"></i> Primary
                    </button>
                    <button class="btn bg-success text-white" type="button">
                        <i class="iconify tabler--check text-base me-4"></i> Success
                    </button>
                    <button class="btn bg-info text-white" type="button">
                        <i class="iconify tabler--info-circle text-base me-4"></i> Info
                    </button>
                    <button class="btn bg-warning text-white" type="button">
                        <i class="iconify tabler--alert-triangle text-base me-4"></i> Warning
                    </button>
                    <button class="btn bg-danger text-white" type="button">
                        <i class="iconify tabler--brand-x text-base me-4"></i> Danger
                    </button>
                    <button class="btn bg-dark text-white" type="button">
                        <i class="iconify tabler--check text-base me-4"></i> Dark
                    </button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="p-5">
                <h4 class="card-title mb-4">Sizes</h4>
                <div class="flex items-center gap-2">
                    <button class="btn btn-sm bg-primary text-white" type="button">Small</button>
                    <button class="btn bg-primary text-white" type="button">Large</button>
                    <button class="btn btn-lg bg-primary text-white" type="button">Default</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="p-5">
                <h4 class="card-title mb-4">Block Button</h4>
                <div class="flex flex-col gap-2">
                    <button class="btn w-full bg-primary text-white" type="button">Default</button>
                    <button class="btn w-full border-primary text-primary" type="button">Default</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="p-5">
                <h4 class="card-title mb-4">Disabled</h4>
                <div class="flex flex-wrap gap-3">
                    <button class="btn bg-primary text-white" disabled="" type="button">Disabled</button>
                    <button class="btn border-primary text-primary" disabled="" type="button">Disabled</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
