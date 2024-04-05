<template>
  <div class="row">
    <div class="col-4 py-5">
      <div class="list-group" id="list-tab" role="tablist">
        <li v-for="(group, index) in groups" :key="group.id"
          :class="['list-group-item', 'list-group-item-action', { active: group.id === selectedGroup }]" role="tab"
          :aria-controls="'group-' + group.id" @click="selectGroup(group.id)">
          {{ group.name }}
        </li>
      </div>
    </div>
    <div class="col-8">
      <GroupComponent :idGroup="selectedGroup" v-if="showGroupComponent" />
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import GroupComponent from './GroupComponent.vue';

export default {
  components: {
    GroupComponent,
  },
  data() {
    return {
      groups: [],
      selectedGroup: 1,
      showGroupComponent: true,
    };
  },
  mounted() {
    this.fetchGroups();
    window.addEventListener('keydown', this.navigateGroups);
  },
  beforeDestroy() {
    window.removeEventListener('keydown', this.navigateGroups);
  },
  methods: {
    fetchGroups() {
      axios.get(`http://127.0.0.1:8000/api/groups/`)
        .then(response => {
          this.groups = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    selectGroup(groupId) {
      this.showGroupComponent = false;
      this.selectedGroup = groupId;

      this.$nextTick(() => {
        this.showGroupComponent = true;
      });
    },
    navigateGroups(event) {
      if (event.key === 'ArrowDown') {
        const nextGroupIndex = this.groups.findIndex(group => group.id === this.selectedGroup) + 1;
        if (nextGroupIndex < this.groups.length) {
          this.selectGroup(this.groups[nextGroupIndex].id);
        }
      } else if (event.key === 'ArrowUp') {
        const prevGroupIndex = this.groups.findIndex(group => group.id === this.selectedGroup) - 1;
        if (prevGroupIndex >= 0) {
          this.selectGroup(this.groups[prevGroupIndex].id);
        }
      }
    },
  },
};
</script>