
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
import './../sass/reset.css';
// 各API接口
import api from './api/api' // 导入api接口
// 首页模板
import App from './components/console/App.vue'

import store from './vuex/store'

Vue.use(iView);
Vue.config.productionTip = false
Vue.prototype.$api = api; // 将api挂载到vue的原型上

/* eslint-disable no-new */
new Vue({
    el: '#app',
    store,
    router,
    template: '<App/>',
    components: { App },
    render: h => h(App)
})