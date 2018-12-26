/**
  * 权限菜单 接口的统一出口
  */
import axios from '.././http'; // 导入http中创建的axios实例
import qs from 'qs'; // 根据需求是否导入qs模块，把请求字段直接映射过来


// 接口请求地址
const api = '/c-api/';

const cate = {
    // 下拉框
    select () {
        return axios.get(api + 'cate/select')
    },
    // 列表
    list () {
        return axios.get(api + 'cate/list')
    },
    // 添加
    create (params) {
        return axios.post(api + 'cate/create',qs.stringify(params))
    },
    // 修改
    edit (params) {
        return axios.post(api + 'cate/edit',qs.stringify(params))
    },
    // 排序
    sort (params) {
        return axios.post(api + 'cate/sort',qs.stringify(params))
    },
    // 单个查看
    detail (params) {
        return axios.get(api + 'cate/detail',{params:params})
    },
    // 删除
    remove (params) {
        return axios.post(api + 'cate/remove',qs.stringify(params))
    },
}


// 导出接口
export default cate