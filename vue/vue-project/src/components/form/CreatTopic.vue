<template>
  <div class="popup">
    <button @click="closePopup" class="btn btn-light position-absolute top-0 end-0 m-1">x</button>
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
      <GroupSelect @selectedGroups="selectedGroup" />
      <CategorySelect @select-category="selectCategory" />
      <button type="submit" class="btn btn-primary">Create Topic</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import GroupSelect from '@/components/select/GroupSelect.vue';
import CategorySelect from '@/components/select/CategorySelect.vue';

export default {
  components: {
    GroupSelect,
    CategorySelect,
  },
  data() {
    return {
      topicName: '',
      description: '',
      category: null,
      categories: [],
      selectedGroups: [],
      groups: []
    }
  },
  methods: {
    closePopup() {
      this.$emit('close');
    },
    selectedGroup(selectedGroups) {
      console.log(selectedGroups);
      this.selectedGroups = selectedGroups;
      console.log(this.selectedGroups);
    },
    selectCategory(category) {
      console.log(category);
      this.category = category;
      console.log(this.category);
    },
    async createTopic() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/topics', {
          topic_name: this.topicName,
          description: this.description,
          category_id: this.category,
          groups: this.selectedGroups
        });
        let id = response.data.Topic_all_info.id;
        this.$router.push(`/topic/${id}`);
      } catch (error) {
        console.error(error);
      }
    }
  }
}
</script>

<style scoped>
.popup {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 1000;
  width: 80%;
  max-width: 90vw;
  height: 80%;
  max-height: 90vh;
  padding: 20px;
  background-color: white;
  border: 1px solid #ccc;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
</style>