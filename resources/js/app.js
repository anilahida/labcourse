import './bootstrap';
import { createApp, defineAsyncComponent } from 'vue';

const app = createApp({});

// ── Eager imports (kritike, gjithmonë duhen) ─────────────────────────────
import MainLayout    from './components/MainLayout.vue';
import BookBrowse    from './components/BookBrowse.vue';
import BookShow      from './components/BookShow.vue';

app.component('main-layout',  MainLayout);
app.component('book-browse',  BookBrowse);
app.component('book-show',    BookShow);

// ── Lazy loading me defineAsyncComponent ─────────────────────────────────
// Komponentët e adminit ngarkohen vetëm kur nevojiten (code splitting)
app.component('orders-index', defineAsyncComponent({
    loader: () => import('./components/OrderIndex.vue'),
    delay: 0,
}));
app.component('author-index', defineAsyncComponent({
    loader: () => import('./components/AuthorIndex.vue'),
    delay: 0,
}));
app.component('category-index', defineAsyncComponent({
    loader: () => import('./components/CategoryIndex.vue'),
    delay: 0,
}));

app.mount('#app');