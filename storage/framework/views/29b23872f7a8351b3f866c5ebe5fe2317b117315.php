<?php $__env->startSection('app_content'); ?>
    <reporttreatmentstep-item :reporttreatmentstep_prop="<?php echo e($reporttreatmentstep->toJson()); ?>"></reporttreatmentstep-item>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Détails Etape de Traitement de Rapport"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/reporttreatmentsteps/show.blade.php ENDPATH**/ ?>