
<template>
  <div class="bg-black/90 overflow-y-hidden laptop:h-[100vh] laptop:pt-4">
    <HeaderComponent />

    <div :class="[type === 'desktop' ? 'flex gap-x-6 justify-stretch overflow-y-hidden ' : '']" 
  class="relative">
    <div v-if="notiStore.hasMessage" :class="[notiStore.type === 'info' ? 'bg-[#2BFF00]/40' : 'bg-[#FF0F00]/40']" class="fixed bottom-8 left-8 p-2 z-[9999] rounded-[15px] transition-all">
      <h2 class="text-white">{{ notiStore.message }}</h2>
    </div>

    <SideBarComponent v-if="type === 'desktop'"/>

    <div class="flex-1">

      <div 
      class="
      bg-gradient-to-t from-[#121212] to-[#292929] 
      laptop:mr-4
      laptop:mt-4 
      laptop:rounded-[10px]
      laptop:h-[85vh]
      overflow-y-scroll
      scroll-container
      laptop:relative">
      <div class="min-h-[100vh]">
        <RouterView />
      </div>

        <FooterComponent />
        <transition appear>
          <SongComponent v-if="showStore.currentEpisode.title"/>      
        </transition>
      </div>


      
    </div>
    </div>
  </div>



</template>

<script setup>
import HeaderComponent from './components/HeaderComponent.vue';
import FooterComponent from './components/FooterComponent.vue';
import SongComponent from './components/SongComponent.vue';
import { useBreakPoints } from './router/composible/useBreakPoint';
import SideBarComponent from './components/SideBarComponent.vue';

import { useNotificationStore } from './stores/NotiStore';
import { useShowsStore } from './stores/ShowsStore';
import { onMounted, ref } from 'vue';

const showStore = useShowsStore();
const notiStore = useNotificationStore();
const {type} = useBreakPoints();

const height = ref();

onMounted(() => {
  height.value = window.clientHeight - 120;
})

</script>



<style scoped>
</style>
