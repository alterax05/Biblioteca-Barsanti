<?php $__env->startSection('title'); ?>
    <?php echo e(__('profile.profile_of')); ?> <?php echo e(Auth()->user()->name . " " . Auth()->user()->surname); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container col-lg-8" style="margin: 0 auto;">
        <div class="row">
            <div class="col-12" style="padding-right: 7px;">
                <div class="welcome cc-card">
                    <p><?php echo e(__('profile.welcome')); ?> <?php echo e(Auth()->user()->name . " " . Auth()->user()->surname); ?></p>
                    <p><?php echo e(__('profile.class')); ?>: <?php echo e(Auth()->user()->class); ?></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-4">
                <div class="cc-card profile-menu" style="overflow: hidden;">
                    <ul>
                        <a href="/profile" class="<?php if(Route::is('profile.prestiti')): ?> actived <?php endif; ?>"><li><i class="fa-solid fa-rectangle-list"></i> <?php echo e(__('profile.in_corso')); ?></li></a>
                        <a href="/profile/restituiti" class="<?php if(Route::is('profile.restituiti')): ?> actived <?php endif; ?>"><li><i class="fa-solid fa-arrow-right-arrow-left"></i> <?php echo e(__('profile.returned')); ?></li></a>
                        <a href="/profile/preferiti" class="<?php if(Route::is('profile.preferiti')): ?> actived <?php endif; ?>"><li><i class="fa-solid fa-star"></i> <?php echo e(__('profile.favourites')); ?></li></a>
                        <a href="/profile/prenotati" class="<?php if(Route::is('profile.prenotati')): ?> actived <?php endif; ?>"><li><i class="fa-solid fa-calendar-week"></i> <?php echo e(__('profile.booked')); ?></li></a>
                    </ul>
                </div>
            </div>

            <?php echo $__env->yieldContent('profile-content'); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <?php if(!empty($_GET['orderby'])): ?>
        <script>
            $(document).ready(function() {
                $('#orderForm select').val("<?php echo e($_GET['orderby']); ?>");
            });
        </script>
    <?php endif; ?>
    <script src="/js/app.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\vhosts\biblioteca.barsanti.edu.it\httpdocs\resources\views/template/profile.blade.php ENDPATH**/ ?>