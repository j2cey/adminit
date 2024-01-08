<?php $__env->startSection('app_content'); ?>
    <treatment-index :treatments_prop="<?php echo e($treatments->toJson()); ?>" :waiting_count_prop="<?php echo e($waiting_count); ?>" :queued_count_prop="<?php echo e($queued_count); ?>" :running_count_prop="<?php echo e($running_count); ?>" :retrying_count_prop="<?php echo e($retrying_count); ?>" :success_count_prop="<?php echo e($success_count); ?>" :failed_count_prop="<?php echo e($failed_count); ?>" ></treatment-index>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Traitements Rapports"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/treatments/index.blade.php ENDPATH**/ ?>