import {getLoggedinUser} from './partials/auth';
import Vue from 'vue';

const user = getLoggedinUser();
export default {
    state: {
        currentUser: user,
        // isLoggedIn: !!user,
        loading: false,
        auth_error: null,
        reg_error: null,
        registeredUser: null,
        isLoggedIn: !!localStorage.getItem('token'),
        comments: {}
    },
    getters: {
        isLoading(state) {
            return state.loading;
        },
        isLoggedin(state) {
            return state.isLoggedin;
        },
        currentUser(state) {
            return state.currentUser;
        },
        authError(state) {
            return state.auth_error;
        },
        regError(state) {
            return state.reg_error;
        },
        registeredUser(state) {
            return state.registeredUser;
        },
    },
    mutations: {
        check(state) {
            state.isLoggedin = !!localStorage.getItem('token');
            if (state.isLoggedin) {
                state.currentUser = localStorage.getItem('token');
                axios.defaults.headers.common.Authorization = `Bearer ${localStorage.getItem(
                    'token'
                )}`;
            }
        },
        login(state) {
            state.loading = true;
            state.auth_error = null;
        },
        loginSuccess(state, payload) {
            state.auth_error = null;
            state.isLoggedin = true;
            state.loading = false;
            state.currentUser = payload.access_token;
            localStorage.setItem('token', payload.access_token)
            axios.defaults.headers.common.Authorization = `Bearer ${payload.access_token}`;
            // state.currentUser = Object.assign({}, payload.user, {token: payload.access_token});
            // localStorage.setItem("user", JSON.stringify(state.currentUser));
            // console.log(state.currentUser);
        },
        loginFailed(state, payload) {
            state.loading = false;
            state.auth_error = payload.error;
        },
        logout(state) {
            localStorage.removeItem("token");
            state.isLoggedin = false;
            state.currentUser = null;
        },
        registerSuccess(state, payload) {
            state.reg_error = null;
            state.registeredUser = payload.user;
        },
        registerFailed(state, payload) {
            state.reg_error = payload.error;
        },
    },
    actions: {
        login(context) {
            context.commit("login"); //коммит это значит что я передаю данные из бэкэнда  в мутацию
        },
        check(context) {
            context.commit('check');
        },
        logout(context) {
            context.commit('logout');
            axios.post('/api/auth/logout')
            Vue.router.push({
                name: 'login',
            });
        },
        add(context) {
            context.commit('sub_comment');
            axios.post('/api/auth/logout')
            Vue.router.push({
                name: 'login',
            });
        },
        fetch(context) {

        },
    }
};