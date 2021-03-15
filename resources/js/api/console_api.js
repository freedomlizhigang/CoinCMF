/**
* api接口统一管理
*/
import common from './rbac/common.js'
import login from './rbac/login.js'
import menu from './rbac/menu.js'
import department from './rbac/department.js'
import role from './rbac/role.js'
import admin from './rbac/admin.js'
import log from './rbac/log.js'
import config from './common/config.js'
import type from './common/type.js'
import cate from './content/cate.js'
import article from './content/article.js'
import adpos from './content/adpos.js'
import ad from './content/ad.js'
import link from './content/link.js'

const console_api = {
  link,
  ad,
  adpos,
  cate,
  article,
  type,
  log,
  config,
  common,
  login,
  menu,
  department,
  role,
  admin
}

export default console_api
