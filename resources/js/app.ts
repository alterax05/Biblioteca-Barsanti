import './bootstrap';

import { createApp } from 'vue';
import Restituisci from './components/admin/Restituisci.vue';
import ListaAutori from './components/admin/ListaAutori.vue';
import Presta from './components/admin/Presta.vue';
import {Toaster} from 'vue-sonner';

const app = createApp({});

// Componenti per l'admin
app.component('Restituisci', Restituisci);
app.component('ListaAutori', ListaAutori);
app.component('Presta', Presta);
app.component('Toaster', Toaster);
app.mount('#main');
