<template>
    <div class="container">
      <h1>Create Topic</h1>
      <form @submit.prevent="createTopic">
        <div class="form-group">
          <label for="topicName">Topic Name</label>
          <input type="text" class="form-control" id="topicName" v-model="topicName" required>
        </div>
        <div class="form-group">
          <label for="description">Description</label>
          <textarea class="form-control" id="description" v-model="description" required></textarea>
        </div>
        <div class="form-group">
          <label for="category">Category</label>
          <select class="form-control" id="category" v-model="category">
            <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
          </select>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        topicName: '',
        description: '',
        category: null,
        categories: []
      }
    },
    async created() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/category');
        this.categories = response.data;
        console.log(response.data);
      } catch (error) {
        console.error(error);
      }
    },
    methods: {
      async createTopic() {
        try {
          const response = await axios.post('http://127.0.0.1:8000/api/topics', {
            topic_name: this.topicName,
            description: this.description,
            category_id: this.category
          });
          console.log(response.data);
        } catch (error) {
          console.error(error);
        }
      }
    }
  }
  </script>