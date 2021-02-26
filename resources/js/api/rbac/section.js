/**
  * 部门 接口的统一出口
  */
import axios from '.././http'; // 导入http中创建的axios实例
import qs from 'qs'; // 根据需求是否导入qs模块，把请求字段直接映射过来


// 接口请求地址
const api = '/c-api/';

const section = {
  // 列表
  list(params) {
    return axios.get(api + 'section/list', { params: params })
  },
  // 添加
  create(params) {
    return axios.post(api + 'section/create', qs.stringify(params))
  },
  // 修改
  edit(params) {
    return axios.post(api + 'section/edit', qs.stringify(params))
  },
  // 修改状态
  status(params) {
    return axios.post(api + 'section/status', qs.stringify(params))
  },
  // 删除
  remove(params) {
    return axios.post(api + 'section/remove', qs.stringify(params))
  },
  // 单条信息
  detail(params) {
    return axios.post(api + 'section/detail', qs.stringify(params))
  }
}


// 导出接口
export default section
