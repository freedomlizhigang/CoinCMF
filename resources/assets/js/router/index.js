import Vue from 'vue'
import Router from 'vue-router'


import Main from '.././components/console/index/Main.vue'
import ArticleList from '.././components/console/article/ArticleList.vue'
import Example from '.././components/Example.vue'
import Count from '.././components/Count.vue'
import Login from '.././components/Login.vue'
import Logout from '.././components/Logout.vue'


Vue.use(Router)

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/console/index/index',
      name: 'Main',
      component: Main,
      meta: { requiresAuth: false }
    },
    {
      path: '/console/art/index',
      name: 'ArticleList',
      component: ArticleList,
      meta: { requiresAuth: false }
    },
    { path: '/console/*', component: Main }
  ]
})
