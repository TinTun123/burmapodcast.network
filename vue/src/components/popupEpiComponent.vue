<template>
    <transition name="fade" mode="out-in">
        <div :key="currentEpisode.type" v-if="currentEpisode"  class="flex flex-col lg-tablet:flex-row lg-tablet:flex-nowrap laptop:flex-nowrap items-stretch laptop:items-center laptop:flex-row w-full gap-x-4 gap-y-4 laptop:px-4">

            <div @click.stop="routeToShow(epi.season.show.id, epi)" v-for="(epi,i) in currentEpisode.episode" :key="i" class="flex justify-between gap-x-2 p-2 bg-[#1A1A1A] laptop:bg-[#282828] hover:bg-[#282828]/80 laptop:cursor-pointer rounded-[10px] shadow-img-shadow laptop:shadow-none">
                <div class="">

                    <div class="flex justify-between">

                        <!-- upper flex -->


                        <div class="flex gap-x-2 items-center">
                            <!-- show title -->

                            <span class="text-white/60 text-sm font-semibold break-all line-clamp-1 leading-7" >
                                {{ epi.season.show.title }}
                            </span>

                            <span class="text-xx-sm text-white font-medium bg-[#404040] whitespace-nowrap px-2 py-1 rounded-full">
                                {{ currentEpisode.type }}
                            </span>

                        </div>

                        <div v-if="type === 'desktop'" class="flex gap-x-2">
                            <!-- icons -->
                            <div class="flex gap-x-1 items-center">
                                <div>
                                    <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.7037 0.5C10.1156 0.5 8.74667 1.38609 8 2.85391C7.25333 1.38609 5.88444 0.5 4.2963 0.5C3.15727 0.501611 2.06529 1.03349 1.25987 1.97898C0.454457 2.92447 0.00137221 4.20636 0 5.54348C0 8.02956 1.33333 10.6278 3.95556 13.2643C5.1663 14.4738 6.47359 15.5434 7.85926 16.4583C7.9025 16.4857 7.95086 16.5 8 16.5C8.04914 16.5 8.0975 16.4857 8.14074 16.4583C9.52641 15.5434 10.8337 14.4738 12.0444 13.2643C14.6667 10.6278 16 8.02956 16 5.54348C15.9986 4.20636 15.5455 2.92447 14.7401 1.97898C13.9347 1.03349 12.8427 0.501611 11.7037 0.5ZM8 15.7539C6.96296 15.0617 0.592593 10.593 0.592593 5.54348C0.593769 4.39079 0.984357 3.2857 1.67868 2.47063C2.37301 1.65555 3.31437 1.19703 4.2963 1.19565C5.86 1.19565 7.17407 2.17913 7.72593 3.76174C7.74825 3.82553 7.78622 3.8801 7.83502 3.9185C7.88383 3.9569 7.94125 3.9774 8 3.9774C8.05875 3.9774 8.11617 3.9569 8.16498 3.9185C8.21378 3.8801 8.25175 3.82553 8.27407 3.76174C8.82593 2.17913 10.14 1.19565 11.7037 1.19565C12.6856 1.19703 13.627 1.65555 14.3213 2.47063C15.0156 3.2857 15.4062 4.39079 15.4074 5.54348C15.4074 10.587 9.03704 15.0617 8 15.7539Z" fill="#CCCCCC"/>
                                    </svg>
                                </div>
                                <span class="text-white/40 text-sm font-semibold">{{ epi.number_of_likes }}</span>
                            </div>
                            <div class="flex gap-x-1 items-center">
                                <div>
                                    <svg width="16" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9 16.5C10.5822 16.5 12.129 16.0308 13.4446 15.1518C14.7602 14.2727 15.7855 13.0233 16.391 11.5615C16.9965 10.0997 17.155 8.49113 16.8463 6.93928C16.5376 5.38743 15.7757 3.96197 14.6568 2.84315C13.538 1.72433 12.1126 0.962403 10.5607 0.653721C9.00887 0.34504 7.40034 0.503466 5.93853 1.10897C4.47672 1.71447 3.22729 2.73985 2.34824 4.05544C1.46919 5.37103 1 6.91775 1 8.5C1 9.82267 1.32 11.0689 1.88889 12.1684L1 16.5L5.33155 15.6111C6.43022 16.1791 7.67822 16.5 9 16.5Z" stroke="#CCCCCC" stroke-width="0.666667" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </div>

                                <span class="text-white/40 text-sm font-semibold">
                                    {{ epi.comments_count }}
                                </span>
                            </div>

                        </div>

                    </div>


                

                        <!-- lower flex -->
                        <!-- episode title -->

                    <h3 class="text-white/80 font-bold leading-8 break-all line-clamp-1">{{ epi.title }}</h3>
                    
                    <!-- <img src="" alt=""> -->

                    </div>

                    <div class="w-[48px] aspect-square flex-none">
                 
                        <img :src="epi.img_url" class="w-full h-full" alt="">
                    </div>

            </div>

        </div>    

    </transition>

</template>

<script setup>

import { computed, onMounted, ref } from 'vue';
import { useShowsStore } from '../stores/ShowsStore';
import { useRouter } from 'vue-router';
import { useBreakPoints } from '../router/composible/useBreakPoint';
const episodes = ref([]);
const currentIndex = ref(0);
const showStore = useShowsStore();
const router = useRouter();
const {type} = useBreakPoints();

const currentEpisode = computed(() => {

    return episodes.value[currentIndex.value];

})

const toggleEpisode = () => {
    currentIndex.value = (currentIndex.value + 1) % episodes.value.length;

}

onMounted(async () => {

    await showStore.fetchLatest();

    episodes.value.push(showStore.latestEpi);

    await showStore.fetchMostListen();

    episodes.value.push(showStore.mostWatchEpi);

    setInterval(toggleEpisode, 5000);
})

async function routeToShow(showId, epi) {

    await showStore.getShow(Number(showId));
    showStore.currentEpisode = epi;

    router.push({
        name : 'show',
        params : {
            id : showId
        }
    });

}


</script>

<style>

.fade-enter-active {
  transition: opacity 5s;
}

.fade-leave-active {
    transition: opacity 0.5s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}

</style>