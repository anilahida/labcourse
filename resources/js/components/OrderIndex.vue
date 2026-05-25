<template>
    <div class="container mt-4">
        <form @submit.prevent="createOrder" class="card p-4 shadow-sm mb-4">
            <h4>Shto Porosi</h4>
            <div class="row">
                <div class="col-md-3">
                    <select v-model="form.client_id" class="form-select" required>
                        <option value="" disabled>Zgjidh klientin</option>
                        <option v-for="c in clients" :key="c.id" :value="c.id">{{ c.name }}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input v-model="form.book_title" class="form-control" placeholder="Titulli i librit" required>
                </div>
                <div class="col-md-3">
                    <input v-model="form.total_amount" type="number" class="form-control" placeholder="Shuma" required>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success">Ruaj</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Klienti</th>
                    <th>Libri</th>
                    <th>Shuma</th>
                    <th>Statusi</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="order in orders" :key="order.id">
                    <td>{{ order.client ? order.client.name : 'N/A' }}</td>
                    <td>{{ order.book_title }}</td>
                    <td>{{ order.total_amount }} €</td>
                    <td>{{ order.status }}</td>
                    <td>
                        <button @click="deleteOrder(order.id)" class="btn btn-danger btn-sm">Fshi</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data() {
        return {
            orders: [],
            clients: [],
            form: { client_id: '', book_title: '', total_amount: '' }
        };
    },
    mounted() {
        this.fetchOrders();
        this.fetchClients();
    },
    methods: {
        fetchOrders() {
            axios.get('/api/orders').then(response => { this.orders = response.data; });
        },
        fetchClients() {
            axios.get('/api/clients').then(response => { this.clients = response.data; });
        },
        createOrder() {
            axios.post('/api/orders', this.form).then(() => {
                this.form = { client_id: '', book_title: '', total_amount: '' };
                this.fetchOrders();
            });
        },
        deleteOrder(id) {
            if (confirm('A jeni të sigurt që doni ta fshini këtë porosi?')) {
                axios.delete(`/api/orders/${id}`).then(() => {
                    this.fetchOrders();
                });
            }
        }
    }
}
</script>