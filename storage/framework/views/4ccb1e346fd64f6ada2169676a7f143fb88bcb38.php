<?php $__env->startSection('title', 'Inserimento dati - Biblioteca'); ?>

<?php $__env->startSection('admin-content'); ?>
        <div class="cc-card filter-card">
            <h5>Aggiungi un libro</h5>
            <form method="POST">
                <div class="input-wrapper row">
                    <?php echo csrf_field(); ?>
                    <div class="col-12">
                        <label>Inserisci l'ISBN del libro (ISBN 13 es. <b>97888</b>12345678)</label>
                        <a href="/admin/insert/advanced" style="display: block">Non c'è l'ISBN</a>
                        <?php if(count($dafare) == 0): ?>
                            <input style="width: 100%;" name="isbn" type="text" placeholder="ISBN" class="isbn" required>
                        <?php else: ?>
                            <select name="isbn">
                                <?php $__currentLoopData = $dafare; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $df): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($df->ISBN); ?>"><?php echo e($df->ISBN); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="input-wrapper row">
                    <div class="col-6">
                        <label>Seleziona le sue condizioni</label>
                        <select name="condizioni" class="form-select" style="width: 100%; height: min-content;" required>
                            <?php $__currentLoopData = $condizioni; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condizion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($condizion->id_condizioni); ?>"><?php echo e($condizion->condizioni); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-6">
                        <label>Inserisci lo scaffale (Num. A/B)</label>
                        <input name="scaffale" value="<?php echo e($_GET['scaffale']??""); ?>" type="text" style="width: 100%; padding: 3px 20px;" required>
                    </div>
                </div>

                <div class="input-wrapper row">
                    <div class="col-6">
                        <label>Inserisci il ripiano</label>
                        <input name="ripiano" value="<?php echo e($_GET['ripiano']??""); ?>" type="text" style="width: 100%; padding: 3px 20px;" required>
                    </div>
                    <div class="col-6">
                        <label>Inserisci il codice inventario</label>
                        <input name="codice" type="text" style="width: 100%; padding: 3px 20px;" required>
                    </div>
                </div>
                <div class="input-wrapper row">
                    <div class="col-6">
                        <label>Inserisci le volte prestate</label>
                        <input name="prestati" value="0" type="text" style="width: 100%; padding: 3px 20px;" required>
                    </div>
                    <div class="col-6">
                        <label>Seleziona il reparto</label>
                        <select name="reparto" class="form-select" style="width: 100%; height: min-content;" required>
                            <?php $__currentLoopData = $reparti; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reparto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($reparto->id_reparto); ?>"><?php echo e($reparto->reparto); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-primary">Inserisci il libro</button>
                    </div>
                </div>
            </form>
            <?php if(!empty($message)): ?>
                <label><?php echo e($message); ?></label>
            <?php endif; ?>
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mikyp\Downloads\backup_biblioteca.barsanti.edu.it\httpdocs\resources\views/admin/insert.blade.php ENDPATH**/ ?>