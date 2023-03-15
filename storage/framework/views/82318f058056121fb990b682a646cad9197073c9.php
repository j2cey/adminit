<?php $__env->startSection('app_content'); ?>
    <reportserver-index :reportservers_prop="<?php echo e($reportservers->toJson()); ?>"></reportserver-index>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Rapport de serveurs"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/reportservers/index.blade.php ENDPATH**/ ?>