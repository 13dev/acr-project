import Vuex from 'vuex'
import Vue from 'vue'

Vue.use(Vuex)
import player from './player.js'

const store = new Vuex.Store({
    modules: {
        player
    }
})

export default store
