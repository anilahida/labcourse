<template>
    <div>
        <app-navbar :current-page="page" @change-page="changePage"></app-navbar>

        <div v-if="page === 'clients'">
            <clients-index></clients-index>
        </div>

        <div v-if="page === 'orders'">
            <orders-index></orders-index>
        </div>
    </div>
</template>

<script>
import Navbar from './Navbar.vue';
import ClientsIndex from './ClientsIndex.vue';
import OrdersIndex from './OrdersIndex.vue';

export default {
    components: {
        'app-navbar': Navbar,
        'clients-index': ClientsIndex,
        'orders-index': OrdersIndex
    },
    data() {
        return {
            page: 'orders' // Faqja fillestare
        }
    },
    methods: {
        changePage(newPage) {
            this.page = newPage;
        }
    }
}
</script>