<template>
 
        <div class="card popup  overflow-auto">
        <button @click="closePopup" class="btn btn-light position-absolute top-0 end-0 m-1">x</button>
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
        closePopup() {
            this.$emit('close');
        },
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
                    this.newGroup =response.data;
                    this.$emit( 'newGroup' ,this.newGroup[0]);
                    
                })
                .catch(error => {
                    console.error(error);
                });
        },
    },
};
</script>
<style scoped>
.popup {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    width: 80%;
    max-width: 450px;
    height: 80%;
    max-height: 450PX;
    padding: 20px;
    background-color: white;
    border: 1px solid #ccc;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
</style>