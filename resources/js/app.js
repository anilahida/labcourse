import './bootstrap';
import { createApp } from 'vue';

// 1. Importo komponentin
import OrderIndex from './components/OrderIndex.vue'; 

const app = createApp({});

// 2. Regjistro komponentin (kjo e bën të disponueshëm në Blade)
app.component('order-index', OrderIndex); 

app.mount('#app'); // Sigurohu që ke <div id="app"> në layouts/app.blade.php