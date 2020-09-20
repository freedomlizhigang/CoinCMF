/**
  * 登录 接口的统一出口
  */
import axios from '.././http'; // 导入http中创建的axios实例
import qs from 'qs'; // 根据需求是否导入qs模块，把请求字段直接映射过来

const api = '/c-api/';

const config = {
  // 查询
  get() {
    return axios.get(api + 'config/get')
  },
  // 修改
  edit(params) {
    return axios.post(api + 'config/edit', qs.stringify(params));
  }
}


// 导出接口
export default config
