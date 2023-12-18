<?php $__env->startSection('app_content'); ?>
    <reporttreatment-item :reporttreatment_prop="<?php echo e($reporttreatment->toJson()); ?>"></reporttreatment-item>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Détails Traitement de Rapport"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/reporttreatments/show.blade.php ENDPATH**/ ?>