<template>
    <div class="container mt-4">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between">
                <h4>Lista e Klientëve</h4>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Emri</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="client in clients" :key="client.id">
                            <td>{{ client.id }}</td>
                            <td>{{ client.name }}</td>
                            <td>{{ client.email }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            clients: [] // Këtu do të ruhen të dhënat që vijnë nga API
        }
    },
    mounted() {
        this.fetchClients();
    },
    methods: {
        fetchClients() {
            // Thirrja e API-t që krijuam te routes/api.php
            axios.get('/api/clients')
                .then(response => {
                    this.clients = response.data;
                })
                .catch(error => {
                    console.error("Gabim gjatë marrjes së klientëve:", error);
                });
        }
    }
}
</script>