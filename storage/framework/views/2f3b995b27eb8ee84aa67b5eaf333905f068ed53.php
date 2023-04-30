<?php $__env->startSection('app_content'); ?>
    <reporttreatmentresult-item :reporttreatmentresult_prop="<?php echo e($reporttreatmentresult->toJson()); ?>"></reporttreatmentresult-item>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Détails Traitement de Rapport"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/reporttreatmentresults/show.blade.php ENDPATH**/ ?>