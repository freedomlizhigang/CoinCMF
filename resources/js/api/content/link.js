/**
  * 友情链接接口的统一出口
  */
import axios from '.././http'; // 导入http中创建的axios实例
import qs from 'qs'; // 根据需求是否导入qs模块，把请求字段直接映射过来

const api = '/c-api/';

const link = {
    // 新闻列表
    list(params) {
        return axios.get(api + 'link/list', { params: params });
    },
    // 添加
    create(params) {
        return axios.post(api + 'link/create', qs.stringify(params))
    },
    // 修改
    edit(params) {
        return axios.post(api + 'link/edit', qs.stringify(params))
    },
    // 单个查看
    detail(params) {
        return axios.post(api + 'link/detail', qs.stringify(params))
    },
    // 删除
    remove(params) {
        return axios.post(api + 'link/remove', qs.stringify(params))
    },
    // 排序
    sort(params) {
        return axios.post(api + 'link/sort', qs.stringify(params))
    },
}

// 导出接口
export default link
