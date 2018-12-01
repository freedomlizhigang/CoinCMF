
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
// 引入基础类
import Vue from 'vue'
import router from './router'
import axios from 'axios'
import VueAxios from 'vue-axios'
import iView from 'iview';
import 'iview/dist/styles/iview.css';
// 首页模板
import App from './components/console/App.vue'

import store from './vuex/store'

Vue.use(iView);
Vue.config.productionTip = false

/* eslint-disable no-new */
new Vue({
  el: '#app',
  router,
  template: '<App/>',
  components: { App },
  render: h => h(App)
})

// router.beforeEach((to, from, next) => {
//   // console.log(to);
//   if (to.meta.requiresAuth && store.getters.get_user_id == 0 && to.name != 'Login') {
//     next({
//       name:'Login'
//     });
//   }
//   else
//   {
//     next();
//   }
// })