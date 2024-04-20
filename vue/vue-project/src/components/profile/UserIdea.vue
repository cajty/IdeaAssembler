<template>
  <div>
    <h2 class="text-center">Ideas</h2>
    <div class="row justify-content-around">
        <div class="card  col-sm-10 col-md-10 col-lg-5 mt-3" v-for="idea in ideas" :key="idea.id">
          <div class="card-body">
            <h5 class="card-title">{{ idea.title }}</h5>
            <p class="card-text">{{ idea.description }}</p>
            <button class="btn btn-black" @click="ideaToShow(idea.id)" >show </button>
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
      const response = await axios.get('http://127.0.0.1:8000/api/ideas/user');
      this.ideas = response.data;
    } catch (error) {
      console.error(error);
    }
  }
}
</script>