
<template>
  <div class="laptop:bg-black/90 bg-gradient-to-t from-[#121212] to-[#292929] laptop:bg-none overflow-y-hidden laptop:h-[100vh] laptop:pt-4 relative" :class="[route.name === 'fanlinks' ? 'bg-white' : '']">
    
    <div class="absolute left-[-100px] bottom-[-250px]">
      <svg width="445" height="672" viewBox="0 0 445 672" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M208.26 173.558L208.26 173.56C207.467 189.308 204.024 204.472 198.287 218.725L197.009 221.901L200.422 222.152C212.083 223.011 223.524 224.512 234.714 226.646L234.721 226.648C354.294 249.103 443.047 339.245 442.497 446.325C441.879 569.863 320.134 669.5 172.565 669.5H-183.801C-227.132 669.5 -261.5 639.921 -261.5 604.31V75.4673C-261.5 35.551 -223.018 2.5 -174.607 2.5H10.5441C122.836 2.5 213.054 79.9578 208.26 173.558Z" class="stroke-[#E84344]/40" stroke-width="5"/>
      </svg>
    </div>
    <div :class="[type === 'desktop' ? 'flex gap-x-6 justify-stretch overflow-y-hidden ' : '']" class="relative">

      <div v-if="notiStore.hasMessage" :class="[(notiStore.type === 'info' || notiStore.type === 'complete' || notiStore.type === 'progress') ? 'bg-white' : 'bg-[#FF0F00]/40']" class="fixed bottom-8 left-8 p-2 z-[9999] rounded-[15px] transition-all">
        <h2 :class="notiStore.type === 'error' ? 'text-white' : 'text-[#35A519]'" class="font-medium text-sm">{{ notiStore.message }}</h2>
      </div>

    <SideBarComponent v-if="type === 'desktop' && route.name !== 'pwdreset' && route.name !== 'verify' && route.name !== 'fanlinks'"/>

    <div class="flex-1">

      <HeaderComponent v-if="route.name !== 'pwdreset' && route.name !== 'verify' && route.name !== 'fanlinks'" />

      <div 
      class="
      bg-gradient-to-t from-[#121212] to-[#292929] 
      laptop:mr-4
      laptop:mt-4 
      laptop:rounded-[10px]
      laptop:h-[80vh]
      scroll-container
      laptop:relative
      overflow-y-scroll"

      :class="[route.name === 'pwdreset' || route.name === 'verify' || route.name == 'fanlinks' ? 'bg-none' : '']">

      <div class="min-h-[100vh]">
        <RouterView />
      </div>

        <FooterComponent v-if="route.name !== 'pwdreset' && route.name !== 'verify' && route.name !== 'fanlinks'" />
        <transition appear>
          <SongComponent v-show="showStore.currentEpisode.title"/>      
        </transition>
      </div>


      
    </div>
    </div>
  </div>

  <Teleport to="body">
        <transition name="modal">
        
            <div v-if="searchStore.openSearch" class="modal-mask">
                <div class="modal-container-search rounded-[15px] relative">
                    <button @click="searchStore.openSearch = false; searchStore.episodes = []" class="absolute left-2 top-2 group" type="button">
                      <div class="w-8 h-8">
                        <svg class="w-full h-full" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6.2376 11.2624L8.5008 9ZM10.7632 6.7376L8.5008 9ZM8.5008 9L6.2376 6.7376ZM8.5008 9L10.7632 11.2624ZM8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="fill-white/10 group-hover:fill-white/20 group-active:fill-white/10"/>
                          <path d="M6.2376 11.2624L8.5008 9M8.5008 9L10.7632 6.7376M8.5008 9L6.2376 6.7376M8.5008 9L10.7632 11.2624M8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="stroke-white/60" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>
                    </button>
                    <h1 class="modal-header mb-4 text-white/80 text-lg font-semibold text-center">search</h1>
                      <div class="">
                        <SearchComponent />
                      </div>


                </div>

            </div>                
        </transition>

    </Teleport>



</template>

<script setup>

import HeaderComponent from './components/HeaderComponent.vue';
import FooterComponent from './components/FooterComponent.vue';
import SongComponent from './components/SongComponent.vue';
import { useBreakPoints } from './router/composible/useBreakPoint';
import {useSearchStore} from './stores/searchStore';
import SideBarComponent from './components/SideBarComponent.vue';
import SearchComponent from './components/SearchComponent.vue';
import { useNotificationStore } from './stores/NotiStore';
import { useShowsStore } from './stores/ShowsStore';
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';

const searchStore = useSearchStore();
const showStore = useShowsStore();
const route = useRoute();
const notiStore = useNotificationStore();
const {type} = useBreakPoints();

const height = ref();

onMounted(() => {
  height.value = window.clientHeight - 120;
})

navigator.serviceWorker.addEventListener('message', (event) => {
  const { type, progress } = event.data;

  if (type === 'progress') {
    notiStore.showNotification(`Saving ${progress}%`, type);
  } else if (type === 'complete') {
    notiStore.showNotification('Saved to playList, Listen offline now', type);
  }

  
})

</script>



<style scoped>
</style>
