import './bootstrap';
import { createApp } from 'vue';
import OrderDetailsIndex from './components/OrderDetailsIndex.vue';
import MainLayout from './components/MainLayout.vue';

const app = createApp({});

app.component('main-layout', MainLayout);
app.component('order-details-index', OrderDetailsIndex);
app.mount('#app')