import { createRouter, createWebHistory } from 'vue-router';
import  Login from '../components/LoginWorld.vue' ;
import About from '../components/AboutWorld.vue';
import Group from '../components/GroupComponent.vue';
import writting from '../components/WComponent.vue';
import groupWritting from '../components/GroupWritting.vue';
import creatgroup from '../components/CreatGroup.vue'
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
    {
      path: '/writting',
      name: 'writting',
      component: writting
    },
    {
      path: '/groupWritting',
      name: 'groupWritting',
      component: groupWritting
    },
    {
      path: '/creategroup',
      name: 'creategroup',
      component: creatgroup
    }


  
  ]
})

export default router
