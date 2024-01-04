<?php $__env->startSection('title', 'Proponi - Biblioteca'); ?>

<?php $__env->startSection('content'); ?>
    <style>
        .btn {
            font-size: 14px;
        }
    </style>
    <div class="container col-5">
        <div class="row">
            <div class="col-6"><h4>Proposte</h4></div>
            <div class="col-6 add-button" data-toggle="modal" data-target="#add_proposta">
                <button class="btn btn-primary">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
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

    <!-- Modal -->
    <div class="modal fade" id="add_proposta" tabindex="-1" role="dialog" aria-labelledby="add_proposta" aria-hidden="true">
        <form method="POST" action="/proponi">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Aggiungi una proposta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <img src="https://storage.googleapis.com/cdn002/2015/01/CodiceISBN839x280.jpg" style="width: 100%; margin-bottom: 20px;filter: grayscale(1);">
                                <label for="video">Codice ISBN del libro</label>
                                <input type="text" class="form-control" id="video" name="isbn" placeholder="esempio 9788804668022">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <?php echo csrf_field(); ?>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Chiudi</button>
                        <button type="submit" class="btn btn-primary">Aggiungi</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\vhosts\biblioteca.barsanti.edu.it\httpdocs\resources\views/proponi.blade.php ENDPATH**/ ?>