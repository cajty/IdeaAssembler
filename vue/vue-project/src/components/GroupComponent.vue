<template>
  <div class="container mt-5">
    <div class="card">
      <div class="card-body">
        <h1 class="card-title text-3xl font-bold mb-4">Your Cart</h1>

        <!-- Form to add a new component -->
        <form @submit.prevent="createComponent" class="mb-4">
          <p v-if="error" class="text-danger mt-2">{{ error }}</p>
          <div class="mb-3">
            <label for="content" class="form-label">Add Item:</label>
            <input type="text" id="content" v-model="content" class="form-control" placeholder="Enter item name">
          </div>
          <button type="submit" class="btn btn-primary">Add to Cart</button>
        </form>

        <!-- Display existing components (cart items) -->
        <div v-if="components.length > 0">
          <h3 class="text-lg font-semibold text-success mb-2">Cart Items</h3>
          <ul class="list-group">
            <li v-for="component in components" :key="component.id" class="list-group-item">
              <div class="d-flex justify-content-between align-items-center">
                <input type="text" v-model="component.content" class="form-control">
                <div>
                  <button class="btn btn-warning me-2" @click="updateComponent(component.id, component.content)">Edit</button>
                  <button class="btn btn-danger" @click="deleteComponent(component.id)">Remove</button>
                </div>
              </div>
            </li>
          </ul>
        </div>

        <!-- Show message if cart is empty -->
        <p v-if="components.length === 0" class="text-gray-600">Your cart is empty.</p>
      </div>
    </div>
  </div>
</template>
  
  
  
  <script>
  import axios from 'axios';
  
  export default {
    data() {
      return {
        groupName: '',
        components: [],
        content: '',
        error: '',
        id: null,
      };
    },
  
    mounted() {
      
      //  let id=$router.params.id;
       fetchGroup(2);
    },
  
    methods: {
      fetchGroup(id) {
        axios.get(`http://127.0.0.1:8000/api/groups/${id}`)
        
          .then(response => {
            this.groupName = response.data.group;
            this.components = response.data.components;
          })
          .catch(error => {
            console.error(error);
            this.eror = error;
          });
      },
  
      createComponent() {
        axios.post('http://127.0.0.1:8000/api/groups/1/componentss', {
          content: this.content,
        })
          .then(response => {
            this.components.push(response.data.component);
            this.content = '';
          })
          .catch(error => {
           
            this.error = error.response.data.error;

          });
      },
  
      deleteComponent(id) {
        axios.delete(`http://127.0.0.1:8000/api/groups/1/components/${id}`)
          .then(() => {
            const index = this.components.findIndex(c => c.id === id);
            this.components.splice(index, 1);
          })
          .catch(error => {
            console.error(error);
          });
      },
  
      updateComponent(id, content) {
        axios.put(`http://127.0.0.1:8000/api/groups/1/components/${id}`, { content })
          .then(() => {
            const index = this.components.findIndex(c => c.id === id);
            this.components[index].content = content;
          })
          .catch(error => {
            console.error(error);
          });
      },
      updateGroup(groupId, groupName) {
    axios.put(`http://127.0.0.1:8000/api/groups/${groupId}`, { name: groupName })
      .then(response => {
        this.groupName = response.data.group;
      })
      .catch(error => {
        console.error(error);
      });
  }
    }
  }
  </script>
  
  
  