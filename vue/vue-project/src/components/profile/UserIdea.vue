<template>
  <div>
    <h2 class="text-center">Ideas</h2>

        <div class="card p-5 mt-3" v-for="idea in ideas" :key="idea.id">
          <div class="card-body">
            <h5 class="card-title">{{ idea.title }}</h5>
            <p class="card-text">{{ idea.content }}</p>
            <button class="btn btn-black" @click="ideaToShow(idea.id)" >show </button>
      
      </div>
    </div>
  </div>
</template>

<script>
import axiosInstance from '@/axiosConfig.js';


export default {
  data() {
    return {
      ideas: []
    }
  },
  methods: {
    ideaToShow(ideaId) {
     this.$emit('idea-show', ideaId);
    }
  },
 
  async created() {
    try {
      const response = await axiosInstance.get('ideas/user');
      this.ideas = response;
    } catch (error) {
      console.error(error);
    }
  }
}
</script>