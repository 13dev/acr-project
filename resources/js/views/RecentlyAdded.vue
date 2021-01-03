<template>
    <div>
        <h1 class="font-bold text-5xl text-white leading-none mb-20">Recently Added</h1>

        <playlist
            :songs="songs"
            display-artist
            display-album
        ></playlist>
    </div>
</template>

<script>
import {mapActions} from 'vuex'
import Playlist from "../components/Playlist";

export default {
    name: 'recently-added',

    data() {
        return {
            songs: [],
        }
    },
    components: {
        Playlist
    },
    methods: {
        ...mapActions('player', [
            'setSource'
        ]),
    },

    beforeRouteEnter(to, from, next) {
        axios.all([
            axios.get('/api/songs/recently-added'),
        ]).then(axios.spread( recentlyAdded => {
            next(vm => {
                vm.songs = recentlyAdded.data.data
            })
        }))
    },
}
</script>
