import { createRouter, createWebHistory } from 'vue-router'
import  Login from '../components/LoginWorld.vue' ;
import About from '../components/AboutWorld.vue';
import Group from '../components/GroupComponent.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/group',
      name: 'group',
      component: Group
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },
  
    {
      path: '/about',
      name: 'about',
      component: About
    },
  
  ]
})

export default router
