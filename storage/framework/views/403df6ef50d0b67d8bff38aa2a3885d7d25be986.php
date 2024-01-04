<?php $__env->startSection('title', 'Presta - Biblioteca'); ?>

<?php $__env->startSection('admin-content'); ?>
    <div class="cc-card" style="padding: 10px 20px;">
        <h5>Presta un libro</h5>

        <div class="input-wrapper row">
            <div class="col-4">
                <img :src="image" alt="cover" style="width: 100%;">
            </div>
            <div class="col-8 d-flex">
                <p style="font-size: 18px;letter-spacing: 1px;" class="align-self-center" v-html="title"></p>
            </div>
        </div>

        <div class="input-wrapper row">
            <div class="col-12">
                <label>Scannerizza l'ISBN</label>
                <input type="text" name="ISBN" class="form-control" @input="scannerISBN">
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/edoardo/PhpstormProjects/bibliotecaLaravel/resources/views/admin/presta.blade.php ENDPATH**/ ?>