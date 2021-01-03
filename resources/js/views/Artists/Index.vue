<template>
    <div>
        <h1 class="font-bold text-5xl text-white leading-none mb-20">Artists</h1>

        <div class="flex flex-wrap -mx-3">
            <div class="text-sm px-3 mb-8 w-full md:w-1/4" v-for="artist in artists" :key="artist.id">
                <router-link tag="button" :to="'/artists/' + artist.id"
                             class="block h-auto w-full rounded mb-2 hover:shadow-lg border-2 border-transparent hover:border-gray-500 focus:outline-none">
                    <div class="rounded w-full bg-dark block" >
                        <img :src="'/storage/covers/' + artist.image" :alt="artist.image" class="h-auto w-full rounded" style="height: 200px; object-fit: cover">
                    </div>
                </router-link>

                <p>
                    <router-link tag="button" :to="'/artists/' + artist.id"
                                 class="text-gray-500 hover:underline font-bold leading-loose focus:outline-none">
                        {{ artist.name }}
                    </router-link>
                </p>
            </div>
        </div>
    </div>
</template>

<script>
import _ from 'lodash'

export default {
    name: 'artists',

    data() {
        return {
            artists: [],
        }
    },

    beforeRouteEnter(to, from, next) {
        axios.all([
            axios.get('/api/artists'),
        ]).then(axios.spread( artists => {
            next(vm => {
                vm.artists = artists.data.data
            })
        }))
    },
}
</script>
