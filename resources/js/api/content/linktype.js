/**
  * 友情链接分类接口的统一出口
  */
import axios from '.././http'; // 导入http中创建的axios实例
import qs from 'qs'; // 根据需求是否导入qs模块，把请求字段直接映射过来

const api = '/c-api/';

const linktype = {
    // 新闻列表
    list(params) {
        return axios.get(api + 'linktype/list', { params: params });
    },
    // 添加
    create(params) {
        return axios.post(api + 'linktype/create', qs.stringify(params))
    },
    // 修改
    edit(params) {
        return axios.post(api + 'linktype/edit', qs.stringify(params))
    },
    // 单个查看
    detail(params) {
        return axios.post(api + 'linktype/detail', qs.stringify(params))
    },
    // 删除
    remove(params) {
        return axios.post(api + 'linktype/remove', qs.stringify(params))
    },
}

// 导出接口
export default linktype
