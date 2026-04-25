import './bootstrap';
import { createApp } from 'vue';

// Importojmë komponentin që sapo krijove
import ClientsIndex from './components/ClientsIndex.vue';

const app = createApp({});

// I japim një emër që do ta përdorim në HTML/Blade
app.component('clients-index', ClientsIndex);

app.mount('#app');
