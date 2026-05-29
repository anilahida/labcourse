<template>
    <div class="space-y-6">
        <div class="bg-white p-6 shadow-md rounded-lg">
            <h2 class="text-xl font-bold mb-4 text-gray-700">
                {{ isEditing ? 'Edito Detajin e Porosisë' : 'Shto Detaj të Ri Porosie' }}
            </h2>
            
            <form @submit.prevent="saveDetail" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Zgjidh Porosinë (ID)</label>
                    <select v-model="form.order_id" class="w-full border border-gray-300 rounded-md p-2 bg-white" required>
                        <option value="">Zgjidhni një porosi...</option>
                        <option v-for="order in orders" :key="order.id" :value="order.id">
                            ID: {{ order.id }} - {{ order.product_name }}
                        </option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Emri i Artikullit</label>
                    <input v-model="form.item_name" type="text" placeholder="Artikulli" class="w-full border border-gray-300 rounded-md p-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sasia</label>
                    <input v-model="form.quantity" type="number" min="1" class="w-full border border-gray-300 rounded-md p-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Çmimi (€)</label>
                    <input v-model="form.price" type="number" step="0.01" min="0" class="w-full border border-gray-300 rounded-md p-2" required>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md flex-1">
                        {{ isEditing ? 'Përditëso' : 'Ruaj' }}
                    </button>
                    <button v-if="isEditing" type="button" @click="cancelEdit" class="bg-gray-400 text-white font-bold py-2 px-3 rounded-md">
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
                        <th class="p-4">Porosia ID</th>
                        <th class="p-4">Artikulli</th>
                        <th class="p-4">Sasia</th>
                        <th class="p-4">Çmimi</th>
                        <th class="p-4">Totali</th>
                        <th class="p-4 text-center">Veprimet</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="detail in details" :key="detail.id" class="hover:bg-gray-50 text-sm">
                        <td class="p-4">{{ detail.id }}</td>
                        <td class="p-4 font-bold">Porosia #{{ detail.order_id }}</td>
                        <td class="p-4">{{ detail.item_name }}</td>
                        <td class="p-4">{{ detail.quantity }}</td>
                        <td class="p-4">{{ detail.price }} €</td>
                        <td class="p-4 font-bold text-blue-600">{{ (detail.quantity * detail.price).toFixed(2) }} €</td>
                        <td class="p-4 text-center space-x-2">
                            <button @click="editDetail(detail)" class="text-blue-600 font-semibold text-xs">Edit</button>
                            <button @click="deleteDetail(detail.id)" class="text-red-600 font-semibold text-xs">Fshij</button>
                        </td>
                    </tr>
                    <tr v-if="details.length === 0">
                        <td colspan="7" class="p-8 text-center text-gray-500">Nuk ka asnjë detaj porosie.</td>
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
            details: [],
            orders: [],
            form: {
                id: null,
                order_id: '',
                item_name: '',
                quantity: 1,
                price: ''
            },
            isEditing: false
        }
    },
    mounted() {
        this.fetchDetails();
        this.fetchOrders();
    },
    methods: {
        fetchDetails() {
            axios.get('/api/order-details')
                .then(response => { this.details = response.data; })
                .catch(error => { console.error(error); });
        },
        fetchOrders() {
            axios.get('/api/orders')
                .then(response => { this.orders = response.data; })
                .catch(error => { console.error(error); });
        },
        saveDetail() {
            if (this.isEditing) {
                axios.put('/api/order-details/' + this.form.id, this.form)
                    .then(() => {
                        this.fetchDetails();
                        this.resetForm();
                    })
                    .catch(error => { console.error(error); });
            } else {
                axios.post('/api/order-details', this.form)
                    .then(() => {
                        this.fetchDetails();
                        this.resetForm();
                    })
                    .catch(error => { console.error(error); });
            }
        },
        editDetail(detail) {
            this.isEditing = true;
            this.form.id = detail.id;
            this.form.order_id = detail.order_id;
            this.form.item_name = detail.item_name;
            this.form.quantity = detail.quantity;
            this.form.price = detail.price;
        },
        deleteDetail(id) {
            if (confirm("A jeni të sigurt?")) {
                axios.delete('/api/order-details/' + id)
                    .then(() => { this.fetchDetails(); })
                    .catch(error => { console.error(error); });
            }
        },
        cancelEdit() {
            this.resetForm();
        },
        resetForm() {
            this.isEditing = false;
            this.form = { id: null, order_id: '', item_name: '', quantity: 1, price: '' };
        }
    }
}
</script>