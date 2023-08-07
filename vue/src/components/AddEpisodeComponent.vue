<template>
    <div class="w-full laptop:px-2 z-[9999]">

        <h3 class="modal-header mb-4 text-white/80 text-lg font-semibold text-center">New Episode</h3>

        <div class="flex flex-col gap-y-4">

                <input 
                class="focus:outline-none
                        appearance-none 
                        border
                        border-white/40 
                        pl-2 py-1 
                        rounded-[10px] 
                        text-base 
                        text-white/80 focus:border-white/80
                        bg-transparent
                        placeholder:text-white/40"
                        placeholder="Episode title"
                v-model="title" type="text" name="title" id="title" >
          

            <div class="flex flex-col gap-y-4 laptop:gap-y-0 laptop:flex-row gap-x-2 justify-between">


                <!-- image input -->
                
                <div  @click="openFile" 
                class="
                rounded-[15px] 
                cursor-pointer 
                hover:bg-white/30 
                transition aspect-square 
                overflow-hidden 
                group
                w-[50%]
                laptop:w-[30%]">

                    <div :style="{'background-image' : `URL(${coverImg})`}" class="aspect-square w-full img_block flex justify-center items-center">

                        <svg v-if="!coverImg"  class="w-16 h-16" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-[#CCCCCC] group-hover:fill-[#CCCCCC]/80 group-active:fill-[#CCCCCC]" d="M21.6 0H2.4C1.0764 0 0 1.0764 0 2.4V16.8C0 18.1236 1.0764 19.2 2.4 19.2H21.6C22.9236 19.2 24 18.1236 24 16.8V2.4C24 1.0764 22.9236 0 21.6 0ZM5.4 3.6C5.87739 3.6 6.33523 3.78964 6.67279 4.12721C7.01036 4.46477 7.2 4.92261 7.2 5.4C7.2 5.87739 7.01036 6.33523 6.67279 6.67279C6.33523 7.01036 5.87739 7.2 5.4 7.2C4.92261 7.2 4.46477 7.01036 4.12721 6.67279C3.78964 6.33523 3.6 5.87739 3.6 5.4C3.6 4.92261 3.78964 4.46477 4.12721 4.12721C4.46477 3.78964 4.92261 3.6 5.4 3.6ZM12 15.6H3.6L8.4 9.6L10.2 12L13.8 7.2L20.4 15.6H12Z"/>
                        </svg>
                    </div>

                </div>

                <input hidden ref="imgInput" @change="onFileSelected" type="file" name="img" id="img">


                <!-- image input end -->

                <!-- data input  -->
                <div class="flex flex-col flex-1 gap-y-2">

                    <div class="flex gap-x-2">

                        <select 
                        class="rounded-full bg-[#2F2F2F] text-white text-sm px-2 py-1 font-semibold" name="season" id="season" v-bind:disabled="isDisabled" v-model="seasonId">
                            <option value="" disabled>Select season</option>
                            <option v-for="(season, i) in seasons" :key="i" :value="season.id">season {{ season.season_number }}</option>
                            <option value="">New season</option>
                        </select>

                        <input 
                        class="focus:outline-none
                                appearance-none 
                                border
                                border-white/40 
                                pl-2 py-1 
                                rounded-[10px] 
                                text-base 
                                text-white/80 focus:border-white/80
                                bg-transparent
                                placeholder:text-white/40"
                        v-model="date" type="date" name="date" id="date">
                    </div>

                    <!-- date input end -->

                    <!-- desc  -->
                    <div class="flex flex-col">
                        <textarea v-model="desc"
                        placeholder="description"
                        class="bg-transparent h-[20vh] appearance-none focus:outline-none text-white w-full p-2 rounded-[15px] border border-[#D6D6D6]/60 focus:border-[#D6D6D6] placeholder:text-white/40"  
                        name="desc" id="desc" rows="5"></textarea>
                    </div>
                    

                    <div class="flex gap-2 flex-wrap mt-4">
                        <div v-for="(user, i) in userStore.users" :key="i" :class="[host.indexOf(user.id) !== -1 ? 'bg-white/30' : 'bg-[#2F2F2F]/60']" class="active:bg-white/30 cursor-pointer px-2 flex items-center rounded-full" @click="pickHost(user.id)">
                            <!-- <label :for="user.id">{{ user.name }}</label>
                            <input class="bg-[#2F2F2F]" type="checkbox" :id="user.id" :value="user.id" :name="user.id" v-model="host"> -->
                            <span class="text-white/80 text-sm font-semibold">{{ user.name }}</span>
                        </div>
                        <button class="text-white/80 text-sm font-semibold px-2 bg-white/20 hover:bg-white/10 rounded-full" @click="$emit('scrollToAddUser')">Add new</button>
                    </div>
                </div>
            </div>

        </div>

        <div @click="selectAudio" class="inline-block bg-[#2F2F2F] hover:bg-[#2F2F2F]/60 mt-4 transition rounded-[10px] cursor-pointer">
            <div class="flex items-center gap-x-2 px-2 py-1">
                
                <div>
                    <svg width="20" height="24" viewBox="0 0 20 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="group-hover:fill-[#CCCCCC]/40 fill-[#CCCCCC]" d="M17.75 24H2.75C1.505 24 0.5 22.995 0.5 21.75V2.25C0.5 1.005 1.505 0 2.75 0H13.385C13.985 0 14.555 0.24 14.975 0.66L19.34 5.025C19.76 5.445 20 6.015 20 6.615V21.75C20 22.995 18.995 24 17.75 24ZM2.75 1.5C2.33 1.5 2 1.83 2 2.25V21.75C2 22.17 2.33 22.5 2.75 22.5H17.75C18.17 22.5 18.5 22.17 18.5 21.75V6.615C18.5012 6.51664 18.4818 6.41911 18.443 6.32869C18.4043 6.23828 18.3471 6.15697 18.275 6.09L13.91 1.725C13.7706 1.58503 13.5825 1.50441 13.385 1.5H2.75Z"/>
                        <path class="group-hover:fill-[#CCCCCC]/40 fill-[#CCCCCC]" d="M19.07 7.50018H14.705C13.49 7.50018 12.5 6.51018 12.5 5.29518V0.930176C12.5 0.510176 12.83 0.180176 13.25 0.180176C13.67 0.180176 14 0.510176 14 0.930176V5.29518C14 5.68518 14.315 6.00018 14.705 6.00018H19.07C19.49 6.00018 19.82 6.33018 19.82 6.75018C19.82 7.17018 19.49 7.50018 19.07 7.50018ZM6.5 9.00018H14V12.0002H6.5V9.00018Z" />
                        <path class="group-hover:fill-[#CCCCCC]/40 fill-[#CCCCCC]" d="M13.25 16.5C12.83 16.5 12.5 16.17 12.5 15.75V11.25C12.5 10.83 12.83 10.5 13.25 10.5C13.67 10.5 14 10.83 14 11.25V15.75C14 16.17 13.67 16.5 13.25 16.5ZM7.25 18C6.83 18 6.5 17.67 6.5 17.25V11.25C6.5 10.83 6.83 10.5 7.25 10.5C7.67 10.5 8 10.83 8 11.25V17.25C8 17.67 7.67 18 7.25 18Z" />
                        <path class="group-hover:fill-[#CCCCCC]/40 fill-[#CCCCCC]" d="M11 15H14V16.5C14 17.325 13.325 18 12.5 18H11C10.175 18 9.5 17.325 9.5 16.5C9.5 15.675 10.175 15 11 15ZM5 16.5H8V18C8 18.825 7.325 19.5 6.5 19.5H5C4.175 19.5 3.5 18.825 3.5 18C3.5 17.175 4.175 16.5 5 16.5Z" />
                    </svg>
                </div>

                <span class="text-white font-medium">
                    {{ audioFilename ? audioFilename : 'select audio file' }}
                </span>

                <span v-if="size"  class="text-white font-medium">
                    {{ size  + ' MB' }}
                </span>
            </div>
        </div>

        <input hidden @change="onAudioSelected" ref="audioInput" type="file" name="audio" id="audio">
        
        <div class="flex justify-end gap-x-4 mt-4">

            <button 
            v-if="Object.keys(props.editEpi).length"
            class=" 
              text-black/80
              bg-[#FF0F00]/60
              hover:bg-[#FF0F00]/40
              active:bg-[#FF0F00]/60
              rounded-full
              px-4  py-1
              font-medium"  @click="deleteEpisode(editEpi.id, route.params.id)">delete</button>

            <button class=" 
              text-black/80
              bg-white/80
              hover:bg-white/60
              active:bg-white/80
              rounded-full
              px-4  py-1
              font-medium"  @click="addEpisode">{{ progressStore.progress ? progressStore.progress + ' uploading' : 'Add episode' }}</button>
        </div>
        

    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useUserStore } from '../stores/userStore';
import { useShowsStore } from '../stores/ShowsStore';
import { useRoute } from 'vue-router';
import { useProgressStore } from '../stores/progressStore';
import { useNotificationStore } from '../stores/NotiStore';

const route = useRoute();

const userStore = useUserStore();
const showStore = useShowsStore();
const progressStore = useProgressStore();
const notiStore = useNotificationStore();

const title = ref('');
const date = ref('');
const img = ref();
const audio = ref();
const desc = ref('');
const host = ref([]);
const seasonId = ref('');
const isDisabled = ref(false);
const coverImg = ref('');
const imgInput = ref(null);
const audioInput = ref(null);
const audioFilename = ref('');
const size = ref();
const props = defineProps(['seasons', 'editEpi']);
const emit = defineEmits(['close', 'scrollToAddUser']);


function addEpisode () {

    if (title.value && img.value && desc.value && host.value && audio.value) {

        console.log('addEpisode');

        if (props.editEpi) {
            console.log('edit');
        } else {
            console.log('create');
        }

        const formData = new FormData();

        formData.append('title', title.value);
        formData.append('desc', desc.value);
        formData.append('img', img.value);
        formData.append('audio', audio.value);
        
        for (let i = 0; i < host.value.length; i++) {
            formData.append('host[]', Number(host.value[i]));
        }

        if (date.value) {
            formData.append('date', date.value);
        }

        if (seasonId.value) {
            formData.append('seasonId', seasonId.value);
        }

        if (!Object.keys(props.editEpi).length) {
            showStore.createEpisode(formData, route.params.id).then(res => {
                if (res.status === 200) {
                    img.value = '';
                    audio.value = '';
                    title.value = '';
                    date.value = '';
                    desc.value = '';
                    host.value = [];
                    seasonId.value = '';
                    emit('close');
                }
                return res;
            })
        } else {
            console.log(formData);
            formData.append('_method', 'PUT');
            showStore.editEpisode(formData, Number(route.params.id), props.editEpi.id).then(res => {
                if (res.status === 200) {
                    img.value = '';
                    audio.value = '';
                    title.value = '';
                    date.value = '';
                    desc.value = '';
                    host.value = [];
                    seasonId.value = '';
                    emit('close');
                }
            })
        } 
    } else {
            notiStore.showNotification('Please fill all required fields', 'error');
        }
}

function deleteEpisode(epId, showId) {

    showStore.deleteEpisode(epId, showId).then(res => {
        if (res.status === 200) {
            img.value = '';
            audio.value = '';
            title.value = '';
            date.value = '';
            date.value = '';
            desc.value = '';
            host.value = [];
            seasonId.value = '';
            emit('close');
        }
        return res;
    });
}

function pickHost(userId) {
    const index = host.value.indexOf(userId);
    console.log(index);
    if (index !== -1) {
        console.log('already selected!, remove');
        host.value.splice(index, 1);
    } else {
        console.log('not selected yet! adding');
        host.value.push(userId);
    }
}

function openFile() {
    imgInput.value.click();
}

function selectAudio() {
    audioInput.value.click();
}

function onFileSelected(e) {
    const files = e.target.files;
    if (files.length) {
        const reader = new FileReader();

        reader.onload = (e) => {
            
            coverImg.value = e.target.result;
            
        }
        reader.readAsDataURL(files[0]);
        img.value = files[0];
    }
}

function onAudioSelected(e) {
    const files = e.target.files;

    if (files.length) {
        audio.value = files[0];
        audioFilename.value = files[0].name;
        size.value = (files[0].size / (1024 * 1024)).toFixed(2);
    }
}

onMounted(() => {

    if (Object.keys(props.editEpi).length) {

        host.value = JSON.parse(JSON.stringify(props.editEpi.users)).map(user => user.id);
        const datefrom = new Date(props.editEpi.created_at);
        
        date.value = datefrom.toISOString().split('T')[0];
        title.value = props.editEpi.title;
        desc.value = props.editEpi.description;
        seasonId.value = props.editEpi.season_id;
        isDisabled.value = true;
    }

})
</script>
<style>

.img_block {
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    -webkit-background-size: cover;
    -moz-background-size: cover;
    -o-background-size: cover;

}
</style>