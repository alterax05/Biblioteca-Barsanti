<?php $__env->startSection('title'); ?>
    Profilo di <?php echo e(Auth()->user()->name . " " . Auth()->user()->surname); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="container row col-lg-8" style="margin: 0 auto;">
        <div class="col-4">
            <p>Bentornato <?php echo e(Auth()->user()->name . " " . Auth()->user()->surname); ?></p>
            <div class="cc-card profile-menu" style="overflow: hidden;">
                <ul>
                    <a href="">
                        <li>Prestiti in corso</li>
                    </a>
                    <a href="">
                        <li>Restituiti</li>
                    </a>
                    <a href="">
                        <li>Preferiti</li>
                    </a>
                </ul>
            </div>

        </div>
        <div class="col-8">
            <h5>Prestiti in corso</h5>
            <div class="libri">
                <?php $__currentLoopData = $prestiti; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $libro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="libro row cc-card spacer-card">
                        <div class="col-3">
                            <a href="/book/<?php echo e($libro->ISBN); ?>">
                                <img onerror="imgError(this)" src="https://pictures.abebooks.com/isbn/<?php echo e($libro->ISBN); ?>-us-300.jpg" alt="cover">
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
                                <p><a href="?editore=<?php echo e($libro->belongsEditore->id_editore); ?>&page=1"><?php echo e($libro->belongsEditore->editore); ?></a>, <?php echo e($libro->anno_stampa); ?></p>

                                <?php if(count($libro->belongsGeneri) != 0): ?>
                                    <div class="genere">
                                        <p>Generi:</p>
                                        <div class="d-flex flex-column">
                                            <?php $__currentLoopData = $libro->belongsGeneri; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="?genere=<?php echo e($genere->belongsGenere->id_genere); ?>&page=1"><?php echo e($genere->belongsGenere->genere); ?></a>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-4 dettagli">
                                <label class="copie">Prestato il: <b><?php echo e(date("d/m/Y", strtotime($libro->data_prestito))); ?></b></label>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/edoardo/PhpstormProjects/bibliotecaLaravel/resources/views/auth/index.blade.php ENDPATH**/ ?>
