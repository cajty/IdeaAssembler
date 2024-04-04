<template>
  <div class="row">
    <div class="col-4 py-5">
      <div class="list-group" id="list-tab" role="tablist">
        <a
          v-for="group in groups"
          :key="group.id"
          :class="['list-group-item', 'list-group-item-action', { active: group === selectedGroup }]"
          :href="'#list-group-' + group.id"
          role="tab"
          :aria-controls="'group-' + group.id"
          @click="selectGroup(group)"
        >
          {{ group.name }}
        </a>
      </div>
    </div>
    <div class="col-8">
      <div class="tab-content" id="nav-tabContent">
        <div
          v-for="group in groups"
          :key="group.id"
          :id="'group-' + group.id"
          class="tab-pane fade"
          :class="{ show: group === selectedGroup }"
          role="tabpanel"
          :aria-labelledby="'list-group-' + group.id"
        >
          <h3>{{ group.name }}</h3>
          <p>Created at: {{ group.created_at }}</p>
          <p>Updated at: {{ group.updated_at }}</p>
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
      selectedGroup: null,
    };
  },
  mounted() {
    this.fetchGroups();
  },
  methods: {
    fetchGroups() {
      axios.get(`http://127.0.0.1:8000/api/groups/`)
        .then(response => {
          this.groups = response.data;
          this.selectedGroup = response.data[0]; // Select the first group by default
        })
        .catch(error => {
          console.error(error);
        });
    },
    selectGroup(group) {
      this.selectedGroup = group;
    },
  },
};
</script>