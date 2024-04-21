<template>
    <SidebarAdmin />
    <TagComponent />
    <CategoryComponent />
   
</template>

<script>
import SidebarAdmin from '@/components/admin/SidebarAdmin.vue';
import CategoryComponent from '@/components/admin/CategoryComponent.vue';

import TagComponent from '@/components/admin/TagComponent.vue'


export default {
    components: {
        SidebarAdmin,
        CategoryComponent,
        TagComponent,
    },
};
</script>