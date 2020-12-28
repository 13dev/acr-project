<template>
    <div class="bg-gray-900 min-h-screen h-screen overflow-hidden font-sans flex flex-col text-gray-400">
        <div class="flex flex-1" style="height: calc(100% - 80px);">
            <sidebar></sidebar>

            <div class="flex-1 relative" style="height: calc(100% - 60px);">
                <search></search>
                <div class="p-6 flex justify-center h-full overflow-y-scroll">
                    <div class="w-full">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
        <player></player>
    </div>
</template>

<script>
import Sidebar from "./Sidebar";
import Player from "./Player";
import Search from "./Search";

export default {
    name: 'app',

    components: {
        Sidebar,
        Player,
        Search,
    }
}
</script>
