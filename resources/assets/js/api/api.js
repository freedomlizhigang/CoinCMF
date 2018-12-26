/**
* api接口统一管理
*/
import axios from './http.js'
import common from './console/common.js'
import login from './console/login.js'
import cate from './console/cate.js'
import article from './console/article.js'
import menu from './console/menu.js'
import section from './console/section.js'
import role from './console/role.js'
import admin from './console/admin.js'
import config from './console/config.js'
import type from './console/type.js'
import log from './console/log.js'

const api = {
    common,
    login,
    cate,
    article,
    menu,
    section,
    role,
    admin,
    config,
    type,
    log,
}

export default api