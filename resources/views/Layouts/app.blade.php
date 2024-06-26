<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body class="antialiased">
    <div class="" id="app">
        @include('includes.navbar')
        <div class="container mt-4" >
            @yield('content')
        </div>
    </div>
</body>
</html>
