/**
  * 用户角色 接口的统一出口
  */
import axios from '.././http'; // 导入http中创建的axios实例
import qs from 'qs'; // 根据需求是否导入qs模块，把请求字段直接映射过来


// 接口请求地址
const api = '/c-api/';

const role = {
  // 列表
  list(params) {
    return axios.get(api + 'role/list', { params: params })
  },
  // 添加
  create(params) {
    return axios.post(api + 'role/create', qs.stringify(params))
  },
  // 修改
  edit(params) {
    return axios.post(api + 'role/edit', qs.stringify(params))
  },
  // 修改状态
  status(params) {
    return axios.post(api + 'role/status', qs.stringify(params))
  },
  // 删除
  remove(params) {
    return axios.post(api + 'role/remove', qs.stringify(params))
  },
  // 权限列表
  priv(params) {
    return axios.get(api + 'role/priv', { params: params })
  },
  // 更新权限
  updatepriv(params) {
    return axios.post(api + 'role/priv', qs.stringify(params))
  }
}


// 导出接口
export default role
