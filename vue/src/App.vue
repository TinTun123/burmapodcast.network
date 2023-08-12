
<template>
  <div class="laptop:bg-black/80 bg-gradient-to-t from-[#121212] to-[#292929] laptop:bg-none overflow-y-hidden laptop:h-[100vh] laptop:pt-4">
    <HeaderComponent v-if="route.name !== 'pwdreset' && route.name !== 'verify'"/>

    <div :class="[type === 'desktop' ? 'flex gap-x-6 justify-stretch overflow-y-hidden ' : '']" 
  class="relative">
    <div v-if="notiStore.hasMessage" :class="[notiStore.type === 'info' ? 'bg-[#2BFF00]/40' : 'bg-[#FF0F00]/40']" class="fixed bottom-8 left-8 p-2 z-[9999] rounded-[15px] transition-all">
      <h2 class="text-white">{{ notiStore.message }}</h2>
    </div>

    <SideBarComponent v-if="type === 'desktop' && route.name !== 'pwdreset' && route.name !== 'verify'"/>

    <div class="flex-1">

      <div 
      class="
      bg-gradient-to-t from-[#121212] to-[#292929] 
      laptop:mr-4
      laptop:mt-4 
      laptop:rounded-[10px]
      laptop:h-[80vh]
      overflow-y-scroll
      scroll-container
      laptop:relative"
      :class="[route.name === 'pwdreset' || route.name === 'verify' ? 'bg-none' : '']">
      <div class="min-h-[100vh]">
        <RouterView />
      </div>

        <FooterComponent v-if="route.name !== 'pwdreset' && route.name !== 'verify'" />
        <transition appear>
          <SongComponent v-if="showStore.currentEpisode.title"/>      
        </transition>
      </div>


      
    </div>
    </div>
  </div>

  <Teleport to="body">
        <transition name="modal">
        
            <div v-if="searchStore.openSearch" class="modal-mask">
                <div class="modal-container rounded-[15px] relative">
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

</script>



<style scoped>
</style>
