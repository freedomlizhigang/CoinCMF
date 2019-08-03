/**
  * 公用 接口的统一出口
  */
import axios from '.././http'; // 导入http中创建的axios实例
import qs from 'qs'; // 根据需求是否导入qs模块，把请求字段直接映射过来

const common = {
    // 面包屑
    breadcrumb (params) {
        return axios.get('/c-api/breadcrumb/list',{params: params})
    },
}


// 导出接口
export default common