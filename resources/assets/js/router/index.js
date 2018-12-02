import Vue from 'vue'
import Router from 'vue-router'


import Main from '.././components/console/index/Main.vue'
import ArticleList from '.././components/console/article/ArticleList.vue'
import CateList from '.././components/console/cate/CateList.vue'
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
      name: 'index-index',
      component: Main,
      meta: { requiresAuth: false }
    },
    {
      path: '/console/cate/index',
      name: 'cate-index',
      component: CateList,
      meta: { requiresAuth: false }
    },
    {
      path: '/console/art/index',
      name: 'art-index',
      component: ArticleList,
      meta: { requiresAuth: false }
    },
    { path: '/console/*', component: Main }
  ]
})
