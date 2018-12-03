import Login from '.././components/console/Login.vue'
import Logout from '.././components/console/Logout.vue'
import Iframe from '.././components/console/Iframe.vue'
import Nofound from '.././components/console/Nofound.vue'
import Main from '.././components/console/index/Main.vue'
import ArticleList from '.././components/console/article/ArticleList.vue'
import ArticleAdd from '.././components/console/article/ArticleAdd.vue'
import CateList from '.././components/console/cate/CateList.vue'
import MenuTree from '.././components/console/menu/MenuTree.vue'

export default [
    // 登录
    {
      path: '/console/login',
      name: 'login',
      component: Login,
      meta: { requiresAuth: false }
    },
    // 内容的模板
    {
        path: '/console/',
        component: Iframe,
        meta: { requiresAuth: true },
        children: [
            // 首页
            {
                path: 'index/index',
                name: 'index-index',
                meta: { requiresAuth: true },
                component: Main
            },
            // 栏目页面
            {
              path: 'cate/index',
              name: 'cate-index',
              component: CateList,
              meta: { requiresAuth: true }
            },
            // 文章列表
            {
              path: 'art/index',
              name: 'art-index',
              component: ArticleList,
              meta: { requiresAuth: true }
            },
            // 添加文章
            {
              path: 'art/add',
              name: 'art-add',
              component: ArticleAdd,
              meta: { requiresAuth: true }
            },
            // 权限菜单
            {
              path: 'menu/index',
              name: 'menu-index',
              component: MenuTree,
              meta: { requiresAuth: true }
            },
            // 其它404
            {
                path: '*',
                name: 'noaccess',
                meta: { requiresAuth: true },
                component: Nofound
            }
        ]
    },
]