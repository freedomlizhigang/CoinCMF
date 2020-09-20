
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
// 引入基础类
import Vue from 'vue'
import console_router from './router/console'
import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
// 各API接口
import console_api from './api/console_api' // 导入api接口
// 首页模板
import App from './views/console/App.vue'

import store from './store/store'

Vue.use(ViewUI);
Vue.config.productionTip = false
Vue.prototype.$api = console_api; // 将api挂载到vue的原型上

/* eslint-disable no-new */
new Vue({
    el: '#app',
    store,
    router: console_router,// 这里是个坑
    template: '<App/>',
    components: { App },
    render: h => h(App)
})