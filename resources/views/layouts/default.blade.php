@vite(['resources/css/app.css', 'resources/js/app.js'])
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- Link to CSS -->
</head>
<body>
<header>
    @if($menu)
        @include('Components.menu')
    @endif
</header>

<div class="container">
    @yield('content')
</div>

<footer>
    @if($footer)
        @include('Components.footer')
    @endif
</footer>
</body>
</html>
