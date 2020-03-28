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

// events bus
window.events = new Vue();

// events.$emit('submitForm', 'abc');
//
// events.$on('submitForm', function(value) {
// });

// register flash events
Vue.component('flash', require('./Flash.vue').default);

window.flash = function (message, level) {
    window.events.$emit('flash', message, level);
};

Vue.config.devtools = false;
Vue.config.productionTip = false;

const app = new Vue({
    el: '#app',
    components: { App },
    router,
});
