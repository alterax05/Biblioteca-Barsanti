<?php $__env->startSection('admin-content'); ?>
    <h5>Lista delle prenotazioni</h5>
    <div class="libri">
        <?php $__currentLoopData = $prestiti; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $libro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="libro row cc-card spacer-card">
                <div class="col-2">
                    <a href="/book/<?php echo e($libro->ISBN); ?>">
                        <img style="width: 100%" onerror="imgError(this)" src="https://pictures.abebooks.com/isbn/<?php echo e($libro->ISBN); ?>-us-300.jpg" alt="cover">
                    </a>
                </div>
                <div class="col-9 row">
                    <div class="col-8">
                        <p class="<?php echo e((strlen($libro->titolo) > 100)? 'too-long': ''); ?>"><a href="/book/<?php echo e($libro->ISBN); ?>"><?php echo e($libro->titolo); ?></a></p>
                        <p><?php if(count($libro->belongsAutori) != 0): ?>
                                di
                                <?php $__currentLoopData = $libro->belongsAutori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="/search/autore/<?php echo e($autore->belongsAutore->id_autore); ?>?page=1"><?php echo e($autore->belongsAutore->autore); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </p>
                        <!--<p><a href="?editore=<?php echo e($libro->belongsEditore->id_editore); ?>&page=1"><?php echo e($libro->belongsEditore->editore); ?></a>, <?php echo e($libro->anno_stampa); ?></p>-->
                        <p style="margin-top: 10px;font-size: 15px;">Prenotato da: <?php echo e($libro->name); ?> <?php echo e($libro->surname); ?> (<b><?php echo e($libro->class); ?></b>)</p>
                    </div>
                    <div class="col-4 dettagli" style="margin-top: 0;">
                        <p><b>Data prenotazione:</b> <?php echo e($libro->created_at); ?></p>
                        <p><b>Scaffale:</b> <?php echo e($libro->scaffale); ?>, ripiano: <?php echo e($libro->ripiano); ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php if(count($prestiti) == 0): ?> <p>Non ci sono prenotazioni in corso!</p> <?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('style'); ?>
    <style>
        .dettagli > p {
            font-size: 13px;
            margin-bottom: 5px;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\vhosts\biblioteca.barsanti.edu.it\httpdocs\resources\views/admin/prenota.blade.php ENDPATH**/ ?>