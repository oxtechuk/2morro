@extends('shared.vertical', ['title' => 'Breadcrumb'])



@section('styles')

@endsection

@section('content')
    @include('shared.partials.page-title', ['subtitle' => 'Components', 'title' => 'Breadcrumb'])

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h5 class="text-lg font-medium text-default-950">Simple</h5>
            </div>
            <div class="card-body">
                <nav aria-label="Breadcrumb" class="flex">
                    <ol class="flex items-center text-sm font-semibold space-x-4" role="list">
                        <li>
                            <div class="flex items-center">
                                <a class="text-default-600 hover:text-default-900" href="#">
                                    <i class="iconify tabler--home text-lg/3 flex-shrink-0"></i>
                                    <a class="ms-2 text-sm font-medium text-default-600 hover:text-default-900"
                                       href="#">Opatix</a>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="iconify tabler--chevron-right text-lg flex-shrink-0 text-default-600"></i>
                                <a class="ms-4 text-sm font-medium text-default-600 hover:text-default-900" href="#">Admin</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <i class="iconify tabler--chevron-right text-lg flex-shrink-0 text-default-600"></i>
                                <a aria-current="page"
                                   class="ms-4 text-sm font-medium text-default-600 hover:text-default-900" href="#">Dashboard</a>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="card">
            <div class="card-header flex items-center justify-between">
                <h5 class="text-lg font-medium text-default-950">Example</h5>
            </div>
            <div class="card-body">
                <ol aria-label="Breadcrumb" class="flex items-center whitespace-nowrap min-w-0">
                    <li class="text-sm text-default-600">
                        <a class="flex items-center font-medium hover:text-primary-600" href="#">
                            Opatix
                            <span class="mx-2">/</span>
                        </a>
                    </li>
                    <li class="text-sm text-default-600">
                        <a class="flex items-center font-medium hover:text-primary-600" href="#">
                            Admin
                            <span class="mx-2">/</span>
                        </a>
                    </li>
                    <li aria-current="page" class="text-sm font-semibold text-default-800 truncate">
                        Dashboard
                    </li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
