<template>
    <div>
        <div class="flex items-end">
            <img :src="'/' + album.cover" :alt="album.name" class="album--image"
                 style="width: 220px; max-height: 220px;">

            <div>
                <h1 class="font-bold text-5xl text-white leading-none mb-3">{{ album.name }}</h1>
                <h2 class="text-sm">By
                    <router-link
                        tag="button"
                        :to="'/artists/' + artist.id"
                        class="hover:underline text-white focus:outline-none"
                    >
                        {{ artist.name }}
                    </router-link>
                </h2>
                <h3 class="text-sm mb-2">
                    <template v-if="album.year">{{ album.year }}</template>
                    <template v-if="songCount"><span class="mx-1">•</span> {{ songCount }}</template>
                    <template v-if="album.playtime"><span class="mx-1">•</span> {{ album.playtime }}</template>
                    <template v-if="album.genre"><span class="mx-1">•</span> {{ album.genre }}</template>
                </h3>
                <button
                    class="px-10 py-2 mt-3 hover:bg-axiom-600 hover:shadow-lg leading-none bg-axiom-500 text-white text-xs tracking-widest uppercase font-bold rounded-full">
                    Play
                </button>
            </div>
        </div>

        <playlist :songs="songs" separate-discs></playlist>
    </div>
</template>

<script>
import Playlist from "../../components/Playlist";
export default {
    name: 'album',
    components: {
        Playlist
    },
    data() {
        return {
            album: {},
        }
    },

    computed: {
        songs() {
            return this.album.songs || []
        },

        artist() {
            return this.album.artist || {}
        },

        songCount() {
            let count = this.songs.length
            return count === 1 ? '1 song' : count + ' songs'
        },

    },

    methods: {
        setAlbum(album) {
            this.album = album
        },
    },

    beforeRouteEnter(to, from, next) {

        axios.all([
            axios.get('/api/albums/' + to.params.id),
        ]).then(axios.spread(function (album) {
            next(function (vm) {
                vm.setAlbum(album.data.data)
            })
        }))
    },

    beforeRouteUpdate(to, from, next) {
        axios.all([
            axios.get('/api/albums/' + to.params.id),
        ]).then(axios.spread(function (album) {
            this.setAlbum(album.data.data)
            next()
        }))
    },
}
</script>
