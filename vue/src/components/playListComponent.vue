<template>
    <div class="mt-8">
        <div class="flex items-center gap-x-2 mb-8">
            <span class="text-white/80 font-semibold flex-none text-lg">Play list</span>
            <div class="w-[90%]">
                <svg class="w-full" height="2" viewBox="0 0 1000 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="1000" height="2" fill="#CCCCCC" fill-opacity="0.4"/>
                </svg>
            </div>
        </div>

        <div v-if="!showStore.playList.length" class="relative inline-block bg-[#191919] p-4 rounded-[10px]">
            <div class="flex justify-center items-center">
                <span class="text-white/80 text-base">No episode listen yet!</span>
            </div>

            <div @click.stop="routeToShows" class="text-right ">
                <span class="text-sm text-white/60 border-b borer-white/40 laptop:cursor-pointer laptop:hover:text-white/20 laptop:active:text-white/60">shows</span>
            </div>

        </div>

        <div @click.stop="play(plyEpi)" v-for="(plyEpi, i) in showStore.playList" :key="i" class="border-b border-white/20 ">
            <div class="p-2 rounded-[10px] active:bg-white/20 transition laptop:cursor-pointer laptop:hover:bg-white/10 laptop:active:bg-white/20">
                <div class="flex justify-between">
                    <div>
                        <span class="text-base text-white font-medium break-all leading-8 line-clamp-1">{{ plyEpi.title }}</span>
                    </div>
                    <div class="flex gap-x-2 items-center">

                        <!-- icons -->

                        <div class="w-8 h-auto">
                            <img v-if="plyEpi.id === showStore.currentEpisode.id" class="w-full h-full" src="../assets/output-onlinegiftools(1).gif" alt="waveform">
                        </div>
                    </div>
                </div>

                <div>
                    <span class="text-white/60 font-semibold text-sm">{{plyEpi.show_title}}</span>
                </div>
            </div>

        </div>

    </div>
</template>

<script setup>
import router from '../router';
import { useShowsStore } from '../stores/ShowsStore';


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

function routeToShows () {
    router.push({
        name : "audienceShows"
    })
}

</script>

<style>

</style>