
import { createRouter, createWebHistory } from 'vue-router';
import { useUserStore } from '../stores/userStore';
import { useNotificationStore } from '../stores/NotiStore';

import HomeComponent from '../components/HomeComponent.vue';
import ShowComponent from '../components/ShowComponent.vue';
import EpisodeListComponent from '../components/EpisodeListComponent.vue';
import LetsTalkComponent from '../components/LetsTalkComponent.vue';
import ForumComponent from '../components/ForumComponent.vue';
import ForumShowComponent from '../components/ForumShowComponent.vue';
import AudienceShowsComponent from '../components/AudienceShowsComponent.vue';
import myFavoriteComponent from '../components/myFavoriteComponent.vue';
import playListComponent from '../components/playListComponent.vue';

const VerifyComponent = () => import('../components/VerifyComponent.vue');
const ResetPwdComponent = () => import('../components/ResetPwdComponent.vue');
const AdminManageShowsComponent = () => import('../components/AdminManageShowsComponent.vue');
const AdminManageHostComponent = () => import('../components/AdminManageHostComponent.vue');
const AdminDashboardComponent = () => import('../components/AdminDashboardComponent.vue');
const AdminShowComponent = () => import('../components/AdminShowComponent.vue');
const AdminForumComponent = () => import('../components/AdminForumComponent.vue');
const AdminForumShowComponent = () => import('../components/AdminForumShowComponent.vue');

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    
    {
      path: '/',
      name: 'home',
      component: HomeComponent
    },

    {
      path: '/about',
      name: 'about',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      
    },

    {

      path : '/audienceShows',
      name : 'audienceShows',
      component : AudienceShowsComponent
    },

    {
      
      path : '/show/:id',
      name : 'show',
      component : ShowComponent,
      children : [
        {
          path : 'episode/',
          name : 'episode',
          component : EpisodeListComponent
        },
        {
          path : 'forums/',
          name : 'forum',
          component : LetsTalkComponent
        }
      ]
    },

    {
      path : '/forums',
      name : 'audienceforums',
      component : ForumComponent
    },

    {
      path : '/forum/:showId/:forumid',
      name : 'audienceforum',
      component : ForumShowComponent
    },

    {
      path : '/favoriteList',
      name : 'myFavorite',
      component : myFavoriteComponent
    },

    {
      path : '/playList',
      name : 'playList',
      component : playListComponent
    },
    {
      path : '/resetpwd',
      name : 'pwdreset',
      component : ResetPwdComponent
    },
    {
      path : '/verify',
      name : 'verify',
      component : VerifyComponent
    },
    {
      path : '/adminDashborad/forum',
      name : 'Adminforum',
      beforeEnter : (to, from, next) => {
        const userStore = useUserStore();
        const notiStore = useNotificationStore();
        if(userStore.hasValideToken) {
          next();
        } else {
          notiStore.showNotification('Welcome', 'info');
          next({name : 'home'});
        }
      },
      component : AdminForumComponent,
    },
    {
      path : '/adminDashboard/shows',
      name : 'adminManageShows',
      beforeEnter : (to, from, next) => {
        const userStore = useUserStore();
        const notiStore = useNotificationStore();
        if(userStore.hasValideToken) {
          next();
        } else {
          notiStore.showNotification('Welcome', 'info');
          next({name : 'home'});
        }
      },
      component : AdminManageShowsComponent
    },
    {
      path : '/adminDashboard/hosts',
      name : 'adminManageHosts',
      beforeEnter : (to, from, next) => {
        const userStore = useUserStore();
        const notiStore = useNotificationStore();
        if(userStore.hasValideToken) {
          next();
        } else {
          notiStore.showNotification('Welcome', 'info');
          next({name : 'home'});
        }
      },
      component : AdminManageHostComponent
    },
    {
      path : '/adminDashborad/show/:showId/forum/:forumid',
      name : 'forumShow',
      beforeEnter : (to, from, next) => {
        const userStore = useUserStore();
        const notiStore = useNotificationStore();
        if(userStore.hasValideToken) {
          next();
        } else {
          notiStore.showNotification('Welcome', 'info');
          next({name : 'home'});
        }
      },
      component : AdminForumShowComponent
    },
    {
      path : '/adminDashborad/show/:id',
      name : 'adminShow',
      beforeEnter : (to, from, next) => {
        const userStore = useUserStore();
        const notiStore = useNotificationStore();
        if(userStore.hasValideToken) {
          next();
        } else {
          notiStore.showNotification('Welcome.', 'info');
          next({name : 'home'});
        }
      },
      component : AdminShowComponent,
    },
    {
      path : '/adminDashboard',
      name : 'adminDashboard',
      beforeEnter : (to, from, next) => {
        const userStore = useUserStore();
        const notiStore = useNotificationStore();
        if(userStore.hasValideToken) {
          next();
        } else {
          notiStore.showNotification('Welcom', 'info');
          next({name : 'home'});
        }
      },
      component : AdminDashboardComponent,
    },
  ],
  scrollBehavior (to, from, savedPosition) {
    if (to.hash && to.name === 'home') {
      const targetElement = document.querySelector('#lets-talk');

      if (targetElement) {
        const targetOffset = targetElement.getBoundingClientRect().top;
        const headerOffset = 56;
        const offset = targetOffset - headerOffset;
        return {
          left : 0,
          top : offset,
          behavior : 'smooth',
        };

      }

    } else if (savedPosition) {
      return savedPosition;
    } else {
      return {left : 0, top : 0};
    }
  }
})

export default router
