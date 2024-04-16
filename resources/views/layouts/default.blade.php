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
        @include('layouts.menu')
    @endif
</header>

<div class="container1">
    @yield('content')
</div>

<footer>
    @if($footer)
        @include('layouts.footer')
    @endif
</footer>
</body>
</html>
