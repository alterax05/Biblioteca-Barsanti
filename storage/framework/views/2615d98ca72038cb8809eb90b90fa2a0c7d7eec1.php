<?php $__env->startSection('title', 'Inserimento dati - Biblioteca'); ?>

<?php $__env->startSection('admin-content'); ?>
    <div class="cc-card filter-card">
        <h5>Aggiungi un libro <b>senza ISBN</b></h5>
        <form method="POST">
            <div class="input-wrapper row">
                <?php echo csrf_field(); ?>
                <div class="col-12">
                    <label>Inserisci il titolo del libro</label>
                    <input name="titolo" type="text" placeholder="Titolo del libro" class="isbn" required>
                </div>
            </div>

            <div class="input-wrapper row">
                <div class="col-6">
                    <label>Seleziona il genere</label>
                    <select name="genere" class="form-select" style="width: 100%; height: min-content;" required>
                        <?php $__currentLoopData = $generi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $genere): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($genere->id_genere); ?>"><?php echo e($genere->genere); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-6">
                    <label>Inserisci l'anno di stampa</label>
                    <input name="anno" type="text" style="width: 100%; padding: 3px 20px;" required>
                </div>
            </div>

            <div class="input-wrapper row">
                <div class="col-6">
                    <label>Seleziona l'autore</label>
                    <div style="position: relative">
                        <input id="autore" name="autore" type="text" style="width: 100%; padding: 3px 20px;" required autocomplete="off" @input="update">
                        <ul class="search-list">
                            <li v-for="(row,rid) in libri" :key="rid">
                                <a @click="changeValue(row.query)">
                                    <div class="option-search">
                                        <div class="col-lg-12">
                                            <p v-html="row.query"></p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="col-6">
                    <label>Seleziona le sue condizioni</label>
                    <select name="editore" class="form-select" style="width: 100%; height: min-content;" required>
                        <?php $__currentLoopData = $editori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $editore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($editore->id_editore); ?>"><?php echo e($editore->editore); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
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
                    <input name="id_libro" type="text" style="width: 100%; padding: 3px 20px;" required>
                </div>
            </div>
            <div class="input-wrapper row">
                <div class="col-6">
                    <label>Inserisci le volte prestate</label>
                    <input name="prestati" value="0" type="text" style="width: 100%; padding: 3px 20px;" required>
                </div>
                <div class="col-6">
                    <label>Seleziona la lingua</label>
                    <select name="lingua" class="form-select" style="width: 100%; height: min-content;" required>
                        <option value="it">Italiano</option>
                        <option value="en">Inglese</option>
                        <option value="de">Tedesco</option>
                        <option value="es">Spagnolo</option>
                        <option value="fr">Francese</option>
                    </select>
                </div>
            </div>

            <div class="input-wrapper row">
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

<?php $__env->startSection('style'); ?>
    <style>
        .search-list {
            width: 100% !important;
            border: solid 1px #d2d2d2;
        }
        input[name="autore"] {
            font-size: 14px;
        }
    </style>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\vhosts\biblioteca.barsanti.edu.it\httpdocs\resources\views/admin/insertAdvanced.blade.php ENDPATH**/ ?>