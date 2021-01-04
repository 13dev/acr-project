<template>
    <div class="flex items-center sticky pin-t py-3 px-6 w-full bg-gray-900 fixed top-0 shadow-md my-auto">
        <div class="flex">
            <div class="flex items-center mr-6">
                <button @click.prevent="$router.go(-1)"
                        class="mr-6 text-gray-200 no-underline hover:text-white focus:outline-none">
                    <i class="fas fa-arrow-left"></i>
                </button>

                <button @click.prevent="$router.go(1)"
                        class="mr-6 text-gray-200 no-underline hover:text-white focus:outline-none">
                    <i class="fas fa-arrow-right"></i>
                </button>
            </div>

            <div @blur="blur" @keydown.esc.prevent="blur">
                <div class="bg-white rounded-full px-2 flex items-center overflow-hidden max-w-md w-full"
                     style="width: 300px">
                    <i class="fas fa-search mr-2" :class="{
                        'text-axiom-500': focused,
                        'text-gray-500': !focused,
                    }"></i>

                    <input type="text" id="search" ref="search" class="py-1 text-sm outline-none w-full" :class="{
                        'text-gray-600': focused,
                        'text-gray-500': !focused,
                    }" placeholder="Search" v-model="query" @focus="focus">
                </div>

                <div class="absolute z-50 bg-white mt-3 p-3 rounded shadow max-w-md w-full" v-if="focused">
                    <div v-if="results && query">
                        <div v-for="(results, type) in types" :key="type" class="mb-4">
                            <span class="uppercase text-gray-800 text-xs font-bold">{{ type }}</span>
                            <ul>
                                <li v-for="result in results.slice(0, 10)" :key="result.id" class="text-black"
                                    @click="unfocus">
                                    <router-link :to="result.resource.url" class="focus:outline-none">
                                        {{ result.resource.title }}
                                    </router-link>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div v-if="results.length === 0 && query" class="text-xs text-black">
                        <p>Nothing found.</p>
                    </div>

                    <div v-if="!query" class="text-xs text-black">
                        <p>Search for albums, artists and songs!</p>
                    </div>
                </div>
            </div>

        </div>

        <div class="flex justify-end w-full" v-if="artist">
            <div class="mr-6 text-gray-200 no-underline flex items-center">
                <div v-if="artist.is_admin" class="mx-2">
                    <a href="/dashboard" class="text-gray-200">Dashboard</a>
                </div>
                <h3>Hello, {{ artist.name }}!</h3>
            </div>
            <div>
                <button
                    @click="logout()"
                    class="px-8 py-1 mr-2 rounded-full bg-green-300 text-green-600 max-w-max shadow-sm hover:shadow-md"
                >
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>

            </div>
        </div>

        <div class="flex justify-end w-full" v-else>
            <div>
                <a class="px-8 py-2 mr-2 rounded-full bg-green-300 text-green-600 max-w-max shadow-sm hover:shadow-md" href="/login">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
            </div>
            <div>
                <a href="/register" class="px-8 py-2 rounded-full border border-green-600 text-green-600 max-w-max shadow-sm hover:shadow-md">
                    <i class="fas fa-user-plus"></i>
                    Sign Up
                </a>
            </div>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            query: null,
            focused: false,
            results: [],
            artist: this.$artist,
        }
    },
    computed: {
        types() {
            return _.groupBy(this.results, 'resource.type')
        }
    },
    watch: {
        query(after, before) {
            this.search()
        },
    },
    methods: {
        logout() {
            axios.get('/logout')
                .then(response => {
                    this.artist = null
                    this.$artist = null
                    this.$router.push({ name: 'browse' })
                })
                .catch(console.log)
        },
        search() {
            axios.get('/api/search/' + this.query)
                .then(response => this.results = response.data.data)
                .catch(error => {})
        },
        focus() {
            this.focused = true
        },
        unfocus() {
            this.focused = false
        },
        blur() {
            this.unfocus()
            this.$refs.search.blur()
        }
    }
}
</script>
