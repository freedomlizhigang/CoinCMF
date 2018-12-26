/**
  * 登录 接口的统一出口
  */
import axios from '.././http'; // 导入http中创建的axios实例
import qs from 'qs'; // 根据需求是否导入qs模块，把请求字段直接映射过来

const login = {
    // 新闻列表
    login (params) {
        return axios.post('/c-api/login',qs.stringify(params));
    },
}


// 导出接口
export default login