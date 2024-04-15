<template>
  <div class="row">
    <div class="col-4 py-5">
      <div class="list-group" id="list-tab" role="tablist">
        <li v-for="(group, index) in groups" :key="group.id"
          :class="['list-group-item', 'list-group-item-action', { active: group === selectedGroup }]" role="tab"
          :aria-controls="'group-' + group.id" @click="selectGroup(group)">
          {{ group.name }}
        </li>
      </div>
    </div>
    <div class="col-8">
      <GroupComponent :Group="selectedGroup" v-if="showGroupComponent" />
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
      selectedGroup: {},
      showGroupComponent: false,
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
    async fetchGroups() {
      try {
        const response = await axios.get(`http://127.0.0.1:8000/api/groups/`);

        this.groups = response.data;
        console.log(this.groups);
        setTimeout(() => {
          this.selectedGroup = this.groups[0];

        }, 0);
      } catch (error) {
        console.error(error);
      }
    },
    selectGroup(group) {
      this.showGroupComponent = false;
      this.selectedGroup = group;
      setTimeout(() => {
        this.showGroupComponent = true;
      }, 0);

    },
    navigateGroups(event) {
      if (event.key === 'ArrowDown') {
        const nextGroupIndex = this.groups.findIndex(group => group === this.selectedGroup) + 1;
        console.log(nextGroupIndex);
        if (nextGroupIndex < this.groups.length) {
          console.log(this.groups[nextGroupIndex]);
          this.selectGroup(this.groups[nextGroupIndex]);
        }
      } else if (event.key === 'ArrowUp') {
        const prevGroupIndex = this.groups.findIndex(group => group === this.selectedGroup) - 1;
        console.log(prevGroupIndex);
        if (prevGroupIndex >= 0) {
          console.log(this.groups[prevGroupIndex]);
          this.selectGroup(this.groups[prevGroupIndex]);
        }
      }
    },
  },
};
</script>