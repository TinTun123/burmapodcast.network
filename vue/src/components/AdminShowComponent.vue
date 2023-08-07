<template>
  <transition name="fadecard">
    <div :key="showStore.currentShow.id" v-if="showStore.currentShow.id">
      <div class="bg-gradient-to-t from-[#262626]/0 to-[#666666] pt-8 px-4 tablet:px-8 relative">

        <div @click.stop="openEditShow = true" class="absolute top-4 right-4 group cursor-pointer">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path class="fill-[#CCCCCC]/80 group-hover:fill-[#CCCCCC]/60 group-active:fill-[#CCCCCC]/80" d="M15.74 3.59283C16.0867 3.24622 16.0867 2.66852 15.74 2.33968L13.6603 0.259964C13.3315 -0.0866546 12.7538 -0.0866546 12.4072 0.259964L10.7718 1.8864L14.1047 5.21928M0 12.6671V16H3.33287L13.1626 6.16137L9.82975 2.8285L0 12.6671Z" />
          </svg>
        </div>

            <div class="w-[152px] laptop:w-[288px] aspect-square laptop:float-left laptop:mr-4 overflow-hidden rounded-[10px] mx-auto shadow-img-shadow">
                <img class="w-full h-full" :src="showStore.currentShow.cover_img" alt="">
            </div>
            <h1 class="text-white text-lg mt-8 font-semibold">{{ showStore.currentShow.title }}</h1>

            <div class="flex justify-between mt-4">
                <div class="flex gap-x-1 items-center">
                    <div>
                        <svg width="8" height="8" viewBox="0 0 8 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="4" cy="4" r="4" fill="white" fill-opacity="0.4"/>
                        </svg>
                    </div>
                    <span class="text-white/80 text-sm font-medium">{{ showStore.seasonCount }} seasons</span>
                </div>

                <div>
                    <span class="text-white/80 text-sm font-medium">+342 likes</span>
                </div>
            </div>

            <p class="text-white/80 text-base leading-7 line-clamp-4 laptop:min-h-[200px]">{{ showStore.currentShow.description }}</p>
        </div>

        <div class="text-end mx-4 mt-4 tablet:mx-8">
          <button class="
                text-base 
                text-white 
                font-medium
                bg-[#D9D9D9]/10  
                rounded-[15px]
                px-3 py-1
                transition
                hover:bg-[#D9D9D9]/5
                active:bg-[#D9D9D9]/10" @click="opneAddEpisode = true">New episode</button>
        </div>

        
        <EpisodeListComponent @editEpisode="editEpisode"/>

      </div>
  </transition>



    <Teleport to="body">

        <transition name="modal">
        
            <div v-if="openEditShow" class="modal-mask">
                <div class="modal-container rounded-[10px] relative">
                    <button @click="openEditShow = false; editEpi = {}" class="absolute left-1 top-1 group" type="button">
                      <div class="w-8 h-8">
                        <svg class="w-full h-full" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6.2376 11.2624L8.5008 9ZM10.7632 6.7376L8.5008 9ZM8.5008 9L6.2376 6.7376ZM8.5008 9L10.7632 11.2624ZM8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="fill-white/80 group-hover:fill-white/40 group-active:fill-white/60"/>
                          <path d="M6.2376 11.2624L8.5008 9M8.5008 9L10.7632 6.7376M8.5008 9L6.2376 6.7376M8.5008 9L10.7632 11.2624M8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="stroke-black/40" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>
                    </button>

                    <div class="flex overflow-hidden">

                      <div class="w-full" ref="addShow">
                        <AddShowComponent @scrollToAddUser="scrollToAddUser" :currentShow="{...showStore.currentShow, 'isEdit' : true}" @close="close"/>
                      </div>

                      <!-- <div class="w-[240px] flex-none" ref="addUser"> -->
                        <!-- <AdduserCOmponent @scrollToAddShow="scrollToAddShow"/> -->
                      <!-- </div> -->

                    </div>


                </div>

            </div>                
        </transition>

    </Teleport>

    <Teleport to="body">
        <transition name="modal">
        
            <div v-if="opneAddEpisode" class="modal-mask">
                <div class="modal-container laptop:w-[50%] rounded-[10px] relative">
                    <button @click="opneAddEpisode = false; editEpi = {}; scrollToAddShow()" class="absolute left-1 top-1 group" type="button">
                      <div class="w-8 h-8">
                        <svg class="w-full h-full" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6.2376 11.2624L8.5008 9ZM10.7632 6.7376L8.5008 9ZM8.5008 9L6.2376 6.7376ZM8.5008 9L10.7632 11.2624ZM8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="fill-white/80 group-hover:fill-white/40 group-active:fill-white/60"/>
                          <path d="M6.2376 11.2624L8.5008 9M8.5008 9L10.7632 6.7376M8.5008 9L6.2376 6.7376M8.5008 9L10.7632 11.2624M8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="stroke-black/40" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>
                    </button>

                    <div class="flex overflow-x-hidden">

                      <div class="flex-none w-full laptop:w-auto" ref="addEpisode">
                        <AddEpisodeComponent :editEpi="editEpi" :seasons="showStore.currentShow.seasons" @close="opneAddEpisode = false" @scrollToAddUser="scrollToAddUser"/>
                      </div>

                      <div class="flex-none w-full flex items-center" ref="addUser">
                        <AddUserComponent @scrollToAddShow="scrollToAddShow"/>
                      </div>

                    </div>


                </div>

            </div>                
        </transition>

    </Teleport>
</template>

<script setup>
import { onBeforeMount, ref } from 'vue';
import { useShowsStore } from '../stores/ShowsStore';
import {useRoute} from 'vue-router';
import AddShowComponent from '../components/AddShowComponent.vue';
import EpisodeListComponent from './EpisodeListComponent.vue';
import AddEpisodeComponent from '../components/AddEpisodeComponent.vue';
import AddUserComponent from '../components/AdduserComponent.vue';
import { useUserStore } from '../stores/userStore';

const userStore = useUserStore();
const showStore = useShowsStore();
const route = useRoute();
const openEditShow = ref(false);
const opneAddEpisode = ref(false);
const addUser = ref(null);
const addEpisode = ref(null);

const editEpi = ref({});

onBeforeMount(async () => {
    if (!userStore.users.length) {
        userStore.getUsers();
    }
    await showStore.getShow(route.params.id);
})

function scrollToAddUser() {
  addUser.value.scrollIntoView({behavior : 'smooth', inline : 'end'});
}

function scrollToAddShow() {
  addEpisode.value.scrollIntoView({behavior : 'smooth', inline : 'start'});
}


function close() {
    openEditShow.value = false;
    editEpi.value = {};
}

function editEpisode(epi) {
  console.log(epi);
  opneAddEpisode.value = true;
  editEpi.value = epi;
}

</script>

<style>

.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  transition: opacity 0.3s ease;
}

.modal-container {
  margin: auto;
  padding: 20px 30px;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;

}

.modal-enter-from {
  opacity: 0;
}

.modal-leave-to {
  opacity: 0;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

.fadecard-enter-active,
.fadecard-leave-active {
  transition: opacity 0.3s ease;
}

.fadecard-enter-from,
.fadecard-leave-to {
  opacity: 0;
}

.fadecard-leave-active {
    position: absolute;
}

</style>