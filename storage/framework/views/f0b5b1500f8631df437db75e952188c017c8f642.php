<?php $__env->startSection('title', 'Admin - Biblioteca'); ?>

<?php $__env->startSection('admin-content'); ?>

    <div class="container">
        <div class="row">
            <p class="visits">Visite del sito oggi: <?php echo e(count($trackers)); ?></p>
        </div>
    </div>

    <div class="container admin-select">
        <div class="row">
        <!--
        <div class="col-12 cc-card d-flex flex-column" style="padding: 10px 20px;">
            <form method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
            <div class="custom-file" style="margin-bottom: 10px;">
                <input type="file" class="custom-file-input" id="validatedCustomFile" required>
                <label class="custom-file-label" for="validatedCustomFile">Inserisci il file degli utenti (CSV file)...</label>
            </div>
            <input type="submit" name="submit" value="Save" class="btn-primary btn" />
        </form>
    </div>
-->
            <div class="col-12" style="margin-top: 20px;">
                <a href="/admin/books/generate">
                    <button class="btn btn-primary">Estrai i libri CSV (Attenzione, peso elevato!)</button>
                </a>
            </div>
        </div>
    </div>

    <div class="container row admin-select">
        <a href="/" style="float: left;" class="col-4">
            <div class="cc-card d-flex flex-column text-lg-center" style="padding: 35px 0;margin: 20px auto;">
                <i class="fas fa-home" style="font-size: 28px"></i>
                <label>Bacheca</label>
            </div>
        </a>

        <a href="/admin/prestiti" style="float: left;" class="col-4">
            <div class="cc-card d-flex flex-column text-lg-center" style="padding: 35px 0;margin: 20px auto;">
                <i class="fas fa-stopwatch" style="font-size: 28px"></i>
                <label>Libri Prestati</label>
            </div>
        </a>

        <a href="/admin/completa" style="float: left;" class="col-4">
            <div class="cc-card d-flex flex-column text-lg-center" style="padding: 35px 0;margin: 20px auto;">
                <i class="fas fa-book" style="font-size: 28px"></i>
                <label>Completa i libri</label>
            </div>
        </a>
        <a href="/admin/insert" style="float: left;" class="col-4">
            <div class="cc-card d-flex flex-column text-lg-center" style="padding: 35px 0;margin: 20px auto;">
                <i class="fas fa-add" style="font-size: 28px"></i>
                <label>Aggiungi un libro</label>
            </div>
        </a>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mikyp\Downloads\backup_biblioteca.barsanti.edu.it\httpdocs\resources\views/admin/index.blade.php ENDPATH**/ ?>