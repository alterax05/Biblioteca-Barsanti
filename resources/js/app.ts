import './bootstrap';

import { createApp } from 'vue';
import Restituisci from './components/Restituisci.vue';

const app = createApp({});
app.component('restituisci', Restituisci);
app.mount('#main');
