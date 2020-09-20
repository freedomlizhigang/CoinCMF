import Vue from 'vue'
import Router from 'vue-router'
import store from '../store/store'
import ViewUI from 'view-design';
import console_routers from './console_routers'


Vue.use(Router)

const console_router = new Router({
  // mode: 'history',
  routes: console_routers
});

// 导航钩子，全局钩子
console_router.beforeEach((to, from, next) => {
  // 登录页面
  if (to.name === 'login') {
    if (store.getters.token == '') {
      next();
    } else {
      next('/index/index');
    }
  }
  // 其它页面
  else {
    if (store.getters.token == '' && to.meta.requiresAuth) {
      next('/');
    } else {
      next();
    }
  }
})
console_router.afterEach(to => {
  ViewUI.LoadingBar.finish()
})

export default console_router
