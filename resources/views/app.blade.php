<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upskillify</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    <!-- Ensure the root element exists and contains the data-page attribute -->
    <div id="app" data-page="{{ json_encode($page) }}"></div>
</body>
</html>
