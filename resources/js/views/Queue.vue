<template>
    <div>
        <h1 class="font-bold text-5xl text-white leading-none mb-20">Queue</h1>

        <playlist
            :songs="queue"
            display-artist
            display-album
        ></playlist>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
import Playlist from "../components/Playlist";

export default {
    computed: {
        ...mapGetters('player', [
            'queue'
        ]),
    },
    components: {
        Playlist
    }
}
</script>
