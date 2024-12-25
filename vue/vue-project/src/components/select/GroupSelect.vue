<template>
    <div>
        <div class="form-group">
            <div class="row overflow-auto" style="max-height: 100px;">
                <div v-for="group in groups" :key="group.id" class="col-12">
                    <div class="form-check border ">
                        <input type="checkbox" class="form-check-input" :id="'group' + group.id" :value="group.id"
                            v-model="selectedGroups"  @change="emitSelectedGroups">
                        <label class="form-check-label" :for="'group' + group.id">{{ group.name }}</label>
                    </div>
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
            selectedGroups: [],
            groups: [],
        };
    },
    emits: ['selectedGroups'],
    methods: {
        emitSelectedGroups() {
            this.$emit('selectedGroups', this.selectedGroups);
        },

    },
    async created() {
        try {
            const response = await axiosInstance.get('groups');
            this.groups = response;

        } catch (error) {
            console.error(error);
        }
    },
};
</script>