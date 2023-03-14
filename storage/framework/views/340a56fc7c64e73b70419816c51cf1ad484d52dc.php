<?php $__env->startSection('app_content'); ?>
    <accessaccount-index :accessaccounts_prop="<?php echo e($accessaccounts->toJson()); ?>"></accessaccount-index>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Comptes d'Accès"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/accessaccounts/index.blade.php ENDPATH**/ ?>