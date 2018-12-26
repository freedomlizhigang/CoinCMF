/**
  * 权限菜单 接口的统一出口
  */
import axios from '.././http'; // 导入http中创建的axios实例
import qs from 'qs'; // 根据需求是否导入qs模块，把请求字段直接映射过来


// 接口请求地址
const api = '/c-api/';

const menu = {
    // 树形列表
    tree () {
        return axios.get(api + 'menu/tree')
    },
    // 下拉菜单
    select () {
        return axios.get(api + 'menu/select')
    },
    // 左侧菜单
    left () {
        return axios.get(api + 'menu/list')
    },
    // 添加
    create (params) {
        return axios.post(api + 'menu/create',qs.stringify(params))
    },
    // 修改
    edit (params) {
        return axios.post(api + 'menu/edit',qs.stringify(params))
    },
    // 单个查看
    detail (params) {
        return axios.post(api + 'menu/detail',qs.stringify(params))
    },
    // 删除
    remove (params) {
        return axios.post(api + 'menu/remove',qs.stringify(params))
    },
}


// 导出接口
export default menu