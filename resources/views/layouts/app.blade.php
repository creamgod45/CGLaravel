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
    @include('layouts.menu')
</header>

<div class="container">
    @yield('content')
</div>

<footer>
    @include('layouts.footer')
</footer>
</body>
</html>
