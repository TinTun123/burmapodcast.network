<template>
    <div class="flex justify-center items-center h-[100vh]">
        <div class="bg-[#1D1D1D] p-8 rounded-[10px]">
            <h1 class="text-white/80 font-semibold text-center mb-4">Reset password</h1>

            <div class="flex flex-col gap-y-4">
                <input 
                    type="password" 
                    id="pwd" 
                    name="password" 
                    v-model="password" 
                    class="focus:outline-none
                    appearance-none 
                    border
                    border-white/40 
                    pl-2 py-1 
                    rounded-[10px] 
                    text-base 
                    text-white/80 focus:border-white/80
                    bg-transparent">

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
            </div>

            <span v-if="error" class="text-sm text-red-300">
                {{ error }}
            </span>

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
                font-medium
                mt-4"
            @click="change">change</button>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useUserStore } from '../stores/userStore';
import { useRoute, useRouter } from 'vue-router';


const password_confirmation = ref('');
const password = ref('');
const userStore = useUserStore();
const route = useRoute();
const router = useRouter();
const error = ref('');

function change() {
    error.value = '';
    if (password.value && password_confirmation.value) {


        if (password.value === password_confirmation.value) {
            const formdata = new FormData();

            formdata.append('password', password.value);
            formdata.append('password_confirmation', password_confirmation.value);

            formdata.append('token', route.query.token);
            formdata.append('email', route.query.email);
            userStore.resetPwd(formdata).then(res => {
                if (res.status === 200) {

                    router.push({
                        name : 'home'
                    });

                }
            })
        } else {
            error.value = 'Password not match.'
        }
    }
}
</script>

<style>

</style>