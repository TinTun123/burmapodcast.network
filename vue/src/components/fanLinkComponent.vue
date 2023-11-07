<template>
    <div class="flex justify-center items-center min-h-screen z-[9999] relative">
        <div class="flex lg-tablet:flex-row flex-col gap-4">
            <div id="thumbnail" class="w-[214px] flex-none mx-auto aspect-square rounded-[8px] overflow-hidden">
                <img :src="showStore.thumb" class="w-full h-full" alt="">
            </div>

            <div class="grid grid-cols-1 items-stretch tablet:grid-cols-2 gap-4 w-full">

                <div @click.stop="dropSpotify = !dropSpotify" class="p-4 group flex gap-x-12 laptop:cursor-pointer bg-[#1D1D1D] h-[96px] justify-between items-center rounded-[4px] shadow-card-shadow relative">
                    <div class="h-[48px]">
                        <img src="../assets/spotify_logo.svg" class="w-full h-full" alt="">
                    </div>
                    <div class="flex flex-col items-center gap-y-1">
                        <svg class="" width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-white group-hover:fill-white/80 transition-all" d="M7.59563 5.19431L1.23294 8.88613C0.692966 9.19911 0 8.82013 0 8.18916V0.805524C0 0.175555 0.691966 -0.204427 1.23294 0.109558L7.59563 3.80138C7.71846 3.8715 7.82056 3.97285 7.89158 4.09517C7.96259 4.21748 8 4.3564 8 4.49784C8 4.63928 7.96259 4.7782 7.89158 4.90051C7.82056 5.02283 7.71846 5.12419 7.59563 5.19431Z"/>
                        </svg>
                        <span class="text-white font-semibold text-xs group-hover:text-white/80 transition-all">GO</span>
                    </div>

                    <transition name="slide-down">
                        <div v-if="dropSpotify" class="bg-[#1D1D1D] absolute w-full top-[96px] left-0 overflow-hidden rounded-b-[15px]">
                            <ul class="transition-all">
                                <li @click.stop="openNewTag('https://open.spotify.com/show/0Ml7VnFRnoM4lsD99LyUgk')" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30 overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">
                                    <div class="flex gap-x-4 justify-start items-center">
                                        <div class="w-[20%] rounded-[4px] overflow-hidden">
                                            <img src="../assets/memory-of-a-poet.jpeg" class="aspect-square" alt="">
                                        </div>
                                        <span class="text-white font-semibold text-base">Memories of a poet</span>
                                    </div>
                                </li>

                                <li @click.stop="openNewTag('https://open.spotify.com/show/6PaSqXTelBeSKwjdE5jrYG')" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30 overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">
                                    
                                    <div class="flex gap-x-4 justify-start items-center">
                                        <div class="w-[20%] rounded-[4px] overflow-hidden">
                                            <img src="../assets/nyi_ko.jpg" class="aspect-square" alt="">
                                        </div>


                                        <span class="text-white font-semibold text-base">Nyo Ki FM</span>
                                    </div>
                                </li>

                                <li @click.stop="openNewTag('https://open.spotify.com/show/3dfOhUocdzeeRNOeWulIMS')" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30 overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">
                                
                                    <div class="flex gap-x-4 justify-start items-center overflow-hidden">
                                        <div class="w-[20%] flex-none rounded-[4px] overflow-hidden">
                                            <img src="../assets/mtk.jpeg" class="aspect-square" alt="">
                                        </div>
                                        <span class="text-white font-semibold text-base" style="text-overflow: ellipsis;">Story Telling by Mauk Kham Wah</span>
                                    </div>
                                </li>

                                <li @click.stop="openNewTag('https://open.spotify.com/show/24JQtnWAi2wrnvFJuTfbZr')" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30 overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">
                                    

                                    <div class="flex gap-x-4 justify-start items-center">
                                        <div class="w-[20%] rounded-[4px] overflow-hidden">
                                            <img src="../assets/sayarchit.jpg" class="aspect-square" alt="">
                                        </div>
                                        <span class="text-white font-semibold text-base">Rebel Wisdom</span>
                                    </div>
                                </li>
                            
                            </ul>
                        </div>
                    </transition>
                 

                </div>

                <div @click.stop="openNewTag(showStore.urls.apple)" class="p-4 group flex gap-x-12 laptop:cursor-pointer bg-[#1D1D1D] justify-between items-center rounded-[4px] shadow-card-shadow">
                    <div class="flex items-center gap-x-1">
                        <img src="../assets/apple_logo.svg"  alt="">
                        <span class="text-white text-xlg font-bold">Apple Podcast</span>
                    </div>
                    <div class="flex flex-col items-center gap-y-1">
                        <svg class="" width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-white group-hover:fill-white/80 transition-all" d="M7.59563 5.19431L1.23294 8.88613C0.692966 9.19911 0 8.82013 0 8.18916V0.805524C0 0.175555 0.691966 -0.204427 1.23294 0.109558L7.59563 3.80138C7.71846 3.8715 7.82056 3.97285 7.89158 4.09517C7.96259 4.21748 8 4.3564 8 4.49784C8 4.63928 7.96259 4.7782 7.89158 4.90051C7.82056 5.02283 7.71846 5.12419 7.59563 5.19431Z"/>
                        </svg>
                        <span class="text-white font-semibold text-xs group-hover:text-white/80 transition-all">PLAY</span>
                        
                    </div>
                </div>

                <div @click.stop="openNewTag(showStore.urls.youtube)" class="p-4 group flex gap-x-12 laptop:cursor-pointer bg-[#1D1D1D] h-[96px] justify-between items-center rounded-[4px] shadow-card-shadow">
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

                <div @click.stop="openNewTag(showStore.urls.informm)" class="p-4 group flex gap-x-12 laptop:cursor-pointer bg-[#1D1D1D] h-[96px] justify-between items-center rounded-[4px] shadow-card-shadow">
                    
                    <div class="h-[48px] flex items-center gap-x-2">
                        <img src="../assets/informm_logo.svg" class="w-full h-full" alt="">
                        <span class="text-white text-xlg font-bold">InforMM</span>
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
import { onMounted, ref } from 'vue';
import { useShowsStore } from '../stores/ShowsStore'
const showStore = useShowsStore();
const dropSpotify = ref(false);

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