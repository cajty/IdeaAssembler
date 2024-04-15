<template>
    <SidebarAdmin />
    <CategoryComponent />
</template>

<script>
import SidebarAdmin from '@/components/admin/SidebarAdmin.vue';
import CategoryComponent from '@/components/admin/CategoryComponent.vue';

export default {
    components: {
        SidebarAdmin,
        CategoryComponent,
    },
};
</script>