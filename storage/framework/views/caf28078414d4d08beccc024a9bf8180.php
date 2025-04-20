<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Upskillify</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?> <!-- Make sure this comes after the routes are injected -->
</head>
<body>
    <?php if (!isset($__inertiaSsrDispatched)) { $__inertiaSsrDispatched = true; $__inertiaSsrResponse = app(\Inertia\Ssr\Gateway::class)->dispatch($page); }  if ($__inertiaSsrResponse) { echo $__inertiaSsrResponse->body; } else { ?><div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div><?php } ?>
    <?php echo app('Tighten\Ziggy\BladeRouteGenerator')->generate(); ?> <!-- This will inject the routes from Ziggy into your JavaScript -->
    <div id="app" data-page="<?php echo e(json_encode($page)); ?>"></div>
</body>
</html>
<?php /**PATH /Users/mikaelachausheva/Documents/MasterDegree/upskillify/resources/views/app.blade.php ENDPATH**/ ?>