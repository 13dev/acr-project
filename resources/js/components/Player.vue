<template>
    <div class="bg-gray-800 w-full flex items-center">
        <div style="width: 200px;" class="block flex flex-col flex-shrink-0 h-20 justify-center text-xs px-3">
            <div v-if="song" class="truncate">
                <router-link tag="button" :to="'/albums/' + song.album.id"
                             class="block focus:outline-none hover:underline text-white">{{ song.title }}
                </router-link>
                <router-link tag="button" :to="'/artists/' + song.artist.id"
                             class="block focus:outline-none hover:underline">{{ song.artist.name }}
                </router-link>
            </div>
            <div v-else>
                <p class="block focus:outline-none">No Track Selected</p>
            </div>
        </div>

        <div class="w-full flex items-center">
            <audio controls ref="player"></audio>
        </div>

        <div class="flex items-center px-6">
            <router-link tag="button" to="/queue" class="focus:outline-none text-gray-500">
                <i class="fas fa-list"></i>
            </router-link>
        </div>
    </div>
</template>

<script>
import _ from 'lodash'
import Plyr from 'plyr'
import {mapGetters, mapActions} from 'vuex'

export default {
    name: 'Player',
    computed: {
        ...mapGetters('player', [
            'player',
            'source',
            'song',
            'queue',
        ]),
    },
    watch: {
        source(value) {
            this.play()
        },
    },
    mounted() {
        let player = new Plyr(this.$refs.player)

        player.on('ended', () => {
            let next = _.findIndex(this.queue, song => song.id === this.song.id) + 1;

            if (!this.queue[next]) {
                next = 0
            }

            this.setSong(this.queue[next]);
        });

        this.initialize(player)
    },

    methods: {
        ...mapActions('player', [
            'initialize',
            'play',
            'setSong',
        ]),
    },
}
</script>

<style scoped>

</style>
