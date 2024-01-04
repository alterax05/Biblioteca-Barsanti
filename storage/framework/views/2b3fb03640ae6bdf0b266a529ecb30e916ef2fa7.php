<?php $__env->startSection('profile-content'); ?>
    <div class="col-8">

        <h5><?php echo e(__('profile.booked_copy')); ?></h5>
        <div class="libri">
            <?php $__currentLoopData = $prestiti; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $libro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="libro row cc-card spacer-card">
                    <div class="col-3">
                        <a href="/book/<?php echo e($libro->ISBN); ?>">
                            <img onerror="imgError(this)" src="/imgs/covers/<?php echo e($libro->ISBN); ?>.jpg" alt="cover">
                        </a>
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
                        <div class="col-4 dettagli">
                            <label class="copie"><?php echo e(__('profile.booked_in')); ?>: <b><?php echo e(date("d/m/Y", strtotime($libro->created_at))); ?></b></label>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.profile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mikyp\Downloads\backup_biblioteca.barsanti.edu.it\httpdocs\resources\views/auth/profile/prenotazioni.blade.php ENDPATH**/ ?>