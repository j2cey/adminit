<?php $__env->startSection('app_content'); ?>
    <reporttreatment-list :reporttreatments_prop="<?php echo e($reporttreatments->toJson()); ?>" :waiting_prop="<?php echo e($waiting); ?>" :queued_prop="<?php echo e($queued); ?>" :running_prop="<?php echo e($running); ?>" :retrying_prop="<?php echo e($retrying); ?>" :success_prop="<?php echo e($success); ?>" :failed_prop="<?php echo e($failed); ?>"></reporttreatment-list>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Traitements Rapports"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/reporttreatments/index.blade.php ENDPATH**/ ?>