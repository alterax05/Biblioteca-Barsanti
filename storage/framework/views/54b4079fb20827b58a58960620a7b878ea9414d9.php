<?php $__env->startSection('title', 'Presta - Biblioteca'); ?>

<?php $__env->startSection('admin-content'); ?>
    <form method="POST">
        <div class="cc-card" style="padding: 10px 20px;">
            <h5>Presta un libro</h5>

            <div v-if="prenota != null" class="input-wrapper row">
                <div class="col-4">
                    <img :src="image" alt="cover" style="width: 100%;">
                </div>
                <div class="col-8">
                    <p style="font-size: 18px;" class="align-self-center"><b v-html="prenota.titolo"></b></p>
                    <p style="font-size: 16px;" class="align-self-center" v-html="prenota.editore"></p>
                    <p style="font-size: 14px; margin-top: 5px;" class="align-self-center" v-html="'Anno Stampa: ' + prenota.anno_stampa"></p>
                    <p style="font-size: 14px;" class="align-self-center" v-html="prenota.ISBN"></p>
                </div>
            </div>

            <div class="input-wrapper row">
                <div class="col-12">
                    <label>Scannerizza l'ISBN</label>
                    <input type="text" name="ISBN" class="form-control" @input="scannerISBN">
                    <input type="text" required style="display: none;" v-if="prenota == null">
                </div>
            </div>

            <div v-if="prenota != null && prenota.copie.length != 0" class="input-wrapper row">
                <div class="col-12">
                    <label>Seleziona il numero della copia</label>
                    <select id="copiaselect" name="copia" class="form-select" style="width: 100%; height: min-content;" @change="selectCopia($event)" required>
                        <option v-for="copia in prenota.copie" :key="copia" v-html="copia.id_libro"></option>
                    </select>
                </div>
            </div>

            <div v-if="prenota != null && prenota.copie.length != 0">
                <div v-if="prenota != null" class="input-wrapper row">
                    <div class="col-12" v-if="prenota.copie[copia].prenotato.length != 0">
                        <label>Prenotazione trovata!</label>
                        <input required readonly type="text" class="form-control" :value="prenota.copie[copia].prenotato[0].name + ' ' + prenota.copie[copia].prenotato[0].surname">
                        <input type="hidden" name="user" :value="prenota.copie[copia].prenotato[0].id">
                    </div>
                    <div class="col-12" v-else>
                        <label>Passa il badge dello studente sul lettore</label>
                        <input required type="text" class="form-control">
                    </div>

                    <input type="hidden" name="ISBN" :value="prenota.ISBN">
                    <?php echo csrf_field(); ?>
                </div>

                <div v-if="prenota != null" class="input-wrapper row">
                    <div class="col-12">
                        <button class="btn btn-primary">Salva</button>
                    </div>
                </div>
            </div>

            <div v-if="prenota != null && prenota.copie.length == 0" class="input-wrapper row">
                <div class="col-12">
                    <label>Non ci sono copie disponibili!</label>
                </div>
            </div>
        </div>
    </form>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('template.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mikyp\Downloads\backup_biblioteca.barsanti.edu.it\httpdocs\resources\views/admin/presta.blade.php ENDPATH**/ ?>