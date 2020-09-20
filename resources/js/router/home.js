import Vue from 'vue'
import Router from 'vue-router'
import store from '.././store/store'
import ViewUI from 'view-design';
import home_routers from './home_routers'


Vue.use(Router)

const home_router = new Router({
  // mode: 'history',
  routes: home_routers
});

// 导航钩子，全局钩子
home_router.beforeEach((to, from, next) => {
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
home_router.afterEach(to => {
  ViewUI.LoadingBar.finish()
})

export default home_router
