<template>

  <SidebarAdmin />
  <router-view />

</template>

<script>
import SidebarAdmin from '@/components/admin/SidebarAdmin.vue';


export default {
  components: {
    SidebarAdmin,
  },
};
</script>