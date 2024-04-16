<template>
  <div class="col-md-3 bg-dark p-4 d-none d-md-block sticky-top side">
    <h4 class="text-light">Admin</h4>
    <ul class="list-group">
      <li class="list-group-item">
        <router-link class="list-group-item" to="/AdminView">Categories</router-link>
      </li>
      <li class="list-group-item">
        <router-link class="list-group-item" to="/events/validate">Events</router-link>
      </li>
      <li class="list-group-item">
        <router-link class="list-group-item" to="/user">User</router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'SidebarAdmin',
  // Add your component logic here
}
</script>

<style scoped>
.side {
  height: 100vh;
}
</style>