<template>
  <div class=" p-3 border">
    <h2 class="text-center center-4">User's Topics</h2>
  
      <div class=" row overflow-auto"  style="max-height: 200px;">
        <div v-if="topics.length === 0">No topics available</div>
        <div v-else v-for="topic in topics" :key="topic.id" >
          <div class="topic-details bg-secondary mt-2 ">
            <h5>{{ topic.topic_name }}</h5>
            <p>{{ topic.description.substring(0, 100) }}..</p>
            <router-link :to="`/topic/${topic.id}`" class="btn btn-primary">
              <i class="fas fa-eye"></i> Show Topic
            </router-link>
          </div>
        </div>
      </div>
    
  </div>
</template>

<script>
import axiosInstance from '@/axiosConfig.js';


export default {
  data() {
    return {
      topics: []
    };
  },
  async created() {
    try {
      const response = await axiosInstance.get('user/topics');
      this.topics = response;
      console.log(response + "tokenddddddddddddddd");
    
    } catch (error) {
      console.error(error);
    }
  }
};
</script>

<style scoped>






.topic-details {
  padding: 15px;
  border-bottom: 1px solid #000000;
}


</style>
