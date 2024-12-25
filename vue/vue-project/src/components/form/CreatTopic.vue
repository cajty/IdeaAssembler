<template>
  <div class="popup  overflow-auto">
    <button @click="closePopup" class="btn btn-light position-absolute top-0 end-0 m-1">x</button>
    <h1>Create Topic</h1>
    <form @submit.prevent="createTopic">
      <div class="mb-3">
        <label for="topicName" class="form-label">Topic Name</label>
        <input type="text" class="form-control" id="topicName" v-model="topicName" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" v-model="description" required></textarea>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Group</label>

        <GroupSelect @selectedGroups="selectedGroup" />
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">tag</label>

        <TagSelect @addTags="addTags"  />
      </div>
      <div class="mb-3">
        <label for="isPublic" class="form-label">Is Public?</label>
        <select class="form-control" id="isPublic" v-model="isPublic" required>
          <option value="true">Yes</option>
          <option value="false">No</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Category</label>

        <CategorySelect @select-category="selectCategory" />
      </div>
      <button type="submit" class="btn btn-primary">Create Topic</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
import GroupSelect from '@/components/select/GroupSelect.vue';
import CategorySelect from '@/components/select/CategorySelect.vue';
import TagSelect from '@/components/select/TagSelect.vue';

export default {
  components: {
    GroupSelect,
    CategorySelect,
    TagSelect,
  },
  data() {
    return {
      topicName: '',
      description: '',
      category: null,
      categories: [],
      selectedGroups: [],
      groups: [],
      isPublic: 'true',
    }
  },
  methods: {
    closePopup() {
      this.$emit('close');
    },
    selectedGroup(selectedGroups) {
      this.selectedGroups = selectedGroups;
    },
    selectCategory(category) {
      this.category = category;
    },
    async createTopic() {
      try {
        const response = await axios.post('http://127.0.0.1:8000/api/topics', {
          topic_name: this.topicName,
          description: this.description,
          category_id: this.category,
          groups: this.selectedGroups,
          tags: this.tags,
          isPublic: this.isPublic === 'true',
        });
      
      let id = response.data[0].id;
     
        this.$router.push(`/topic/${id}`);
      } catch (error) {
        console.error(error);
      }
    },
    addTags(tags) {
      this.tags = tags;
      console.log(this.tags);
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
  height: 100%;
  max-height: 100vh;
  padding: 20px;
  background-color: white;
  border: 1px solid #ccc;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
</style>
