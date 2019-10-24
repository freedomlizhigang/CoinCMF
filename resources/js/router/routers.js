import Nofound from '.././components/console/Nofound.vue'
import Login from '.././components/console/Login.vue'
import Logout from '.././components/console/Logout.vue'
import Iframe from '.././components/console/Iframe.vue'
import Main from '.././components/console/main/Main.vue'
import ArticleList from '.././components/console/main/ArticleList.vue'
import ArticleAdd from '.././components/console/main/ArticleAdd.vue'
import ArticleEdit from '.././components/console/main/ArticleEdit.vue'
import CateList from '.././components/console/main/CateList.vue'
import MenuTree from '.././components/console/main/MenuTree.vue'
import SectionList from '.././components/console/main/SectionList.vue'
import RoleList from '.././components/console/main/RoleList.vue'
import AdminList from '.././components/console/main/AdminList.vue'
import AdminEditInfo from '.././components/console/main/AdminEditInfo.vue'
import AdminEditPwd from '.././components/console/main/AdminEditPwd.vue'
import Config from '.././components/console/main/Config.vue'
import TypeList from '.././components/console/main/TypeList.vue'
import LogList from '.././components/console/main/LogList.vue'

export default [
    // 登录
    {
      path: '/',
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
              path: 'cate/list',
              name: 'cate-list',
              component: CateList,
              meta: { requiresAuth: true }
            },
            // 文章列表
            {
              path: 'article/list',
              name: 'article-list',
              component: ArticleList,
              meta: { requiresAuth: true }
            },
            // 添加文章
            {
              path: 'article/add',
              name: 'article-add',
              component: ArticleAdd,
              meta: { requiresAuth: true }
            },
            // 添加文章
            {
              path: 'article/edit/:id',
              name: 'article-edit',
              component: ArticleEdit,
              meta: { requiresAuth: true }
            },
            // 操作日志
            {
              path: 'log/list',
              name: 'log-list',
              component: LogList,
              meta: { requiresAuth: true }
            },
            // 分类管理
            {
              path: 'type/list',
              name: 'type-list',
              component: TypeList,
              meta: { requiresAuth: true }
            },
            // 系统设置
            {
              path: 'config/index',
              name: 'config-index',
              component: Config,
              meta: { requiresAuth: true }
            },
            // 用户
            {
              path: 'admin/list',
              name: 'admin-list',
              component: AdminList,
              meta: { requiresAuth: true }
            },
            {
              path: 'admin/editinfo',
              name: 'admin-editinfo',
              component: AdminEditInfo,
              meta: { requiresAuth: true }
            },
            {
              path: 'admin/editpwd',
              name: 'admin-editpwd',
              component: AdminEditPwd,
              meta: { requiresAuth: true }
            },
            // 角色
            {
              path: 'role/list',
              name: 'role-list',
              component: RoleList,
              meta: { requiresAuth: true }
            },
            // 部门
            {
              path: 'section/list',
              name: 'section-list',
              component: SectionList,
              meta: { requiresAuth: true }
            },
            // 权限菜单
            {
              path: 'menu/tree',
              name: 'menu-tree',
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
    // 其它404
    {
        path: '*',
        name: 'noaccess',
        meta: { requiresAuth: false },
        component: Nofound
    }
]