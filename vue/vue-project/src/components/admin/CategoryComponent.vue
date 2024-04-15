<template>
    <div class="card mt-4 col-8 m-5" id="d">
        <div class="card-body">
            <h5 class="card-title">
                <form @submit.prevent="submitCategory">
                    <div class="d-flex">
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="name" class="sr-only">Categories</label>
                            <input type="text" v-model="categoryName" id="name" class="form-control"
                                placeholder="Categories">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </form>
            </h5>
            <table class="table">
                <tbody>
                    <tr v-for="(category, index) in categories" :key="index">
                        <td>
                            <input type="text" v-model="category.name" class="form-control">

                        </td>
                        <td>
                            <button @click="updateCategory(category.id, category.name)" class="btn btn-primary">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button @click="deleteCategory(category.id)" class="btn btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <!-- Pagination component goes here -->
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            categories: [],
            categoryName: '',
        };
    },
    mounted() {
        this.getCategories();
    },
    methods: {
        async getCategories() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/category');
                this.categories = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        async submitCategory() {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/category', { name: this.categoryName });
                console.log(response.data);
                this.categories.push(response.data);
                this.categoryName = '';
            } catch (error) {
                console.error(error);
            }
        },
        async getCategory(id) {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/category/${id}`);
                this.categoryName = response.data.name;
            } catch (error) {
                console.error(error);
            }
        },
        async deleteCategory(id) {
            try {
                await axios.delete(`http://127.0.0.1:8000/api/category/${id}`);
                this.categories = this.categories.filter(category => category.id !== id);
            } catch (error) {
                console.error(error);
            }
        },
        async updateCategory(id, name) {
            try {
                const response = await axios.put(`http://127.0.0.1:8000/api/category/${id}`, { name: name });
            } catch (error) {
                console.error(error);
            }
        },
    },
    created() {
        this.getCategories();
    },
};
</script>