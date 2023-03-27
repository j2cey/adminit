<?php $__env->startSection('app_content'); ?>
    <reportfile-item :reportfile_prop="<?php echo e($reportfile->toJson()); ?>"></reportfile-item>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Détails Fichier " . $reportfile->name], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/reportfiles/show.blade.php ENDPATH**/ ?>