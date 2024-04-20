<template>
    <h1>d</h1>
    <div class="form-group">
        <label for="category">Category</label>
        <select class="form-control" id="category" v-model="category"  @change="emitCategory">
            <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
        </select>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    data() {
        return {
            category: null,
            categories: [],
        };
    },
    emits: ['select-category'],
    methods: {
        emitCategory() {
            this.$emit('select-category', this.category);
        },
    },
    async created() {
        try {
            const responseCategories = await axios.get('http://127.0.0.1:8000/api/category');
            this.categories = responseCategories.data;
        } catch (error) {
            console.error(error);
        }

    },
  
};

</script>