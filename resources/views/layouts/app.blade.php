<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('favicon.ico')}}">
    <link rel="icon" type="image/png" href="{{asset('favicon.ico')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('includes.meta')

    <!-- Shortcut Icon -->
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}">
    <link rel="icon" type="image/ico" href="{{asset('favicon.ico')}}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Vite Bundle -->
    @vite(['resources/css/app.css'])
    @vite(['resources/js/app.js'])
</head>

<body>
    @include('includes.header')

    <main>
        @yield('content')
    </main>

    @include('includes.footer')

    <!-- Scripts -->
    @stack('scripts')

{{-- 컴포넌트로 써도 되고 content blade에 section 추가해도 되고--}}
    @include('components.modals')
{{--    @yield('modals')--}}
</body>

</html>
