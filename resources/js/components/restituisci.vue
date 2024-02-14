<template>
    <label>Inserisci il codice ISBN del libro da restituire</label>
    <input @input="rest" type="text" name="isbn" class="form-control" required>
    <select v-if="restituisci != null" type="text" name="libro" class="form-select" style="margin-top: 10px;" required>
        <option v-for="copia in restituisci" :key="copia.libro + '#'" :value="copia.libro"
            v-html="copia.titolo + ' - ' + copia.utente"></option>
    </select>
    <button v-if="restituisci != null && restituisci.length !== 0" type="submit" class="btn-primary btn"
        style="margin-top: 10px; font-size: 13px;width: 100%;">Restituisci</button>
</template>

<script setup lang="ts">
    import { ref, type InputHTMLAttributes, type ReservedProps } from 'vue';
    import axios from 'axios';

    interface Restituisci {
        libro: string;
        titolo: string;
        utente: string;
    }

    const restituisci = ref<Restituisci[] | null>(null);
    function rest(event: Event) {
        const value = (event.target as HTMLInputElement).value;
        if (value.length === 13) {
            axios
            .get("/api/admin/restituisci/" + value)
            .then((response) => {
                if (response.data !== undefined) {
                    restituisci.value = response.data as Restituisci[];
                }
            })
            .catch((error) => {
                console.error(error);
            });
        }
    }
</script>
