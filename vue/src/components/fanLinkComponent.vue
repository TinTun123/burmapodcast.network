<template>
    <div class="flex justify-center items-center min-h-screen">
        <div class="flex tablet:flex-row flex-col gap-4">
            <div id="thumbnail" class="w-[214px] aspect-square rounded-[8px] overflow-hidden">
                <img :src="showStore.thumb" class="w-full h-full" alt="">
            </div>

            <div class="grid grid-cols-1 items-stretch tablet:grid-cols-2 gap-4 w-full">

                <div @click.stop="openNewTag(showStore.urls.spotify)" class="p-4 group flex gap-x-12 laptop:cursor-pointer bg-black/10 h-[96px] justify-between items-center rounded-[4px] shadow-card-shadow">
                    <div class="h-[48px]">
                        <img src="../assets/spotify_logo.svg" class="w-full h-full" alt="">
                    </div>
                    <div class="flex flex-col items-center gap-y-1">
                        <svg class="" width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-white group-hover:fill-white/80 transition-all" d="M7.59563 5.19431L1.23294 8.88613C0.692966 9.19911 0 8.82013 0 8.18916V0.805524C0 0.175555 0.691966 -0.204427 1.23294 0.109558L7.59563 3.80138C7.71846 3.8715 7.82056 3.97285 7.89158 4.09517C7.96259 4.21748 8 4.3564 8 4.49784C8 4.63928 7.96259 4.7782 7.89158 4.90051C7.82056 5.02283 7.71846 5.12419 7.59563 5.19431Z"/>
                        </svg>
                        <span class="text-white font-semibold text-xs group-hover:text-white/80 transition-all">PLAY</span>
                        
                    </div>

                </div>

                <div @click.stop="openNewTag(showStore.urls.apple)" class="p-4 group flex gap-x-12 laptop:cursor-pointer bg-black/10 justify-between items-center rounded-[4px] shadow-card-shadow">
                    <div class="flex items-end gap-x-1">
                        <img src="../assets/apple_logo.svg"  alt="">
                        <span class="text-white fonr-bold">Apple Podcast</span>
                    </div>
                    <div class="flex flex-col items-center gap-y-1">
                        <svg class="" width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-white group-hover:fill-white/80 transition-all" d="M7.59563 5.19431L1.23294 8.88613C0.692966 9.19911 0 8.82013 0 8.18916V0.805524C0 0.175555 0.691966 -0.204427 1.23294 0.109558L7.59563 3.80138C7.71846 3.8715 7.82056 3.97285 7.89158 4.09517C7.96259 4.21748 8 4.3564 8 4.49784C8 4.63928 7.96259 4.7782 7.89158 4.90051C7.82056 5.02283 7.71846 5.12419 7.59563 5.19431Z"/>
                        </svg>
                        <span class="text-white font-semibold text-xs group-hover:text-white/80 transition-all">PLAY</span>
                        
                    </div>
                </div>

                <div @click.stop="openNewTag(showStore.urls.youtube)" class="p-4 group flex gap-x-12 laptop:cursor-pointer bg-black/10 h-[96px] justify-between items-center rounded-[4px] shadow-card-shadow">
                    <div class="h-[48px]">
                        <img src="../assets/youtube_logo.svg" class="w-full h-full" alt="">
                    </div>
                    <div class="flex flex-col items-center gap-y-1">
                        <svg class="" width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-white group-hover:fill-white/80 transition-all" d="M7.59563 5.19431L1.23294 8.88613C0.692966 9.19911 0 8.82013 0 8.18916V0.805524C0 0.175555 0.691966 -0.204427 1.23294 0.109558L7.59563 3.80138C7.71846 3.8715 7.82056 3.97285 7.89158 4.09517C7.96259 4.21748 8 4.3564 8 4.49784C8 4.63928 7.96259 4.7782 7.89158 4.90051C7.82056 5.02283 7.71846 5.12419 7.59563 5.19431Z"/>
                        </svg>
                        <span class="text-white font-semibold text-xs group-hover:text-white/80 transition-all">PLAY</span>
                    </div>
                </div>

                

            </div>

        </div>
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useShowsStore } from '../stores/ShowsStore'
const showStore = useShowsStore();


// console.log(showStore);
onMounted(async () => {

    await showStore.getURLS();
})


function openNewTag(url) {
    
    window.open(url, '_blank');
    return;
}




</script>

<style>
</style>