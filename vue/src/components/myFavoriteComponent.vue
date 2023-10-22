<template>
    <transition name="appear">
        <div class="mx-4 mt-8 tablet:mx-8">
            <div class="flex items-center gap-x-2 mb-8">
                <span class="text-white/80 font-semibold flex-none text-lg">My Favorite</span>
                <div class="w-[90%]">
                    <svg class="w-full" height="2" viewBox="0 0 1000 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="1000" height="2" fill="#CCCCCC" fill-opacity="0.4"/>
                    </svg>
                </div>
            </div>

            <div v-if="!showStore.myFavorite.length" class="relative inline-block bg-[#191919] p-4 rounded-[10px]">
                <div class="flex justify-center items-center">
                    <span class="text-white/80 text-base">No favourite episode added yet!</span>
                </div>

                <div @click.stop="routeToShows" class="text-right">
                    <span class="text-sm text-white/60 border-b borer-white/40 laptop:cursor-pointer laptop:hover:text-white/20 laptop:active:text-white/60">shows</span>
                </div>

            </div>

            <div @click.stop="play(favEpi)" v-for="(favEpi, i) in showStore.myFavorite" :key="i" class="border-b border-white/20 ">
                <div class="p-2 rounded-[10px] active:bg-white/20 transition laptop:cursor-pointer laptop:hover:bg-white/10 laptop:active:bg-white/20">
                    <div class="flex justify-between">
                        <div>
                            <span class="text-base text-white font-medium break-all line-clamp-1">{{ favEpi.title }}</span>
                        </div>
                        <div class="flex gap-x-2 items-center">

                            <!-- icons -->

                            <div class="w-8 h-auto">
                                <img v-if="favEpi.id === showStore.currentEpisode.id" class="w-full h-full" src="../assets/output-onlinegiftools(1).gif" alt="waveform">
                            </div>

                            <div>
                                <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <mask id="mask0_96_3200" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="-1" y="-1" width="18" height="16">
                                        <path d="M4.4 0.134767C1.97 0.134767 0 2.10477 0 4.53477C0 8.93477 5.2 12.9348 8 13.8652C10.8 12.9348 16 8.93477 16 4.53477C16 2.10477 14.03 0.134767 11.6 0.134767C10.112 0.134767 8.796 0.873567 8 2.00437C7.59427 1.42645 7.05526 0.954802 6.42861 0.629361C5.80196 0.30392 5.10612 0.134267 4.4 0.134767Z" fill="white" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                    </mask>
                                    <g mask="url(#mask0_96_3200)">
                                        <path d="M-1.59998 -3.06519H17.6V16.1348H-1.59998V-3.06519Z" fill="#ED4343" fill-opacity="0.8"/>
                                    </g>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div>
                        <span class="text-white/60 font-semibold text-sm">{{favEpi.show_title}}</span>
                    </div>
                </div>

            </div>
            <playListComponent />
        </div>    
    </transition>

</template>

<script setup>
import playListComponent from './playListComponent.vue';
import { useRouter } from 'vue-router';
import { useShowsStore } from '../stores/ShowsStore';

const router = useRouter();
const showStore = useShowsStore();

async function play(epi) {

    await showStore.getShow(Number(epi.show_id));
    showStore.currentEpisode = epi;

    router.push({
        name : 'show',
        params : {
            id : epi.show_id
        }
    });
}

function routeToShows() {
    router.push({
        name : 'audienceShows'
    });
}
</script>


<style>

</style>