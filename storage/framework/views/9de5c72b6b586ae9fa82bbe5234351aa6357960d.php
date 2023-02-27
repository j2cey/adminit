<?php $__env->startSection('content'); ?>

    <!-- Navbar -->
    <?php echo $__env->make('layouts.admin02.nav.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- /.navbar -->

    <!-- Content Wrapper. Contains page content -->
    <?php echo $__env->make('layouts.admin02.content', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <?php echo $__env->make('layouts.admin02.controlbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- /.control-sidebar -->

    <!-- Admin Footer -->
    <?php echo $__env->make('layouts.admin02.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.core.app02', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/admin02.blade.php ENDPATH**/ ?>