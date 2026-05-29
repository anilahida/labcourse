<template>
    <div class="container mt-4">
        <div class="card p-4 mb-4 shadow-sm" style="border-left: 5px solid #8B0000;">
            <h4 class="mb-3" style="color: #8B0000;">Shto Autor</h4>
            <form @submit.prevent="createAuthor">
                <div class="row g-3">
                    <div class="col-md-9">
                        <input v-model="form.name" class="form-control" placeholder="Emri i autorit">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="w-100" style="background-color: #8B0000; color: white; border: none; padding: 8px; border-radius: 4px;">
                            Ruaj Autorin
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card shadow-sm">
            <table class="table table-hover align-middle mb-0">
                <thead style="background-color: #8B0000; color: white;">
                    <tr>
                        <th class="p-3">Emri i Autorit</th>
                        <th class="p-3 text-center">Veprime</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="author in authors" :key="author.id">
                        <td class="p-3">{{ author.name }}</td>
                        <td class="p-3 text-center">
                            <button @click="deleteAuthor(author.id)" class="btn btn-sm" style="background-color: #e74c3c; color: white;">Fshi</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            authors: [],
            form: { name: '' }
        };
    },
    mounted() { this.fetchAuthors(); },
    methods: {
        fetchAuthors() { axios.get('/api/authors').then(res => this.authors = res.data); },
        createAuthor() { axios.post('/api/authors', this.form).then(() => { this.form.name = ''; this.fetchAuthors(); }); },
        deleteAuthor(id) { axios.delete(`/api/authors/${id}`).then(() => this.fetchAuthors()); }
    }
}
</script>