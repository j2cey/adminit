<?php $__env->startSection('app_content'); ?>
    <collectedreportfile-item :report_prop="<?php echo e($report->toJson()); ?>" :collectedreportfile_prop="<?php echo e($collectedreportfile->toJson()); ?>"></collectedreportfile-item>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Détails Fichier Téléchargé " . $collectedreportfile->local_file_name], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/collectedreportfiles/show.blade.php ENDPATH**/ ?>