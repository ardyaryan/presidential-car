<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    @section('head')
    {{ HTML::style('public/css/style.css'); }}
    @show
</head>
<body>
@yield('body')
</body>
</html>