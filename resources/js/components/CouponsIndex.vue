<template>
    <div class="container mt-4">
        <div class="card p-4 mb-4 shadow-sm">
            <h4>🎟️ Shto Kupon të Ri</h4>
            <form @submit.prevent="createCoupon" class="row g-3 mt-2">
                <div class="col-md-3">
                    <label class="form-label">Kodi i Kuponit</label>
                    <input type="text" v-model="form.code" class="form-control" required placeholder="p.sh. DISKONT20">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Lloji</label>
                    <select v-model="form.type" class="form-select">
                        <option value="Percentage">Përqindje (%)</option>
                        <option value="Fixed">Vlerë Fikse ($)</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Vlera e Zbritjes</label>
                    <input type="number" step="0.01" v-model="form.value" class="form-control" required placeholder="p.sh. 15">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">Krijo Kupon</button>
                </div>
            </form>
        </div>

        <div class="card p-4 shadow-sm">
            <h4>Lista e Kuponave</h4>
            <table class="table table-bordered table-striped mt-3">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Kodi</th>
                        <th>Lloji</th>
                        <th>Vlera</th>
                        <th>Aksionet</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="coupon in coupons" :key="coupon.id">
                        <td>{{ coupon.id }}</td>
                        <td><strong>{{ coupon.code }}</strong></td>
                        <td>{{ coupon.type }}</td>
                        <td>{{ coupon.type === 'Percentage' ? coupon.value + '%' : '$' + coupon.value }}</td>
                        <td>
                            <button @click="deleteCoupon(coupon.id)" class="btn btn-danger btn-sm">Fshi</button>
                        </td>
                    </tr>
                    <tr v-if="coupons.length === 0">
                        <td colspan="5" class="text-center text-muted">Nuk ka asnjë kupon në databazë.</td>
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
            coupons: [],
            form: {
                code: '',
                type: 'Percentage',
                value: ''
            }
        };
    },
    mounted() {
        this.fetchCoupons();
    },
    methods: {
        fetchCoupons() {
            axios.get('/api/coupons')
                .then(response => { 
                    this.coupons = response.data; 
                })
                .catch(error => console.error("Gabim gjatë marrjes së kuponave:", error));
        },
        createCoupon() {
            axios.post('/api/coupons', this.form)
                .then(() => {
                    this.fetchCoupons();
                    this.form.code = '';
                    this.form.type = 'Percentage';
                    this.form.value = '';
                })
                .catch(error => alert('Gabim gjatë shtimit! Kodi i kuponit duhet të jetë unik.'));
        },
        deleteCoupon(id) {
            if (confirm('A jeni të sigurt që dëshironi ta fshini këtë kupon?')) {
                axios.delete(`/api/coupons/${id}`)
                    .then(() => this.fetchCoupons())
                    .catch(error => console.error(error));
            }
        }
    }
}
</script>