<template>
    <div class="sticky
        top-0
        z-[999]">

        <div class="flex w-full laptop:w-auto">
            <div v-if="type === 'desktop'" class="laptop:bg-[#282828] px-4 flex-none ml-4 rounded-[10px] w-[20%]">
                <div class="h-full flex justify-center items-center">
                    <span class="text-white font-bold">Burma podcast Network</span>
                </div>
            </div>

            <div 
            class="bg-black
            laptop:bg-transparent
            z-[999]
            laptop:mx-4 
            laptop:rounded-[10px] 
            flex 
            justify-between 
            laptop:justify-end 
            gap-x-1
            laptop:flex-1 
            items-center 
            px-4
            laptop:px-0
            w-full
            laptop:w-auto">
                <div @click.stop="routeToHome" class="laptop:hidden">

                    <svg width="81" height="36" viewBox="0 0 81 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.74609 26.0785C4.74609 27.1154 3.90625 27.9535 2.87109 27.9535C1.83984 27.9535 1 27.1154 1 26.0785C1 25.0416 1.83984 24.2035 2.87109 24.2035C3.90625 24.2035 4.74609 25.0416 4.74609 26.0785Z" fill="#ED4343"/>
                        <path d="M2.87109 21.3268V14.2073" stroke="white" stroke-width="3.75029" stroke-miterlimit="10" stroke-linecap="round"/>
                        <path d="M4.74609 9.42145C4.74609 10.4545 3.90625 11.2964 2.87109 11.2964C1.83984 11.2964 1 10.4545 1 9.42145C1 8.38455 1.83984 7.54645 2.87109 7.54645C3.90625 7.54645 4.74609 8.38455 4.74609 9.42145Z" fill="#ED4343"/>
                        <path d="M12.3594 17.4034C12.3594 18.4403 11.5234 19.2784 10.4883 19.2784C9.45312 19.2784 8.61719 18.4403 8.61719 17.4034C8.61719 16.3704 9.45312 15.5284 10.4883 15.5284C11.5234 15.5284 12.3594 16.3704 12.3594 17.4034Z" fill="#ED4343"/>
                        <path d="M27.6328 18.4034C27.6328 19.4403 26.793 20.2784 25.7578 20.2784C24.7227 20.2784 23.8867 19.4403 23.8867 18.4034C23.8867 17.3704 24.7227 16.5284 25.7578 16.5284C26.793 16.5284 27.6328 17.3704 27.6328 18.4034Z" fill="#ED4343"/>
                        <path d="M33.375 23.5089V16.3894" stroke="white" stroke-width="3.75029" stroke-miterlimit="10" stroke-linecap="round"/>
                        <path d="M35.2461 11.6036C35.2461 12.6366 34.4102 13.4786 33.375 13.4786C32.3398 13.4786 31.5 12.6366 31.5 11.6036C31.5 10.5667 32.3398 9.72859 33.375 9.72859C34.4102 9.72859 35.2461 10.5667 35.2461 11.6036Z" fill="#ED4343"/>
                        <path d="M35.2461 28.1707C35.2461 29.1578 34.4102 29.9557 33.375 29.9557C32.3398 29.9557 31.5 29.1578 31.5 28.1707C31.5 27.1872 32.3398 26.3857 33.375 26.3857C34.4102 26.3857 35.2461 27.1872 35.2461 28.1707Z" fill="#ED4343"/>
                        <path d="M35.2461 6.33191C35.2461 7.36491 34.4102 8.20691 33.375 8.20691C32.3398 8.20691 31.5 7.36491 31.5 6.33191C31.5 5.29501 32.3398 4.45691 33.375 4.45691C34.4102 4.45691 35.2461 5.29501 35.2461 6.33191Z" fill="#ED4343"/>
                        <path d="M50.4766 20.5441C50.4766 21.5781 49.6406 22.4171 48.6055 22.4171C47.5703 22.4171 46.7344 21.5781 46.7344 20.5441C46.7344 19.5061 47.5703 18.6671 48.6055 18.6671C49.6406 18.6671 50.4766 19.5061 50.4766 20.5441Z" fill="#ED4343"/>
                        <path d="M50.4766 15.2675C50.4766 16.3044 49.6406 17.1425 48.6055 17.1425C47.5703 17.1425 46.7344 16.3044 46.7344 15.2675C46.7344 14.2345 47.5703 13.3925 48.6055 13.3925C49.6406 13.3925 50.4766 14.2345 50.4766 15.2675Z" fill="#ED4343"/>
                        <path d="M40.9883 24.8055V17.686" stroke="white" stroke-width="3.75029" stroke-miterlimit="10" stroke-linecap="round"/>
                        <path d="M40.9883 12.6908V5.57132" stroke="white" stroke-width="3.75029" stroke-miterlimit="10" stroke-linecap="round"/>
                        <path d="M71.4414 21.2341V14.1147" stroke="white" stroke-width="3.75029" stroke-miterlimit="10" stroke-linecap="round"/>
                        <path d="M71.4414 34V26.8805" stroke="white" stroke-width="3.75029" stroke-miterlimit="10" stroke-linecap="round"/>
                        <path d="M71.4258 9.11947V2" stroke="white" stroke-width="3.75029" stroke-miterlimit="10" stroke-linecap="round"/>
                        <path d="M79.086 27.5375V20.418" stroke="white" stroke-width="3.75029" stroke-miterlimit="10" stroke-linecap="round"/>
                        <path d="M79.0665 15.4228V8.30334" stroke="white" stroke-width="3.75029" stroke-miterlimit="10" stroke-linecap="round"/>
                        <path d="M42.8633 29.5572C42.8633 30.5902 42.0234 31.4322 40.9883 31.4322C39.957 31.4322 39.1172 30.5902 39.1172 29.5572C39.1172 28.5203 39.957 27.6822 40.9883 27.6822C42.0234 27.6822 42.8633 28.5203 42.8633 29.5572Z" fill="#ED4343"/>
                        <path d="M18.125 28.6633V21.5438" stroke="white" stroke-width="3.75029" stroke-miterlimit="10" stroke-linecap="round"/>
                        <path d="M19.9961 16.758C19.9961 17.791 19.1562 18.633 18.125 18.633C17.0898 18.633 16.25 17.791 16.25 16.758C16.25 15.7211 17.0898 14.883 18.125 14.883C19.1562 14.883 19.9961 15.7211 19.9961 16.758Z" fill="#ED4343"/>
                        <path d="M19.9961 11.4843C19.9961 12.5223 19.1562 13.3613 18.125 13.3613C17.0898 13.3613 16.25 12.5223 16.25 11.4843C16.25 10.4503 17.0898 9.6113 18.125 9.6113C19.1562 9.6113 19.9961 10.4503 19.9961 11.4843Z" fill="#ED4343"/>
                        <path d="M63.836 26.4464V19.3298" stroke="white" stroke-width="3.75029" stroke-miterlimit="10" stroke-linecap="round"/>
                        <path d="M65.7109 14.542C65.7109 15.58 64.8711 16.419 63.8359 16.419C62.8008 16.419 61.9648 15.58 61.9648 14.542C61.9648 13.508 62.8008 12.669 63.8359 12.669C64.8711 12.669 65.7109 13.508 65.7109 14.542Z" fill="#ED4343"/>
                        <path d="M65.7109 9.26941C65.7109 10.3063 64.8711 11.1444 63.8359 11.1444C62.8008 11.1444 61.9648 10.3063 61.9648 9.26941C61.9648 8.23641 62.8008 7.39441 63.8359 7.39441C64.8711 7.39441 65.7109 8.23641 65.7109 9.26941Z" fill="#ED4343"/>
                        <path d="M19.9961 6.21172C19.9961 7.24862 19.1562 8.08672 18.125 8.08672C17.0898 8.08672 16.25 7.24862 16.25 6.21172C16.25 5.17871 17.0898 4.33672 18.125 4.33672C19.1562 4.33672 19.9961 5.17871 19.9961 6.21172Z" fill="#ED4343"/>
                        <path d="M58.0938 22.6779C58.0938 23.711 57.2539 24.5529 56.2227 24.5529C55.1875 24.5529 54.3477 23.711 54.3477 22.6779C54.3477 21.641 55.1875 20.8029 56.2227 20.8029C57.2539 20.8029 58.0938 21.641 58.0938 22.6779Z" fill="#ED4343"/>
                        <path d="M58.0938 17.4034C58.0938 18.4403 57.2539 19.2784 56.2227 19.2784C55.1875 19.2784 54.3477 18.4403 54.3477 17.4034C54.3477 16.3704 55.1875 15.5284 56.2227 15.5284C57.2539 15.5284 58.0938 16.3704 58.0938 17.4034Z" fill="#ED4343"/>
                        <path d="M58.0938 12.1317C58.0938 13.1686 57.2539 14.0067 56.2227 14.0067C55.1875 14.0067 54.3477 13.1686 54.3477 12.1317C54.3477 11.0987 55.1875 10.2567 56.2227 10.2567C57.2539 10.2567 58.0938 11.0987 58.0938 12.1317Z" fill="#ED4343"/>
                    </svg>

                </div>

                <div class="flex gap-x-4 justify-end laptop:justify-start laptop:w-full">
                    
                    <div @click.stop="drop = !drop" class="laptop:hidden">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_5_487)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 1.5C0 1.10218 0.118526 0.720644 0.329505 0.43934C0.540483 0.158035 0.826631 0 1.125 0H22.875C23.1734 0 23.4595 0.158035 23.6705 0.43934C23.8815 0.720644 24 1.10218 24 1.5C24 1.89782 23.8815 2.27936 23.6705 2.56066C23.4595 2.84196 23.1734 3 22.875 3H1.125C0.826631 3 0.540483 2.84196 0.329505 2.56066C0.118526 2.27936 0 1.89782 0 1.5ZM0 12C0 11.6022 0.118526 11.2206 0.329505 10.9393C0.540483 10.658 0.826631 10.5 1.125 10.5H22.875C23.1734 10.5 23.4595 10.658 23.6705 10.9393C23.8815 11.2206 24 11.6022 24 12C24 12.3978 23.8815 12.7794 23.6705 13.0607C23.4595 13.342 23.1734 13.5 22.875 13.5H1.125C0.826631 13.5 0.540483 13.342 0.329505 13.0607C0.118526 12.7794 0 12.3978 0 12ZM0 22.5C0 22.1022 0.118526 21.7206 0.329505 21.4393C0.540483 21.158 0.826631 21 1.125 21H22.875C23.1734 21 23.4595 21.158 23.6705 21.4393C23.8815 21.7206 24 22.1022 24 22.5C24 22.8978 23.8815 23.2794 23.6705 23.5607C23.4595 23.842 23.1734 24 22.875 24H1.125C0.826631 24 0.540483 23.842 0.329505 23.5607C0.118526 23.2794 0 22.8978 0 22.5Z" fill="white"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_5_487">
                                    <rect width="24" height="24" fill="white"/>
                                </clipPath>
                            </defs>
                        </svg>
                    </div>

                    <!-- <div class="hidden laptop:block">
                        <NavigatorComponent />
                    </div> -->
                    <div v-if="type === 'desktop'" class='laptop:w-full'>
                        <popupEpiComponent />
                    </div>

                


                    


                </div>

            </div>
        </div>


        <transition name="slide-down">
            <div v-if="drop" class="flex flex-col items-stretch gap-y-2 bg-black">

                <router-link to="/">
                    <div :class="route.name === 'home' ? 'bg-white/20' : ''" class="text-white flex justify-center items-center gap-x-2 text-center p-2 border-y border-[#FFFFFF]/10 active:bg-white/10">
                        <div class="">
                            <svg width="16" height="15" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.707 0.293031C11.5194 0.105559 11.2651 0.000244141 11 0.000244141C10.7348 0.000244141 10.4805 0.105559 10.293 0.293031L3.29296 7.29303L1.29296 9.29303C1.19745 9.38528 1.12127 9.49562 1.06886 9.61763C1.01645 9.73963 0.988862 9.87085 0.987709 10.0036C0.986555 10.1364 1.01186 10.2681 1.06214 10.391C1.11242 10.5139 1.18667 10.6255 1.28056 10.7194C1.37446 10.8133 1.48611 10.8876 1.60901 10.9379C1.7319 10.9881 1.86358 11.0134 1.99636 11.0123C2.12914 11.0111 2.26036 10.9835 2.38236 10.9311C2.50437 10.8787 2.61471 10.8025 2.70696 10.707L2.99996 10.414V17C2.99996 17.7957 3.31603 18.5587 3.87864 19.1214C4.44125 19.684 5.20431 20 5.99996 20H16C16.7956 20 17.5587 19.684 18.1213 19.1214C18.6839 18.5587 19 17.7957 19 17V10.414L19.293 10.707C19.4816 10.8892 19.7342 10.99 19.9964 10.9877C20.2586 10.9854 20.5094 10.8803 20.6948 10.6948C20.8802 10.5094 20.9854 10.2586 20.9876 9.99643C20.9899 9.73423 20.8891 9.48163 20.707 9.29303L11.707 0.293031Z" fill="#CCCCCC"/>
                            </svg>
                        </div>
                        Home
                    </div>
                </router-link>

                <router-link :to="{name : 'audienceShows'}">
                    <div :class="[route.name === 'audienceShows' || route.name === 'episode' ?  'bg-white/20' : '']" class="text-white text-center p-2 border-b border-[#FFFFFF]/10 active:bg-white/10">
                        Shows
                    </div>
                </router-link>


                <router-link :to="{name : 'audienceforums'}">
                    <div :class="[route.name === 'audienceforums' || route.name === 'audienceforum' ? 'bg-white/20' : '']" class="text-white text-center p-2 border-b border-[#FFFFFF]/10 active:bg-white/10">
                        Let's talk
                    </div>
                </router-link>


                <div class="text-white text-center p-2 border-b border-[#FFFFFF]/10 active:bg-white/10">
                    About us
                </div>

                <router-link v-if="userStore.user_level === 2 && userStore.token" :to="{name : 'adminManageShows'}">

                    <div :class="[route.name === 'adminManageShows' || route.name === 'adminShow' ? 'bg-white/20' : '']" class="text-white text-center p-2 border-b border-[#FFFFFF]/10 active:bg-white/10">
                        Manage Shows
                    </div>                

                </router-link>

                <router-link v-if="userStore.user_level === 2 && userStore.token" :to="{name : 'adminManageHosts'}">

                    <div :class="[route.name === 'adminManageHosts' ? 'bg-white/20' : '']" class="text-white text-center p-2 border-b border-[#FFFFFF]/10 active:bg-white/10">
                        Hosts
                    </div>   

                </router-link>

                <router-link v-if="userStore.user_level === 2 && userStore.token" :to="{name : 'Adminforum'}">

                    <div :class="[route.name === 'Adminforum' || route.name === 'forumShow' ? 'bg-white/20' : '']" class="text-white text-center p-2 border-b border-[#FFFFFF]/10 active:bg-white/10">
                        Forums
                    </div>

                </router-link>


            </div>
        </transition>
    </div>

</template>

<script setup>
import { ref, watch } from 'vue';
import popupEpiComponent from '../components/popupEpiComponent.vue';
import { useRoute, useRouter } from 'vue-router';
import { useUserStore } from '../stores/userStore';
import { useBreakPoints } from '../router/composible/useBreakPoint';

const drop = ref(false);
const route = useRoute();
const router = useRouter();
const userStore = useUserStore();

const {type} = useBreakPoints();

// eslint-disable-next-line no-unused-vars
watch(() => route.name, (newName) => {
    drop.value = false;
})

function routeToHome() {
    router.push({
        name : 'home'
    })
}
</script>

<style>
</style>