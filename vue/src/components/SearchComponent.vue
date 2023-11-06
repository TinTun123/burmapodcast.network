<template>
    <div class="w-full">
        <div class="flex flex-col gap-y-4">
            <!-- input field -->
            <div class="flex items-center flex-wrap gap-y-2 justify-end gap-x-4">
                <input v-model="query" type="text" class="appearance-none flex-1 focus:outline-none focus:border-[#D9D9D9]/60 h-full bg-transparent rounded-full border border-[#D9D9D9] text-white/80 placeholder:text-white/40 px-2" placeholder="search">
                <button @click="find" class="bg-[#D9D9D9] laptop:cursor-pointer laptop:hover:bg-[#D9D9D9]/80 laptop:active:shadow-none laptop:active:bg-[#D9D9D9] text-[#2F2F2F] font-semibold rounded-full px-4">Search</button>
            </div>

            <!-- filter -->
            <div class="flex gap-x-4 flex-wrap gap-y-2 items-center">
                <span class="text-base text-white font-medium">filter by:</span>

                <!-- <div @click.stop="pickCat('hosts')" :class="[category === 'hosts' ? 'bg-[#808080]' : 'bg-[#404040]']" class="flex gap-x-1 items-center px-2 py-1 rounded-full laptop:cursor-pointer hover:bg-[#404040]/60 active:bg-[#404040]">
                    <span :class="[category === 'hosts' ? 'text-white' : 'text-white/80']" class="text-sm font-semibold">Hosts</span>
                </div> -->

                <div class="relative overflow-x-visible">
                    <div @click.stop="dropHost = !dropHost" class="flex justify-between items-center gap-x-2 px-2 py-1 rounded-full laptop:cursor-pointer bg-[#404040] hover:bg-[#404040]/60 active:bg-[#404040]">
                        <span class="text-sm font-semibold text-white/80">Hosts</span>

                        <div>
                            <svg width="17" height="11" viewBox="0 0 17 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16.4865 2.62163L8.37837 10.7297L0.270264 2.62163L2.16216 0.729737L8.37837 6.94595L14.5946 0.729737L16.4865 2.62163Z" fill="white" fill-opacity="0.8"/>
                            </svg>
                        </div>
                    </div>

                    <div class="absolute -left-16 overflow-x-visible">

                        <transition name="slide-down">

                            <div v-if="dropHost" class="bg-[#404040]  scroll-container overflow-x-visible overflow-y-scroll rounded-[15px]">

                                <ul class="transition-all max-h-[161px] text-center overflow-x-visible">
                                    <li @click.stop="searchByHost(user.id)" v-for="(user, i) in userStore.users" :key="i" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30 overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">
                                        <div class="flex gap-x-2">
                                            <div class="">
                                                <div v-if="!user.profile_url"  class="h-8 w-8 tablet:w-8 tablet:h-8 aspect-square">
                                                    <svg class="w-full h-full" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.4C10.3209 2.39969 8.67111 2.83978 7.21526 3.67635C5.75942 4.51292 4.54845 5.7167 3.70323 7.16754C2.85801 8.61838 2.4081 10.2655 2.39841 11.9446C2.38872 13.6236 2.81959 15.2759 3.64801 16.7364C4.20794 16.0087 4.92772 15.4195 5.75171 15.0144C6.5757 14.6092 7.48181 14.399 8.4 14.4H15.6C16.5182 14.399 17.4243 14.6092 18.2483 15.0144C19.0723 15.4195 19.7921 16.0087 20.352 16.7364C21.1804 15.2759 21.6113 13.6236 21.6016 11.9446C21.5919 10.2655 21.142 8.61838 20.2968 7.16754C19.4516 5.7167 18.2406 4.51292 16.7847 3.67635C15.3289 2.83978 13.6791 2.39969 12 2.4ZM21.5316 19.2912C23.136 17.1995 24.0039 14.6361 24 12C24 5.37239 18.6276 0 12 0C5.37241 0 1.35039e-05 5.37239 1.35039e-05 12C-0.00394822 14.6361 0.863899 17.1996 2.46841 19.2912L2.46241 19.3128L2.88841 19.8084C4.01387 21.1242 5.41127 22.1803 6.98428 22.9039C8.5573 23.6276 10.2685 24.0015 12 24C14.4328 24.0045 16.8089 23.2655 18.81 21.882C19.6631 21.2925 20.4367 20.5956 21.1116 19.8084L21.5376 19.3128L21.5316 19.2912ZM12 4.79999C11.0452 4.79999 10.1295 5.17928 9.45442 5.85441C8.77929 6.52954 8.4 7.44521 8.4 8.39999C8.4 9.35477 8.77929 10.2704 9.45442 10.9456C10.1295 11.6207 11.0452 12 12 12C12.9548 12 13.8705 11.6207 14.5456 10.9456C15.2207 10.2704 15.6 9.35477 15.6 8.39999C15.6 7.44521 15.2207 6.52954 14.5456 5.85441C13.8705 5.17928 12.9548 4.79999 12 4.79999Z" fill="#CCCCCC"/>
                                                    </svg>
                                                </div>

                                                <div v-else class="w-8 h-8 tablet:w-8 tablet:h-8 rounded-full overflow-hidden aspect-square">
                                                    <img :src="user.profile_url" class="w-full h-full" alt="">
                                                </div>
                                            </div>

                                            <span>
                                                {{ user.name }}
                                            </span>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </transition>
                    </div>


                </div>

                <div @click.stop="pickCat('shows')" :class="[category === 'shows' ? 'bg-[#808080]' : 'bg-[#404040]']" class="flex gap-x-1 items-center px-2 py-1 rounded-full  laptop:cursor-pointer hover:bg-[#404040]/60 active:bg-[#404040]">
                    <span :class="[category === 'shows' ? 'text-white' : 'text-white/80']" class="text-sm font-semibold">shows</span>
                </div>

                <div @click.stop="pickCat('episodes')" :class="[category === 'episodes' ? 'bg-[#808080]' : 'bg-[#404040]']" class="flex gap-x-1 items-center px-2 py-1 rounded-full  laptop:cursor-pointer hover:bg-[#404040]/60 active:bg-[#404040]">
                    <span :class="[category === 'episodes' ? 'text-white' : 'text-white/80']" class="text-sm font-semibold">episodes</span>
                </div>

                <div @click.stop="pickCat('most')" :class="[category === 'most' ? 'bg-[#808080]' : 'bg-[#404040]']" class="flex gap-x-1 items-center px-2 py-1 rounded-full laptop:cursor-pointer hover:bg-[#404040]/60 active:bg-[#404040]">
                    <span :class="[category === 'most' ? 'text-white' : 'text-white/80']" class="text-sm font-semibold">most listen</span>
                </div>
            </div>

            <!-- <div class="flex gap-x-2 items-center">
                <h1 class="text-white font-semibold">Episodes:</h1>
                <span class="text-x-sm text-white/70 font-bold">{{ msg }}</span>
            </div> -->

            <!-- episode list -->

            <div>
                    <transition-group class="flex flex-col gap-y-4 max-h-[60vh] overflow-y-scroll scroll-container laptop:p-4" name="showList" tag="div">
                        <div v-for="(epi, i) in searchStore.episodes" :key="i" @click.stop="play(epi, epi.season.show.id)" class="flex gap-y-2 flex-col bg-[#1F1D1D] p-4 rounded-[10px] shadow-card-shadow transition hover:shadow-img-shadow laptop:cursor-pointer">
                            <div class="flex justify-between">
                            
                                <div class="flex gap-x-2 items-center">
                                
                                    <span class="text-x-sm text-white/60 font-bold">{{ epi.season.show.title }}</span>
                                </div>

                                <div class="flex gap-x-2 items-center">
                                
                                    <div class="flex gap-x-1 items-center">
                                        <div>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M7 13C8.18669 13 9.34672 12.6481 10.3334 11.9888C11.3201 11.3295 12.0891 10.3925 12.5433 9.2961C12.9974 8.19974 13.1162 6.99335 12.8847 5.82946C12.6532 4.66557 12.0818 3.59648 11.2426 2.75736C10.4035 1.91825 9.33443 1.3468 8.17054 1.11529C7.00665 0.88378 5.80025 1.0026 4.7039 1.45673C3.60754 1.91085 2.67047 2.67989 2.01118 3.66658C1.35189 4.65328 1 5.81331 1 7C1 7.992 1.24 8.92667 1.66667 9.75133L1 13L4.24867 12.3333C5.07267 12.7593 6.00867 13 7 13Z" stroke="#CCCCCC" stroke-width="0.666667" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </div>
                                        <span class="text-white/60 text-x-sm font-semibold">
                                            {{ epi.comments_count }}
                                        </span>
                                    </div>

                                    <div class="flex gap-x-1 items-center">
                                        <div>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.77778 1C8.58667 1 7.56 1.66457 7 2.76543C6.44 1.66457 5.41333 1 4.22222 1C3.36795 1.00121 2.54896 1.40012 1.9449 2.10923C1.34084 2.81835 1.00103 3.77977 1 4.78261C1 6.64717 2 8.59587 3.96667 10.5733C4.87473 11.4804 5.85519 12.2826 6.89444 12.9687C6.92687 12.9892 6.96315 13 7 13C7.03685 13 7.07313 12.9892 7.10556 12.9687C8.14481 12.2826 9.12528 11.4804 10.0333 10.5733C12 8.59587 13 6.64717 13 4.78261C12.999 3.77977 12.6592 2.81835 12.0551 2.10923C11.451 1.40012 10.632 1.00121 9.77778 1ZM7 12.4404C6.22222 11.9213 1.44444 8.56978 1.44444 4.78261C1.44533 3.91809 1.73827 3.08928 2.25901 2.47797C2.77975 1.86666 3.48578 1.52277 4.22222 1.52174C5.395 1.52174 6.38056 2.25935 6.79444 3.4463C6.81119 3.49415 6.83967 3.53507 6.87627 3.56387C6.91287 3.59267 6.95594 3.60805 7 3.60805C7.04406 3.60805 7.08713 3.59267 7.12373 3.56387C7.16033 3.53507 7.18881 3.49415 7.20556 3.4463C7.61944 2.25935 8.605 1.52174 9.77778 1.52174C10.5142 1.52277 11.2202 1.86666 11.741 2.47797C12.2617 3.08928 12.5547 3.91809 12.5556 4.78261C12.5556 8.56521 7.77778 11.9213 7 12.4404Z" stroke="#CCCCCC" stroke-width="0.37"/>
                                            </svg>
                                        </div>
                                        <span class="text-white/60 text-x-sm font-semibold">
                                            {{ epi.number_of_likes }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <span class="text-base text-white font-medium break-all line-clamp-1 leading-8">
                                    {{ epi.title }}
                                </span>
                            </div>

                            <div class="flex flex-wrap gap-2 mt-1">
                                <div v-for="(user, index) in epi.users" :key="index" class="flex gap-x-1 items-center px-2 rounded-full bg-[#404040]">
                                    <div>
                                        <svg width="12" height="12" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.8095 12.7619V15.2381H4.19048V12.7619C4.19048 11.7105 5.89715 10.8571 8 10.8571C10.1029 10.8571 11.8095 11.7105 11.8095 12.7619ZM8 3.04762C9.31345 3.04762 10.5731 3.56939 11.5019 4.49814C12.4306 5.42689 12.9524 6.68655 12.9524 8C12.9524 8.95238 12.6857 9.84381 12.221 10.5981L11.0476 9.55428C11.2914 9.08952 11.4286 8.55619 11.4286 8C11.4286 6.09524 9.90476 4.57143 8 4.57143C6.09524 4.57143 4.57143 6.09524 4.57143 8C4.57143 8.55619 4.70857 9.08952 4.95238 9.55428L3.77905 10.5981C3.31429 9.84381 3.04762 8.95238 3.04762 8C3.04762 6.68655 3.56939 5.42689 4.49814 4.49814C5.42689 3.56939 6.68655 3.04762 8 3.04762ZM8 0C10.1217 0 12.1566 0.842855 13.6569 2.34315C15.1571 3.84344 16 5.87827 16 8C16 9.73714 15.4438 11.3448 14.5067 12.6552L13.3638 11.6267C14.0648 10.5905 14.4762 9.34095 14.4762 8C14.4762 6.28241 13.7939 4.63516 12.5794 3.42064C11.3648 2.20612 9.71759 1.52381 8 1.52381C6.28241 1.52381 4.63517 2.20612 3.42064 3.42064C2.20612 4.63516 1.52381 6.28241 1.52381 8C1.52381 9.34095 1.93524 10.5905 2.63619 11.6267L1.49334 12.6552C0.520743 11.298 -0.0015564 9.66977 3.48388e-06 8C3.48388e-06 5.87827 0.842858 3.84344 2.34315 2.34315C3.84344 0.842855 5.87827 0 8 0ZM8 6.09524C8.50518 6.09524 8.98966 6.29592 9.34687 6.65313C9.70408 7.01034 9.90476 7.49482 9.90476 8C9.90476 8.50517 9.70408 8.98966 9.34687 9.34687C8.98966 9.70408 8.50518 9.90476 8 9.90476C7.49483 9.90476 7.01034 9.70408 6.65313 9.34687C6.29592 8.98966 6.09524 8.50517 6.09524 8C6.09524 7.49482 6.29592 7.01034 6.65313 6.65313C7.01034 6.29592 7.49483 6.09524 8 6.09524Z" fill="#8B8B8B"/>
                                        </svg>
                                    </div>
                                    <span class="text-x-sm font-semibold text-white/80">{{ user.name }}</span>

                                </div>
                            </div>
                        
                    </div>                    
                    </transition-group>



                <div v-if="!searchStore.episodes.length" class="flex flex-col items-center justify-center">
                    <div v-if="!searchStore.searching">
                        <svg width="77" height="76" viewBox="0 0 77 76" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g filter="url(#filter0_d_277_3857)">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M50.786 27.7667C50.786 30.1979 50.3071 32.6053 49.3767 34.8514C48.4464 37.0975 47.0827 39.1383 45.3636 40.8574C43.6445 42.5765 41.6037 43.9402 39.3575 44.8706C37.1114 45.8009 34.7041 46.2798 32.2729 46.2798C29.8417 46.2798 27.4344 45.8009 25.1883 44.8706C22.9421 43.9402 20.9013 42.5765 19.1822 40.8574C17.4631 39.1383 16.0994 37.0975 15.1691 34.8514C14.2387 32.6053 13.7598 30.1979 13.7598 27.7667C13.7598 22.8568 15.7103 18.1479 19.1822 14.676C22.6541 11.2041 27.3629 9.25366 32.2729 9.25366C37.1829 9.25366 41.8917 11.2041 45.3636 14.676C48.8355 18.1479 50.786 22.8568 50.786 27.7667ZM48.3608 50.402C42.6857 54.4369 35.7019 56.1924 28.7935 55.3208C21.8851 54.4492 15.5562 51.0139 11.0612 45.6959C6.56618 40.3779 4.23309 33.5653 4.52432 26.6082C4.81554 19.6511 7.70982 13.0573 12.6335 8.13355C17.5573 3.20982 24.1511 0.315544 31.1082 0.0243181C38.0653 -0.266908 44.8779 2.06617 50.1959 6.56118C55.5139 11.0562 58.9492 17.3851 59.8208 24.2935C60.6924 31.2019 58.9369 38.1857 54.902 43.8608L71.0269 59.9795C71.4816 60.4032 71.8464 60.9141 72.0993 61.4819C72.3523 62.0496 72.4883 62.6625 72.4993 63.2839C72.5102 63.9054 72.3959 64.5226 72.1632 65.0989C71.9304 65.6752 71.5839 66.1987 71.1444 66.6382C70.7049 67.0777 70.1814 67.4242 69.6051 67.657C69.0288 67.8898 68.4115 68.0041 67.7901 67.9931C67.1686 67.9821 66.5558 67.8461 65.9881 67.5932C65.4203 67.3402 64.9094 66.9755 64.4856 66.5207L48.3608 50.402Z" fill="#bfbfbf"/>
                            </g>
                            <defs>
                            <filter id="filter0_d_277_3857" x="0.5" y="0" width="76" height="75.9939" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                            <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                            <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                            <feOffset dy="4"/>
                            <feGaussianBlur stdDeviation="2"/>
                            <feComposite in2="hardAlpha" operator="out"/>
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.25 0"/>
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_277_3857"/>
                            <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_277_3857" result="shape"/>
                            </filter>
                            </defs>
                        </svg>
                    </div>
                    <div v-else>
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="display: block; shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                        <circle cx="50" cy="50" fill="none" stroke="#bfbfbf" stroke-width="3" r="35" stroke-dasharray="164.93361431346415 56.97787143782138">
                            <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="1s" values="0 50 50;360 50 50" keyTimes="0;1"></animateTransform>
                        </circle>
                        <!-- [ldio] generated by https://loading.io/ --></svg>
                    </div>
                </div>
                <h3 class="text-[#bfbfbf] text-center font-semibold">found {{ searchStore.episodes.length  }} episodes</h3>

            </div>

        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useSearchStore } from '../stores/searchStore';
import { useShowsStore } from '../stores/ShowsStore';
import { useUserStore } from '../stores/userStore';
import {useRouter} from 'vue-router';
import { useNotificationStore } from '../stores/NotiStore';

const category = ref('');
const query = ref('');
const msg = ref('');
const searchStore = useSearchStore();
const showStore = useShowsStore();
const userStore = useUserStore();
const notiStore = useNotificationStore();
const router = useRouter();
const dropHost = ref(false);


onMounted(async () => {
    await userStore.getUsers();
})

function pickCat(cat) {
    console.log(category.value === cat);
    category.value = cat;
}

async function play(epi, showId) {
    await showStore.getShow(Number(showId));
    showStore.currentEpisode = epi;

    router.push({
        name : 'show',
        params : {
            id : showId
        }
    });
    searchStore.openSearch = false;
}

function find() {
    msg.value = '';
    searchStore.episodes = [];
    if (query.value && category.value) {
        
        searchStore.searchQuery(query.value, category.value).then(res => {
            if (res.status === 200) {
                msg.value = res.data.msg;
                return res;
            }
        })
    } else {
        msg.value = 'Please fill query field and select filter type.'
        notiStore.showNotification(msg.value, 'error');
    }
}

function searchByHost(id) {
    dropHost.value = false;
    msg.value = "";
    searchStore.episodes = [];

    console.log('userid: ', id);
    searchStore.searchByHost(id).then(res => {
        if (res.status === 200) {
            msg.value = res.data.msg;
            return res;
        }
    })
}

</script>

<style>

</style>