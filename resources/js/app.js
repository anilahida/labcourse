import './bootstrap';
import { createApp } from 'vue';

// Kjo është rruga që i tregon JS-së ku ndodhen komponentët e tu
import OrderIndex from './components/OrderIndex.vue'; 

const app = createApp({});
app.component('order-index', OrderIndex);
app.mount('#app');