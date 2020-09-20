import Nofound from '.././views/home/Nofound.vue'

const home_routers = [
  // 登录
  {
    path: '/',
    name: 'login',
    component: Nofound,
    meta: { requiresAuth: false }
  },
  // 其它404
  {
    path: '*',
    name: 'noaccess',
    meta: { requiresAuth: false },
    component: Nofound
  }
]

export default home_routers