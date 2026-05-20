<template>
    <div>
        <app-navbar :current-page="page" @change-page="changePage"></app-navbar>

        <div v-if="page === 'clients'">
            <clients-index></clients-index>
        </div>

        <div v-if="page === 'orders'">
            <orders-index></orders-index>
        </div>

        <div v-if="page === 'order_details'">
            <order-details-index></order-details-index>
        </div>
    </div>
</template>

<script>
import Navbar from './Navbar.vue';
import ClientsIndex from './ClientsIndex.vue';
import OrdersIndex from './OrderIndex.vue';
// 2. KËTU u importua komponenti i ri i detajeve
import OrderDetailsIndex from './OrderDetailsIndex.vue';

export default {
    components: {
        'app-navbar': Navbar,
        'clients-index': ClientsIndex,
        'orders-index': OrdersIndex,
        // 3. KËTU u regjistrua tag-u i ri për HTML
        'order-details-index': OrderDetailsIndex,
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