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
                    <input v-model="form.total_amount" type="number" class="form-control" placeholder="Shuma (p.sh. 20)" required>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-success">Ruaj</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            clients: [],
            form: { 
                client_id: '', 
                book_title: '', 
                total_amount: '' 
            }
        };
    },
    mounted() {
        axios.get('/api/clients').then(res => this.clients = res.data);
    },
    methods: {
    createOrder() {
        // Kjo do të printojë në Console çfarë po dërgohet
        console.log("Po dërgojmë këtë objekt:", this.form); 
        
        axios.post('/api/orders', this.form)
            .then(() => {
                alert('U ruajt me sukses!');
                window.location.reload();
            })
            .catch(error => {
                // Kjo do të tregojë gabimin real nga serveri
                console.error("Gabimi nga serveri:", error.response.data);
            });
    }
}
}
</script>