<?php $__env->startSection('content'); ?>
    <div class="container row col-lg-8" style="margin: 0 auto;">
        <div class="col-4">
            <h5>Pannello admin</h5>
            <div class="cc-card admin-menu">
                <div class="search-fast">
                    <form method="POST" action="/admin/restituisci">
                        <?php echo csrf_field(); ?>
                        <label>Inserisci il codice ISBN del libro da restituire</label>
                        <input @input="rest" type="text" name="isbn" class="form-control" required>
                        <select v-if="restituisci != null" type="text" name="libro" class="form-select" style="margin-top: 10px;" required>
                            <option v-for="copia in restituisci" :key="copia.libro + '#'" v-html="copia.libro"></option>
                        </select>
                        <button v-if="restituisci != null && restituisci.length !== 0" type="submit" class="btn-primary btn" style="margin-top: 10px; font-size: 13px;width: 100%;">Restituisci</button>
                    </form>
                </div>
                <ul>
                    <a href="/admin"><li <?php if(Route::is('admin.index')): ?> actived <?php endif; ?>><i class="fas fa-home"></i> Bacheca</li></a>
                    <a href="/admin/insert"><li <?php if(Route::is('admin.insert')): ?> actived <?php endif; ?>><i class="fas fa-book"></i> Aggiungi un libro</li></a>
                    <a href="/admin/prestiti"><li <?php if(Route::is('admin.prestiti')): ?> actived <?php endif; ?>><i class="fas fa-stopwatch"></i> Libri in prestito</li></a>
                    <a href="/admin/prenota"><li <?php if(Route::is('admin.prenota')): ?> actived <?php endif; ?>><i class="fa-solid fa-ear-listen"></i> Prenotazioni</li></a>
                    <a href="/admin/presta"><li <?php if(Route::is('admin.presta')): ?> actived <?php endif; ?>><i class="fas fa-truck-loading"></i> Presta un libro</li></a>
                    <a href="/admin/proposte"><li <?php if(Route::is('admin.proposte')): ?> actived <?php endif; ?>><i class="fa-solid fa-hand-holding-heart"></i> Proposte</li></a>
                    <a href="/admin/completa"><li <?php if(Route::is('admin.completa')): ?> actived <?php endif; ?>><i class="fas fa-swatchbook"></i> Libri incompleti</li></a>
                    <a href="/admin/bacheca"><li <?php if(Route::is('admin.bacheca')): ?> actived <?php endif; ?>><i class="fa-solid fa-desktop"></i> Bacheca</li></a>
                </ul>
            </div>
        </div>
        <div class="col-8">
            <?php echo $__env->yieldContent('admin-content'); ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="/js/admin.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\inetpub\vhosts\biblioteca.barsanti.edu.it\httpdocs\resources\views/template/admin.blade.php ENDPATH**/ ?>