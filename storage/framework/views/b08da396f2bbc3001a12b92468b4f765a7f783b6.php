<?php $__env->startSection('admin-content'); ?>
    <h5>Proposte</h5>
    <div class="libri">
        <?php $__currentLoopData = $proposte; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $libro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="card" style="margin-bottom: 20px;">
                <div class="libro row">
                    <div class="col-3">
                        <img onerror="imgError(this)" src="https://www.ibs.it/images/<?php echo e($libro->ISBN); ?>_0_190_0_75.jpg" alt="cover">
                    </div>
                    <div class="col-9 row">
                        <div class="col-8">
                            <p class="<?php echo e((strlen($libro->titolo) > 100)? 'too-long': ''); ?>"><a href="/book/<?php echo e($libro->ISBN); ?>"><?php echo e($libro->titolo); ?></a></p>
                            <p><?php if(count($libro->belongsAutori) != 0): ?>
                                    <?php echo e(__('book.of')); ?>

                                    <?php $__currentLoopData = $libro->belongsAutori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <a href="/search/autore/<?php echo e($autore->belongsAutore->id_autore); ?>?page=1"><?php echo e($autore->belongsAutore->autore); ?></a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </p>
                            <p><a href="/search?editore=<?php echo e($libro->belongsEditore->id_editore); ?>&page=1"><?php echo e($libro->belongsEditore->editore); ?></a>, <?php echo e($libro->anno_stampa); ?></p>

                            <?php if(count($libro->belongsGeneri) != 0): ?>
                                <div class="genere">
                                    <p><?php echo e(__('book.generi')); ?>:</p>
                                    <div class="d-flex flex-column">
                                        <?php $__currentLoopData = $libro->belongsGeneri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <a href="/search?genere=<?php echo e($genere->belongsGenere->id_genere); ?>&page=1"><?php echo e($genere->belongsGenere->genere); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-4">
                            <p style="font-size: 14px">Status:</p>
                            <span class="badge btn-warning" style="color: #000"><?php echo e($libro->status == 0? 'In revisione' : 'Acquistato'); ?></span>
                            <p style="margin-top: 20px; font-size: 14px;">Proposte:</p>
                            <span><?php echo e($libro->proposte); ?> utenti</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php echo $__env->make('template.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mikyp\Downloads\backup_biblioteca.barsanti.edu.it\httpdocs\resources\views/admin/proposte.blade.php ENDPATH**/ ?>