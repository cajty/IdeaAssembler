import { createRouter, createWebHistory } from 'vue-router';
import  Login from '../components/LoginWorld.vue' ;
import About from '../components/AboutWorld.vue';

import writting from '../components/WComponent.vue';
import groupWritting from '../components/GroupWritting.vue';






import IdeaWriting from '../views/IdeaWriting.vue';
import AdminView from '../views/AdminV.vue';

import mindmap from '../components/MindMap.vue';


import ProfileV from '../views/ProfileV.vue'

import TopicDetail from '../views/TopicDetail.vue'






const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
 
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
      path: '/IdeaWriting/:ideaId/:topicId',
      name: 'IdeaWriting',
      component: IdeaWriting
    },

    {
      path: '/AdminView',
      name: 'AdminView',
      component: AdminView
    },

   
 

  {
    path:'/mindmap',
    name: 'mindmap',
    component: mindmap
  },

  

  {
    path: '/profile',
    name: 'ProfileV',
    component: ProfileV
  },
  {
    path: '/topic/:id',
    name: 'TopicDetail',
    component: TopicDetail,
    props: true
  },


  
  ]
})

export default router
