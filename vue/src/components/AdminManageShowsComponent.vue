<template>
    <div class="mx-4 mt-8 tablet:mx-8">
        <!-- <div class="relative mb-8">

            <hr class="w-[80%] ml-auto h-px bg-white/30 rounded-full">
            <span class="absolute text-white/80 font-semibold text-lg top-[50%] -translate-y-[50%]">Shows</span>

            </div> -->

            <div>
            <transition-group 
            class="grid 
            grid-cols-2 
            gap-4 
            tablet:grid-cols-4 
            lg-table:grid-cols-5 
            laptop:grid-cols-4
            mb-8
            laptop:justify-center"
            name="showList" tag="div">
                <div @click="routeTo(shows.id)" v-for="(shows, index) in showStore.shows" :key="index" class="col-span-1 cursor-pointer group">
                    <div class="inline-block laptop:h-full laptop:shadow-card-shadow">
                        <div class="flex 
                        flex-col 
                        gap-y-2
                        laptop:items-center
                        laptop:bg-gradient-to-t from-[#292929] to-[#121212]
                        group-hover:to-60%
                        transition
                        duration-500
                        laptop:rounded-[10px]
                        laptop:p-4
                        laptop:h-full">
                            <div 
                            class="w-[152px] laptop:w-[174px] 
                            aspect-square 
                            overflow-hidden 
                            rounded-[10px]
                            shadow-card-shadow">
                                <img class="w-full h-full" :src="shows.cover_img" alt="">
                            </div>

                            <div class="flex flex-col ">
                                <div class="flex items-center gap-x-1">
                                    <span class="text-x-sm text-white/60 font-semibold">{{ shows.totalEpisodes }} Episodes</span>
                                    <div>
                                        <svg width="5" height="4" viewBox="0 0 5 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="2.04778" cy="2" r="2" fill="#E84344"/>
                                        </svg>
                                    </div>
                                    <span class="text-x-sm text-white/60 font-semibold">{{ shows.listener_count }} listen</span>
                                </div>

                                <span  class="text-white text-base font-medium laptop:w-[174px]">
                                    {{ shows.title }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>
                <div :key="100" @click="open = true" 
                class="col-span-1 
                laptop:w-[50%] laptop:aspect-square 
                m-auto 
                rounded-[10px] 
                hover:to-60% 
                laptop:bg-gradient-to-t from-[#292929] to-[#121212] 
                shadow-card-shadow 
                w-full
                h-full
                laptop:h-auto
                cursor-pointer flex justify-center items-center">
                <span  class="text-white text-base font-medium laptop:w-auto">
                    New
                </span>
                </div>     
            </transition-group>

        </div> 
    </div>

    <Teleport to="body">
        <transition name="modal">
        
            <div v-if="open" class="modal-mask">
                <div class="modal-container rounded-[10px] relative">
                    <button @click="open = false" class="absolute left-1 top-1 group" type="button">
                      <div class="w-8 h-8">
                        <svg class="w-full h-full" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6.2376 11.2624L8.5008 9ZM10.7632 6.7376L8.5008 9ZM8.5008 9L6.2376 6.7376ZM8.5008 9L10.7632 11.2624ZM8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="fill-white/80 group-hover:fill-white/40 group-active:fill-white/60"/>
                          <path d="M6.2376 11.2624L8.5008 9M8.5008 9L10.7632 6.7376M8.5008 9L6.2376 6.7376M8.5008 9L10.7632 11.2624M8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="stroke-black/40" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>
                    </button>

                    <div class="flex overflow-hidden">

                      <div class="w-full" ref="addShow">
                        <AddShowComponent @close="close" :currentShow="{'isEdit' : false}"/>
                      </div>
                    </div>


                </div>

            </div>                
        </transition>

    </Teleport>
</template>


<script setup>
import { onMounted, ref } from 'vue';
import { useShowsStore } from '../stores/ShowsStore';
import AddShowComponent from './AddShowComponent.vue';
import { useRouter } from 'vue-router';
import { useForumStore } from '../stores/forumStore';

const router = useRouter();
const open = ref(false);
const showStore = useShowsStore();
const forumStore = useForumStore();

onMounted(async () => {

if (!showStore.shows.length) {

    showStore.fetchShows();

}

if (!forumStore.forums.length)
{
    await forumStore.getForums();
}
})

function routeTo(showId) {
    router.push({
      name : 'adminShow',
      params : {
        'id' : showId
      }
    })
}

function close() {
  open.value = false;
}
</script>

<style>
</style>