<?php $__env->startSection('title', 'Admin - Biblioteca'); ?>

<?php $__env->startSection('admin-content'); ?>
    <?php $__currentLoopData = $libri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $libro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="row cc-card d-flex" style="margin-bottom: 20px; padding: 10px 20px; <?php echo ($libro->id_libro < 100)? 'background: #b009094f;':'background: #b077094f;'; ?>">
            <div class="col-8 align-self-center" style="height: fit-content">
                <p><?php echo e($libro->titolo); ?></p>
                <p style="font-size: 14px"><?php echo e($libro->ISBN); ?></p>
            </div>
            <div class="col-4">
                <label style="font-size: 14px; margin-bottom: 10px;"><?php echo ($libro->id_libro < 100)? '<i class="fas fa-hashtag"></i> Non catalogato':'<i class="fas fa-user"></i> Autore mancante'; ?></label>
                <a href="/admin/book/<?php echo e($libro->ISBN); ?>/<?php echo e($libro->id_libro); ?>">
                    <button class="btn btn-primary">Completa</button>
                </a>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mikyp\Downloads\backup_biblioteca.barsanti.edu.it\httpdocs\resources\views/admin/completi.blade.php ENDPATH**/ ?>