require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import VeeValidate from 'vee-validate'
import {routes} from './routes.js';
import storeData from './store.js';
import Main from './components/Main.vue';
import BootstrapVue from 'bootstrap-vue';
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'


Vue.component('form-component', require('./components/FormComponent.vue').default);
Vue.component('comments-component', require('./components/CommentsComponent.vue').default);
Vue.component('modal', require('./components/CommentsComponent.vue').default);
Vue.component('form-sub-component', require('./components/FormSubComponent.vue').default);
Vue.use(VeeValidate);
Vue.use(VueRouter);
Vue.use(Vuex);
Vue.use(BootstrapVue);

const router = new VueRouter({
    routes,
    mode: 'history'
});
Vue.router = router;
router.beforeEach((to, from, next) => {
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedin) {
        next({name: 'login'})
        return
    }
    if (to.path === '/login' && store.state.isLoggedin) {
        next({name: 'dashboard'})
        return
    }
    next()
})
const store = new Vuex.Store(storeData);
store.dispatch('check');

const app = new Vue({
    // el: '#app',
    router,
    store,
    render: h => h(Main)

}).$mount('#app');
