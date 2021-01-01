<template>
    <tr class="border-b border-gray-800 hover:bg-gray-700 " ref="track">
        <td class="p-2 w-10">{{ songtrack }}</td>
        <td class="p-2 w-10">
            <i
                v-if="isCurrentlyPlaying()"
                class="fas fa-compact-disc fa-spin text-green-500"
            ></i>

            <button
                v-else
                @click.prevent="setSoundAndCount()"
            >
                <i class="fas fa-play hover:text-axiom-500 focus:outline-none cursor-pointer"></i>
            </button>
        </td>
        <td class="p-2 text-green-500" v-if="isCurrentlyPlaying()">{{ song.title }}</td>
        <td class="p-2 hover:underline cursor-pointer" v-else @click.prevent="setSoundAndCount()">{{ song.title }}</td>
        <td class="p-2" v-if="displayArtist">
            <router-link
                tag="button"
                :to="'/artists/' + song.artist.id"
                class="focus:outline-none hover:underline"
            >
                {{ song.artist.name }}
            </router-link>
        </td>
        <td class="p-2" v-if="displayAlbum">
            <router-link
                tag="button"
                :to="'/albums/' + song.album.id"
                class="focus:outline-none hover:underline"
            >
                {{ song.album.name }}
            </router-link>
        </td>
        <td class="p-2 w-16">{{ song.playtime }}</td>
        <td class="p-2 w-16"></td>
    </tr>
</template>

<script>
import {mapActions, mapGetters} from 'vuex'

export default {
    name: 'AppTrack',
    props: {
        songtrack: {
            required: true,
        },
        song: {
            required: true,
        },
        displayArtist: {
            type: Boolean,
            required: false,
            default: false,
        },
        displayAlbum: {
            type: Boolean,
            required: false,
            default: false
        },
    },
    computed: {
        ...mapGetters('player', {
            currentSong: 'song',
        }),
    },
    methods: {
        ...mapActions('player', [
            'setSong',
            'play',
            'isCurrentlyPlaying',
        ]),
        setSoundAndCount() {
            axios.get('/api/songs/played/' + this.song.id)
                .then((response) => {
                    if (response.status === 200) {
                        this.setSong(this.song)
                    }
                })
                .catch(console.log)
        },
        isCurrentlyPlaying() {
            if (!this.currentSong) {
                return false
            }
            return this.currentSong.id === this.song.id
        }
    },
}
</script>

<style scoped>

</style>
