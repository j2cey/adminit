<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Admin-IT')); ?></title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- bootstrap slider -->
    <link href="<?php echo e(asset('AdminLTE/plugins/bootstrap-slider/css/bootstrap-slider.min.css')); ?>" rel="stylesheet">

    <!-- Buefy -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@5.8.55/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">

    <script type="text/javascript">
        window.Laravel = {
            csrfToken: "<?php echo e(csrf_token()); ?>",
            jsPermissions: <?php echo auth()->check()?auth()->user()->jsPermissions():0; ?>

        }
    </script>

    <script>
        <?php if(auth()->guard()->check()): ?>
            window.Permissions = <?php echo json_encode(Auth::user()->allPermissions, true); ?>;
        <?php else: ?>
            window.Permissions = [];
        <?php endif; ?>
    </script>
</head>


<body class="hold-transition layout-top-nav">

<!-- wrapper -->
<div class="wrapper" id="app">
    <?php echo $__env->yieldContent('content'); ?>

    <vue-noty></vue-noty>
</div>
<!-- ./wrapper -->

<script src="<?php echo e(asset('AdminLTE/plugins/jquery/jquery.min.js')); ?>"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo e(asset('AdminLTE/plugins/jquery-ui/jquery-ui.min.js')); ?>"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>

<!-- Scripts -->
<script src="<?php echo e(asset('js/app.js')); ?>" defer></script>
<!-- bs-custom-file-input -->
<script src="<?php echo e(asset('AdminLTE/plugins/bs-custom-file-input/bs-custom-file-input.min.js')); ?>" defer></script>
<!-- SweetAlert2 -->
<script src="<?php echo e(asset('AdminLTE/plugins/sweetalert2/sweetalert2.min.js')); ?>"></script>
<!-- Toastr -->
<script src="<?php echo e(asset('AdminLTE/plugins/toastr/toastr.min.js')); ?>"></script>
<!-- AdminLTE Customization -->
<script src="<?php echo e(asset('AdminLTE/dist/js/demo.js')); ?>"></script>

<!-- Bootstrap slider -->
<script src="<?php echo e(asset('AdminLTE/plugins/bootstrap-slider/bootstrap-slider.min.js')); ?>"></script>

</body>

</html>
<?php /**PATH /var/www/adminit/resources/views/layouts/core/app02.blade.php ENDPATH**/ ?>