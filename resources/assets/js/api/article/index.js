/**
  * 文章 接口的统一出口
  */
import axios from '.././http'; // 导入http中创建的axios实例

const article = {
    // 新闻列表
    articleList () {
        return  axios.get('/c-api/menu/list');
    },
}


// 导出接口
export default article