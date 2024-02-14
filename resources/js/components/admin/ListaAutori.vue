<template>
    <input v-model="autore" id="autore" name="autore" type="text" style="width: 100%; padding: 3px 20px;" required autocomplete="off" @input="update">
    <ul class="search-list">
        <li v-for="(row, rid) in autori" :key="rid">
            <a @click="changeValue(row.autore)">
                <div class="option-search">
                    <div class="col-lg-12">
                        <p v-html="row.autore"></p>
                    </div>
                </div>
            </a>
        </li>
    </ul>
</template>

<script setup lang="ts">
    import { ref } from 'vue';
    import axios from 'axios';

    interface Autore {
        autore: string;
    }

    const autore = ref<string>("");
    const autori = ref<Autore[] | null>(null);

    function update(event: Event) {
        const value = (event.target as HTMLInputElement ).value;

        if (value.length > 2) {
            axios
            .get("/api/autori/" + value.replace(" ","-"))
            .then((response) => {
                if (response.data !== undefined) {
                    autori.value = response.data as Autore[];
                }
            })
            .catch((error) => {
                console.error(error);
            });
        }
    }

    function changeValue(value: string) {
        autore.value = value;
        autori.value = null;
    }
</script>