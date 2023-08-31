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

      <!-- Owl Carousel  -->
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">

    <!-- custom css -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>

    

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
    
    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <script>

        window.addEventListener('message', event => {           
        alertify.set('notifier','position', 'top-right');
        alertify.notify(event.detail.text, event.detail.type);
        });
    </script>

    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    @yield('script')
    
    @livewireScripts
</body>
</html>
