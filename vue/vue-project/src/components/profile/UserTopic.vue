<template>
    <div class="container mt-5">
      <h1>User's Topics</h1>
      <div class="row">
        <div class="col-md-4 mb-3" v-for="topic in topics" :key="topic.id">
          <div class="card">
            <div class="card ">
              <h5 class="card-title">{{ topic.topic_name }}</h5>
              <p class="card-text">{{ topic.description.substring(0, 100)  }} ..</p>
              <router-link :to="`/topic/${topic.id}`" class="btn btn-primary">
              <i class="fas fa-eye"></i> Show Topic
            </router-link>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        topics: []
      }
    },
    async created() {
      try {
        const response = await axios.get('http://127.0.0.1:8000/api/user/topics'); // replace with the actual URL of your API
        this.topics = response.data;
      } catch (error) {
        console.error(error);
      }
    }
  }
  </script>