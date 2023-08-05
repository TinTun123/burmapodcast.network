<template>
    <div 
    @touchstart="touchStart" 
    @touchmove="touchMove" 
    @touchend="touchEnd" 
    draggable="true"
    ref="elementRef"
    class="movable fixed laptop:sticky left-0 right-0 tablet:left-0 tablet:right-0 tablet:bottom-4 transition-all bg-gradient-to-t from-[#292929] to-[#121212]" 
    @click.stop="type === 'desktop' ? scroll() : ''"
    :style="{bottom : `${translateY}px`}"
    :class="[scrolled ? 'pt-8 laptop:bottom-4 laptop:pb-8 rounded-t-[10px]' : 'cursor-pointer']">

        <div @click.stop="drop" v-if="scrolled" class="absolute hidden laptop:block laptop:top-4 laptop:right-4 cursor-pointer">
            <svg width="16" height="14" viewBox="0 0 24 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0.528277 0.528277C0.866635 0.190022 1.32548 0 1.80392 0C2.28236 0 2.74121 0.190022 3.07957 0.528277L12.0109 9.4596L20.9422 0.528277C21.2825 0.199608 21.7383 0.0177431 22.2114 0.021854C22.6845 0.025965 23.137 0.215723 23.4715 0.550256C23.8061 0.884789 23.9958 1.33733 23.9999 1.81042C24.004 2.2835 23.8222 2.73927 23.4935 3.07957L13.2865 13.2865C12.9482 13.6248 12.4893 13.8148 12.0109 13.8148C11.5325 13.8148 11.0736 13.6248 10.7352 13.2865L0.528277 3.07957C0.190021 2.74121 0 2.28236 0 1.80392C0 1.32548 0.190021 0.866635 0.528277 0.528277Z" fill="white"/>
            </svg>
        </div>

        <div class="absolute laptop:hidden left-[50%] top-2 -translate-x-[50%]">

            <svg width="49" height="4" viewBox="0 0 49 4" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="0.5" width="48" height="4" rx="2" fill="#404040"/>
            </svg>

        </div>

        <audio controls hidden ref="audio" @ended="isPlaying = false">
            <source :src="currentEpisode.audio_url" type="audio/mpeg">
        </audio>

        <div class="flex items-center justify-between gap-x-4" :class="[scrolled ? 'flex-col items-stretch laptop:flex-row laptop:mx-4 laptop:justify-start' : 'pr-4']">

            <img :src="currentEpisode.img_url" :class="[scrolled ? 'mx-auto laptop:mx-0 laptop:ml-4 mb-4 w-[30%] tablet:w-[153px] shadow-card-shadow rounded-[10px]' : 'w-[68px]']" class="aspect-square" alt="">

            <div class="laptop:flex-1 laptop:mr-4">


                <h1 :class="[scrolled ? 'my-0 mx-4' : 'line-clamp-1']" class="text-white text-base font-semibold whitespace-break-spaces">
                    {{ currentEpisode.title }}
                </h1>
                <div v-if="scrolled" class="flex my-1 justify-between laptop:items-center laptop:w-full mx-4">

                    <div class="flex gap-x-1 items-center">

                        <div>
                            <svg width="8" height="9" viewBox="0 0 8 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="4" cy="4.5" r="4" fill="white" fill-opacity="0.4"/>
                            </svg>
                        </div>

                        <span class="text-white/60 font-semibold text-sm">{{ formattedDuratiuon }}</span>

                    </div>


                    <div class="flex gap-x-2">

                        <div>
                            <svg width="16" height="16" viewBox="0 0 22 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15.5237 19.3327L15.394 19.7191C15.366 19.8025 15.3423 19.9053 15.3257 20.0303C15.3083 20.1607 15.3 20.2838 15.3 20.4C15.3 21.2689 15.5984 21.9913 16.2036 22.5964C16.8087 23.2016 17.5311 23.5 18.4 23.5C19.2689 23.5 19.9913 23.2016 20.5965 22.5964C21.2016 21.9913 21.5 21.2689 21.5 20.4C21.5 19.5311 21.2016 18.8087 20.5965 18.2036C19.9915 17.5986 19.2694 17.3002 18.4009 17.3L15.5237 19.3327ZM15.5237 19.3327L15.1714 19.1278M15.5237 19.3327L15.1714 19.1278M15.1714 19.1278L6.71139 14.2078L6.39963 14.0265M15.1714 19.1278L6.39963 14.0265M6.39963 14.0265L6.12921 14.2651M6.39963 14.0265L6.12921 14.2651M6.12921 14.2651C5.83148 14.5278 5.49977 14.7331 5.13205 14.8823C4.77294 15.028 4.39715 15.1007 4.00089 15.1H4.00002M6.12921 14.2651L4.00002 15.1M4.00002 15.1C3.13112 15.1 2.40874 14.8016 1.80358 14.1964C1.19841 13.5913 0.900024 12.8689 0.900024 12C0.900024 11.1311 1.19841 10.4087 1.80358 9.80355C2.40874 9.19839 3.13112 8.9 4.00002 8.9C4.39657 8.9 4.77266 8.97311 5.13205 9.11892C5.50004 9.26822 5.83191 9.47329 6.12971 9.73536L6.40007 9.97327M4.00002 15.1L6.40007 9.97327M6.40007 9.97327L6.71139 9.79222M6.40007 9.97327L6.71139 9.79222M6.71139 9.79222L15.1714 4.87222L15.523 4.66775M6.71139 9.79222L15.523 4.66775M15.523 4.66775L15.3944 4.28189M15.523 4.66775L15.3944 4.28189M15.3944 4.28189C15.366 4.19683 15.3422 4.0935 15.3256 3.96934C15.3083 3.84015 15.3 3.71713 15.3 3.6C15.3 2.73109 15.5984 2.00872 16.2036 1.40355C16.8087 0.798386 17.5311 0.5 18.4 0.5C19.2689 0.5 19.9913 0.798386 20.5965 1.40355C21.2016 2.00872 21.5 2.7311 21.5 3.6C21.5 4.46891 21.2016 5.19128 20.5965 5.79645C19.9913 6.40161 19.2689 6.7 18.4 6.7C18.0032 6.7 17.6268 6.62717 17.2672 6.48197C16.9001 6.33372 16.5688 6.12871 16.2713 5.86552L16.0008 5.62622M15.3944 4.28189L16.0008 5.62622M6.46002 9.36C6.12002 9.0608 5.74002 8.826 5.32002 8.6556C4.90002 8.4852 4.46002 8.4 4.00002 8.4C3.00002 8.4 2.15002 8.75 1.45002 9.45C0.750024 10.15 0.400024 11 0.400024 12C0.400024 13 0.750024 13.85 1.45002 14.55C2.15002 15.25 3.00002 15.6 4.00002 15.6C4.46002 15.6008 4.90002 15.516 5.32002 15.3456L6.46002 9.36ZM6.46002 9.36L14.92 4.44L6.46002 9.36ZM16.0008 5.62622L15.6887 5.80778M16.0008 5.62622L15.6887 5.80778M15.6887 5.80778L7.22866 10.7278L6.87706 10.9323M15.6887 5.80778L6.87706 10.9323M6.87706 10.9323L7.00568 11.3181M6.87706 10.9323L7.00568 11.3181M7.00568 11.3181C7.03394 11.4029 7.05776 11.5065 7.07439 11.6315C7.09174 11.762 7.10002 11.8847 7.10002 12C7.10002 12.1162 7.09172 12.2393 7.07439 12.3697C7.05777 12.4947 7.03401 12.5975 7.006 12.6809L6.87634 13.0673M7.00568 11.3181L6.87634 13.0673M6.87634 13.0673L7.22866 13.2722M6.87634 13.0673L7.22866 13.2722M7.22866 13.2722L15.6887 18.1922L16.0004 18.3735M7.22866 13.2722L16.0004 18.3735M16.0004 18.3735L16.2708 18.1349M16.0004 18.3735L16.2708 18.1349M16.2708 18.1349C16.5684 17.8724 16.8998 17.6676 17.2672 17.5192M16.2708 18.1349L17.2672 17.5192M17.2672 17.5192C17.6271 17.3739 18.0037 17.3007 18.4008 17.3L17.2672 17.5192Z" stroke="white"/>
                            </svg>
                        </div>

                        <div>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.9452 4.73013C11.9424 4.73176 11.9401 4.73335 11.9383 4.73481L11.9602 4.76268M11.9452 4.73013C11.9454 4.73001 11.9456 4.72989 11.9458 4.72977M11.9452 4.73013L11.9993 4.749L11.9602 4.76268M11.9452 4.73013H12.0548L12.0007 4.749L12.0398 4.76268L12.4111 4.89261M11.9602 4.76268L11.9383 4.73481C11.934 4.73818 11.9329 4.74007 11.9338 4.73884C11.9346 4.73762 11.9369 4.73397 11.9392 4.72747L11.9458 4.72977M11.9602 4.76268L11.5889 4.89261L11.9605 4.76303L12 4.74925L12.0395 4.76303L12.4111 4.89261M11.9458 4.72977C11.9572 4.72312 11.9757 4.7161 12 4.7161C12.0243 4.7161 12.0428 4.72312 12.0542 4.72977L12 4.74875L11.9458 4.72977ZM12.4111 4.89261C12.3776 4.9883 12.3207 5.07015 12.2475 5.12775L6.44444 1.04348C4.97156 1.04555 3.55951 1.73332 2.51802 2.95594C1.47654 4.17855 0.890653 5.83618 0.888889 7.56521C0.888889 15.1396 10.4444 21.8426 12 22.8809C13.5556 21.8426 23.1111 15.1304 23.1111 7.56521C23.1093 5.83618 22.5235 4.17855 21.482 2.95594C20.4405 1.73332 19.0284 1.04555 17.5556 1.04348C15.21 1.04348 13.2389 2.51869 12.4111 4.89261ZM17.5556 0.543478C16.3858 0.543478 15.3047 0.878888 14.3894 1.48403C15.3042 0.847227 16.3879 0.500069 17.5552 0.5C18.5706 0.501509 19.567 0.812847 20.4494 1.39901C19.5744 0.846788 18.5825 0.544921 17.5563 0.543478H17.5556ZM6.44374 0.543478C5.41748 0.544921 4.42564 0.846782 3.55066 1.399C4.433 0.812841 5.42938 0.501509 6.4448 0.5C7.61208 0.500069 8.69581 0.847227 9.61064 1.48403C8.69533 0.878888 7.61423 0.543478 6.44444 0.543477L6.44374 0.543478Z" stroke="white"/>
                            </svg>
                        </div>

                    </div>
                </div>
            </div>




            <div @click.stop="togglePlayBack" class="w-9 h-9 group flex-none" v-if="!scrolled">
                <svg v-if="!isPlaying" class="w-full h-full" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_67_2999)">
                        <path class="fill-white group-active:fill-white/60" d="M24 48C10.746 48 0 37.254 0 24C0 10.746 10.746 0 24 0C37.254 0 48 10.746 48 24C48 37.254 37.254 48 24 48ZM18 12.018V35.982L36 24L18 12.018Z"/>
                    </g>

                    <defs>
                        <clipPath id="clip0_67_2999">
                            <rect width="48" height="48" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>

                <svg v-else class="w-full h-full" viewBox="0 0 65 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="fill-white group-active:fill-white/80" fill-rule="evenodd" clip-rule="evenodd" d="M64.5 32C64.5 40.4869 61.1286 48.6263 55.1274 54.6274C49.1263 60.6286 40.9869 64 32.5 64C24.0131 64 15.8737 60.6286 9.87258 54.6274C3.87142 48.6263 0.5 40.4869 0.5 32C0.5 23.5131 3.87142 15.3737 9.87258 9.37258C15.8737 3.37142 24.0131 0 32.5 0C40.9869 0 49.1263 3.37142 55.1274 9.37258C61.1286 15.3737 64.5 23.5131 64.5 32ZM20.5 24C20.5 22.9391 20.9214 21.9217 21.6716 21.1716C22.4217 20.4214 23.4391 20 24.5 20C25.5609 20 26.5783 20.4214 27.3284 21.1716C28.0786 21.9217 28.5 22.9391 28.5 24V40C28.5 41.0609 28.0786 42.0783 27.3284 42.8284C26.5783 43.5786 25.5609 44 24.5 44C23.4391 44 22.4217 43.5786 21.6716 42.8284C20.9214 42.0783 20.5 41.0609 20.5 40V24ZM40.5 20C39.4391 20 38.4217 20.4214 37.6716 21.1716C36.9214 21.9217 36.5 22.9391 36.5 24V40C36.5 41.0609 36.9214 42.0783 37.6716 42.8284C38.4217 43.5786 39.4391 44 40.5 44C41.5609 44 42.5783 43.5786 43.3284 42.8284C44.0786 42.0783 44.5 41.0609 44.5 40V24C44.5 22.9391 44.0786 21.9217 43.3284 21.1716C42.5783 20.4214 41.5609 20 40.5 20Z"/>
                </svg>



            </div>

        </div>


        <p v-if="scrolled" class="mx-4 text-white max-h-[180px] tablet:max-h-[1000px] overflow-y-scroll py-2 scroll-container">

            {{ currentEpisode.description }}

        </p>

        <div v-if="scrolled" class="text-right tablet:mb-16">
            <span  class="text-white/60 text-sm font-semibold mx-4 leading-[24px]">

            {{ getDate(currentEpisode.created_at) }}

            </span>
        </div>


        <div v-if="scrolled" class="flex items-center mb-2 mx-4 gap-x-2">

            <span class="text-white text-sm">{{formattedCurrentTime}}</span>

            <div class="bg-gray-300/20 w-full h-1 rounded-full">
                <div :style="{'width' : `${progressPercentage}%`}" class="h-1 rounded-full bg-white"></div>
            </div>

            <span class="text-white text-sm">{{ formattedRemainingTime }}</span>

        </div>

        <div v-if="scrolled" class="flex items-center justify-evenly mb-4 laptop:mb-0 gap-x-4">
            <div @click.stop="routeTofavourite" class="w-4 h-4 tablet:w-6 tablet:h-6 group">
                <svg class="w-full h-full" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="fill-white group-active:fill-white/60" d="M8.08 12.44L8 12.52L7.912 12.44C4.112 8.992 1.6 6.712 1.6 4.4C1.6 2.8 2.8 1.6 4.4 1.6C5.632 1.6 6.832 2.4 7.256 3.488H8.744C9.168 2.4 10.368 1.6 11.6 1.6C13.2 1.6 14.4 2.8 14.4 4.4C14.4 6.712 11.888 8.992 8.08 12.44ZM11.6 0C10.208 0 8.872 0.648 8 1.664C7.128 0.648 5.792 0 4.4 0C1.936 0 0 1.928 0 4.4C0 7.416 2.72 9.888 6.84 13.624L8 14.68L9.16 13.624C13.28 9.888 16 7.416 16 4.4C16 1.928 14.064 0 11.6 0Z" />
                </svg>
            </div>

            <div @click.stop="playPre" class="w-4 h-4 tablet:w-6 tablet:h-6">
                <svg class="w-full h-full" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="group-active:fill-white/60" :class="[Object.keys(preEpi).length ? 'fill-white' : 'fill-white/40']" d="M27.7867 2.96L12.4 13.8133C10.9067 14.88 10.9067 17.12 12.4 18.16L27.7867 29.04C29.5733 30.2667 32 29.0133 32 26.8533V5.14667C32 2.98667 29.5733 1.73333 27.7867 2.96ZM5.33333 29.3333L5.33333 2.66667C5.33333 1.2 4.13333 0 2.66667 0C1.2 0 0 1.2 0 2.66667L0 29.3333C0 30.8 1.2 32 2.66667 32C4.13333 32 5.33333 30.8 5.33333 29.3333Z"/>
                </svg>
            </div>

            <div @click.stop="togglePlayBack" class="w-6 h-6 tablet:w-8 tablet:h-8 group cursor-pointer">
                <svg v-if="isPlaying" class="w-full h-full" viewBox="0 0 65 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path  class="fill-white group-active:fill-white/80" fill-rule="evenodd" clip-rule="evenodd" d="M64.5 32C64.5 40.4869 61.1286 48.6263 55.1274 54.6274C49.1263 60.6286 40.9869 64 32.5 64C24.0131 64 15.8737 60.6286 9.87258 54.6274C3.87142 48.6263 0.5 40.4869 0.5 32C0.5 23.5131 3.87142 15.3737 9.87258 9.37258C15.8737 3.37142 24.0131 0 32.5 0C40.9869 0 49.1263 3.37142 55.1274 9.37258C61.1286 15.3737 64.5 23.5131 64.5 32ZM20.5 24C20.5 22.9391 20.9214 21.9217 21.6716 21.1716C22.4217 20.4214 23.4391 20 24.5 20C25.5609 20 26.5783 20.4214 27.3284 21.1716C28.0786 21.9217 28.5 22.9391 28.5 24V40C28.5 41.0609 28.0786 42.0783 27.3284 42.8284C26.5783 43.5786 25.5609 44 24.5 44C23.4391 44 22.4217 43.5786 21.6716 42.8284C20.9214 42.0783 20.5 41.0609 20.5 40V24ZM40.5 20C39.4391 20 38.4217 20.4214 37.6716 21.1716C36.9214 21.9217 36.5 22.9391 36.5 24V40C36.5 41.0609 36.9214 42.0783 37.6716 42.8284C38.4217 43.5786 39.4391 44 40.5 44C41.5609 44 42.5783 43.5786 43.3284 42.8284C44.0786 42.0783 44.5 41.0609 44.5 40V24C44.5 22.9391 44.0786 21.9217 43.3284 21.1716C42.5783 20.4214 41.5609 20 40.5 20Z"/>
                </svg>

                <svg v-else class="w-full h-full" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="fill-white group-active:fill-white/80" d="M12 0C9.62663 0 7.30655 0.703788 5.33316 2.02236C3.35977 3.34094 1.8217 5.21508 0.913451 7.4078C0.00519941 9.60051 -0.232441 12.0133 0.230582 14.3411C0.693605 16.6689 1.83649 18.807 3.51472 20.4853C5.19295 22.1635 7.33115 23.3064 9.65892 23.7694C11.9867 24.2324 14.3995 23.9948 16.5922 23.0866C18.7849 22.1783 20.6591 20.6402 21.9776 18.6668C23.2962 16.6935 24 14.3734 24 12C24 10.4241 23.6896 8.8637 23.0866 7.4078C22.4835 5.95189 21.5996 4.62902 20.4853 3.51472C19.371 2.40042 18.0481 1.5165 16.5922 0.913446C15.1363 0.310389 13.5759 0 12 0ZM9.6 17.4V6.6L16.8 12L9.6 17.4Z" />
                </svg>
            </div>

            <div @click.stop="playNext" class="w-4 h-4 tablet:w-6 tablet:h-6 group">
                <svg class="w-full h-full" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path :class="[Object.keys(nextEpi).length ? 'fill-white' : 'fill-white/40']" class="group-active:fill-white/60" d="M4.21333 29.04L19.6 18.1867C21.0933 17.12 21.0933 14.88 19.6 13.84L4.21333 2.96C2.42667 1.73333 0 2.98667 0 5.14667V26.8533C0 29.0133 2.42667 30.2667 4.21333 29.04ZM26.6667 2.66667V29.3333C26.6667 30.8 27.8667 32 29.3333 32C30.8 32 32 30.8 32 29.3333V2.66667C32 1.2 30.8 0 29.3333 0C27.8667 0 26.6667 1.2 26.6667 2.66667Z"/>
                </svg>
            </div>

            <div @click.stop="routeToplaylist" class="w-4 h-4 tablet:w-6 tablet:h-6 group">
                <svg class="w-full h-full" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="group-active:fill-white/60 fill-white" d="M0 0.842106C0 0.685069 0.0623825 0.534465 0.173424 0.423424C0.284465 0.312383 0.435069 0.25 0.592106 0.25H13.6184C13.7755 0.25 13.9261 0.312383 14.0371 0.423424C14.1482 0.534465 14.2105 0.685069 14.2105 0.842106C14.2105 0.999142 14.1482 1.14975 14.0371 1.26079C13.9261 1.37183 13.7755 1.43421 13.6184 1.43421H0.592106C0.435069 1.43421 0.284465 1.37183 0.173424 1.26079C0.0623825 1.14975 0 0.999142 0 0.842106ZM0.592106 6.17106H9.47369C9.63073 6.17106 9.78133 6.10867 9.89237 5.99763C10.0034 5.88659 10.0658 5.73599 10.0658 5.57895C10.0658 5.42191 10.0034 5.27131 9.89237 5.16027C9.78133 5.04923 9.63073 4.98685 9.47369 4.98685H0.592106C0.435069 4.98685 0.284465 5.04923 0.173424 5.16027C0.0623825 5.27131 0 5.42191 0 5.57895C0 5.73599 0.0623825 5.88659 0.173424 5.99763C0.284465 6.10867 0.435069 6.17106 0.592106 6.17106ZM5.92106 9.72369H0.592106C0.435069 9.72369 0.284465 9.78607 0.173424 9.89711C0.0623825 10.0082 0 10.1588 0 10.3158C0 10.4728 0.0623825 10.6234 0.173424 10.7345C0.284465 10.8455 0.435069 10.9079 0.592106 10.9079H5.92106C6.07809 10.9079 6.2287 10.8455 6.33974 10.7345C6.45078 10.6234 6.51316 10.4728 6.51316 10.3158C6.51316 10.1588 6.45078 10.0082 6.33974 9.89711C6.2287 9.78607 6.07809 9.72369 5.92106 9.72369ZM15.565 4.71596L12.6045 3.8278C12.516 3.80126 12.4227 3.79576 12.3318 3.81173C12.2409 3.8277 12.1549 3.86471 12.0809 3.91979C12.0068 3.97487 11.9467 4.0465 11.9052 4.12896C11.8637 4.21143 11.8421 4.30244 11.8421 4.39474V8.26637C11.3905 8.00565 10.8655 7.90124 10.3486 7.96935C9.83158 8.03746 9.35153 8.27428 8.98288 8.64306C8.61423 9.01184 8.37758 9.49197 8.30966 10.009C8.24174 10.526 8.34633 11.0509 8.60721 11.5024C8.86809 11.9539 9.27068 12.3067 9.75252 12.506C10.2344 12.7054 10.7685 12.7401 11.2721 12.6049C11.7757 12.4696 12.2206 12.172 12.5378 11.7581C12.855 11.3442 13.0267 10.8372 13.0263 10.3158V5.19038L15.2245 5.84984C15.2995 5.87428 15.3787 5.88347 15.4573 5.87688C15.536 5.87029 15.6125 5.84805 15.6824 5.81146C15.7523 5.77488 15.8142 5.72468 15.8645 5.66383C15.9147 5.60298 15.9523 5.5327 15.975 5.45712C15.9977 5.38154 16.005 5.30219 15.9966 5.22373C15.9882 5.14527 15.9642 5.06928 15.926 5.00023C15.8878 4.93118 15.8362 4.87046 15.7742 4.82164C15.7122 4.77282 15.6411 4.73689 15.565 4.71596Z" />
                </svg>
            </div>
        </div>



    </div>
</template>

<script setup>

import { computed, onMounted, ref, watch } from 'vue';
import {useShowsStore } from '../stores/ShowsStore';
import { useBreakPoints } from '../router/composible/useBreakPoint';
import { storeToRefs } from 'pinia';
import router from '../router';

const elementRef = ref(null);
const showStore = useShowsStore();
const translateY = ref(0);
const scrolled = ref(false);
const touchOffsetY = ref('0');
const startY = ref(0);
const {type} = useBreakPoints();

const audio = ref(null);

const nextEpi = ref();
const preEpi = ref();

const isPlaying = ref(false);
const currentTime = ref(0);
const totalTime = ref(0);
const {currentEpisode} = storeToRefs(showStore);
const remainingTime = computed(() => totalTime.value - currentTime.value);

const formatTime = (time) => {

    const minutes = Math.floor(time / 60);
    const seconds = Math.floor(time % 60);

    return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

const formatDuration = (time) => {
    const minutes = Math.floor(time / 60);
    const seconds = Math.floor(time % 60);

    return `${minutes} mins ${seconds} secs`;
}

const formattedCurrentTime = computed(() => formatTime(currentTime.value));
const formattedRemainingTime = computed(() => formatTime(remainingTime.value));
const formattedDuratiuon = computed(() => formatDuration(totalTime.value));


const updateCurrentTime = () => {
    currentTime.value = audio.value.currentTime;
}

const togglePlayBack = () => {
    if (isPlaying.value) {
        audio.value.pause();
    } else {
        audio.value.play();
    }
    isPlaying.value = !isPlaying.value;
}

function playNext() {
    if (Object.keys(nextEpi.value).length) {
        showStore.currentEpisode = nextEpi.value;
    }

}

function playPre() {

    if (Object.keys(preEpi.value).length) {

        showStore.currentEpisode = preEpi.value;

    }
}


const progressPercentage = computed(() => {
    return (currentTime.value / totalTime.value) * 100;
})

onMounted(() => {
    audio.value.addEventListener('loadedmetadata', () => {
        totalTime.value = audio.value.duration;
    });

    audio.value.addEventListener('timeupdate', updateCurrentTime);

    audio.value.play();
    isPlaying.value = true;
    nextEpi.value = showStore.getNext(showStore.currentEpisode.id);
    preEpi.value = showStore.getPre(showStore.currentEpisode.id);
    showStore.addplaylist(showStore.currentEpisode, showStore.currentShow.id, showStore.currentShow.title);
})

function getDate(date) {
    const created_at = new Date(date);

    return created_at.toLocaleDateString(undefined, {
        month : 'short',
        day : 'numeric'
    });
}

function scroll() {
    if (type.value === 'desktop') {
        scrolled.value = true;
        translateY.value = 0;
    }

}

function drop() {
    scrolled.value = false;
    translateY.value = 0;
}

function touchStart(event) {

    const touch = event.touches[0];

    const frombottom = Math.abs(touch.clientY - window.innerHeight);

    touchOffsetY.value =  frombottom - translateY.value;

    startY.value = event.touches[0].clientY;
}


function touchMove(event) {

    event.preventDefault();
    
    const touch = event.touches[0];

    const frombottom = Math.abs(touch.clientY - window.innerHeight);
    
    const deltaY = event.touches[0].clientY - startY.value;

        translateY.value = frombottom - touchOffsetY.value;

        if (deltaY < 0) {

            // translateY.value = window.innerHeight - (window.innerHeight * 0.1) - elementRef.value.clientHeight;
            translateY.value = 0;
            scrolled.value = true;

        } else {

            translateY.value = 0;
            scrolled.value = false;

        }
        
}

// eslint-disable-next-line no-unused-vars
function touchEnd(event) {

    touchOffsetY.value = 0;

}

function routeTofavourite() {

    translateY.value = 0;
    scrolled.value = false;

    router.push({
        name : 'myFavorite'
    })
}

function routeToplaylist() {
    translateY.value = 0;
    scrolled.value = false;

    router.push({
        name : 'playList'
    });
}

// eslint-disable-next-line no-unused-vars
watch((currentEpisode), (newEpi, oldEpi) => {

    if (audio.value) {
        audio.value.src = newEpi.audio_url;
        audio.value.load();

        audio.value.addEventListener('loadedMetaData', () => {
            console.log('play loaded');
            audio.value.play();
        });
        
        audio.value.play();
        isPlaying.value = true;

        nextEpi.value = showStore.getNext(newEpi.id);
        preEpi.value = showStore.getPre(newEpi.id);

        showStore.addplaylist(newEpi, showStore.currentShow.id, showStore.currentShow.title);
    }

})
</script>

<style>

</style>