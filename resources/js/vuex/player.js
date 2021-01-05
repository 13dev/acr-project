let getters = {
    player: state => {
        return state.player
    },

    source: state => {
        return state.source
    },

    song: state => {
        return state.song
    },

    queue: state => {
        return state.queue
    },

    tempQueue: state => {
        return state.tempQueue
    },
};

let mutations = {
    INITIALIZE(state, payload) {
        if (payload.player) {
            state.player = payload.player
        }
    },

    PLAY(state) {
        state.player.play()
    },

    TOGGLE_PLAY(state) {
        state.player.togglePlay()
    },

    INCREASE_VOLUME(state) {
        state.player.increaseVolume()
    },

    DECREASE_VOLUME(state) {
        state.player.decreaseVolume()
    },

    SET_SONG(state, payload) {

        state.song = payload.song
        state.source = '/api/stream/' + payload.song.id

        if (state.tempQueue.length > 0) {
            state.queue = state.tempQueue
            state.tempQueue = []
        }

        state.player.source = {
            type: 'audio',
            title: payload.song.title,
            sources: [
                {
                    src: state.source,
                    type: 'audio/mpeg',
                },
            ],
        }
    },
    SET_QUEUE(state, payload) {
        state.queue = payload.queue
    },

    SET_TEMPQUEUE(state, payload) {
        state.tempQueue = payload.queue
    },

    PUSH_TEMPQUEUE(state, payload) {
        let queue = state.tempQueue

        state.tempQueue = queue.concat(payload.queue)
    },
};

let actions = {
    initialize({commit}, player) {
        commit('INITIALIZE', {
            player: player
        })
    },

    play({commit}) {
        commit('PLAY')
    },

    setSong({commit}, song) {
        commit('SET_SONG', {
            song: song
        })
    },

    setQueue({commit}, songs) {
        commit('SET_QUEUE', {
            queue: songs
        })
    },

    resetQueue({commit}) {
        commit('SET_QUEUE', {
            queue: []
        })
    },

    resetTempQueue({commit}) {
        commit('SET_TEMPQUEUE', {
            queue: []
        })
    },

    pushToTempQueue({commit}, songs) {
        commit('PUSH_TEMPQUEUE', {
            queue: songs
        })
    },

    togglePlay({commit}) {
        commit('TOGGLE_PLAY')
    },
};
export default {
    namespaced: true,

    state: {
        player: {},
        source: null,
        song: null,
        queue: [],
        tempQueue: [],
    },
    getters,
    mutations,
    actions,
}
