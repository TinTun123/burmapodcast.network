<template>
    <div :class="[route.name === 'adminManageHosts' ? 'laptop:w-auto' : 'laptop:w-[50%]']" class="w-auto m-auto z-[9999]">
        <h1 class="modal-header mb-4 text-white/80 text-lg font-semibold text-center">Add new user</h1>
        <div class="flex flex-col justify-center gap-y-4 mb-4">

            <div  @click="openFile" 
                        class="
                        flex-none
                        rounded-[15px] 
                        cursor-pointer 
                        hover:bg-white/30 
                        transition aspect-square 
                        overflow-hidden 
                        group
                        w-[50%] 
                        laptop:w-[50%]
                        self-center
                        laptop:aspect-square"> 

                <div :style="{'background-image' : `URL(${coverImg})`}" class="aspect-square w-full img_block flex justify-center items-center">

                    <svg v-if="!coverImg"  class="w-16 h-16" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path class="fill-[#CCCCCC] group-hover:fill-[#CCCCCC]/80 group-active:fill-[#CCCCCC]" d="M21.6 0H2.4C1.0764 0 0 1.0764 0 2.4V16.8C0 18.1236 1.0764 19.2 2.4 19.2H21.6C22.9236 19.2 24 18.1236 24 16.8V2.4C24 1.0764 22.9236 0 21.6 0ZM5.4 3.6C5.87739 3.6 6.33523 3.78964 6.67279 4.12721C7.01036 4.46477 7.2 4.92261 7.2 5.4C7.2 5.87739 7.01036 6.33523 6.67279 6.67279C6.33523 7.01036 5.87739 7.2 5.4 7.2C4.92261 7.2 4.46477 7.01036 4.12721 6.67279C3.78964 6.33523 3.6 5.87739 3.6 5.4C3.6 4.92261 3.78964 4.46477 4.12721 4.12721C4.46477 3.78964 4.92261 3.6 5.4 3.6ZM12 15.6H3.6L8.4 9.6L10.2 12L13.8 7.2L20.4 15.6H12Z"/>
                    </svg>
                </div>

                <input hidden ref="imgInput" @change="onFileSelected" type="file" name="img" id="img">

            </div>
            
            <input type="text" id="name" name="name" v-model="name" 
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
                    placeholder="Username">
            <Transition>
                <input v-if="level === '3'" type="mail" id="email" name="email" v-model="email" 
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
                        placeholder="Email">
            </Transition>

  
            <Transition>
            
                <input v-if="level === '3'" type="password" id="password" name="password" v-model="password" 
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
                        placeholder="password">
            </Transition>


            <Transition>
                <input v-if="level === '3'" type="password" id="password_confirmation" name="password_confirmation" v-model="password_confirmation" 
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
                        placeholder="Confirm password">
            </Transition>
            

                <select
                class="rounded-full bg-[#2F2F2F] text-white text-sm px-2 py-1 font-semibold"
                name="level" id="level" v-model="level">
                    <option value="" disabled>user type</option>
                    <option value="1">CoHost</option>
                    <option value="2">Host</option>
                    <option value="3">Admin</option>
                </select>
        </div>

        <div class="flex gap-x-4 justify-end">
            <button
            v-if="route.name !== 'adminManageHosts'" 
        class="modal-footer 
              modal-default-button 
              text-black/80
              bg-white/80
              hover:bg-white/60
              active:bg-white/80
              rounded-full
              px-4  py-1
              float-right
              font-medium"
        @click="$emit('scrollToAddShow')">Back</button>
            <button 
            class="modal-footer 
                modal-default-button 
                text-black/80
                bg-white/80
                hover:bg-white/60
                active:bg-white/80
                rounded-full
                px-4  py-1
                float-right
                font-medium"
            @click="addUser">
                <div class="flex items-center justify-center gap-x-2">
                    <div v-if="isLoading">
                        <svg class="animate-spin" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="fill-[#202020]" d="M8 2.74178e-09C5.91079 -5.46575e-05 3.90445 0.817176 2.40987 2.27699C0.915303 3.7368 0.0510965 5.72337 0.002 7.812C0.094 4.033 2.968 1 6.5 1C10.09 1 13 4.134 13 8C13 8.39782 13.158 8.77936 13.4393 9.06066C13.7206 9.34196 14.1022 9.5 14.5 9.5C14.8978 9.5 15.2794 9.34196 15.5607 9.06066C15.842 8.77936 16 8.39782 16 8C16 5.87827 15.1571 3.84344 13.6569 2.34315C12.1566 0.842855 10.1217 2.74178e-09 8 2.74178e-09ZM8 16C10.0892 16.0001 12.0956 15.1828 13.5901 13.723C15.0847 12.2632 15.9489 10.2766 15.998 8.188C15.906 11.967 13.032 15 9.5 15C5.91 15 3 11.866 3 8C3 7.60218 2.84196 7.22064 2.56066 6.93934C2.27936 6.65804 1.89782 6.5 1.5 6.5C1.10218 6.5 0.720644 6.65804 0.43934 6.93934C0.158035 7.22064 0 7.60218 0 8C0 10.1217 0.842855 12.1566 2.34315 13.6569C3.84344 15.1571 5.87827 16 8 16Z"/>
                        </svg>
                    </div>
                    
                    <span>
                        Add
                    </span>
                </div>
            
            </button>
        </div>
        

    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useUserStore } from '../stores/userStore';
import { useNotificationStore } from '../stores/NotiStore';
import { useRoute } from 'vue-router';

const name = ref('');
const email = ref('');
const password = ref('');
const password_confirmation = ref('');
const level = ref('3');
const userStore = useUserStore();
const notiStore = useNotificationStore();
const route = useRoute();
const imgInput = ref(null);
const coverImg = ref('');
const img = ref();
const emit = defineEmits(['scrollToAddShow']);
const isLoading = ref(false);


function openFile() {
    imgInput.value.click();
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

function addUser() {
    isLoading.value = true;
    if (level.value === '3' && !name.value && !email.value && !password.value && !password_confirmation.value && !level.value) {
        notiStore.showNotification('Please fill all required fields!', 'error');
        isLoading.value = false;
        return;
    }

    if (name.value && level.value) {
        const formData = new FormData();

        formData.append('name', name.value);

        if (level.value === '3') {
            formData.append('email', email.value);
            formData.append('password', password.value);
            formData.append('password_confirmation', password_confirmation.value);
        }

        formData.append('level', level.value);
        if (img.value) {
            formData.append('profile_img', img.value);
        }

        
        userStore.register(formData).then(res => {
            isLoading.value = false;
            emit('scrollToAddShow');
           return res; 
        }).then(res => {
            console.log(res);
        })
    
    } else {
        isLoading.value = false;
        notiStore.showNotification('Please fill all required fields!', 'error');
    }
}

</script>

<style>

</style>