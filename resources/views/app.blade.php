<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
@inertiaHead

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Upskillify</title>
    @routes
    @vite(['resources/js/app.js']) <!-- Make sure this comes after the routes are injected -->
</head>
<body>
    @inertia
    <div id="app" data-page="{{ json_encode($page) }}"></div>
</body>
</html>
