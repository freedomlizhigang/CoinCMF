/**
  * 公用 接口的统一出口
  */
import axios from '.././http'; // 导入http中创建的axios实例

const common = {
  // 面包屑
  breadcrumb(params) {
    return axios.get('/c-api/breadcrumb/list', { params: params })
  }
}


// 导出接口
export default common
