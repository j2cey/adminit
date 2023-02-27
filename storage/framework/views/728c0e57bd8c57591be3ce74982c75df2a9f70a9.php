<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
        <?php if(auth()->guard()->guest()): ?>
            <a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
        <?php else: ?>
            <h5><?php echo e(Auth::user()->name); ?></h5>
            <a class="d-block" href="javascript:{}" onclick="document.getElementById('logout-form').submit();">Logout</a>
            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                <?php echo csrf_field(); ?><a class="nav-link" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
            </form>
        <?php endif; ?>
    </div>
</aside>
<?php /**PATH /var/www/adminit/resources/views/layouts/admin02/controlbar.blade.php ENDPATH**/ ?>