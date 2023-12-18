<?php $__env->startSection('app_content'); ?>
    <treatmentoperation-item :treatmentoperation_prop="<?php echo e($treatmentoperation->toJson()); ?>"></treatmentoperation-item>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Détails Operation de Traitement"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/treatmentoperations/show.blade.php ENDPATH**/ ?>