<template>
    <div class="space-y-8">
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 shadow-sm">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">
                {{ isEditing ? 'Edito Porosinë' : 'Shto Porosi të Re' }}
            </h2>
            <form @submit.prevent="saveOrder" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Zgjidh Klientin</label>
                    <select v-model="form.client_id" class="w-full p-2 border rounded-md bg-white outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Zgjidhni një klient...</option>
                        <option v-for="client in clients" :key="client.id" :value="client.id">
                            {{ client.name }}
                        </option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Produkti</label>
                    <input v-model="form.product_name" type="text" placeholder="Emri i produktit" class="w-full p-2 border rounded-md outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Çmimi (€)</label>
                    <input v-model="form.price" type="number" step="0.01" placeholder="0.00" class="w-full p-2 border rounded-md outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition-colors h-10">
                    {{ isEditing ? 'Përditëso' : 'Ruaj' }}
                </button>
            </form>
        </div>

        <div class="overflow-x-auto mt-8">
            <table class="min-w-full bg-white border border-gray-200 shadow-sm rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200 text-gray-600 uppercase text-xs">
                        <th class="px-6 py-3 text-left font-medium border-r w-16">ID</th>
                        <th class="px-6 py-3 text-left font-medium border-r">Klienti</th>
                        <th class="px-6 py-3 text-left font-medium border-r">Produkti</th>
                        <th class="px-6 py-3 text-left font-medium border-r">Çmimi</th>
                        <th class="px-6 py-3 text-left font-medium border-r">Statusi</th>
                        <th class="px-6 py-3 text-center font-medium">Veprimet</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="order in orders" :key="order.id" class="hover:bg-gray-50 transition-colors text-sm">
                        <td class="px-6 py-4 text-gray-900 border-r">{{ order.id }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900 border-r">{{ order.client ? order.client.name : 'I panjohur' }}</td>
                        <td class="px-6 py-4 text-gray-600 border-r">{{ order.product_name }}</td>
                        <td class="px-6 py-4 text-gray-900 font-medium border-r">{{ order.price }} €</td>
                        <td class="px-6 py-4 border-r">
                            <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">{{ order.status }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-6">
                                <button @click="editOrder(order)" class="text-blue-600 hover:text-blue-800 font-bold">Edit</button>
                                <button @click="deleteOrder(order.id)" class="text-red-600 hover:text-red-800 font-bold">Fshij</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            orders: [],
            clients: [],
            isEditing: false,
            currentOrderId: null,
            form: {
                client_id: '',
                product_name: '',
                price: '',
            }
        }
    },
    mounted() {
        this.fetchOrders();
        this.fetchClients();
    },
    methods: {
        fetchOrders() {
            axios.get('/api/orders')
                .then(response => { this.orders = response.data; })
                .catch(error => console.error(error));
        },
        fetchClients() {
            axios.get('/api/clients')
                .then(response => { this.clients = response.data; })
                .catch(error => console.error(error));
        },
        saveOrder() {
            if (!this.form.client_id || !this.form.product_name || !this.form.price) {
                alert("Ju lutem plotësoni të gjitha fushat!");
                return;
            }
            if (this.isEditing) {
                axios.put(`/api/orders/${this.currentOrderId}`, this.form)
                    .then(() => { this.resetForm(); this.fetchOrders(); });
            } else {
                axios.post('/api/orders', this.form)
                    .then(() => { this.resetForm(); this.fetchOrders(); });
            }
        },
        editOrder(order) {
            this.isEditing = true;
            this.currentOrderId = order.id;
            this.form.client_id = order.client_id;
            this.form.product_name = order.product_name;
            this.form.price = order.price;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        deleteOrder(id) {
            if (confirm("A jeni të sigurt?")) {
                axios.delete(`/api/orders/${id}`).then(() => { this.fetchOrders(); });
            }
        },
        resetForm() {
            this.isEditing = false;
            this.currentOrderId = null;
            this.form.client_id = '';
            this.form.product_name = '';
            this.form.price = '';
        }
    }
}
</script>