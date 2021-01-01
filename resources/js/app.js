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

// Reset temp Queue before each page
router.beforeEach((to, from, next) => {
    store.dispatch('player/resetTempQueue')
    next()
})

let artist = document.querySelector("meta[name='artist']");
Vue.prototype.$artist = artist !== null ? JSON.parse(artist.getAttribute('content')) : null;

const app = new Vue({
    el: '#app',
    store,
    router
});


