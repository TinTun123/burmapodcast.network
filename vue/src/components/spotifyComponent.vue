<template>
    <div class="relative">

        <div class="flex items items-center gap-x-2">

            <div @click="selectThumb" 
            class="
            rounded-[15px] 
            cursor-pointer 
            hover:bg-white/30 
            transition aspect-square 
            overflow-hidden 
            group
            w-[20%]
            mx-auto
            laptop:aspect-square
            flex-none">

                <div :style="{'background-image' : `URL(${buffer.showThumb})`}" class="aspect-square w-full img_block flex justify-center items-center">
                    <svg v-if="!buffer.showThumb"  class="w-16 h-16" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="fill-[#CCCCCC] group-hover:fill-[#CCCCCC]/80 group-active:fill-[#CCCCCC]" d="M21.6 0H2.4C1.0764 0 0 1.0764 0 2.4V16.8C0 18.1236 1.0764 19.2 2.4 19.2H21.6C22.9236 19.2 24 18.1236 24 16.8V2.4C24 1.0764 22.9236 0 21.6 0ZM5.4 3.6C5.87739 3.6 6.33523 3.78964 6.67279 4.12721C7.01036 4.46477 7.2 4.92261 7.2 5.4C7.2 5.87739 7.01036 6.33523 6.67279 6.67279C6.33523 7.01036 5.87739 7.2 5.4 7.2C4.92261 7.2 4.46477 7.01036 4.12721 6.67279C3.78964 6.33523 3.6 5.87739 3.6 5.4C3.6 4.92261 3.78964 4.46477 4.12721 4.12721C4.46477 3.78964 4.92261 3.6 5.4 3.6ZM12 15.6H3.6L8.4 9.6L10.2 12L13.8 7.2L20.4 15.6H12Z"/>
                    </svg>
                </div>

                <input hidden ref="imgInput" @change="onThumbSelected" type="file" name="img" id="spotifyThumbs">

            </div>

            <div class="space-y-2 relative pr-2">

                <div class="flex gap-x-2">
                    <div class="">
                        <input type="text" class="focus:outline-none
                        appearance-none 
                        border
                        top-[32px]
                        pl-2
                        border-white/40 
                        py-1
                        transition
                        rounded-[10px] 
                        text-base 
                        text-white/80 focus:border-white/80
                        bg-white/10
                        placeholder:text-white/40
                        w-full"
                        placeholder="Show Title"
                        v-model="buffer.showTitle">
                    </div>
                    
                    <div class="w-full">
                        <input type="text" class="focus:outline-none
                        appearance-none 
                        border
                        top-[32px]
                        pl-2
                        border-white/40 
                        py-1
                        transition
                        rounded-[10px] 
                        text-base 
                        text-white/80 focus:border-white/80
                        bg-white/10
                        placeholder:text-white/40
                        w-full"
                        placeholder="Enter url"
                        v-model="buffer.url">
                    </div>
                    
                </div>
                <div>
                
                    <div class="w-auto">
                        <button v-if="mode === 0" @click.stop="insert" class="block w-full rounded-[10px] border border-white/40 px-2 py-1 h-full font-medium
                        
                        text-white/80 focus:border-white/80
                        bg-white/10
                        hover:bg-white/20
                        text-base
                        transition">
                        Insert
                        </button>

                        <div v-else class="flex gap-x-4">
                            <button @click.stop="cancleEdit" class="block w-full rounded-[10px] border border-white/40 px-2 py-1 h-full font-medium
                        
                            text-white/80 focus:border-white/80
                            bg-white/10
                            hover:bg-white/20
                            text-base
                            transition">
                            Cancel
                            </button>

                            <button @click.stop="insert" class="block w-full rounded-[10px] border border-white/40 px-2 py-1 h-full font-medium
                        
                            text-white/80 focus:border-white/80
                            bg-white/10
                            hover:bg-white/20
                            text-base
                            transition">
                                Save
                            </button>

                            <button @click.stop="deleteSpotify(buffer.id)" class="block w-full rounded-[10px] border border-[#E84344]/80 px-2 py-1 h-full font-medium
                            text-white
                            bg-[#E84344]/80 
                            hover:bg-[#E84344]/60
                            text-base
                            transition">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <div class="flex flex-nowrap gap-x-4 my-4 overflow-x-scroll scroll-container">
            
            <div class="
            flex-none 
            relative 
            flex
            items-center 
            rounded-[4px] 
            overflow-hidden 
            gap-x-2 
            pr-2 
            bg-gradient-to-t 
            from-[#292929] 
            to-[#121212]
            transition
            hover:scale-105
            hover:bg-[#D9D9D9]/5
            active:bg-[#D9D9D9]/10
            laptop:cursor-pointer"
            v-for="(spo, i) in spotiUrls" :key="i">
                <div class="aspect-square">

                    <div class="w-[64px] aspect-square">
                        <img :src="spo.showThumb" class="w-full h-full max-h-[67.5px]" alt="">
                    </div>

                </div>

                <div class="max-w-[150px] py-1">

                    <h3 class="text-sm line-clamp-2 text-white/80 font-medium">
                        {{spo.showTitle}}
                    </h3>

                </div>

                <div @click.stop="editPopulate(spo.id)" class="absolute top-1 right-1 w-3 h-3 laptop:cursor-pointer group">
                    <svg class="w-full h-full" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="fill-[#D9D9D9] hover:fill-[#D9D9D9]/60 transition active:fill-[#D9D9D9]" d="M10.8827 1.84719C11.1608 1.5691 11.491 1.3485 11.8543 1.198C12.2176 1.0475 12.6071 0.970039 13.0003 0.970039C13.3936 0.970039 13.7831 1.0475 14.1464 1.198C14.5097 1.3485 14.8399 1.5691 15.118 1.84719C15.3961 2.12528 15.6167 2.45542 15.7672 2.81876C15.9177 3.1821 15.9951 3.57153 15.9951 3.96481C15.9951 4.35809 15.9177 4.74752 15.7672 5.11086C15.6167 5.4742 15.3961 5.80435 15.118 6.08244L14.228 6.97244L9.99271 2.7372L10.8827 1.84719ZM9.18497 3.54494L1.88896 10.8409C1.46181 11.2684 1.15721 11.8026 1.00695 12.3879L0.0129748 16.2564C-0.0116743 16.3527 -0.0107918 16.4537 0.0155353 16.5495C0.0418623 16.6453 0.0927234 16.7326 0.163096 16.8027C0.233469 16.8729 0.32092 16.9234 0.416814 16.9494C0.512708 16.9755 0.613728 16.976 0.7099 16.951L4.57726 15.9582C5.16266 15.8082 5.69696 15.5036 6.12421 15.0762L13.4202 7.78019L9.18497 3.54494Z"/>
                    </svg>
                </div>
                
            </div>
        </div>

        
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useShowsStore } from '../stores/ShowsStore.js';

const buffer = ref({
    showThumb : '',
    showTitle : '',
    url : '',
    imgFile : ''
})

const imgInput = ref(null);
const mode = ref(0);
const showStore = useShowsStore();
const spotiUrls = ref([]);



onMounted(async () => {

    spotiUrls.value = showStore.spotiUrls;
})

function selectThumb() {
   
    imgInput.value.click();
}

function onThumbSelected(e) {
    
    const files = e.target.files;
    if (files.length) {
        const reader = new FileReader();

        reader.onload = (e) => {
            
            buffer.value.showThumb = e.target.result;
        
        }
        reader.readAsDataURL(files[0]);
        buffer.value.imgFile = files[0];
        console.log(buffer.value.imgFile);
    }
}

function cancleEdit() {

    buffer.value = {
        thumb : '',
        title : '',
        url : '',
        imgFile : '',
        id : ''
    }

    mode.value = 0;
}

function saveEdit() {

    // sent edit request

    // adjust local array
    spotiUrls.value.forEach(spot => {
        if (spot.id === buffer.value.id) {
            spot.title = buffer.value.title;
            spot.url = buffer.value.url;
            spot.thumb = buffer.value.thumb;
            return;
        }
    })

    buffer.value = {
        thumb : '',
        title : '',
        url : '',
        imgFile : '',
        id : ''
    }

    mode.value = 0;
}

function insert() {

    if (buffer.value.showThumb && buffer.value.showTitle && buffer.value.url) {


        const formData = new FormData();
        formData.append('showTitle', buffer.value.showTitle);
        formData.append('showUrl', buffer.value.url);
        if (buffer.value.imgFile) {
            formData.append('showThumb', buffer.value.imgFile);
        }


        if (mode.value === 0) {

            showStore.saveSpotifyUrl(formData).then(res => {

                if (res.status === 200) {
                        buffer.value = {
                        thumb : '',
                        title : '',
                        url : '',
                        imgFile : '',
                        id : ''
                    }

                let temp = {
                    'id' : res.data.spotifyShow.id,
                    'showThumb' : res.data.spotifyShow.showThumb,
                    'showTitle' : res.data.spotifyShow.showTitle,
                    'url' : res.data.spotifyShow.url
                }
                    spotiUrls.value.unshift(temp);

                    mode.value = 0;

                }

            }).catch(e => {
                console.log(e.response.data.error);
            })
        } else {

            showStore.editSpotify(formData, buffer.value.id).then(res => {
                if (res.status === 200) {

                    spotiUrls.value.forEach(spot => {
                        if (spot.id === buffer.value.id) {
                            spot.showTitle = buffer.value.showTitle;
                            spot.url = buffer.value.url;
                            spot.showThumb = buffer.value.showThumb;
                        }
                    })

                    buffer.value = {
                        showThumb : '',
                        showTitle : '',
                        url : '',
                        imgFile : '',
                        id : ''
                    }

                    let index = spotiUrls.value.findIndex(spot => spot.id === res.data.spotifyShow.id);

                    let temp = {
                        'id' : res.data.spotifyShow.id,
                        'showThumb' : res.data.spotifyShow.showThumb,
                        'showTitle' : res.data.spotifyShow.showTitle,
                        'url' : res.data.spotifyShow.url
                    }

                    spotiUrls.value.splice(index, 1, temp);
                  
                    mode.value = 0;
                    return;
                }
            })

        }
    }


}

function deleteSpotify(id) {
    showStore.deleteSpotify(id).then(res => {
        if (res.status === 200) {
            let index = spotiUrls.value.findIndex(spot => spot.id === res.data.id);

            spotiUrls.value.splice(index, 1);
            console.log(index);
            mode.value = 0;
            buffer.value = {
                showThumb : '',
                showTitle : '',
                url : '',
                imgFile : '',
                id : ''
            }
            return;
        }
    }).catch(e => {
        console.log(e);
    })
}

function editPopulate(id) {
    mode.value = 1;
    spotiUrls.value.forEach(spot => {
        if (spot.id === id) {
            buffer.value = JSON.parse(JSON.stringify(spot));
            buffer.value.imgFile = '';
        }
    })
}

</script>

<style scoped>
</style>