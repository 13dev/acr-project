<template>
    <div class="bg-gray-900 min-h-screen h-screen overflow-hidden font-sans flex flex-col text-gray-400">
        <div class="flex flex-1">
            <sidebar></sidebar>

            <div class="flex-1 relative overflow-y-scroll">
                <!-- search -->

                <div class="p-6 flex justify-center overflow-y-scroll">
                    <div class="w-full">
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
        <!-- player -->
    </div>
</template>

<script>
import Sidebar from "./Sidebar";

export default {
    name: 'app',
    components: {
        Sidebar
    }
}
</script>
