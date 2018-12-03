import { LOGIN,LOGOUT } from '.././mutation_types'

// localStorage 保存数据时间更久，不会因为关闭标签而丢失

const state = {
    user_id: localStorage.getItem("user_id") || 0,
    user_name: localStorage.getItem("user_name") || '未登录',
    token: localStorage.getItem("token") || '',
}

const getters = {
    user_id: state => {
        return state.user_id
    },
    user_name: state => {
        return state.user_name
    },
    token: state => {
        return state.token
    }
}

const mutations = {
    [LOGIN](state,data){
        localStorage.setItem("user_id",data.id);  // 设置localStorage
        localStorage.setItem("user_name",data.name);
        localStorage.setItem("token",data.token);
        state.user_id = data.id;
        state.user_name = data.name;
        state.token = data.token;
    },
    [LOGOUT](state){
        localStorage.removeItem("user_id");  //移除localStorage
        localStorage.removeItem("user_name");
        localStorage.removeItem("token");
        state.user_id = 0
        state.user_name = '';
        state.token = '';
    }
}

export default {
    state,
    mutations,
    getters
}