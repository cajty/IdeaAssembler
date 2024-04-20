<template>
  <div class=" p-3 border">
    <h2 class="text-center mb-3">User Groups</h2>
    <div>
      <div class=" row overflow-auto" style="max-height: 200px;">
        <div v-if="groups.length === 0">No groups available</div>
        <div v-else v-for="group in groups" :key="group.id" class="pb-1 group-item">
          <span>{{ group.name }}</span>
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
      groups: [],
    };
  },
  async created() {
    try {
      const response = await axios.get('http://127.0.0.1:8000/api/groups');
      this.groups = response.data;
    } catch (error) {
      console.error(error);
    }
  },
};
</script>

<style scoped>




.group-item {
  border-bottom: 1px solid #000000;
}


</style>
