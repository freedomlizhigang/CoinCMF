/**
  * 文章 接口的统一出口
  */
import axios from '.././http'; // 导入http中创建的axios实例
import qs from 'qs'; // 根据需求是否导入qs模块，把请求字段直接映射过来

const api = '/c-api/';

const article = {
    // 新闻列表
    list(params) {
        return  axios.get(api + 'article/list',{params:params});
    },
    // 添加
    create (params) {
        return axios.post(api + 'article/create',qs.stringify(params))
    },
    // 修改
    edit (params) {
        return axios.post(api + 'article/edit',qs.stringify(params))
    },
    // 排序
    sort (params) {
        return axios.post(api + 'article/sort',qs.stringify(params))
    },
    // 单个查看
    detail (params) {
        return axios.get(api + 'article/detail',{params:params})
    },
    // 删除
    remove (params) {
        return axios.post(api + 'article/remove',qs.stringify(params))
    },
    // 删除
    deleteall (params) {
        return axios.post(api + 'article/deleteall',qs.stringify(params))
    },
}


// 导出接口
export default article