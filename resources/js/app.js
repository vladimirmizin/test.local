require('./bootstrap');
import Vue from 'vue';
import VueRouter from 'vue-router';
import Vuex from 'vuex';
import VeeValidate from 'vee-validate'
import {routes} from './routes.js';
import storeData from './store.js';
import Main from './components/Main.vue';

Vue.component('form-component', require('./components/FormComponent.vue').default);
Vue.component('comments-component', require('./components/CommentsComponent.vue').default);
Vue.component('modal', require('./components/CommentsComponent.vue').default);
Vue.component('form-sub-component', require('./components/FormSubComponent.vue').default);
Vue.use(VeeValidate);
Vue.use(VueRouter);
Vue.use(Vuex);
const router = new VueRouter({
    routes,
    mode: 'history'
});
Vue.router = router;
router.beforeEach((to, from, next) => {
    // check if the route requires authentication and user is not logged in
    if (to.matched.some(route => route.meta.requiresAuth) && !store.state.isLoggedin) {
        // redirect to login page
        next({name: 'login'})
        return
    }
    // if logged in redirect to dashboard
    if (to.path === '/login' && store.state.isLoggedin) {
        next({name: 'dashboard'})
        return
    }
    next()
})
const store = new Vuex.Store(storeData);
store.dispatch('check');

// new Vue(Main).$mount('#app');
const app = new Vue({
    // el: '#app',
    router,
    store,
    render: h => h(Main)

}).$mount('#app');
