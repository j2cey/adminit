<?php $__env->startSection('app_content'); ?>
    <treatment-details :treatment_prop="<?php echo e($treatment->toJson()); ?>" :subtreatments_prop="<?php echo e($subtreatments->toJson()); ?>"></treatment-details>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Treatment Details"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/treatments/show.blade.php ENDPATH**/ ?>