/**
* api接口统一管理
*/
import axios from './http'
import common from './common/index'
import login from './login/index'
import article from './article/index'

const api = {
    common,
    login,
    article,
}

export default api