<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    @include('includes.meta')

    <title>{{ $title ?? 'SPA Page' }}</title>
    <!-- Vite Bundle -->
    @vite(['resources/css/app.css'])
    @vite(['resources/js/app.js'])
</head>
<body>
    @persist('header')
    @include('includes.header')
    @endpersist

    <main>
        {{ $slot }}
    </main>

    @persist('footer')
    @include('includes.footer')
    @endpersist
</body>
</html>
