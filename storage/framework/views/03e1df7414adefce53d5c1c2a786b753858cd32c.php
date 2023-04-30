<?php $__env->startSection('app_content'); ?>
    <reporttreatmentresult-list :reporttreatmentresults_prop="<?php echo e($reporttreatmentresults->toJson()); ?>"></reporttreatmentresult-list>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Traitements Rapports"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/reporttreatmentresults/index.blade.php ENDPATH**/ ?>