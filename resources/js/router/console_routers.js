import Nofound from '.././views/console/Nofound.vue'
import Login from '.././views/console/Login.vue'
import Iframe from '.././views/console/Iframe.vue'
import Main from '.././views/console/rbac/Main.vue'
import MenuTree from '.././views/console/rbac/MenuTree.vue'
import DepartmentList from '.././views/console/rbac/DepartmentList.vue'
import RoleList from '.././views/console/rbac/RoleList.vue'
import AdminList from '.././views/console/rbac/AdminList.vue'
import LogList from '.././views/console/rbac/LogList.vue'
import AdminEditInfo from '.././views/console/rbac/AdminEditInfo.vue'
import AdminEditPwd from '.././views/console/rbac/AdminEditPwd.vue'
import Config from '.././views/console/common/Config.vue'
import TypeList from '.././views/console/common/TypeList.vue'
import ArticleList from '.././views/console/content/ArticleList.vue'
import ArticleAdd from '.././views/console/content/ArticleAdd.vue'
import ArticleEdit from '.././views/console/content/ArticleEdit.vue'
import CateAdd from '.././views/console/content/CateAdd.vue'
import CateEdit from '.././views/console/content/CateEdit.vue'
import CateList from '.././views/console/content/CateList.vue'
import AdPos from '.././views/console/content/AdPos.vue'
import Ad from '.././views/console/content/Ad.vue'
import Link from '.././views/console/content/Link.vue'


const console_routers = [
  // 登录
  {
    path: '/',
    name: 'login',
    component: Login,
    meta: { requiresAuth: false }
  },
  // 内容的模板
  {
    path: '/',
    component: Iframe,
    meta: { requiresAuth: true },
    children: [
      //  友情链接页面
      {
        path: 'link/list',
        name: 'link-list',
        component: Link,
        meta: { requiresAuth: true }
      },
      // 广告页面
      {
        path: 'ad/list',
        name: 'ad-list',
        component: Ad,
        meta: { requiresAuth: true }
      },
      // 广告位页面
      {
        path: 'adpos/list',
        name: 'adpos-list',
        component: AdPos,
        meta: { requiresAuth: true }
      },
      // 栏目页面
      {
        path: 'cate/list',
        name: 'cate-list',
        component: CateList,
        meta: { requiresAuth: true }
      },
      // 添加栏目
      {
        path: 'cate/create',
        name: 'cate-create',
        component: CateAdd,
        meta: { requiresAuth: true }
      },
      // 修改栏目
      {
        path: 'cate/edit/:id',
        name: 'cate-edit',
        component: CateEdit,
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
        path: 'article/create',
        name: 'article-create',
        component: ArticleAdd,
        meta: { requiresAuth: true }
      },
      // 修改文章
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
        path: 'admin/selfeditinfo',
        name: 'admin-selfeditinfo',
        component: AdminEditInfo,
        meta: { requiresAuth: true }
      },
      {
        path: 'admin/selfeditpassword',
        name: 'admin-selfeditpassword',
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
        path: 'department/list',
        name: 'department-list',
        component: DepartmentList,
        meta: { requiresAuth: true }
      },
      // 权限菜单
      {
        path: 'menu/tree',
        name: 'menu-tree',
        component: MenuTree,
        meta: { requiresAuth: true }
      },
      // 首页
      {
        path: 'index/index',
        name: 'index-index',
        meta: { requiresAuth: true },
        component: Main
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

export default console_routers