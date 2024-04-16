<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-body">
        <h1 class=" mb-4">
          <input type="text" v-model="Group.name">
        </h1>
        <button @click="updateGroup( Group.name)" class="btn btn-primary">
          <i class="fas fa-edit"></i>
        </button>
        <button @click="deleteGroup()" class="btn btn-danger">Delete Group</button>
        <!-- Form to add a new component -->
        <form @submit.prevent="createComponent" class="mb-4">
          <p v-if="error" class="text-danger mt-2">{{ error }}</p>
          <div class="mb-3">
            <label for="content" class="form-label">Add component:</label>
            <input type="text" id="content" v-model="content" class="form-control" placeholder="Enter item name">
          </div>
          <button type="submit" class="btn btn-primary">Add</button>
        </form>

        <!-- Display existing components (cart items) -->
        <!-- <div v-if="components.length > Group"> -->
        <h3 class="text-lg font-semibold text-success mb-2">Cart Items</h3>
        <ul class="list-group">
          <li v-for="component in Group.component" :key="component.id" class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
              <input type="text" v-model="component.content" class="form-control">
              <div>
                <button @click="updateComponent(component.id, component.content)" class="btn btn-primary">
                  <i class="fas fa-edit"></i>
                </button>
                <button @click="deleteComponent(component.id)" class="btn btn-danger">
                  <i class="fas fa-trash-alt"></i>
                </button>
              </div>
            </div>
          </li>
        </ul>
        <!-- </div> -->

        <!-- Show message if cart is empty -->
        <!-- <p v-if="components.length === 0" class="text-gray-600">Your cart is empty.</p> -->
      </div>
    </div>
  </div>
</template>






<script>
import axios from 'axios';

export default {
  data() {
    return {
      content: '',
      error: null,
    };
  },
  props: {
    Group: {
      type: Object,
      required: true,
    }
  },
  methods: {
    createComponent() {
      axios.post(`http://127.0.0.1:8000/api/groups/${this.Group.id}/componentss`, {
        content: this.content,
      })
        .then(response => {
          this.Group.component.push(response.data.component);
          this.content = '';
          this.error = null;
        })
        .catch(error => {
          this.error = error.response.data.error;
        });
    },
    deleteComponent(id) {
      axios.delete(`http://127.0.0.1:8000/api/groups/${this.Group.id}/components/${id}`)
        .then(() => {
          const index = this.Group.component.findIndex(c => c.id === id);
          this.Group.component.splice(index, 1);
        })
        .catch(error => {
          console.error(error);
        });
    },
    updateComponent(id, content) {
      axios.put(`http://127.0.0.1:8000/api/groups/${this.Group.id}/components/${id}`, { content })
        .then(() => {
          const index = this.Group.component.findIndex(c => c.id === id);
          this.Group.component[index].content = content;
        })
        .catch(error => {
          console.error(error);
        });
    },
    updateGroup(groupName) {
      axios.put(`http://127.0.0.1:8000/api/groups/${this.Group.id}`, { name: groupName })
        .then(response => {
          console.log(groupName);
          this.Group.name= groupName;
        })
        .catch(error => {
          console.error(error);
        });
    },
    deleteGroup() {
    axios.delete(`http://127.0.0.1:8000/api/groups/${this.Group.id}`)
      .then(() => {
        // remove the group from the local state
        this.Group = this.Group.filter(group => group.id !== groupId);
      })
      .catch(error => {
        console.error(error);
      });
  },
  },
 

}
</script>

<!-- fetchGroup(id) {
  axios.get(`http://127.0.0.1:8000/api/groups/${id}`)
    .then(response => {
      console.log(response.data);
      this.groupName = response.data.group;
      this.components = response.data.components;
    })
    .catch(error => {
      console.error(error);
      this.eror = error;
    });
}, -->