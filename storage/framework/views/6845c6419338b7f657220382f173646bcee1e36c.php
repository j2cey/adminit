<?php $__env->startSection('app_content'); ?>
    <systems-index :statuses_prop="<?php echo e($statuses->toJson()); ?>" :settings_grouped_prop="<?php echo e(json_encode($settings_grouped)); ?>" :permissions_prop="<?php echo e($permissions->toJson()); ?>" :roles_prop="<?php echo e($roles->toJson()); ?>" :users_prop="<?php echo e($users->toJson()); ?>"></systems-index>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', ['page_title' => "Système"], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/systems/index.blade.php ENDPATH**/ ?>