/**
  * 权限菜单 接口的统一出口
  */
import axios from '.././http'; // 导入http中创建的axios实例


// 接口请求地址
const api = '/c-api/';

const log = {
  // 列表
  list(params) {
    return axios.get(api + 'log/list', { params: params })
  },
  // 清除
  clear() {
    return axios.post(api + 'log/clear')
  }
}


// 导出接口
export default log
