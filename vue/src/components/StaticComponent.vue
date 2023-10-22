<template>
    <div class="mx-4 tablet:mx-8">
        <div class="inline-block mt-4">
            <div @click.stop="drop = !drop" class="flex items-center bg-[#404040] w-[210px] rounded-full justify-between px-2 py-1 gap-x-2 transition-all" :class="[drop ? 'rounded-b-[0px] rounded-t-[15px]' : 'rounded-full']">
                <div class="flex gap-x-1 items-center justify-center overflow-hidden">
                    <span class="text-x-sm text-white/40 font-bold">show</span>
                    <span class="text-sm text-white overflow-hidden whitespace-nowrap leading-6" style="text-overflow: ellipsis;">{{ selectedShow.title }}</span>
                </div>


                <div>
                    <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.63605 5.62381C1.82358 5.42463 2.07788 5.31273 2.34305 5.31273C2.60821 5.31273 2.86252 5.42463 3.05005 5.62381L8.00005 10.8832L12.95 5.62381C13.1387 5.43027 13.3913 5.32318 13.6535 5.3256C13.9156 5.32802 14.1665 5.43976 14.3519 5.63676C14.5373 5.83375 14.6424 6.10024 14.6447 6.37883C14.647 6.65741 14.5462 6.9258 14.364 7.12619L8.70705 13.1368C8.51952 13.3359 8.26521 13.4478 8.00005 13.4478C7.73488 13.4478 7.48058 13.3359 7.29305 13.1368L1.63605 7.12619C1.44858 6.92694 1.34326 6.65674 1.34326 6.375C1.34326 6.09326 1.44858 5.82306 1.63605 5.62381Z" fill="#DDDDDD"/>
                    </svg>
                </div>
            </div>

            <transition name="slide-down">
                <div v-if="drop" class="bg-[#404040] overflow-hidden w-[210px] rounded-b-[15px]">
                    <ul class="transition-all">
                        <li v-for="(show, i) in showStore.shows" :key="i" @click.stop="selectedShow.title = show.title; selectedShow.id = show.id; drop = !drop; updateData()" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30 overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">{{show.title}}</li>
                    
                    </ul>
                </div>
            </transition>

        </div>
        <div class="mt-4 flex flex-col gap-y-4 tablet:flex-row gap-x-4">

            <div class="bg-[#212121] rounded-[12px] shadow-card-shadow p-4 flex-1">

                <div class="text-right">
                    <div class="inline-block bg-[#404040] rounded-full px-2">
                        <div class="flex items-center gap-x-1">
                            <div>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.91667 10.6458V12.5417H4.08334V10.6458C4.08334 9.84083 5.39 9.1875 7 9.1875C8.61 9.1875 9.91667 9.84083 9.91667 10.6458ZM7 3.20833C8.00562 3.20833 8.97004 3.60781 9.68112 4.31889C10.3922 5.02996 10.7917 5.99439 10.7917 7C10.7917 7.72917 10.5875 8.41167 10.2317 8.98917L9.33334 8.19C9.52 7.83417 9.625 7.42583 9.625 7C9.625 5.54167 8.45834 4.375 7 4.375C5.54167 4.375 4.375 5.54167 4.375 7C4.375 7.42583 4.48 7.83417 4.66667 8.19L3.76834 8.98917C3.4125 8.41167 3.20834 7.72917 3.20834 7C3.20834 5.99439 3.60781 5.02996 4.31889 4.31889C5.02997 3.60781 5.99439 3.20833 7 3.20833ZM7 0.875C8.62445 0.875 10.1824 1.52031 11.331 2.66897C12.4797 3.81763 13.125 5.37555 13.125 7C13.125 8.33 12.6992 9.56083 11.9817 10.5642L11.1067 9.77667C11.6433 8.98333 11.9583 8.02667 11.9583 7C11.9583 5.68497 11.4359 4.4238 10.5061 3.49393C9.57621 2.56406 8.31504 2.04167 7 2.04167C5.68497 2.04167 4.4238 2.56406 3.49393 3.49393C2.56406 4.4238 2.04167 5.68497 2.04167 7C2.04167 8.02667 2.35667 8.98333 2.89334 9.77667L2.01834 10.5642C1.27369 9.525 0.873808 8.27842 0.875003 7C0.875003 5.37555 1.52031 3.81763 2.66897 2.66897C3.81763 1.52031 5.37555 0.875 7 0.875ZM7 5.54167C7.38678 5.54167 7.75771 5.69531 8.0312 5.9688C8.30469 6.24229 8.45834 6.61323 8.45834 7C8.45834 7.38677 8.30469 7.75771 8.0312 8.0312C7.75771 8.30469 7.38678 8.45833 7 8.45833C6.61323 8.45833 6.2423 8.30469 5.96881 8.0312C5.69532 7.75771 5.54167 7.38677 5.54167 7C5.54167 6.61323 5.69532 6.24229 5.96881 5.9688C6.2423 5.69531 6.61323 5.54167 7 5.54167Z" fill="#A6A6A6"/>
                                </svg>
                            </div>
                            <span class="text-sm font-semibold text-white/80">Hosts</span>
                        </div>
                    </div>
                </div>
                <ul v-if="statisticStore.showData.users && statisticStore.showData.users.length" class="flex justify-between flex-wrap mt-4">
                    <li v-for="(user, i) in statisticStore.showData.users" :key="i" class="flex gap-x-1 items-center">
                        <div>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 1.3125C3.86395 1.3125 1.3125 3.86395 1.3125 7C1.3125 10.1361 3.86395 12.6875 7 12.6875C10.1361 12.6875 12.6875 10.1361 12.6875 7C12.6875 3.86395 10.1361 1.3125 7 1.3125ZM5.6875 4.8125C5.68851 4.46471 5.82711 4.13146 6.07304 3.88554C6.31896 3.63961 6.65221 3.50101 7 3.5C7.34779 3.50101 7.68104 3.63961 7.92696 3.88554C8.17289 4.13146 8.31149 4.46471 8.3125 4.8125V6.5625C8.31149 6.91029 8.17289 7.24354 7.92696 7.48946C7.68104 7.73539 7.34779 7.87399 7 7.875C6.65221 7.87399 6.31896 7.73539 6.07304 7.48946C5.82711 7.24354 5.68851 6.91029 5.6875 6.5625V4.8125ZM9.625 6.78727C9.625 7.42602 9.32586 8.03441 8.78309 8.50063C8.39955 8.82983 7.93499 9.05055 7.4375 9.13992V9.625H8.3125V10.5H5.6875V9.625H6.5625V9.13992C6.06501 9.05055 5.60045 8.82983 5.21691 8.50063C4.67414 8.03441 4.375 7.42602 4.375 6.78727V5.6957H5.25V6.78727C5.25 7.48891 6.01562 8.3043 7 8.3043C7.80938 8.3043 8.75 7.64176 8.75 6.78727V5.6957H9.625V6.78727Z" fill="#8C8C8C"/>
                            </svg>
                        </div>
                        <span class="text-white/80 text-sm laptop:text-base font-medium">
                            {{ user.name }}
                        </span>
                    </li>
                </ul>
                <div v-else class="flex justify-center items-center">
                    <span class="text-white/80 font-medium">No host found.</span>
                </div>
                </div>

                <div class="bg-[#212121] rounded-[12px] shadow-card-shadow p-4 flex-1">
                    <ul class="grid grid-cols-2 laptop:grid-cols-3 items-center justify-between gap-y-4">
                        <li class="flex items-center gap-x-2">
                            <span class="text-sm text-white/80 font-semibold">
                                {{ statisticStore.showData.totalEpisodeCount }}
                            </span>
                            <span class="text-sm text-white/80">Episodes</span>
                            <div>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.18582 5.7274C6.18582 5.37567 5.96742 5.09044 5.69792 5.09044H4.60592C4.83342 3.63803 5.81832 2.5461 6.99992 2.5461C8.18152 2.5461 9.16642 3.63978 9.39322 5.09219H7.65092C7.38142 5.09219 7.16302 5.37654 7.16302 5.7274C7.16302 6.07913 7.38142 6.36436 7.65092 6.36436H9.44152V7.63653H7.65092C7.38142 7.63653 7.16302 7.92176 7.16302 8.27261C7.16302 8.62434 7.38142 8.90957 7.65092 8.90957H9.39322C9.19862 10.1564 8.44542 11.1381 7.48852 11.3909V13.3639C7.48852 13.7148 7.26942 14 6.99992 14C6.73042 14 6.51132 13.7148 6.51132 13.3639V11.3909C5.55442 11.1372 4.80122 10.1564 4.60732 8.90957H5.69722C5.96742 8.90957 6.18582 8.62434 6.18582 8.27261C6.18582 7.92176 5.96742 7.63653 5.69792 7.63653H4.55762V6.36436H5.69652C5.96672 6.36436 6.18512 6.07913 6.18512 5.72827L6.18582 5.7274Z" fill="white" fill-opacity="0.6"/>
                                    <path d="M7 0C4.669 0 2.7622 2.36323 2.6138 5.35117C2.36107 5.17986 2.0781 5.09023 1.7906 5.09043C0.8015 5.09043 0 6.13512 0 7.42391V9.12131C0 10.4092 0.8015 11.4539 1.7906 11.4539C1.8242 11.4539 1.8578 11.4522 1.8907 11.4504V11.4539C2.8245 11.4539 3.5812 10.4678 3.5812 9.2508V5.72652C3.5812 3.26705 5.1121 1.27305 7 1.27305C8.8879 1.27305 10.4188 3.26705 10.4188 5.72652V9.2508C10.4188 10.467 11.1748 11.4539 12.1093 11.4539V11.4504C12.1422 11.453 12.1758 11.4539 12.2094 11.4539C13.1985 11.4539 14 10.4092 14 9.12043V7.42304C14 6.13512 13.1985 5.09043 12.2094 5.09043C11.9126 5.09043 11.6326 5.18493 11.3862 5.35117C11.2378 2.36323 9.3303 0 7 0Z" fill="white" fill-opacity="0.6"/>
                                </svg>
                            </div>
                        </li>

                        <li class="flex items-center gap-x-2">
                            <span class="text-sm text-white/80 font-semibold">
                                {{ statisticStore.showData.totalTopicsCount }}
                            </span>
                            <span class="text-sm text-white/80">Topics</span>
                            <div>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.24992 2.91666C5.86876 2.91666 6.46225 3.1625 6.89983 3.60008C7.33742 4.03767 7.58325 4.63116 7.58325 5.25C7.58325 5.86884 7.33742 6.46233 6.89983 6.89991C6.46225 7.3375 5.86876 7.58333 5.24992 7.58333C4.63108 7.58333 4.03759 7.3375 3.6 6.89991C3.16242 6.46233 2.91659 5.86884 2.91659 5.25C2.91659 4.63116 3.16242 4.03767 3.6 3.60008C4.03759 3.1625 4.63108 2.91666 5.24992 2.91666ZM5.24992 8.75C6.80742 8.75 9.91658 9.53166 9.91658 11.0833V12.25H0.583252V11.0833C0.583252 9.53166 3.69242 8.75 5.24992 8.75ZM9.77659 3.12666C10.9549 4.41 10.9549 6.18916 9.77659 7.3675L8.79658 6.38166C9.28658 5.69333 9.28658 4.80083 8.79658 4.1125L9.77659 3.12666ZM11.7074 1.16666C13.9999 3.52916 13.9824 7.06416 11.7074 9.33333L10.7566 8.3825C12.3724 6.5275 12.3724 3.87916 10.7566 2.1175L11.7074 1.16666Z" fill="#A6A6A6"/>
                                </svg>
                            </div>
                        </li>

                        <li class="flex items-center gap-x-2">
                            <span class="text-sm text-white/80 font-semibold">
                                {{ statisticStore.showData.download_count}}
                            </span>
                            <span class="text-sm text-white/80">Download</span>
                            <div>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_336_3232)">
                                        <path d="M10.7692 12.25C10.7692 12.092 10.7159 11.9553 10.6094 11.8398C10.5028 11.7244 10.3766 11.6667 10.2308 11.6667C10.0849 11.6667 9.95874 11.7244 9.85217 11.8398C9.7456 11.9553 9.69232 12.092 9.69232 12.25C9.69232 12.408 9.7456 12.5447 9.85217 12.6602C9.95874 12.7756 10.0849 12.8333 10.2308 12.8333C10.3766 12.8333 10.5028 12.7756 10.6094 12.6602C10.7159 12.5447 10.7692 12.408 10.7692 12.25ZM12.923 12.25C12.923 12.092 12.8697 11.9553 12.7632 11.8398C12.6566 11.7244 12.5304 11.6667 12.3846 11.6667C12.2387 11.6667 12.1125 11.7244 12.006 11.8398C11.8994 11.9553 11.8461 12.092 11.8461 12.25C11.8461 12.408 11.8994 12.5447 12.006 12.6602C12.1125 12.7756 12.2387 12.8333 12.3846 12.8333C12.5304 12.8333 12.6566 12.7756 12.7632 12.6602C12.8697 12.5447 12.923 12.408 12.923 12.25ZM13.9999 10.2083V13.125C13.9999 13.3681 13.9214 13.5747 13.7643 13.7448C13.6073 13.9149 13.4166 14 13.1922 14H0.807917C0.583563 14 0.392863 13.9149 0.235815 13.7448C0.0787679 13.5747 0.000244141 13.3681 0.000244141 13.125V10.2083C0.000244141 9.96528 0.0787679 9.75868 0.235815 9.58854C0.392863 9.4184 0.583563 9.33333 0.807917 9.33333H4.72008L5.85587 10.5729C6.18119 10.9132 6.56259 11.0833 7.00008 11.0833C7.43757 11.0833 7.81897 10.9132 8.14428 10.5729L9.28848 9.33333H13.1922C13.4166 9.33333 13.6073 9.4184 13.7643 9.58854C13.9214 9.75868 13.9999 9.96528 13.9999 10.2083ZM11.2656 5.02214C11.3609 5.27127 11.3217 5.48394 11.1478 5.66016L7.37867 9.74349C7.27771 9.85894 7.15152 9.91667 7.00008 9.91667C6.84864 9.91667 6.72244 9.85894 6.62148 9.74349L2.85234 5.66016C2.67847 5.48394 2.6392 5.27127 2.73455 5.02214C2.8299 4.78516 2.99536 4.66667 3.23094 4.66667H5.38473V0.583333C5.38473 0.425347 5.43801 0.288628 5.54458 0.173177C5.65115 0.0577257 5.77735 0 5.92318 0H8.07697C8.2228 0 8.349 0.0577257 8.45557 0.173177C8.56214 0.288628 8.61542 0.425347 8.61542 0.583333V4.66667H10.7692C11.0048 4.66667 11.1702 4.78516 11.2656 5.02214Z" fill="#A6A6A6"/>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_336_3232">
                                        <rect width="14" height="14" fill="white"/>
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                        </li>

                        <li class="flex items-center gap-x-2">
                            <span class="text-sm text-white/80 font-semibold">
                                {{ statisticStore.showData.comment_count}}
                            </span>
                            <span class="text-sm text-white/80">Comments</span>
                            <div>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_336_3238)">
                                    <path d="M4.54999 9.625C7.06343 9.625 9.09999 7.47031 9.09999 4.8125C9.09999 2.15469 7.06343 0 4.54999 0C2.03656 0 -4.73094e-06 2.15469 -4.73094e-06 4.8125C-4.73094e-06 5.86797 0.321558 6.84414 0.866245 7.63984C0.789683 7.89687 0.675933 8.12383 0.55562 8.31523C0.45062 8.48477 0.343433 8.61602 0.264683 8.70625C0.225308 8.75 0.192495 8.78555 0.17062 8.80742C0.159683 8.81836 0.150933 8.82656 0.146558 8.8293L0.142183 8.83477C0.0218703 8.94688 -0.0306297 9.14375 0.0174953 9.32148C0.0656203 9.49922 0.199058 9.625 0.349995 9.625C0.82687 9.625 1.30812 9.47188 1.70843 9.2832C1.90968 9.1875 2.09781 9.08086 2.26187 8.97148C2.93343 9.38711 3.71437 9.625 4.54999 9.625ZM9.79999 4.8125C9.79999 7.8832 7.63218 10.1965 5.06406 10.4727C5.59562 12.507 7.35874 14 9.44999 14C10.2856 14 11.0666 13.7621 11.7403 13.3465C11.9044 13.4559 12.0903 13.5625 12.2916 13.6582C12.6919 13.8469 13.1731 14 13.65 14C13.8009 14 13.9366 13.877 13.9825 13.6965C14.0284 13.516 13.9781 13.3191 13.8556 13.207L13.8512 13.2016C13.8469 13.1961 13.8381 13.1906 13.8272 13.1797C13.8053 13.1578 13.7725 13.125 13.7331 13.0785C13.6544 12.9883 13.5472 12.857 13.4422 12.6875C13.3219 12.4961 13.2081 12.2664 13.1316 12.0121C13.6762 11.2191 13.9978 10.243 13.9978 9.18477C13.9978 6.64727 12.1406 4.56641 9.78468 4.38594C9.79343 4.52539 9.79781 4.66758 9.79781 4.80977L9.79999 4.8125Z" fill="#A6A6A6"/>
                                    </g>
                                    <defs>
                                    <clipPath id="clip0_336_3238">
                                    <rect width="14" height="14" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </div>
                        </li>

                        

                        <li class="flex items-center gap-x-2">
                            <span class="text-sm text-white/80 font-semibold">
                                {{ statisticStore.showData.like_count }}
                            </span>
                            <span class="text-sm text-white/80">Likes</span>
                            <div>
                                <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.5 14L6.485 12.9929C2.88 9.42997 0.5 7.07248 0.5 4.19619C0.5 1.83869 2.194 0 4.35 0C5.568 0 6.737 0.617984 7.5 1.58692C8.263 0.617984 9.432 0 10.65 0C12.806 0 14.5 1.83869 14.5 4.19619C14.5 7.07248 12.12 9.42997 8.515 12.9929L7.5 14Z" fill="#A6A6A6"/>
                                </svg>
                            </div>
                        </li>

                        <li class="flex items-center gap-x-2">
                            <span class="text-sm text-white/80 font-semibold">
                                {{ statisticStore.showData.listen_count }}
                            </span>
                            <span class="text-sm text-white/80">Listen</span>
                            <div>
                                <svg width="14" height="12" viewBox="0 0 14 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2.74596 1.02279C2.83733 1.11445 2.88858 1.23862 2.88846 1.36804C2.88833 1.49746 2.83685 1.62154 2.74531 1.71302C2.18374 2.27187 1.73835 2.93635 1.43482 3.66814C1.13128 4.39994 0.975597 5.18458 0.976748 5.97683C0.975637 6.77814 1.13495 7.57156 1.44528 8.31034C1.75562 9.04911 2.21071 9.71828 2.78372 10.2784C2.83058 10.3231 2.8681 10.3766 2.89409 10.4358C2.92009 10.4951 2.93404 10.559 2.93515 10.6237C2.93625 10.6884 2.92448 10.7527 2.90052 10.8128C2.87656 10.8729 2.84089 10.9277 2.79558 10.9739C2.75027 11.0201 2.69622 11.0569 2.63659 11.082C2.57695 11.1071 2.51291 11.1202 2.44819 11.1204C2.38347 11.1205 2.31936 11.1079 2.25959 11.083C2.19981 11.0582 2.14557 11.0218 2.1 10.9758C1.43423 10.3248 0.90545 9.54707 0.544798 8.68855C0.184146 7.83003 -0.00108711 6.90803 4.79938e-06 5.97683C4.79938e-06 4.04158 0.785958 2.28865 2.05507 1.02214C2.14673 0.93077 2.2709 0.879517 2.40032 0.879639C2.52974 0.879761 2.65447 0.931248 2.74596 1.02279ZM11.3087 1.06967C11.4013 0.979162 11.5259 0.929076 11.6553 0.930419C11.7848 0.931762 11.9084 0.984424 11.999 1.07684C13.2835 2.38408 14.0022 4.14412 14 5.97683C14 7.90688 13.2186 9.6559 11.9547 10.9218C11.8632 11.0135 11.739 11.0651 11.6094 11.0652C11.4798 11.0653 11.3555 11.0139 11.2638 10.9224C11.1721 10.8309 11.1205 10.7067 11.1204 10.5771C11.1203 10.4475 11.1716 10.3232 11.2632 10.2315C11.8221 9.67307 12.2653 9.00976 12.5673 8.27964C12.8694 7.54952 13.0243 6.76696 13.0233 5.97683C13.0255 4.39981 12.4071 2.88524 11.3016 1.76056C11.211 1.66813 11.1608 1.54351 11.162 1.41409C11.1632 1.28467 11.2158 1.16103 11.3081 1.07033L11.3087 1.06967ZM4.59591 3.03879C4.68441 3.13335 4.73172 3.25918 4.72745 3.38862C4.72317 3.51807 4.66766 3.64051 4.57312 3.72902C3.95516 4.30725 3.58075 5.09777 3.58075 5.96511C3.58075 6.84288 3.96428 7.64186 4.59526 8.22204C4.69059 8.30977 4.74716 8.43178 4.75253 8.56122C4.75791 8.69067 4.71164 8.81694 4.62391 8.91227C4.53618 9.0076 4.41417 9.06418 4.28473 9.06955C4.15528 9.07492 4.02901 9.02866 3.93368 8.94093C3.11842 8.19144 2.604 7.13721 2.604 5.96511C2.604 4.8067 3.10605 3.76418 3.90633 3.01535C4.00097 2.92693 4.12686 2.87973 4.2563 2.88413C4.38574 2.88852 4.50813 2.94416 4.59656 3.03879H4.59591ZM9.43665 3.06353C9.52613 2.96997 9.6491 2.91577 9.77853 2.91284C9.90796 2.90991 10.0333 2.95849 10.1269 3.04791C10.9063 3.79349 11.3947 4.82363 11.3947 5.96511C11.3947 7.12093 10.8953 8.16148 10.0989 8.90902C10.0524 8.95418 9.99737 8.98964 9.93704 9.01332C9.8767 9.03701 9.81225 9.04844 9.74745 9.04696C9.68265 9.04548 9.6188 9.03112 9.5596 9.00471C9.50041 8.9783 9.44707 8.94037 9.40268 8.89314C9.3583 8.8459 9.32376 8.7903 9.30108 8.72958C9.27841 8.66886 9.26804 8.60423 9.2706 8.53946C9.27316 8.4747 9.28858 8.41109 9.31597 8.35234C9.34336 8.2936 9.38217 8.24089 9.43014 8.1973C10.0455 7.61972 10.418 6.82986 10.418 5.96511C10.418 5.11014 10.054 4.32939 9.45163 3.75377C9.35816 3.6642 9.30407 3.54118 9.30126 3.41175C9.29846 3.28232 9.34715 3.15707 9.43665 3.06353Z" fill="#A6A6A6"/>
                                    <path d="M8.0784 4.96818C8.66184 5.39665 8.95357 5.61088 8.95357 5.97749C8.95357 6.34344 8.66184 6.55702 8.0784 6.98549C7.92626 7.09819 7.77032 7.2057 7.61087 7.30781C7.48259 7.38921 7.33673 7.47321 7.18566 7.5559C6.60352 7.87497 6.3131 8.03386 6.05199 7.85739C5.79087 7.68158 5.76678 7.31172 5.71989 6.57395C5.70687 6.36558 5.69775 6.16046 5.69775 5.97683C5.69775 5.79321 5.70622 5.58874 5.71989 5.37972C5.76678 4.64195 5.79087 4.27274 6.05199 4.09693C6.31245 3.92046 6.60352 4.07935 7.18501 4.39777C7.33673 4.48046 7.48259 4.56446 7.61087 4.64586C7.75803 4.73898 7.91757 4.85032 8.0784 4.96818Z" fill="#A6A6A6"/>
                                </svg>
                            </div>
                        </li>

                    </ul>
                </div>
        </div>
        <h1 class="mt-4 flex gap-x-4 items-center">
            <div>
                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.2222 0.5H1.77778C0.8 0.5 0 1.3 0 2.27778V14.7222C0 15.7 0.8 16.5 1.77778 16.5H14.2222C15.2 16.5 16 15.7 16 14.7222V2.27778C16 1.3 15.2 0.5 14.2222 0.5ZM5.33333 12.9444H3.55556V6.72222H5.33333V12.9444ZM8.88889 12.9444H7.11111V4.05556H8.88889V12.9444ZM12.4444 12.9444H10.6667V9.38889H12.4444V12.9444Z" fill="#969696"/>
                </svg>
            </div>
            <span class="text-white/80 font-semibold">Temporal statistic</span>
        </h1>

        <div class="flex justify-between">
            <div class="inline-block mt-4">
                <div @click.stop="droptime = !droptime" class="flex items-center bg-[#404040] w-[100px] rounded-full justify-between px-2 py-1 gap-x-2 transition-all" :class="[droptime ? 'rounded-b-[0px] rounded-t-[15px]' : 'rounded-full']">
                    <div class="flex gap-x-1 items-center justify-center overflow-hidden">
                        <span class="text-sm text-white overflow-hidden whitespace-nowrap leading-6" style="text-overflow: ellipsis;">{{ selectedTime }}</span>
                    </div>


                    <div>
                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.63605 5.62381C1.82358 5.42463 2.07788 5.31273 2.34305 5.31273C2.60821 5.31273 2.86252 5.42463 3.05005 5.62381L8.00005 10.8832L12.95 5.62381C13.1387 5.43027 13.3913 5.32318 13.6535 5.3256C13.9156 5.32802 14.1665 5.43976 14.3519 5.63676C14.5373 5.83375 14.6424 6.10024 14.6447 6.37883C14.647 6.65741 14.5462 6.9258 14.364 7.12619L8.70705 13.1368C8.51952 13.3359 8.26521 13.4478 8.00005 13.4478C7.73488 13.4478 7.48058 13.3359 7.29305 13.1368L1.63605 7.12619C1.44858 6.92694 1.34326 6.65674 1.34326 6.375C1.34326 6.09326 1.44858 5.82306 1.63605 5.62381Z" fill="#DDDDDD"/>
                        </svg>
                    </div>
                </div>

                <transition name="slide-down">
                    <div v-if="droptime" class="bg-[#404040] overflow-hidden w-[100px] rounded-b-[15px]">

                        <ul class="transition-all text-center">
                            <li @click.stop="selectedTime = 'weeks'; droptime = !droptime; selectedEach = monthArr[0];" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30 overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">weeks</li>
                            <li @click.stop="selectedTime = 'months'; droptime = !droptime; selectedEach = yearsArr[0];" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30 overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">months</li>
                            <li @click.stop="selectedTime = 'years'; droptime = !droptime;" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30  overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">years</li>
                        </ul>

                    </div>
                </transition>

            </div>

            <div v-if="selectedTime !== 'years'" class="inline-block mt-4 relative">
                <div @click.stop="dropeach = !dropeach" class="flex items-center bg-[#404040] w-[100px] rounded-full justify-between px-2 py-1 gap-x-2 transition-all laptop:cursor-pointer" :class="[dropeach ? 'rounded-b-[0px] rounded-t-[15px]' : 'rounded-full']">
                    <div  class="flex gap-x-1 items-center justify-center overflow-hidden">
                        <span class="text-sm text-white overflow-hidden whitespace-nowrap leading-6" style="text-overflow: ellipsis;">{{ selectedEach }}</span>
                    </div>


                    <div>
                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.63605 5.62381C1.82358 5.42463 2.07788 5.31273 2.34305 5.31273C2.60821 5.31273 2.86252 5.42463 3.05005 5.62381L8.00005 10.8832L12.95 5.62381C13.1387 5.43027 13.3913 5.32318 13.6535 5.3256C13.9156 5.32802 14.1665 5.43976 14.3519 5.63676C14.5373 5.83375 14.6424 6.10024 14.6447 6.37883C14.647 6.65741 14.5462 6.9258 14.364 7.12619L8.70705 13.1368C8.51952 13.3359 8.26521 13.4478 8.00005 13.4478C7.73488 13.4478 7.48058 13.3359 7.29305 13.1368L1.63605 7.12619C1.44858 6.92694 1.34326 6.65674 1.34326 6.375C1.34326 6.09326 1.44858 5.82306 1.63605 5.62381Z" fill="#DDDDDD"/>
                        </svg>
                    </div>
                </div>

                <transition name="slide-down">
                    <div v-if="dropeach" class="bg-[#404040] overflow-hidden w-[100px] absolute overflow-y-scroll max-h-[150px] rounded-b-[15px]">

                        <ul class="transition-all text-center">
                            <li @click.stop="selectedEach = item; dropeach = !dropeach" v-for="(item, i) in selectedTime === 'weeks' ? monthArr : yearsArr" :key="i" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30 overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">{{ item }}</li>
                        </ul>

                    </div>
                </transition>
            </div>
        </div>

        <div class="grid grid-cols-1 laptop:grid-cols-3 gap-4">
            <div>
                <Bar id="my-chart" :options="LikeschatOptions" :data="likesChartData"/>
            </div>

            <div>
                <Bar id="my-chart" :options="DownloadchatOptions" :data="downloadChartData"/>
            </div>

            <div>
                <Bar id="my-chart" :options="CommentschatOptions" :data="commentsChartData"/>                
            </div>
       
            <div>
                <Bar id="my-chart" :options="ListenchatOptions" :data="listenChartData"/>                
            </div>

            <div>
                <Bar id="my-chart" :options="shareChatOptions" :data="shareChartData"/>                
            </div>

        </div>

        <h1 class="mt-4 flex gap-x-4 items-center">
            <div>
                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.21804 0.5V9.28195H16C15.5982 13.3345 12.1784 16.5 8.02005 16.5C3.59058 16.5 0 12.9094 0 8.47995C0 4.32155 3.16551 0.901804 7.21804 0.5ZM8.82205 0.5C10.6626 0.685421 12.3826 1.50124 13.6907 2.80932C14.9988 4.1174 15.8146 5.83736 16 7.67794H8.82205V0.5Z" fill="#969696"/>
                </svg>
            </div>
            <span class="text-white/80 font-semibold">Geo-graphical statistic</span>
        </h1>


        <div class="grid grid-cols-1 laptop:grid-cols-3 gap-4">
            <div>
                <Bar id="my-chart" :options="LikesGeoOptions" :data="likesGeoData"/>
            </div>

            <div>
                <Bar id="my-chart" :options="downloadGeoOptions" :data="downloadGeoData"/>
            </div>

            <div>
                <Bar id="my-chart" :options="CommentsGeoOptions" :data="commentsGeoData"/>                
            </div>
       
            <div>
                <Bar id="my-chart" :options="ListenGeoOptions" :data="listenGeoData"/>                
            </div>

            <div>
                <Bar id="my-chart" :options="shareGeoOptions" :data="shareGeoData"/>                
            </div>

        </div>

        <h1 class="mt-4 flex gap-x-4 items-center">
            <div>
                <svg width="16" height="19" viewBox="0 0 16 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.4071 13.2857C13.1393 12.1679 14.2857 10.2179 14.2857 8C14.2857 4.52857 11.4714 1.71429 8 1.71429C4.52857 1.71429 1.71429 4.52857 1.71429 8C1.71429 10.2179 2.86071 12.1643 4.59286 13.2857C4.63571 13.9036 4.73571 14.6429 4.85 15.325L4.85714 15.3607C2 14.1357 0 11.3036 0 8C0 3.58214 3.58214 0 8 0C12.4179 0 16 3.58214 16 8C16 11.3036 14 14.1393 11.1429 15.3607L11.15 15.3214C11.2607 14.6357 11.3643 13.9 11.4071 13.2857ZM11.325 11.925C11.2679 11.7214 11.1857 11.5286 11.075 11.3464C10.8679 11 10.5929 10.7393 10.2929 10.5464C10.9893 9.91786 11.4286 9.01071 11.4286 8C11.4286 6.10714 9.89286 4.57143 8 4.57143C6.10714 4.57143 4.57143 6.10714 4.57143 8C4.57143 9.01071 5.01071 9.92143 5.70714 10.5464C5.40714 10.7393 5.13214 11 4.925 11.3464C4.81429 11.5286 4.73214 11.7214 4.675 11.925C3.56429 10.9821 2.85714 9.57143 2.85714 8C2.85714 5.16071 5.16071 2.85714 8 2.85714C10.8393 2.85714 13.1429 5.16071 13.1429 8C13.1429 9.57143 12.4357 10.9821 11.325 11.925ZM8 11.1429C9.175 11.1429 10.2857 11.45 10.2857 12.7071C10.2857 13.8857 9.825 16.425 9.55 17.4536C9.36786 18.1321 8.675 18.2893 8 18.2893C7.325 18.2893 6.63571 18.1321 6.45 17.4536C6.17143 16.4357 5.71429 13.8929 5.71429 12.7107C5.71429 11.4571 6.825 11.1464 8 11.1464V11.1429ZM8 6C8.53043 6 9.03914 6.21071 9.41421 6.58579C9.78929 6.96086 10 7.46957 10 8C10 8.53043 9.78929 9.03914 9.41421 9.41421C9.03914 9.78929 8.53043 10 8 10C7.46957 10 6.96086 9.78929 6.58579 9.41421C6.21071 9.03914 6 8.53043 6 8C6 7.46957 6.21071 6.96086 6.58579 6.58579C6.96086 6.21071 7.46957 6 8 6Z" fill="#969696"/>
                </svg>
            </div>

            <span class="text-white/80 font-semibold">Episodes</span>
        </h1>

        <div v-if="statisticStore.showData.episodes && statisticStore.showData.episodes.length">
            <EpiStatisticComponent :episodes="statisticStore.showData.episodes" :show="selectedShow"/>
        </div>

        <div v-else class="h-[150px] flex justify-center items-center">
            <span class="text-white/80 font-medium">No episode was found for selected Show.</span>
        </div>



    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { Bar } from 'vue-chartjs';
import { useStatisticStore } from '../stores/statisticStore';
import { useShowsStore } from '../stores/ShowsStore';
import  EpiStatisticComponent  from '../components/EpiStatisticComponent.vue';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const statisticStore = useStatisticStore();
const showStore = useShowsStore();

const drop = ref(false);
const selectedShow = ref({
    title : '',
    id : ''
});

const droptime = ref(false);
const selectedTime = ref('weeks');
const selectedEach = ref('January');

const dropeach = ref(false);

const monthArr = ref([
    'January',
    'February',
    'March',
    'April', 
    'May', 
    'June', 
    'July', 
    'August', 
    'September', 
    'October', 
    'November', 
    'December'
])


const yearsArr = ref([
        '2020',
        '2021',
        '2022',
        '2023',
        '2024'
]);

function getDataByWeek() {

    statisticStore.getDataByWeek(selectedEach.value, 0, selectedShow.value.id);
}

function getDataByMonths() {

    statisticStore.getDataByMonth(selectedEach.value, 0, selectedShow.value.id);
}

function getDataByYears() {

    statisticStore.getDataByYear(0, selectedShow.value.id);
}

async function getDataByGeo() {
    await statisticStore.getDataByGeo(0, selectedShow.value.id);
}

async function getShowData() {
    await statisticStore.getShowData(selectedShow.value.id);
}

onMounted(async () => {

    if (!showStore.shows.length) {
        await showStore.fetchShows().then(res => {
            return res;
        }).catch(error => {
            console.log('error: ', error.message);

        });
    }

    if (showStore.shows.length) {
        selectedShow.value.title = showStore.shows[0].title;
        selectedShow.value.id = showStore.shows[0].id;
        getDataByWeek();
    }

    await getShowData();
    await getDataByGeo();

    yearsArr.value = statisticStore.showData.years;

})


// eslint-disable-next-line no-unused-vars
watch(selectedEach, (newVal) => {
    
    if (selectedTime.value === 'weeks') {

        getDataByWeek();

    } else if (selectedTime.value === 'months') {

        getDataByMonths();
        
    }

});


// eslint-disable-next-line no-unused-vars
watch(selectedTime, async (newVal) => {
    if (selectedTime.value === 'years') {
         getDataByYears();

    }
});

async function updateData () {
    getShowData();
    selectedTime.value = 'weeks';
    selectedEach.value = 'January';
}

const getLikeTitle = computed(() => {

    let retStr = 'No data available';

    if (selectedTime.value === 'weeks') {
        retStr =  `Weekly likes rate for ${selectedEach.value}`;
    } else if (selectedTime.value === 'months') {
        retStr = `Monthly likes rate for ${selectedEach.value}`
    } else if (selectedTime.value === 'years') {
        retStr = `Yearly likes rate`;
    }

    return retStr;
})

const getDownloadTitle = computed(() => {

let retStr = 'No data available';

    if (selectedTime.value === 'weeks') {
        retStr =  `Weekly download rate for ${selectedEach.value}`;
    } else if (selectedTime.value === 'months') {
        retStr = `Monthly download rate for ${selectedEach.value}`
    } else if (selectedTime.value === 'years') {
        retStr = `Yearly download rate`;
    }
    return retStr;
})

const getCommentsTitle = computed(() => {

let retStr = 'No data available';

    if (selectedTime.value === 'weeks') {
        retStr =  `Weekly comments rate for ${selectedEach.value}`;
    } else if (selectedTime.value === 'months') {
        retStr = `Monthly comments rate for ${selectedEach.value}`
    } else if (selectedTime.value === 'years') {
        retStr = `Yearly comments rate`;
    }
    return retStr;
})

const getListenTitle = computed(() => {

let retStr = 'No data available';

    if (selectedTime.value === 'weeks') {
        retStr =  `Weekly listen rate for ${selectedEach.value}`;
    } else if (selectedTime.value === 'months') {
        retStr = `Monthly listen rate for ${selectedEach.value}`
    } else if (selectedTime.value === 'years') {
        retStr = `Yearly listen rate`;
    }

    return retStr;
})


const getShareTitle = computed(() => {

let retStr = 'No data available';

    if (selectedTime.value === 'weeks') {
        retStr =  `Weekly share rate for ${selectedEach.value}`;
    } else if (selectedTime.value === 'months') {
        retStr = `Monthly share rate for ${selectedEach.value}`
    } else if (selectedTime.value === 'years') {
        retStr = `Yearly share rate`;
    }

    return retStr;
})


const likesChartData = computed(() => {
    let chartdataret = {};
    if (statisticStore.likeTotalTemData.data && statisticStore.likeTotalTemData.labels.length) {
        chartdataret = {
            labels : statisticStore.likeTotalTemData.labels,
            datasets : [{
                label : 'Likes',
                backgroundColor : '#f87979', 
                data  : statisticStore.likeTotalTemData.data
            }]
        };
    } else {
        chartdataret = {
            labels : statisticStore.likeTotalTemData.labels,
            datasets : [{
                label : 'Likes',
                backgroundColor : '#f87979', 
                data  : []
            }]
        };
    }
    
    return chartdataret;
});

const likesGeoData = computed(() => {
    let chartdatare = {};
    if(statisticStore.likeTotalGeoData.data && statisticStore.likeTotalGeoData.labels.length) {
        chartdatare = {
            labels : statisticStore.likeTotalGeoData.labels,
            datasets : [{
                label : 'Likes',
                backgroundColor : '#8CBAFF', 
                data  : statisticStore.likeTotalGeoData.data
            }]
        };
    } else {
        chartdatare = {
            labels : [],
            datasets : [{
                label : 'Likes',
                backgroundColor : '#8CBAFF', 
                data  : []
            }]
        };
    }
    

    return chartdatare;
});

const downloadChartData = computed(() => {
    let chartdataret = {};

    if (statisticStore.downloadTotalTemData.data && statisticStore.downloadTotalTemData.data.length) {
        chartdataret = {
            labels : statisticStore.downloadTotalTemData.labels,
            datasets : [{
                label : 'Download',
                backgroundColor : '#F2F879', 
                data  : statisticStore.downloadTotalTemData.data
            }]
        };
    } else {
        chartdataret = {
            labels : statisticStore.downloadTotalTemData.labels,
            datasets : [{
                label : 'Download',
                backgroundColor : '#F2F879', 
                data  : []
            }]
        };
    }
    


    return chartdataret;
});

const downloadGeoData = computed(() => {
    let chartdatare = {};
    if(statisticStore.downloadTotalGeoData.data && statisticStore.downloadTotalGeoData.labels.length) {
        chartdatare = {
            labels : statisticStore.downloadTotalGeoData.labels,
            datasets : [{
                label : 'Download',
                backgroundColor : '#8CFFC8', 
                data  : statisticStore.downloadTotalGeoData.data
            }]
        };
    } else {
        chartdatare = {
            labels : [],
            datasets : [{
                label : 'Download',
                backgroundColor : '#8CFFC8', 
                data  : []
            }]
        };
    }
    

    return chartdatare;
});

const commentsChartData = computed(() => {

    let chartdataret = {};

    if (statisticStore.commentsTotalTemData.data && statisticStore.commentsTotalTemData.data.length) {
        chartdataret = {
            labels : statisticStore.commentsTotalTemData.labels,
            datasets : [{
                label : 'Comments',
                backgroundColor : '#83F879', 
                data  : statisticStore.commentsTotalTemData.data
            }]
        };
    } else {
        chartdataret = {
            labels : statisticStore.commentsTotalTemData.labels,
            datasets : [{
                label : 'Comments',
                backgroundColor : '#83F879', 
                data  : []
            }]
        };
    }

    return chartdataret;
});


const commentsGeoData = computed(() => {
    let chartdatare = {};
    if(statisticStore.commentsTotalGeoData.data && statisticStore.commentsTotalGeoData.labels.length) {
        chartdatare = {
            labels : statisticStore.commentsTotalGeoData.labels,
            datasets : [{
                label : 'Comments',
                backgroundColor : '#A3FF8C', 
                data  : statisticStore.commentsTotalGeoData.data
            }]
        };
    } else {
        chartdatare = {
            labels : [],
            datasets : [{
                label : 'Comments',
                backgroundColor : '#A3FF8C', 
                data  : []
            }]
        };
    }
    

    return chartdatare;
});


const listenChartData = computed(() => {
    let chartdataret = {};

    if (statisticStore.listenTotalTemData.data && statisticStore.listenTotalTemData.data.length) {
    
        chartdataret = {
            labels : statisticStore.listenTotalTemData.labels,
            datasets : [{
                label : 'Listen',
                backgroundColor : '#79F8F8', 
                data  : statisticStore.listenTotalTemData.data
            }]
        };

    } else {

        chartdataret = {
            labels : statisticStore.listenTotalTemData.labels,
            datasets : [{
                label : 'Listen',
                backgroundColor : '#79F8F8', 
                data  : []
            }]
        };

    }

    return chartdataret;

});

const listenGeoData = computed(() => {

    let chartdatare = {};
    if(statisticStore.listenTotalGeoData.data && statisticStore.listenTotalGeoData.labels.length) {
        chartdatare = {
            labels : statisticStore.listenTotalGeoData.labels,
            datasets : [{
                label : 'Listen',
                backgroundColor : '#FF8C8C', 
                data  : statisticStore.listenTotalGeoData.data
            }]
        };
    } else {
        chartdatare = {
            labels : [],
            datasets : [{
                label : 'Listen',
                backgroundColor : '#FF8C8C', 
                data  : []
            }]
        };
    }
    

    return chartdatare;
});

const shareChartData = computed(() => {
    
    let chartdataret = {};

    if (statisticStore.shareTotalTemData.data && statisticStore.shareTotalTemData.data.length) {

        chartdataret = {
            labels : statisticStore.shareTotalTemData.labels,
            datasets : [{
                label : 'Share',
                backgroundColor : '#F879EB', 
                data  : statisticStore.shareTotalTemData.data
            }]
        };

    } else {

        chartdataret = {
            labels : statisticStore.shareTotalTemData.labels,
            datasets : [{
                label : 'Share',
                backgroundColor : '#F879EB', 
                data  : []
            }]
        };

    }

    return chartdataret;
});


const shareGeoData = computed(() => {
    
    let chartdatare = {};
    if(statisticStore.shareTotalGeoData.data && statisticStore.shareTotalGeoData.labels.length) {
        chartdatare = {
            labels : statisticStore.shareTotalGeoData.labels,
            datasets : [{
                label : 'Share',
                backgroundColor : '#F7FF8C', 
                data  : statisticStore.shareTotalGeoData.data
            }]
        };
    } else {
        chartdatare = {
            labels : [],
            datasets : [{
                label : 'Share',
                backgroundColor : '#F7FF8C', 
                data  : []
            }]
        };
    }
    

    return chartdatare;
});

// 
const LikeschatOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: getLikeTitle.value,
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

const LikesGeoOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: 'Like user geo-graphical distribution',
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

const DownloadchatOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: getDownloadTitle.value,
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

const downloadGeoOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: 'Download users geo-graphical distribution',
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

// 

const CommentschatOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: getCommentsTitle.value,
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

const CommentsGeoOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: 'Comments users geo-graphical distribution',
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

// 

const ListenchatOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: getListenTitle.value,
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

const ListenGeoOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: 'Geo-graphical representation of listener',
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

const shareChatOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: getShareTitle.value,
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

const shareGeoOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: 'Geo-graphical representation of sharer',
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 


</script>

<style>
</style>