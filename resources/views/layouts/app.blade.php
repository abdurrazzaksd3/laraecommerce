<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <meta name="description" content="@yield('meta_description')">
    <meta name="keyword" content="@yield('meta_keyword')">
    <meta name="description" content="laravel Ecommerce')">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net"> 
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- style -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- custom css -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

    @livewireStyles
</head>
<body>
    <div id="app">

        @include('layouts.inc.frontend.navbar')
        
        <main>
            @yield('content')
        </main>
    </div>

    <!-- script -->
    
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    
    
    @livewireScripts
</body>
</html>
