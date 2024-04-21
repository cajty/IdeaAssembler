<template>
    <div class="card mt-4 col-8 m-5" id="d">
        <div class="card-body">
            <h5 class="card-title">
                <form @submit.prevent="submittag">
                    <div class="d-flex">
                        <div class="form-group mx-sm-3 mb-2">
                            <label for="name" class="sr-only">tags</label>
                            <input type="text" v-model="tagName" id="name" class="form-control"
                                placeholder="tags">
                        </div>
                        <button type="submit" class="btn btn-primary mb-2">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </form>
            </h5>
            <table class="table">
                <tbody>
                    <tr v-for="(tag, index) in tags" :key="index">
                        <td>
                            <input type="text" v-model="tag.name" class="form-control">

                        </td>
                        <td>
                            <button @click="updateTag(tag.id, tag.name)" class="btn btn-primary">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button @click="deleteTag(tag.id)" class="btn btn-danger">
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
            tags: [],
            tagName: '',
        };
    },
    mounted() {
        this.getTags();
    },
    methods: {
        async getTags() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/tag');
                this.tags = response.data;
            } catch (error) {
                console.error(error);
            }
        },
        async submittag() {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/tag', { name: this.tagName });
                console.log(response.data);
                this.tags.push(response.data);
                this.tagName = '';
            } catch (error) {
                console.error(error);
            }
        },
        async getTag(id) {
            try {
                const response = await axios.get(`http://127.0.0.1:8000/api/tag/${id}`);
                this.tagName = response.data.name;
            } catch (error) {
                console.error(error);
            }
        },
        async deleteTag(id) {
            try {
                await axios.delete(`http://127.0.0.1:8000/api/tag/${id}`);
                this.tags = this.tags.filter(tag => tag.id !== id);
            } catch (error) {
                console.error(error);
            }
        },
        async updateTag(id, name) {
            try {
                const response = await axios.put(`http://127.0.0.1:8000/api/tag/${id}`, { name: name });
            } catch (error) {
                console.error(error);
            }
        },
    },
    created() {
        this.getTags();
    },
};
</script>