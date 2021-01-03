<template>
    <div class="flex items-center justify-center">
        <div class="bg-gray-800 text-white font-bold rounded-lg shadow-lg p-10 text-center w-full lg:w-1/2">
            <h2 class="font-bold text-3xl text-white leading-none mb-10">Import From Youtube</h2>
            <div class="mb-3 pt-0">
                <input
                    :disabled="importing"
                    v-model="url"
                    type="text"
                    placeholder="Youtube Url"
                    class="px-3 py-3 placeholder-gray-400 text-gray-700 relative bg-white bg-white rounded text-sm shadow outline-none focus:outline-none focus:shadow-outline w-full"
                />

                <vue-simple-progress
                    v-if="importing"
                    class="px-3 py-3"
                    text-fg-color="#eee"
                    size="big"
                    :val="progressValue"
                    :text="progressValue + '%'"
                    bar-color="#48bb78"
                    bar-border-radius="10"
                    text-align="left"
                ></vue-simple-progress>

                <button
                    class="px-8 py-2 rounded-full border border-green-600 text-green-600 max-w-max shadow-sm hover:shadow-md my-3"
                    @click.prevent="importMusic()"
                    :disabled="importing"
                >
                    <i class="fas fa-plus"></i>
                    Import From Youtube
                </button>

            </div>
        </div>

    </div>
</template>

<script>
import 'vue-simple-progress';

export default {
    name: "ImportYoutube",

    data() {
        return {
            progressValue: 0,
            url: '',
            importing: false,
        }
    },
    methods: {
        importMusic() {
            axios.post('/api/songs/import-youtube', {
                url: this.url
            }).then(function (response) {
                this.trackProgress(response.data.data.job_id);
                this.importing = true;
            }.bind(this)).catch(console.log)
        },

        trackProgress(jobId) {
            let interval = setInterval(() => {
                axios.get('/api/songs/import-youtube/' + jobId)
                    .then((response) => {
                        this.progressValue = response.data.data.progress_now;

                        if(response.data.data.status === 'finished') {
                            clearInterval(interval);
                            this.importing = false;
                        }
                    }).catch(console.log)
            }, 1000);

        }
    }
}
</script>

<style>
.vue-simple-progress-text {
    font-size: 16px!important;
}
</style>
