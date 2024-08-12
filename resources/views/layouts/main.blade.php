<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Laravel')</title>

    {{-- CSS --}}
    @include('components.ext_css.ext_css')

    {{-- JS --}}
    @include('components.ext_js.ext_js')

    @stack('style')
</head>

<body>
    @if (auth()->check())
        @include('components.navbar')
    @endif

    @yield('content')

    @stack('script')
</body>

</html>
