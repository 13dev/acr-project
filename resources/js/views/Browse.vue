<template>
    <div>
        <h1 class="font-bold text-5xl text-white leading-none mb-20">Browse</h1>

        <h2 class="font-bold text-axiom-500 text-2xl mb-6 border-b border-gray-800 py-3">Top 10 played Songs</h2>
        <div class="flex flex-wrap -mx-4">
            <div class="text-sm px-3 mb-8 w-full xl:w-2/12 md:w-3/12" v-for="song in topSongs" :key="song.id">
                <router-link
                    tag="button"
                    :to="'/albums/' + song.album.id"
                    class="block h-auto w-full rounded mb-2 hover:shadow-lg border-2 border-transparent hover:border-gray-500 focus:outline-none">

                    <div class="rounded w-full bg-dark block" style="height: 220px;">
                        <img
                            :src="'/' + song.album.cover"
                            :alt="song.album.name"
                            class="h-full w-full rounded"
                            style="max-width: 100%; max-height: 100%; height: 100%; width: 100%; object-fit: cover;"
                        >
                    </div>
                </router-link>

                <p>
                    <router-link
                        tag="button"
                        :to="'/albums/' + song.album.id"
                        class="text-gray-500 hover:underline font-bold leading-loose focus:outline-none"
                    >
                        {{ song.album.name }}
                    </router-link>
                </p>
                <p>
                    <button class="text-gray-600 hover:underline leading-loose focus:outline-none">
                        {{ song.title }}
                    </button>
                </p>
            </div>
        </div>

        <h2 class="font-bold text-axiom-500 text-2xl mb-6 border-b border-gray-800 py-3">Top 10 played Artists</h2>
        <div class="flex flex-wrap -mx-4">
            <div class="text-sm px-3 mb-8 w-full md:w-2/12" v-for="artist in topArtists" :key="artist.id">
                <router-link
                    tag="button"
                    :to="'/artist/' + artist.id"
                    class="block h-auto w-full rounded mb-2 hover:shadow-lg border-2 border-transparent hover:border-gray-500 focus:outline-none">

                    <div class="rounded w-full bg-dark block" style="height: 220px;">
                        <img
                            :src="'/' + artist.image"
                            :alt="artist.name"
                            class="h-full w-full rounded"
                            style="max-width: 100%; max-height: 100%; height: 100%; width: 100%; object-fit: cover;"
                        >
                    </div>
                </router-link>

                <p>
                    <router-link
                        tag="button"
                        :to="'/artist/' + artist.id"
                        class="text-gray-500 hover:underline font-bold leading-loose focus:outline-none"
                    >
                        {{ artist.name }}
                    </router-link>
                </p>
            </div>
        </div>

        <h2 class="font-bold text-axiom-500 text-2xl mb-6 border-b border-gray-800 py-3">Top 10 played Albums</h2>
        <div class="flex flex-wrap -mx-4">
            <div class="text-sm px-3 mb-8 w-full md:w-2/12" v-for="album in topAlbums" :key="album.id">
                <router-link
                    tag="button"
                    :to="'/album/' + album.id"
                    class="block h-auto w-full rounded mb-2 hover:shadow-lg border-2 border-transparent hover:border-gray-500 focus:outline-none">

                    <div class="rounded w-full bg-dark block" style="height: 220px;">
                        <img
                            :src="'/' + album.cover"
                            :alt="album.name"
                            class="h-full w-full rounded"
                            style="max-width: 100%; max-height: 100%; height: 100%; width: 100%; object-fit: cover;"
                        >
                    </div>
                </router-link>

                <p>
                    <router-link
                        tag="button"
                        :to="'/artist/' + album.id"
                        class="text-gray-500 hover:underline font-bold leading-loose focus:outline-none"
                    >
                        {{ album.name }}
                    </router-link>
                </p>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    name: 'Browse',
    data() {
        return {
            topSongs: {},
            topArtists: {},
            topAlbums: {}
        }
    },
    beforeRouteEnter(to, from, next) {
        axios.all([
            axios.get('/api/songs/top-songs'),
            axios.get('/api/songs/top-artists'),
            axios.get('/api/songs/top-albums'),
        ]).then(axios.spread(function (topSongs, topArtists, topAlbums) {
            next(function (vm) {
                vm.topSongs = topSongs.data.data
                vm.topArtists = topArtists.data.data
                vm.topAlbums = topAlbums.data.data
            })
        }))
    },
}
</script>
