<template>
    <div class="sidebar" style="width: 200px">
        <div class="sidebar__container">
            <img src="/images/logo.png" alt="Logo" class="px-4 pt-4">
            <ul class="sidebar__nav">
                <li class="sidebar__label mt-8">
                    Feed
                </li>
                <li class="sidebar__item">
                    <router-link tag="button" exact to="/" class="sidebar__link">
                        <i class="fas fa-newspaper text-axiom-500"></i> Browse
                    </router-link>
                </li>
            </ul>

            <ul class="sidebar__nav mt-5">
                <li class="sidebar__label">
                    Your Library
                </li>
                <li class="sidebar__item">
                    <router-link tag="button" to="/recently-added" class="sidebar__link">
                        <i class="fas fa-plus text-axiom-500"></i> Recently Added
                    </router-link>
                </li>

                <li class="sidebar__item">
                    <router-link tag="button" to="/artists" class="sidebar__link">
                        <i class="fas fa-users text-axiom-500"></i> Artists
                    </router-link>
                </li>

                <li class="sidebar__item">
                    <router-link tag="button" to="/albums" class="sidebar__link">
                        <i class="fas fa-compact-disc"></i> Albums
                    </router-link>
                </li>

                <li class="sidebar__label mt-3" v-if="this.$artist">
                    Options
                </li>

                <li class="sidebar__item" v-if="this.$artist">
                    <router-link tag="button" to="/import-youtube" class="sidebar__link">
                        <i class="fab fa-youtube"></i> Youtube Import
                    </router-link>
                </li>
            </ul>

        </div>
        <cover></cover>
    </div>
</template>
<script>
import Cover from "./Cover";
export default {
    name: 'sidebar',
    components: {
      Cover
    },
    data() {
        return {}
    }
}
</script>
