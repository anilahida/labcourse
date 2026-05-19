import './bootstrap';
import { createApp } from 'vue';

import MainLayout from './components/MainLayout.vue';

const app = createApp({});

app.component('main-layout', MainLayout);

app.mount('#app')