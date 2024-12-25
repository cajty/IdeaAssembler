<template>
    <div class="form-group">
        <select class="form-control" id="category" v-model="category"  @change="emitCategory">
            <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
        </select>
    </div>
</template>

<script>
import axiosInstance from '@/axiosConfig.js';

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
            const responseCategories = await axiosInstance.get('category');
            this.categories = responseCategories;
        } catch (error) {
            console.error(error);
        }

    },
  
};

</script>