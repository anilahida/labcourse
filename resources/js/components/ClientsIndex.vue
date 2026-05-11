<template>
    <div class="space-y-8">
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 shadow-sm">
            <h2 class="text-lg font-semibold mb-4 text-gray-700">Shto Klient të Ri</h2>
            <form @submit.prevent="saveClient" class="flex flex-col md:flex-row gap-4">
                <input v-model="form.name" type="text" placeholder="Emri i plotë" 
                    class="flex-1 p-2 border rounded-md focus:ring-2 focus:ring-blue-500 outline-none">
                
                <input v-model="form.email" type="email" placeholder="Email adresa" 
                    class="flex-1 p-2 border rounded-md focus:ring-2 focus:ring-blue-500 outline-none">
                
                <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition-colors">
                    Ruaj
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 shadow-sm rounded-lg">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200 text-gray-600 uppercase text-xs">
                        <th class="px-6 py-3 text-left font-medium border-r">ID</th>
                        <th class="px-6 py-3 text-left font-medium border-r">Emri</th>
                        <th class="px-6 py-3 text-left font-medium">Email</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <tr v-for="client in clients" :key="client.id" class="hover:bg-gray-50 transition-colors text-sm">
                        <td class="px-6 py-4 text-gray-900 border-r">{{ client.id }}</td>
                        <td class="px-6 py-4 font-semibold text-gray-900 border-r">{{ client.name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ client.email }}</td>
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
            clients: [],
            form: {
                name: '',
                email: ''
            }
        }
    },
    mounted() {
        this.fetchClients();
    },
    methods: {
        fetchClients() {
            axios.get('/api/clients')
                .then(response => { this.clients = response.data; })
                .catch(error => { console.error("Gabim gjatë marrjes së klientëve:", error); });
        },
        saveClient() {
            if (!this.form.name || !this.form.email) {
                alert("Ju lutem plotësoni të gjitha fushat!");
                return;
            }
            axios.post('/api/clients', this.form)
                .then(response => {
                    this.clients.push(response.data); // Shton klientin e ri në listë pa bërë refresh
                    this.form.name = ''; // Pastron formën
                    this.form.email = '';
                })
                .catch(error => { console.error("Gabim gjatë ruajtjes:", error); });
        }
    }
}
</script>