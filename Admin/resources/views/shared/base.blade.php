<!DOCTYPE html>

<html @yield('html_attribute') lang="en">
    
<head>
    @include('shared.partials/title-meta')

    @yield('styles')

    @include('shared.partials/head-css')

</head>
<body @yield('body_attribute')>

@yield('content')

@yield('scripts')

</body>
</html>
