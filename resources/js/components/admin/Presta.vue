<template>
        <div class="cc-card" style="padding: 10px 20px;">
            <h5>Presta un libro</h5>

            <div v-if="prenota != null" class="input-wrapper row">
                <div class="col-4">
                    <img :src="image" alt="cover" style="width: 100%;">
                </div>
                <div class="col-8">
                    <p style="font-size: 18px;" class="align-self-center"><b v-html="prenota.titolo"></b></p>
                    <p style="font-size: 16px;" class="align-self-center" v-html="prenota.editore"></p>
                    <p style="font-size: 14px; margin-top: 5px;" class="align-self-center"
                        v-html="'Anno Stampa: ' + prenota.anno_stampa"></p>
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
                    <select id="copiaselect" name="copia" class="form-select" style="width: 100%; height: min-content;"
                        @change="selectCopia($event)" required>
                        <option v-for="copia in prenota.copie" :key="num_copia" v-html="copia.id_libro"></option>
                    </select>
                </div>
            </div>

            <div v-if="prenota != null && prenota.copie.length != 0">
                <div v-if="prenota != null" class="input-wrapper row">
                    <div class="col-12" v-if="prenota.copie[num_copia].prenotato.length != 0">
                        <label>Prenotazione trovata!</label>
                        <input required readonly type="text" class="form-control"
                            :value="prenota.copie[num_copia].prenotato[0].name + ' ' + prenota.copie[num_copia].prenotato[0].surname">
                        <input type="hidden" name="user" :value="prenota.copie[num_copia].prenotato[0].id">
                    </div>
                    <input type="hidden" name="ISBN" :value="prenota.ISBN">
                </div>

                <div v-if="prenota != null" class="input-wrapper row">
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Salva</button>
                    </div>
                </div>
            </div>

            <div v-if="prenota != null && prenota.copie.length == 0" class="input-wrapper row">
                <div class="col-12">
                    <label>Non ci sono copie disponibili!</label>
                </div>
            </div>

        </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios'

const prenota = ref<Libro | null>(null);
const image = ref<string | undefined>(undefined);
const num_copia = ref<number>(0);

interface Libro {
    ISBN: string;
    titolo: string;
    editore: string;
    anno_stampa: string;
    copie: Copia[];
}

interface Copia {
    id_libro: number;
    prenotato: Prenotato[];
}

interface Prenotato {
    id: number;
    name: string;
    surname: string;
}

function selectCopia(event: Event) {
    num_copia.value = parseInt((event.target as HTMLSelectElement).value);
}

function scannerISBN(event: Event) {
    const isbn = (event.target as HTMLInputElement).value;

    if (isbn.length === 13) {
        axios.get('/api/admin/search/' + isbn)
            .then(response => {
                if (response.data != null && response.status === 200) {
                    prenota.value = response.data;
                    image.value = "https://pictures.abebooks.com/isbn/" + isbn + "-us-300.jpg";
                }
            })
            .catch(_ => {
                prenota.value = null;
                image.value = undefined;
            });
    }
    else {
        prenota.value = null;
        image.value = undefined;
    }
}
</script>