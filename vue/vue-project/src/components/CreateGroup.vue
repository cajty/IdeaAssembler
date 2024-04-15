<template>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <form>
                    <div class="mb-3">
                        <label for="groupName" class="form-label">Group Name</label>
                        <input type="text" class="form-control" id="groupName" v-model="newGroup.name"
                            placeholder="Enter new group name">
                    </div>
                    <div v-for="(component, index) in newGroup.components" :key="index" class="mb-3">
                        <label :for="'component' + index" class="form-label">Component {{ index + 1 }}</label>
                        <input type="text" class="form-control" :id="'component' + index" v-model="component.content"
                            placeholder="Enter component content">
                    </div>
                    <div class="d-flex p-2">
                        <button type="button" class="btn btn-primary" @click="addComponent">Add Component</button>
                        <button type="button" class="btn btn-success" @click="createGroup">Create Group</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            newGroup: {
                name: '',
                components: [{ content: '' }],
            },
        };
    },
    methods: {
        addComponent() {
            this.newGroup.components.push({ content: '' });
        },
        createGroup() {
            if (this.newGroup.name.length < 5) {
                alert('Group name must be at least 5 characters long');
                return;
            }
            axios.post('http://127.0.0.1:8000/api/groups', this.newGroup)
                .then(response => {
                    console.log(response.data);
                    this.newGroup = { name: '', components: [{ content: '' }] };
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
};
</script>