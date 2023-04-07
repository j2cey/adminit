<?php $__env->startSection('app_content'); ?>
    <reportattribute-index :report_prop="<?php echo e($report->toJson()); ?>" :reportattributes_prop="<?php echo e($dynamicattributes->toJson()); ?>"></reportattribute-index>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Champs du Rapport"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/dynamicattributes/index.blade.php ENDPATH**/ ?>