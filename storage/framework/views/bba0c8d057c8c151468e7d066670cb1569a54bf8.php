<?php $__env->startSection('title', 'Autori - Biblioteca'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container row col-lg-8 lettere-cont" style="margin: 0 auto;">
        <div class="cc-card" style="overflow: hidden">
            <div class="lettere">
                <?php $__currentLoopData = $lettere; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="/autori/<?php echo e($letter); ?>" class="<?php if($letter == $lettera): ?> actived <?php endif; ?>"><?php echo e($letter); ?></a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <div class="autori row">
                <?php $__currentLoopData = $autori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-4 d-flex flex-column">
                    <?php $__currentLoopData = $a; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="/search/autore/<?php echo e($autore['id_autore']); ?>"><?php echo e($autore['autore']); ?> (<?php echo e($autore['libri']); ?>)</a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\vhosts\biblioteca.barsanti.edu.it\httpdocs\resources\views/autori.blade.php ENDPATH**/ ?>