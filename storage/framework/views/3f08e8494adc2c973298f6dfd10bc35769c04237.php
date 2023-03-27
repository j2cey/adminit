<?php $__env->startSection('app_content'); ?>
    <reportfile-index :report_prop="<?php echo e($report->toJson()); ?>" :reportfiles_prop="<?php echo e($report->reportfiles->toJson()); ?>"></reportfile-index>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Fichiers du Rapport"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/reportfiles/index.blade.php ENDPATH**/ ?>