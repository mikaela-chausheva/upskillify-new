<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upskillify</title>
    @vite(['resources/js/app.js']) <!-- Make sure this comes after the routes are injected -->
</head>
<body>
    @inertia
    @routes <!-- This will inject the routes from Ziggy into your JavaScript -->
    <div id="app" data-page="{{ json_encode($page) }}"></div>
</body>
</html>
