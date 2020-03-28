require('./bootstrap');

import Vue from 'vue';
import VueRouter from 'vue-router';
Vue.use(VueRouter)

import routes from './routes.js';

import App from './App.vue';

Vue.component('my-nav', require('./Nav.vue').default);

let router = new VueRouter({
    mode: 'history',
    linkActiveClass: "active",
    routes: routes,
})

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
