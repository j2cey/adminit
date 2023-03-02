<?php $__env->startSection('app_content'); ?>

    <section class="section">

        <div class="container">
            <subject-create :subject_prop="<?php echo e($subject->toJson()); ?>"></subject-create>
        </div>

    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/adminit/resources/views/subjects/edit.blade.php ENDPATH**/ ?>