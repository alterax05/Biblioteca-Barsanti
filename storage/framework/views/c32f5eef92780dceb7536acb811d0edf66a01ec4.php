<?php $__env->startSection('title', 'Nazioni - Biblioteca'); ?>

<?php $__env->startSection('content'); ?>
    <div class="container col-md-8 col-12 col-lg-8">
        <div class="row">
            <?php $__currentLoopData = $nazioni; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nazione): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-4" style="float:left; margin-top: 30px;">
                <a href="/search/nazione/<?php echo e($nazione->id_nazione); ?>">
                    <div class="cc-card flag-card">
                        <div class="header-card">
                            <img src="/imgs/flags/<?php echo e($nazione->tag); ?>.png"><label><?php echo e(__('nazioni.' . $nazione->nazione)); ?></label>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\vhosts\biblioteca.barsanti.edu.it\httpdocs\resources\views/nazioni.blade.php ENDPATH**/ ?>