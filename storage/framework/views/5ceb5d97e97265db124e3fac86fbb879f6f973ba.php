<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card cc-card" style="border: none;">
                <div class="card-header"><?php echo e(__('auth.title')); ?></div>
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <label class="is-invalid-email"><i class="fa-solid fa-triangle-exclamation"></i> <?php echo e($message); ?></label>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                <div class="card-body">
                    <div class="col-lg-12 col-10 col-md-10 row" style="margin: 0 auto;text-align: center;">
                        <label style="margin-bottom: 20px;"><?php echo e(__("auth.guida")); ?></label>
                    </div>
                    <a href="/login/redirect">
                        <div class="google-button col-md-10 col-lg-10 col-12 row">
                            <div class="cc-card btn-card row">
                                <i class="fa-brands fa-google col-2"></i>
                                <p class="col-10"><?php echo e(__('auth.google')); ?></p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\vhosts\biblioteca.barsanti.edu.it\httpdocs\resources\views/auth/login.blade.php ENDPATH**/ ?>