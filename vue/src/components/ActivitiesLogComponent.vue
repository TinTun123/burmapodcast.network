<template>
    <div>
        
        <div class="relative overflow-x-auto shadow-card-shadow rounded-[15px]">
            <table class="w-full text-sm text-left  text-white">
                <thead class="text-xs text-white bg-black/30 uppercase ">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Log Details
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Log Type    
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Date/Time
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(log, i) in userStore.logs" :key="i" class=" bg-black/10 border-b border-white/20">
                        <th  class="px-6 py-4 font-medium text-white">
                           {{ log.name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ log.log_details }}
                        </td>
                        <td class="px-6 py-4">
                          {{ log.log_type }}
                        </td>
                        <td class="px-6 py-4">
                            {{ log.created_at }}
                        </td>
                    </tr>
                    <tr class="bg-black/10 border-b  border-white/20">
                        <th scope="row" class="px-6 py-4 font-medium text-white">
                            page: {{ userStore.current_page }} / {{ userStore.total_page }}
                        </th>
                        <td class="px-6 py-4">
                            
                        </td>
                        <td class="px-6 py-4">
                           
                        </td>
                        <td class="px-6 py-4 flex gap-x-4 justify-center">

                            <div @click.stop="userStore.getPrevLog" class="laptop:cursor-pointer group">
                                <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path :class="[userStore.prev_url ? '' : 'fill-white/60']" class="fill-white group-hover:fill-white/60 group-active:fill-white" d="M8.85778 0.352185C9.08328 0.577756 9.20996 0.883657 9.20996 1.20262C9.20996 1.52157 9.08328 1.82747 8.85778 2.05305L2.90356 8.00726L8.85778 13.9615C9.07689 14.1883 9.19813 14.4922 9.19539 14.8076C9.19265 15.123 9.06615 15.4247 8.84312 15.6477C8.6201 15.8707 8.31841 15.9972 8.00302 16C7.68763 16.0027 7.38378 15.8815 7.15692 15.6623L0.352269 8.85769C0.126765 8.63212 8.39269e-05 8.32622 8.39269e-05 8.00726C8.39269e-05 7.6883 0.126765 7.3824 0.352269 7.15683L7.15692 0.352185C7.38249 0.126681 7.68839 0 8.00735 0C8.3263 0 8.6322 0.126681 8.85778 0.352185Z" />
                                </svg>
                            </div>

                            <div @click.stop="userStore.getNextLog" class="laptop:cursor-pointer group">
                                <svg width="10" height="16" viewBox="0 0 10 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path :class="[userStore.next_url ? '' : 'fill-white/60']" class="fill-white group-hover:fill-white/60 group-active:fill-white" d="M0.352185 15.6478C0.126681 15.4222 0 15.1163 0 14.7974C0 14.4784 0.126681 14.1725 0.352185 13.947L6.3064 7.99274L0.352185 2.03852C0.133072 1.81166 0.0118287 1.50781 0.0145694 1.19242C0.01731 0.87703 0.143815 0.575334 0.366837 0.352312C0.58986 0.129289 0.891555 0.00278603 1.20694 4.53828e-05C1.52233 -0.00269526 1.82618 0.118547 2.05305 0.33766L8.85769 7.14231C9.0832 7.36788 9.20988 7.67378 9.20988 7.99274C9.20988 8.3117 9.0832 8.6176 8.85769 8.84317L2.05305 15.6478C1.82747 15.8733 1.52157 16 1.20261 16C0.883656 16 0.577757 15.8733 0.352185 15.6478Z" />
                                </svg>
                            </div>


                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useUserStore } from '../stores/userStore';


const userStore = useUserStore();

onMounted(() => {
    userStore.fetchLog();

})


</script>

<style>
</style>