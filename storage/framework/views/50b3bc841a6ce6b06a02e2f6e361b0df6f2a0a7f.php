<?php $__env->startSection('title', 'Libro - Biblioteca'); ?>

<?php $__env->startSection('admin-content'); ?>
    <div class="cc-card filter-card">
        <div class="row">
            <div class="col-4">
                <img class="book-cover" src="https://pictures.abebooks.com/isbn/<?php echo e($libro->ISBN); ?>-us-300.jpg" style="width: 100%;">
            </div>
            <div class="col-8">
                <h5 style="margin-top: 20px;">Titolo: <?php echo e($libro->titolo); ?></h5>
            </div>
        </div>

        <div class="input-wrapper row">
            <div class="col-12">
                <form method="POST" id="autoreForm" action="/admin/book/<?php echo e($libro->ISBN); ?>/authors">
                    <?php echo csrf_field(); ?>
                    <label>Autori</label>
                    <textarea readonly class="form-control" style="margin-bottom: 20px; font-size: 14px;"><?php $__currentLoopData = $autori; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($autore->autore); ?>, <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></textarea>
                    <label style="font-size: 14px;">Aggiungi un autore</label>
                    <select class="form-select" name="author" style="height: fit-content;">
                        <?php $__currentLoopData = $autoriAll; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $autore): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($autore->id_autore); ?>"><?php echo e($autore->autore); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <button onclick="$('autoreForm').submit()" class="btn-primary btn" style="font-size: 12px; margin-top: 10px;">Aggiungi un autore</button>
                </form>
            </div>
        </div>
        <form method="POST">
            <div class="input-wrapper row">
                <?php echo csrf_field(); ?>
                <div class="col-12">
                    <label>ISBN del libro</label>
                    <input style="width: 100%;" name="isbn" value="<?php echo e($libro->ISBN); ?>" type="text" placeholder="ISBN" class="isbn" required>
                </div>
            </div>

            <div class="input-wrapper row">
                <div class="col-6">
                    <label>Inserisci lo scaffale (Num. A/B)</label>
                    <input name="scaffale" value="<?php echo e($libro->scaffale); ?>" type="text" style="width: 100%; padding: 3px 20px;" required>
                </div>
                <div class="col-6">
                    <label>Inserisci le persone a cui è stato prestato (default: 0)</label>
                    <input name="prestati" value="0" type="text" value="<?php echo e($libro->prestiti); ?>" style="width: 100%; padding: 3px 20px;" required>
                </div>
            </div>

            <div class="input-wrapper row">
                <div class="col-6">
                    <label>Inserisci il ripiano</label>
                    <input name="ripiano" value="<?php echo e($libro->ripiano); ?>" type="text" style="width: 100%; padding: 3px 20px;" required>
                </div>
                <div class="col-6">
                    <label>Inserisci il codice inventario</label>
                    <input name="codice" type="text" value="<?php echo e($libro->id_libro); ?>" style="width: 100%; padding: 3px 20px;" required>
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

<?php echo $__env->make('template.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\vhosts\biblioteca.barsanti.edu.it\httpdocs\resources\views/admin/book.blade.php ENDPATH**/ ?>