<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <title>@yield('title')</title>
</head>
<body>
@if($menu)
    @include('layouts.menu')
@endif

@yield('content')

@include('layouts.notification')
@if($footer)
    @include('layouts.footer')
@endif
</body>
</html>
