<template>
    <div class="container mt-4">
        <div class="card p-4 mb-4 shadow-sm">
            <h4>📦 Shto Dërgesë të Re</h4>
            <form @submit.prevent="createShipment" class="row g-3 mt-2">
                <div class="col-md-3">
                    <label class="form-label">ID e Porosisë</label>
                    <input type="number" v-model="form.order_id" class="form-control" required placeholder="p.sh. 1">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Numri i Gjurmimit (Tracking)</label>
                    <input type="text" v-model="form.tracking_number" class="form-control" required placeholder="p.sh. TRK12345">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Statusi</label>
                    <select v-model="form.status" class="form-select">
                        <option value="Pending">Pending</option>
                        <option value="Shipped">Shipped</option>
                        <option value="Delivered">Delivered</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Ruaj Dërgesën</button>
                </div>
            </form>
        </div>

        <div class="card p-4 shadow-sm">
            <h4>Lista e Dërgesave</h4>
            <table class="table table-bordered table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>ID e Porosisë</th>
                        <th>Kodi Tracking</th>
                        <th>Statusi</th>
                        <th>Aksionet</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="shipment in shipments" :key="shipment.id">
                        <td>{{ shipment.id }}</td>
                        <td>Porosia #{{ shipment.order_id }}</td>
                        <td><code>{{ shipment.tracking_number }}</code></td>
                        <td>
                            <span class="badge" :class="shipment.status === 'Delivered' ? 'bg-success' : (shipment.status === 'Shipped' ? 'bg-info' : 'bg-warning')">
                                {{ shipment.status }}
                            </span>
                        </td>
                        <td>
                            <button @click="deleteShipment(shipment.id)" class="btn btn-danger btn-sm">Fshi</button>
                        </td>
                    </tr>
                    <tr v-if="shipments.length === 0">
                        <td colspan="5" class="text-center text-muted">Nuk ka asnjë dërgesë në databazë.</td>
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
            shipments: [],
            form: {
                order_id: '',
                tracking_number: '',
                status: 'Pending'
            }
        };
    },
    mounted() {
        this.fetchShipments();
    },
    methods: {
        fetchShipments() {
            axios.get('/api/shipments')
                .then(response => { this.shipments = response.data; })
                .catch(error => console.error(error));
        },
        createShipment() {
            axios.post('/api/shipments', this.form)
                .then(() => {
                    this.fetchShipments();
                    this.form.order_id = '';
                    this.form.tracking_number = '';
                    this.form.status = 'Pending';
                })
                .catch(error => alert('Gabim gjatë shtimit! Sigurohu që ID e porosisë ekziston dhe kodi tracking është unik.'));
        },
        deleteShipment(id) {
            if (confirm('A jeni të sigurt që dëshironi ta fshini këtë dërgesë?')) {
                axios.delete(`/api/shipments/${id}`)
                    .then(() => this.fetchShipments())
                    .catch(error => console.error(error));
            }
        }
    }
}
</script>