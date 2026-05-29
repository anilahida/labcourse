import './bootstrap';
import { createApp } from 'vue';

const app = createApp({});

// 1. Importo të gjithë komponentët (lart)
import MainLayout from './components/MainLayout.vue';
import OrderIndex from './components/OrderIndex.vue';
import AuthorIndex from './components/AuthorIndex.vue';
import CategoryIndex from './components/CategoryIndex.vue';

// 2. Regjistro të gjithë komponentët
app.component('main-layout', MainLayout);
app.component('orders-index', OrderIndex);
app.component('author-index', AuthorIndex);
app.component('category-index', CategoryIndex);

// 3. Monto aplikacionin VETËM NË FUND
app.mount('#app');