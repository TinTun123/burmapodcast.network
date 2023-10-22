<template>
        <transition name="slide-fade" appear>

        <div class="mx-4 tablet:mx-8">

            <div class="flex flex-col gap-y-4">

                <div v-for="(seasons, index) in showStore.currentShow.seasons" :key="index">

                    <h1 class="text-lg font-medium text-white/80">Season: {{ seasons.season_number }}</h1>
                    
                    <div class="flex flex-col">

                        <div class="border-b border-[#7D7D7D]/40" v-for="(epi, i) in seasons.episodes" :key="i" >
                        
                            <div @click.stop="play(epi)" class="flex justify-between transition hover:bg-white/10 laptop:active:bg-white/20 rounded-[10px] p-2"> 

                                <div class="flex gap-x-1 items-center">
                                    <div v-if="userStore.token" class="">
                                        <svg width="8" height="8" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="12" cy="12" r="12" :class="[epi.state ? 'fill-[#6ac562]' : 'fill-[#d3a968]']"/>
                                        </svg>
                                    </div>
                                    <h2 class="text-base text-white font-medium">0{{ epi.episode_number }}</h2>
                                    <h3 class="text-base text-white font-regular line-clamp-1">{{ epi.title }}</h3>
                                    

                                </div>
 
                                <div class="flex item-center gap-x-2">

                                    <div class="w-8 h-auto">
                                        <img v-if="epi.id === showStore.currentEpisode.id" class="w-full h-full" src="../assets/output-onlinegiftools(1).gif" alt="waveform">
                                    </div>

                                    <div @click.stop="likeEpisode(epi)" v-if="route.name === 'show'">

                                        <svg v-if="showStore.isLike(epi.id)" width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <mask id="mask0_96_3200" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="-1" y="-1" width="18" height="16">
                                                <path d="M4.4 0.134767C1.97 0.134767 0 2.10477 0 4.53477C0 8.93477 5.2 12.9348 8 13.8652C10.8 12.9348 16 8.93477 16 4.53477C16 2.10477 14.03 0.134767 11.6 0.134767C10.112 0.134767 8.796 0.873567 8 2.00437C7.59427 1.42645 7.05526 0.954802 6.42861 0.629361C5.80196 0.30392 5.10612 0.134267 4.4 0.134767Z" fill="white" stroke="white" stroke-width="1.33333" stroke-linecap="round" stroke-linejoin="round"/>
                                            </mask>
                                            <g mask="url(#mask0_96_3200)">
                                                <path d="M-1.59998 -3.06519H17.6V16.1348H-1.59998V-3.06519Z" fill="#ED4343" fill-opacity="0.8"/>
                                            </g>
                                        </svg>

                                        <svg v-else width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path class="fill-[#CCCCCC] " d="M11.7037 0.5C10.1156 0.5 8.74667 1.38609 8 2.85391C7.25333 1.38609 5.88444 0.5 4.2963 0.5C3.15727 0.501611 2.06529 1.03349 1.25987 1.97898C0.454457 2.92447 0.00137221 4.20636 0 5.54348C0 8.02956 1.33333 10.6278 3.95556 13.2643C5.1663 14.4738 6.47359 15.5434 7.85926 16.4583C7.9025 16.4857 7.95086 16.5 8 16.5C8.04914 16.5 8.0975 16.4857 8.14074 16.4583C9.52641 15.5434 10.8337 14.4738 12.0444 13.2643C14.6667 10.6278 16 8.02956 16 5.54348C15.9986 4.20636 15.5455 2.92447 14.7401 1.97898C13.9347 1.03349 12.8427 0.501611 11.7037 0.5ZM8 15.7539C6.96296 15.0617 0.592593 10.593 0.592593 5.54348C0.593769 4.39079 0.984357 3.2857 1.67868 2.47063C2.37301 1.65555 3.31437 1.19703 4.2963 1.19565C5.86 1.19565 7.17407 2.17913 7.72593 3.76174C7.74825 3.82553 7.78622 3.8801 7.83502 3.9185C7.88383 3.9569 7.94125 3.9774 8 3.9774C8.05875 3.9774 8.11617 3.9569 8.16498 3.9185C8.21378 3.8801 8.25175 3.82553 8.27407 3.76174C8.82593 2.17913 10.14 1.19565 11.7037 1.19565C12.6856 1.19703 13.627 1.65555 14.3213 2.47063C15.0156 3.2857 15.4062 4.39079 15.4074 5.54348C15.4074 10.587 9.03704 15.0617 8 15.7539Z"/>
                                        </svg>
                                    </div>

                                    <div @click.stop="drop(epi.id)">
                                        <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9 16.5C10.5822 16.5 12.129 16.0308 13.4446 15.1518C14.7602 14.2727 15.7855 13.0233 16.391 11.5615C16.9965 10.0997 17.155 8.49113 16.8463 6.93928C16.5376 5.38743 15.7757 3.96197 14.6568 2.84315C13.538 1.72433 12.1126 0.962403 10.5607 0.653721C9.00887 0.34504 7.40034 0.503466 5.93853 1.10897C4.47672 1.71447 3.22729 2.73985 2.34824 4.05544C1.46919 5.37103 1 6.91775 1 8.5C1 9.82267 1.32 11.0689 1.88889 12.1684L1 16.5L5.33155 15.6111C6.43022 16.1791 7.67822 16.5 9 16.5Z" stroke="#CCCCCC" stroke-width="0.666667" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>

                                    <div v-if="userStore.token && (route.name !== 'episode'&& route.name !== 'show') && (userStore.isAdmin || userStore.iscoHost)" @click.stop="edit(epi)">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M15.74 3.59283C16.0867 3.24622 16.0867 2.66852 15.74 2.33968L13.6603 0.259964C13.3315 -0.0866546 12.7538 -0.0866546 12.4072 0.259964L10.7718 1.8864L14.1047 5.21928M0 12.6671V16H3.33287L13.1626 6.16137L9.82975 2.8285L0 12.6671Z" fill="#CCCCCC"/>
                                        </svg>
                                    </div>
                                </div>

                            </div>

                            <transition name="slide-down">
                                <div v-if="dropId === epi.id" :class="[dropId === epi.id ? 'max-h-[1000px]' : 'max-h-0']" class="relative">
                                    <div @click.stop="drop(epi.id)" 
                                    class="text-white/60 
                                    text-sm 
                                    font-semibold 
                                    border-b border-white/80 
                                    absolute
                                    right-4
                                    top-[-16px]
                                    cursor-pointer">
                                    close all
                                    </div>

                                    <ul class="space-y-4 mt-8 max-h-[70vh] overflow-y-scroll scroll-container">

                                        <li v-for="(comment) in commentStore.currentComList" :key="comment.id">
                                            <div class="bg-[#303030] rounded-t-[15px] rounded-br-[15px] inline-block px-4 py-2 relative">
                                                <div v-if="userStore.token && (route.name !== 'episode'&& route.name !== 'show') && userStore.user_level === 2" class="absolute top-2 right-2 group cursor-pointer" @click.stop="deleteComment(comment.id, epi.id)">
                                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M20 5C20.2652 5 20.5196 5.10536 20.7071 5.29289C20.8946 5.48043 21 5.73478 21 6C21 6.26522 20.8946 6.51957 20.7071 6.70711C20.5196 6.89464 20.2652 7 20 7H19L18.997 7.071L18.064 20.142C18.0281 20.6466 17.8023 21.1188 17.4321 21.4636C17.0619 21.8083 16.5749 22 16.069 22H7.93C7.42414 22 6.93707 21.8083 6.56688 21.4636C6.1967 21.1188 5.97092 20.6466 5.935 20.142L5.002 7.072C5.00048 7.04803 4.99982 7.02402 5 7H4C3.73478 7 3.48043 6.89464 3.29289 6.70711C3.10536 6.51957 3 6.26522 3 6C3 5.73478 3.10536 5.48043 3.29289 5.29289C3.48043 5.10536 3.73478 5 4 5H20ZM16.997 7H7.003L7.931 20H16.069L16.997 7ZM14 2C14.2652 2 14.5196 2.10536 14.7071 2.29289C14.8946 2.48043 15 2.73478 15 3C15 3.26522 14.8946 3.51957 14.7071 3.70711C14.5196 3.89464 14.2652 4 14 4H10C9.73478 4 9.48043 3.89464 9.29289 3.70711C9.10536 3.51957 9 3.26522 9 3C9 2.73478 9.10536 2.48043 9.29289 2.29289C9.48043 2.10536 9.73478 2 10 2H14Z" class="fill-[#CCCCCC]/60 group-hover:fill-[#CCCCCC]/40 group-active:fill-[#CCCCCC]/60"/>
                                                    </svg>
                                                </div>
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-semibold text-white/80">{{ comment.user ? comment.user.name : comment.audience.name }}</span>
                                                    <span class="text-[#D6D6D6]/80 text-x-sm font-semibold">{{ comment.human_created_at }}</span>
                                                </div>

                                                <p class="text-white text-base font-medium mt-2 ml-2">{{ comment.content }}</p>
                                            </div>
                                            <!-- <span>{{ comment.content }}</span>
                                            <span>by {{ comment.user ? comment.user.name : comment.audience.name }}</span> -->
                                            <!-- <button v-if="userStore.token" @click.stop="deleteComment(comment.id, epi.id)">delete</button> -->
                                        </li>
                                        <li v-if="!commentStore.currentComList.length">
                                            <div class="bg-[#303030] rounded-t-[15px] rounded-br-[15px] inline-block px-4 py-2">
                                                <p class="text-white text-base font-medium mt-2 ml-2">No comment posted yet!</p>
                                            </div>
                                        </li>
                                        <div class="flex justify-between items-center laptop:justify-end pb-2 gap-x-2">
                                            <input 
                                            class="appearance-none 
                                            focus:outline-none 
                                            rounded-full 
                                            border border-[#D6D6D6] 
                                            placeholder:text-sm placeholder:text-white/40 placeholder:font-semibold 
                                            text-white/80 
                                            bg-transparent 
                                            px-2 py-2
                                            w-full
                                            laptop:w-auto" 
                                            placeholder="comment" type="text" v-model="comment">
                                            <button @click.stop="createComment(epi.id)" type="button" 
                                            class="text-sm font-semibold rounded-full px-3 py-2 bg-white">Post</button>
                                        </div>
                                    </ul> 
                                </div>
                            </transition>
                        </div>
                    </div>

                </div>
            </div>
            <CollectUserDataComponent @createComment="createComment" @likeEpisode="likeEpisode" ref="collectUserData"/>
        </div> 
    </transition>




</template>

<script setup>
import { useRoute } from 'vue-router';
import { useShowsStore } from '../stores/ShowsStore';
import { onMounted, ref, watch } from 'vue';
import { useUserStore } from '../stores/userStore';
import CollectUserDataComponent from '../components/CollectUserDataComponent.vue';
import { useCommentStore } from '../stores/commentStore';

const dropId = ref(0);
const showStore = useShowsStore();
const route = useRoute();
const userStore = useUserStore();
const commentStore = useCommentStore();
const emit = defineEmits(['editEpisode']);
const comment = ref('');
const collectUserData = ref(null);
// eslint-disable-next-line no-unused-vars
const props = defineProps(['showName']);



function drop(id) {

    if(id !== dropId.value) {
        dropId.value = id;
    } else {
        dropId.value = 0;
    }
}

function play(epi) {

    showStore.currentEpisode = epi;
    
}

function edit(epi) {
    emit('editEpisode', epi);
}

onMounted(async () => {

    if (route.query.epid) {
        
        const epi = getEpisodeplay(route.query.epid);
        play(epi); 
        showStore.scrollState = true;

    }
})


function getEpisodeplay(epiid) {

for (let i = 0; i < showStore.currentShow.seasons.length; i++) {
    for (let j = 0; j < showStore.currentShow.seasons[i].episodes.length; j++) {
        if (Number(epiid) === showStore.currentShow.seasons[i].episodes[j].id) {
            return showStore.currentShow.seasons[i].episodes[j];
        }
    }
}

}


async function collectData(emittype, payload) {

    await collectUserData.value.openModal(emittype, payload);

}


function createComment(epiId) {

    if (!Object.keys(userStore.audience).length && !userStore.token) {

        collectData('createComment', epiId);
        return '';

    }
 
    if (comment.value) {
        const formData = new FormData();

        formData.append('comment', comment.value);
        formData.append('showId', showStore.currentShow.id);

        if (Object.keys(userStore.audience).length) {
            formData.append('audienceId', userStore.audience.id);
        }

        // eslint-disable-next-line no-unused-vars
        commentStore.createComment(formData, epiId).then(res => {
            comment.value = '';
        })

    }
    
}

function deleteComment(commentId, episodeId) {

    commentStore.deleteComment(commentId, episodeId).then(res => {
        return res;
    })
}

function likeEpisode(epi) {

    if (!Object.keys(userStore.audience).length && !userStore.token) {
        
        collectData('likeEpisode', epi);
        return '';
    }

    if (showStore.isLike(epi.id)) {

        return ''

    } else {

        showStore.likeEpisode(epi, showStore.currentShow.title, showStore.currentShow.id);
    }

}
// eslint-disable-next-line no-unused-vars
watch((dropId), (newDrop, oldDrop) => {
    if (newDrop !== 0) {
        commentStore.getComments(newDrop);
    }
})


</script>

<style>
</style>