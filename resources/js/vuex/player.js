export default {
    namespaced: true,

    state: {
        player: {},
        source: null,
        song: null,
        queue: [],
        tempQueue: [],
    },

    getters: {
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
    },

    mutations: {
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
                        type: 'audio/mp3',
                    },
                ],
            }
        },

        IS_CURRENTLY_PLAYING: (state, currentSong) => {
            if (!state.song || currentSong == null) {
                return false;
            }

            return currentSong.id === state.song.id;
        },

        PLAYTIME: state => {
            if(state.song == null) {
                return 0;
            }

            let seconds = Math.floor(state.song.length)
            let minutes = Math.floor(seconds / 60)

            seconds = seconds - (minutes * 60)
            return minutes + ':' + (seconds.toString().padStart(2, 0))
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
    },

    actions: {
        initialize({commit}, player) {
            commit('INITIALIZE', {
                player: player
            })
            commit('PLAYTIME')
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


        isCurrentlyPlaying({commit}, currentSong) {
            commit('IS_CURRENTLY_PLAYING', {
                currentSong: currentSong,
            })
        },

        playtime({commit}) {
            commit('PLAYTIME')
        }
    },
}
