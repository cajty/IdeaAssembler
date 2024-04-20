<script setup>
import { RouterLink, RouterView } from 'vue-router'
import './assets/main.css'

</script>


<template>

  <div  class="row justify-content-between">
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container">
        <router-link class="navbar-brand" to="/">IdeaAssembler</router-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link class="nav-link" to="/AdminView">AdminView</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/profile">profile</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/create-topic">create-topic</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/s">create-group</router-link>
            </li>
            <li class="nav-item">
              <router-link class="nav-link" to="/IdeaWriting">IdeaWriting</router-link>
            </li>
          </ul>

          <div class="dropdown  ">
            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
              {{ isLoggedIn ? userName : 'Login' }}
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <li v-if="isLoggedIn"><a class="dropdown-item" @click="logout">Logout</a></li>
              <li v-else>
                <router-link class="dropdown-item" to="/signup">Sign in</router-link>
                <router-link class="dropdown-item" to="/login">Login</router-link>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>

    <div v-if="success" class="alert alert-success z-2" id="alert">
      {{ success }}
    </div>
    <div v-if="errors.length" class="alert alert-danger z-2" id="alert">
      <ul>
        <li v-for="error in errors">{{ error }}</li>
      </ul>
    </div>

    <RouterView />

    <div class="d-flex flex-column vh-100">
    <footer class="py-4 bg-dark text-white mt-auto">
      <div class="container text-center">
        <p>&copy; 2024 EventOrg. All rights reserved.</p>
      </div>
    </footer>
  </div>

 </div>
</template>

<script>
export default {
  data() {
    return {
      success: '',
      errors: [],
      isLoggedIn: false,
      userName: '',
    };
  },
  methods: {
    logout() {
      // Handle logout logic
    },
  },
};
</script>
<style scoped>
.vh-100 {
  min-height: 0vh;
}
</style>



