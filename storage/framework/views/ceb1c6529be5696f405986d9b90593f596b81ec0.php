

<?php $__env->startSection('app_content'); ?>
<dynamicattribute-item :model_prop="<?php echo e($model->toJson()); ?>" :dynamicattribute_prop="<?php echo e($dynamicattribute->toJson()); ?>"></dynamicattribute-item>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Détails Champs de Rapport"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/dynamicattributes/show.blade.php ENDPATH**/ ?>