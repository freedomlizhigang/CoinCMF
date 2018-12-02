import { LOGIN,LOGOUT } from '.././mutation_types'

const state = {
    user_id: 0,
    user_name: ''
}

const getters = {
    user_id: state => {
        return state.user_id
    },
    user_name: state => {
        return state.user_name
    }
}

const mutations = {
    [LOGIN](state,data){
        state.user_id = data.id;
        state.user_name = data.name;
    },
    [LOGOUT](state){
        state.user_id = 0
        state.user_name = '';
    }
}

export default {
    state,
    mutations,
    getters
}