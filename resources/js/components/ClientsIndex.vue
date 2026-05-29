<template>
    <div class="space-y-8">
        <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 shadow-sm">
           <h2 class="text-lg font-semibold mb-4 text-gray-700">{{ isEditing ? 'Edito Klientin' : 'Shto Klient të Ri' }}</h2>
            <form @submit.prevent="saveClient" class="flex flex-col md:flex-row gap-4">
                <input v-model="form.name" type="text" placeholder="Emri i plotë" 
                       class="flex-1 p-2 border rounded-md focus:ring-2 focus:ring-blue-500 outline-none">
                
                <input v-model="form.email" type="email" placeholder="Email adresa" 
                       class="flex-1 p-2 border rounded-md focus:ring-2 focus:ring-blue-500 outline-none">
                
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md transition-colors">
                    {{ isEditing ? 'Përditëso' : 'Ruaj' }}
                </button>
            </form>
        </div>

        <div class="overflow-x-auto mt-8">
            <table class="min-w-full bg-white border border-gray-200 shadow-sm rounded-lg overflow-hidden">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200 text-gray-600 uppercase text-xs">
                        <th class="px-6 py-3 text-left font-medium border-r w-16">ID</th>
                        <th class="px-6 py-3 text-left font-medium border-r">Emri</th>
                        <th class="px-6 py-3 text-left font-medium border-r">Email</th>
                        <th class="px-6 py-3 text-center font-medium">Veprimet</th>
                    </tr>
                </thead>
         <tbody class="divide-y divide-gray-200">
            <tr v-for="client in clients" :key="client.id" class="hover:bg-gray-50 transition-colors">
                <td class="px-6 py-4 text-gray-900 border-r">{{ client.id }}</td>
                <td class="px-6 py-4 font-semibold text-gray-900 border-r">{{ client.name }}</td>
                <td class="px-6 py-4 text-gray-600 border-r">{{ client.email }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-center gap-6">
                        <button @click="editClient(client)" class="text-blue-600 hover:text-blue-800 font-bold">
                            Edit
                        </button>
                        <button @click="deleteClient(client.id)" class="text-red-600 hover:text-red-800 font-bold">
                            Fshij
                        </button>
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
            clients: [],
            isEditing: false,
            currentClientId: null,
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
                .then(response => {
                    this.clients = response.data;
                })
                .catch(error => {
                    console.error("Gabim gjatë marrjes së klientëve:", error);
                });
        },
       saveClient() {
            if (!this.form.name || !this.form.email) {
                alert("Ju lutem plotësoni të gjitha fushat!");
                return;
            }

            if (this.isEditing) {
                // Nëse jemi duke edituar
                axios.put(`/api/clients/${this.currentClientId}`, this.form)
                    .then(response => {
                        const index = this.clients.findIndex(c => c.id === this.currentClientId);
                        this.clients[index] = response.data;
                        this.resetForm();
                    })
                    .catch(error => console.error("Gabim gjatë përditësimit:", error));
            } else {
                // Nëse jemi duke shtuar klient të ri
                axios.post('/api/clients', this.form)
                    .then(response => {
                        this.clients.push(response.data);
                        this.resetForm();
                    })
                    .catch(error => console.error("Gabim gjatë ruajtjes:", error));
            }
        },
        editClient(client) {
            this.isEditing = true;
            this.currentClientId = client.id;
            this.form.name = client.name;
            this.form.email = client.email;
            window.scrollTo({ top: 0, behavior: 'smooth' }); // E dërgon faqen lart te forma
        },

        resetForm() {
            this.isEditing = false;
            this.currentClientId = null;
            this.form.name = '';
            this.form.email = '';
        },
        deleteClient(id) {
            if (confirm("A jeni të sigurt që dëshironi ta fshini këtë klient?")) {
                axios.delete(`/api/clients/${id}`)
                    .then(() => {
                        this.clients = this.clients.filter(client => client.id !== id);
                    })
                    .catch(error => {
                        console.error("Gabim gjatë fshirjes:", error);
                    });
            }
        }
    }
}
</script>