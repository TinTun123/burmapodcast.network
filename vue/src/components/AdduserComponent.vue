<template>
    <div :class="[route.name === 'adminManageHosts' ? 'laptop:w-auto' : 'laptop:w-[50%]']" class="w-auto m-auto z-[9999]">
        <h1 class="modal-header mb-4 text-white/80 text-lg font-semibold text-center">Add new user</h1>
        <div class="flex flex-col justify-center gap-y-4 mb-4">
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

            <input type="mail" id="email" name="email" v-model="email" 
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
  

            <input type="password" id="password" name="password" v-model="password" 
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


            <input type="password" id="password_confirmation" name="password_confirmation" v-model="password_confirmation" 
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

            <select
            class="rounded-full bg-[#2F2F2F] text-white text-sm px-2 py-1 font-semibold"
            name="level" id="level" v-model="level">
                <option value="" disabled>user type</option>
                <option value="1">Gust Host</option>
                <option value="2">Host</option>
            </select>
        </div>

        <div class="flex gap-x-4 justify-end">
            <button
            v-if="route.name !== 'adminDashboard'" 
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
        @click="addUser">Add</button>
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
const level = ref('');
const userStore = useUserStore();
const notiStore = useNotificationStore();
const route = useRoute();
const emit = defineEmits(['scrollToAddShow']);

function addUser() {
    if (name.value && email.value && password.value && password_confirmation.value && level.value) {
        const formData = new FormData();

        formData.append('name', name.value);
        formData.append('email', email.value);
        formData.append('password', password.value);
        formData.append('password_confirmation', password_confirmation.value);
        formData.append('level', level.value);

        userStore.register(formData).then(res => {
            emit('scrollToAddShow');
           return res; 
        });
    
    } else {
        notiStore.showNotification('Please fill all require fields!', 'error');
    }
}

</script>

<style>
</style>