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

const app = new Vue({
    el: '#app',
    store,
    router
});
