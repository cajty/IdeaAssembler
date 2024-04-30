import { createRouter, createWebHistory } from 'vue-router';
import About from '../components/AboutWorld.vue';

import writting from '../components/WComponent.vue';
import groupWritting from '../components/GroupWritting.vue';






import IdeaWriting from '../views/IdeaWriting.vue';
import AdminView from '../views/AdminV.vue';

import category from '../components/admin/CategoryComponent.vue'
import tag from '../components/admin/TagComponent.vue'
import users from '../components/admin/UserComponent.vue'
import statistique from '../components/admin/StatistiqueComponent.vue'


import mindmap from '../components/MindMap.vue';


import ProfileV from '../views/ProfileV.vue'

import TopicDetail from '../views/TopicDetail.vue'


import tagsSelection from '../components/select/TagSelect.vue'
import serch from '../views/HomePage.vue'






const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/serch',
      name: 'serch',
      component: serch
    },
    {
      path: '/',
      name: 'home',
      component: serch
    },
    {
      path: '/tagsSelection',
      name: 'tagsSelection',
      component: tagsSelection
    },

    {

      path: '/login',
      name: 'login',

      component: () => import('../views/LoginView.vue')

    },
    {
      path: '/signup',
      name: 'signup',

      component: () => import('../views/SignupView.vue')
    },

    {
      path: '/about',
      name: 'about',
      component: groupWritting
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
      path: '/admin',
      component: AdminView,
      children: [
        { path: 'statistique', component: statistique },
        { path: 'category', component: category },
        { path: 'tag', component: tag },
        { path: 'users', component: users },
      ],

    },




    {
      path: '/mindmap',
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
router.beforeEach((to, from, next) => {
  const publicPages = ['/login', '/signup'];
  const authRequired = !publicPages.includes(to.path);
  const loggedIn = localStorage.getItem('user');

  if (authRequired && !loggedIn) {
    return next('/login');
  }

 
  if (to.path.startsWith('/admin')) {
    const role = localStorage.getItem('role');
    if (role !== '1') { 
      return next('/profile'); 
    }
  }

  next();
});





export default router
