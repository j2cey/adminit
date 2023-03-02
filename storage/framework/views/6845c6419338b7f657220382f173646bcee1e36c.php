<?php $__env->startSection('app_content'); ?>
    <systems-index :statuses_prop="<?php echo e($statuses->toJson()); ?>" :settings_grouped_prop="<?php echo e(json_encode($settings_grouped)); ?>" :settings_prop="<?php echo e($settings->toJson()); ?>" :roles_prop="<?php echo e($roles->toJson()); ?>" :users_prop="<?php echo e($users->toJson()); ?>"></systems-index>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "System"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/systems/index.blade.php ENDPATH**/ ?>