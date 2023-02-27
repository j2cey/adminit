<?php $__env->startSection('app_content'); ?>
    <reports-details :report_prop="<?php echo e($report->toJson()); ?>"></reports-details>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Report Details"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/reports/show.blade.php ENDPATH**/ ?>