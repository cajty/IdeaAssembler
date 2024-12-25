<template>
    <div class="col-3 mb-2">
        <div class="list-group" id="list-tab" role="tablist">
            <li v-for="(group, index) in groups" :key="group.id"
                :class="['list-group-item', 'list-group-item-action', { active: group === selectedGroup }]" role="tab"
                @click="selectGroup(index)">
                {{ group.name }} {{ index }}
            </li>
        </div>
    </div>
</template>

<script>
export default {
    props: ['groups', 'selectedGroup'],
    methods: {
        selectGroup(index) {
            this.$emit('updateGroup', index);
        },
    },
};
</script>