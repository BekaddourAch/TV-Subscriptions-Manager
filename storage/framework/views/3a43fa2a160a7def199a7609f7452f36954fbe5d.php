<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Laravel 9 & Laratrust Application">
        <meta name="author" content="Yaser Alshikh">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <link rel="shortcut icon" href="<?php echo e(asset('favicon.ico')); ?>">

        <title><?php echo e(config('app.name', 'Laravel')); ?> - Admin Dashboard</title>

        <!-- Custom fonts for this template-->
        <link href="<?php echo e(asset('backend/vendor/fontawesome-free/css/all.min.css')); ?>" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">
        <link href="<?php echo e(asset('backend/css/sb-admin-2.min.css')); ?>" rel="stylesheet">
    </head>
    <body class="bg-gradient-primary">

        <div class="container">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <!-- Scripts -->
        <script src="<?php echo e(mix('js/app.js')); ?>"></script>
        <?php echo $__env->yieldContent('script'); ?>
    </body>
</html>
<?php /**PATH C:\xampp\htdocs\tv-subscriptions-management\resources\views/layouts/admin-auth.blade.php ENDPATH**/ ?>