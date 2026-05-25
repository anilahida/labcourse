<template>
    <div class="container mt-4">
        <div style="background: #8B0000; color: white; padding: 15px; margin-bottom: 20px; border-radius: 5px;">
            Sistemi i Porosive - Menaxhimi i të dhënave
        </div>

        <div class="card p-4 mb-4 shadow-sm" style="border-left: 5px solid #8B0000;">
            <h4 class="mb-3" style="color: #8B0000;">Shto Porosi të Re</h4>
            <form @submit.prevent="createOrder">
                <div class="row g-3">
                    <div class="col-md-3">
                        <select v-model="form.client_id" class="form-select">
                            <option value="" disabled>Zgjidh klientin</option>
                            <option v-for="c in clients" :key="c.id" :value="c.id">{{ c.name }}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input v-model="form.book_title" class="form-control" placeholder="Titulli i librit" required>
                    </div>
                    <div class="col-md-3">
                        <input v-model="form.total_amount" type="number" class="form-control" placeholder="Shuma (€)" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="w-100 btn btn-danger">Ruaj Porosinë</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #8B0000; color: white;">
                        <tr>
                            <th class="p-3">Klienti</th>
                            <th class="p-3">Libri</th>
                            <th class="p-3">Shuma</th>
                            <th class="p-3 text-center">Veprime</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders" :key="order.id">
                            <td class="p-3">{{ order.client ? order.client.name : 'N/A' }}</td>
                            <td class="p-3">{{ order.book_title }}</td>
                            <td class="p-3">{{ order.total_amount }} €</td>
                            <td class="p-3 text-center">
                                <button @click="deleteOrder(order.id)" class="btn btn-sm btn-outline-danger">Fshi</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            orders: [],
            clients: [],
            form: { client_id: '', book_title: '', total_amount: '' },
        };
    },
    mounted() {
        this.fetchOrders();
        this.fetchClients();
    },
    methods: {
        fetchOrders() {
            axios.get('/api/orders')
                .then(response => { this.orders = response.data; })
                .catch(error => { console.error("Gabim te fetchOrders:", error); });
        },
        fetchClients() {
            axios.get('/api/clients')
                .then(response => { this.clients = response.data; })
                .catch(error => { console.error("Gabim te fetchClients:", error); });
        },
        createOrder() {
            axios.post('/api/orders', this.form)
                .then(() => {
                    this.form = { client_id: '', book_title: '', total_amount: '' };
                    this.fetchOrders();
                })
                .catch(error => { console.error("Gabim te createOrder:", error); });
        },
        deleteOrder(id) {
            if (confirm('Jeni të sigurt që doni ta fshini?')) {
                axios.delete(`/api/orders/${id}`)
                    .then(() => { this.fetchOrders(); })
                    .catch(error => { console.error("Gabim te deleteOrder:", error); });
            }
        }
    }
}
</script>