import './bootstrap';

import { createApp } from 'vue';
import Restituisci from './components/admin/Restituisci.vue';
import ListaAutori from './components/admin/ListaAutori.vue';
import Presta from './components/admin/Presta.vue';

const app = createApp({});

// Componenti per l'admin
app.component('restituisci', Restituisci);
app.component('lista_autori', ListaAutori);
app.component('presta', Presta);
app.mount('#main');
