<!DOCTYPE html>

<html @yield('html_attribute')>
<head>
    @include('shared.partials/title-meta')

    @yield('styles')

    @include('shared.partials/head-css')
</head>
<body>
<div class="wrapper">

    @include('shared.partials/sidenav')

    <div class="page-content">
        
        @include('shared.partials/topbar')

        <main>

            @yield('content')

        </main>

        @include('shared.partials/footer')

    </div>

</div>

@include('shared.partials/footer-scripts')

@yield('scripts')

</body>
</html>
