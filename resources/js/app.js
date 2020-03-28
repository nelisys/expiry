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
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (localStorage.getItem('user') == null) {
            next({
                name: 'login',
                params: { nextUrl: to.fullPath }
            })
        } else {
            next();
        }
    } else {
        next();
    }
});

// events bus
window.events = new Vue();

// events.$emit('submitForm', 'abc');
//
// events.$on('submitForm', function(value) {
// });

// register flash events
Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('my-spinner', require('./components/MySpinner.vue').default);

Vue.component('my-input-text', require('./components/MyInputText.vue').default);
Vue.component('my-label-input-text', require('./components/MyLabelInputText.vue').default);

Vue.component('my-input-textarea', require('./components/MyInputTextarea.vue').default);
Vue.component('my-label-input-textarea', require('./components/MyLabelInputTextarea.vue').default);

Vue.component('my-input-date-picker', require('./components/MyInputDatePicker.vue').default);
Vue.component('my-label-input-date-picker', require('./components/MyLabelInputDatePicker.vue').default);

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
