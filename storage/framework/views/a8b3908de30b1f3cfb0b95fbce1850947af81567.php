<?php $__env->startSection('content'); ?>
    <div class="container row col-lg-8" style="margin: 0 auto;">
        <div class="col-4">
            <h5>Pannello admin</h5>
            <div class="cc-card admin-menu">
                <div class="search-fast">
                    <label>Cerca un libro velocemente inserendo il codice inventario</label>
                    <input type="text" id="book" class="form-control">
                    <button onclick="searchBook()" class="btn-primary btn" style="margin-top: 10px; font-size: 13px">Cerca</button>
                </div>
                <ul>
                    <a href="/admin"><li><i class="fas fa-home"></i> Bacheca</li></a>
                    <a href="/admin/insert"><li><i class="fas fa-book"></i> Aggiungi un libro</li></a>
                    <a href="/admin/prestiti"><li><i class="fas fa-stopwatch"></i> Libri in prestito</li></a>
                    <a href="/admin/presta"><li><i class="fas fa-truck-loading"></i> Presta un libro</li></a>
                    <a href="/admin/completa"><li><i class="fas fa-swatchbook"></i> Libri incompleti</li></a>
                </ul>
            </div>
        </div>
        <div class="col-8">
            <?php echo $__env->yieldContent('admin-content'); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        function searchBook() {
            if($('#book').val() != "")
                window.location.href = '/admin/book/' + $('#book').val();
        }
    </script>
    <script src="/js/admin.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/edoardo/PhpstormProjects/bibliotecaLaravel/resources/views/template/admin.blade.php ENDPATH**/ ?>