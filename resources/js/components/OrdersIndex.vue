<template>
    <div class="space-y-6">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-xl font-bold mb-4 text-gray-700">
                {{ isEditing ? 'Edito Porosinë' : 'Shto Porosi të Re' }}
            </h2>
            
            <form @submit.prevent="saveOrder" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Zgjidh Klientin</label>
                    <select v-model="form.client_id" class="w-full border border-gray-300 rounded-md p-2 bg-white" required>
                        <option value="">Zgjidhni një klient...</option>
                        <option v-for="client in clients" :key="client.id" :value="client.id">
                            {{ client.name }}
                        </option>
                    </select>
                </div>

                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Produkti</label>
                    <input v-model="form.product_name" type="text" placeholder="Emri i produktit" class="w-full border border-gray-300 rounded-md p-2" required>
                </div>

                <div class="md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Çmimi (€)</label>
                    <input v-model="form.price" type="number" step="0.01" placeholder="0.00" class="w-full border border-gray-300 rounded-md p-2" required>
                </div>

                <div v-if="isEditing" class="md:col-span-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statusi</label>
                    <select v-model="form.status" class="w-full border border-gray-300 rounded-md p-2 bg-white">
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <div class="flex gap-2 md:col-span-1">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition-colors flex-1">
                        {{ isEditing ? 'Përditëso' : 'Ruaj' }}
                    </button>
                    <button v-if="isEditing" type="button" @click="cancelEdit" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-3 rounded-md transition-colors">
                        Anulo
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold border-b">
                        <th class="p-4">ID</th>
                        <th class="p-4">Klienti</th>
                        <th class="p-4">Produkti</th>
                        <th class="p-4">Çmimi</th>
                        <th class="p-4">Statusi</th>
                        <th class="p-4 text-center">Veprimet</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="order in orders" :key="order.id" class="hover:bg-gray-50 transition-colors text-sm">
                        <td class="p-4 font-medium text-gray-600">{{ order.id }}</td>
                        <td class="p-4 font-bold text-gray-900">{{ order.client ? order.client.name : 'Pa Klient' }}</td>
                        <td class="p-4 text-gray-600">{{ order.product_name }}</td>
                        <td class="p-4 font-bold text-gray-800">{{ parseFloat(order.price).toFixed(2) }} €</td>
                        <td class="p-4">
                            <span :class="['px-2 py-1 rounded-full text-xs font-semibold', statusClass(order.status)]">
                                {{ order.status }}
                            </span>
                        </td>
                        <td class="p-4 text-center space-x-2">
                            <button @click="editOrder(order)" class="text-blue-600 hover:text-blue-900 font-semibold text-xs">Edit</button>
                            <button @click="deleteOrder(order.id)" class="text-red-600 hover:text-red-900 font-semibold text-xs">Fshij</button>
                        </td>
                    </tr>
                    <tr v-if="orders.length === 0">
                        <td colspan="6" class="p-8 text-center text-gray-500">Nuk ka asnjë porosi të regjistruar.</td>
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
            form: {
                id: null,
                client_id: '',
                product_name: '',
                price: '',
                status: 'pending'
            },
            isEditing: false
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
                .catch(error => { console.error("Gabim gjatë marrjes së porosive:", error); });
        },
        fetchClients() {
            axios.get('/api/clients')
                .then(response => { this.clients = response.data; })
                .catch(error => { console.error("Gabim gjatë marrjes së klientëve:", error); });
        },
        saveOrder() {
            if (this.isEditing) {
                axios.put(`/api/orders/${this.form.id}`, this.form)
                    .then(() => {
                        this.fetchOrders();
                        this.resetForm();
                    })
                    .catch(error => { console.error("Gabim gjatë përditësimit:", error); });
            } else {
                axios.post('/api/orders', this.form)
                    .then(() => {
                        this.fetchOrders();
                        this.resetForm();
                    })
                    .catch(error => { console.error("Gabim gjatë ruajtjes:", error); });
            }
        },
        editOrder(order) {
            this.isEditing = true;
            this.form.id = order.id;
            this.form.client_id = order.client_id;
            this.form.product_name = order.product_name;
            this.form.price = order.price;
            this.form.status = order.status;
        },
        deleteOrder(id) {
            if (confirm("A jeni të sigurt që dëshironi ta fshini këtë porosi?")) {
                axios.delete(`/api/orders/${id}`)
                    .then(() => { this.fetchOrders(); })
                    .catch(error => { console.error("Gabim gjatë fshirjes:", error); });
            }
        },
        cancelEdit() {
            this.resetForm();
        },
        resetForm() {
            this.isEditing = false;
            this.form = { id: null, client_id: '', product_name: '', price: '', status: 'pending' };
        },
        statusClass(status) {
            if (status === 'completed') return 'bg-green-100 text-green-800';
            if (status === 'cancelled') return 'bg-red-100 text-red-800';
            return 'bg-yellow-100 text-yellow-800';
        }
    }
}
</script>
              
                          
      
         