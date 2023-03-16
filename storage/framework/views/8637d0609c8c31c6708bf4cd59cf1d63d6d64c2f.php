<?php $__env->startSection('app_content'); ?>
    <reportsetting-index :filemimetypes_prop="<?php echo e($filemimetypes->toJson()); ?>" :reportfiletypes_prop="<?php echo e($reportfiletypes->toJson()); ?>" :accessprotocoles_prop="<?php echo e($accessprotocoles->toJson()); ?>" :osservers_prop="<?php echo e($osservers->toJson()); ?>"></reportsetting-index>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Paramètres"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/reportsetting/index.blade.php ENDPATH**/ ?>