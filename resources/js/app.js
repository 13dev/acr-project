import './bootstrap'
import VueRouter from 'vue-router';
import Vue from 'vue'
import {routes} from './router';
import store from './vuex';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

// We want to reset our temp queue before each page
// This way when we click play, we can properly
// set our queue based on current tracks.
router.beforeEach((to, from, next) => {
    store.dispatch('player/resetTempQueue')

    next()
})

const app = new Vue({
    el: '#app',
    store,
    router
});
