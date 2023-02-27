<?php $__env->startSection('content'); ?>

    <!-- Navbar -->
    <?php echo $__env->make('layouts.admin02.nav.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- /.navbar -->

    <div class="content-wrapper" style="min-height: 346px;">
        <div class="container">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h5 class="m-0 text-dark"><?php echo e($page_title); ?></h5>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <?php $__currentLoopData = Breadcrumbs::current(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crumbs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($crumbs->url() && !$loop->last): ?>
                                        <li class="breadcrumb-item text-xs">
                                            <a href="<?php echo e($crumbs->url()); ?>">
                                                <?php echo e($crumbs->title()); ?>

                                            </a>
                                        </li>
                                    <?php else: ?>
                                        <li class="breadcrumb-item active text-xs">
                                            <?php echo e($crumbs->title()); ?>

                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- /.content -->
                <?php echo $__env->yieldContent('app_content'); ?>

                <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <?php echo $__env->make('layouts.admin02.controlbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- /.control-sidebar -->

    <!-- Admin Footer -->
    <?php echo $__env->make('layouts.admin02.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.core.app02', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/app.blade.php ENDPATH**/ ?>