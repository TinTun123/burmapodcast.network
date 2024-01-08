<template>
    <div class="laptop:ml-4 laptop:h-auto  laptop:w-[15%] h-[100vh]">

        <div class="flex justify-center items-center cursor-pointer">
            <router-link :class="route.name === 'home' ? '' : ''" :to="{name : 'home'}">
                <svg width="106" height="106" viewBox="0 0 106 106" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_330_2643)">
                    <path d="M105.565 70.2782C105.471 90.0125 87.1096 105.81 65.0015 105.81H11.941C5.34535 105.81 0 101.036 0 95.1521V11.8827C0 5.32047 5.9579 0 13.3099 0H40.8777C57.7354 0 71.4162 12.313 70.6879 27.3477C70.5678 29.8722 70.0457 32.3028 69.1766 34.5864C70.9267 34.7227 72.6443 34.961 74.3246 35.2999C92.2563 38.8611 105.647 53.1796 105.565 70.2782Z" fill="#E84344"/>
                    <path d="M18.6151 51.275C17.8038 48.5134 15.5494 46.4297 12.7921 45.5945C11.4677 45.1933 10.0928 46.0803 10.0928 47.3286V51.7277C10.0928 52.7365 11.0094 53.5546 12.1396 53.5546H16.6276C17.964 53.5533 18.9533 52.4267 18.6151 51.275Z" fill="#F7F2EB"/>
                    <path d="M47.2002 54.0335C45.9113 54.0335 44.8627 53.1028 44.8583 51.9511C44.8227 43.9207 41.3016 36.3722 34.9433 30.697C28.5834 25.0203 20.1249 21.8776 11.128 21.8459C9.83463 21.8418 8.79048 20.9019 8.79494 19.7475C8.79938 18.5958 9.84798 17.6651 11.1369 17.6651C11.1398 17.6651 11.1428 17.6651 11.1458 17.6651C21.3871 17.7009 31.0158 21.2792 38.2551 27.7408C45.4931 34.2011 49.502 42.7941 49.5435 51.9338C49.548 53.0882 48.5039 54.0281 47.2106 54.0335C47.2061 54.0335 47.2031 54.0335 47.2002 54.0335Z" fill="#F7F2EB"/>
                    <path d="M56.6764 54.032C55.3861 54.032 54.339 53.1 54.3345 51.9482C54.2975 41.6595 49.7901 31.9889 41.643 24.7184C33.499 17.4493 22.6674 13.4261 11.1446 13.3904C9.85126 13.3864 8.80562 12.4478 8.81007 11.2921C8.81452 10.1403 9.86164 9.20839 11.152 9.20839C11.155 9.20839 11.1579 9.20839 11.1609 9.20839C23.9281 9.24808 35.9298 13.7054 44.9549 21.761C53.983 29.8191 58.9768 40.5342 59.0184 51.9337C59.0228 53.088 57.9772 54.028 56.6839 54.0306C56.6809 54.032 56.6764 54.032 56.6764 54.032Z" fill="#F7F2EB"/>
                    <path d="M37.0481 54.0361C35.7608 54.0361 34.7136 53.1081 34.7062 51.9564C34.672 46.3447 32.2071 41.0706 27.7635 37.1056C23.3155 33.1355 17.4006 30.9353 11.1074 30.9088C9.81412 30.9035 8.76997 29.9636 8.7759 28.8078C8.78184 27.6561 9.82896 26.7268 11.1178 26.7268C11.1223 26.7268 11.1253 26.7268 11.1297 26.7268C18.6657 26.7586 25.7493 29.3944 31.0754 34.1482C36.397 38.8968 39.3485 45.2142 39.39 51.9339C39.3975 53.0883 38.3533 54.0295 37.06 54.0361C37.057 54.0361 37.0526 54.0361 37.0481 54.0361Z" fill="#F7F2EB"/>
                    <path d="M26.8975 54.0375C25.6131 54.0375 24.5675 53.1135 24.5556 51.9657C24.5245 48.7712 23.114 45.7689 20.5866 43.513C18.0503 41.2493 14.6777 39.9917 11.0884 39.9691C9.79505 39.9612 8.75238 39.0186 8.76129 37.8642C8.77018 36.7152 9.8173 35.7872 11.1032 35.7872C11.1091 35.7872 11.1136 35.7872 11.1195 35.7872C15.9488 35.8163 20.4873 37.5094 23.8986 40.5556C27.3009 43.5925 29.1979 47.6314 29.2394 51.9286C29.2513 53.083 28.2116 54.0269 26.9183 54.0375C26.9109 54.0375 26.9034 54.0375 26.8975 54.0375Z" fill="#F7F2EB"/>
                    <path d="M8.98486 58.0808H13.421C15.2171 58.0808 16.4319 58.5998 16.4319 60.1672C16.4319 61.0157 15.9958 61.5585 15.1504 61.9239C16.3117 62.2178 16.8798 63.0082 16.8798 64.0565C16.8798 65.7656 15.2557 66.4964 13.553 66.4964H8.98486V58.0808ZM11.0584 61.487H13.157C13.8971 61.487 14.4251 61.1932 14.4251 60.4849C14.4251 59.6959 13.7384 59.5185 12.9998 59.5185H11.0584V61.487ZM11.0584 65.0574H13.2772C14.0826 65.0574 14.8093 64.8218 14.8093 63.9493C14.8093 63.0889 14.2145 62.7473 13.3172 62.7473H11.0599V65.0574H11.0584Z" fill="#F7F2EB"/>
                    <path d="M26.2834 63.3139C26.2834 65.5883 24.778 66.6963 22.2566 66.6963C19.7085 66.6963 18.2432 65.6121 18.2432 63.3139V58.0808H20.3166V63.3139C20.3166 64.2327 20.5806 65.1408 22.2581 65.1408C23.7368 65.1408 24.2115 64.5755 24.2115 63.3139V58.0808H26.2849V63.3139H26.2834Z" fill="#F7F2EB"/>
                    <path d="M33.4145 63.384L36.0546 66.507H33.5198L31.1438 63.4781H30.1278V66.507H28.041V58.0808H32.2933C34.6693 58.0808 35.5815 59.4125 35.5815 60.7801C35.5815 61.9239 34.9081 63.0783 33.3374 63.384H33.4145ZM30.1263 59.5185V62.0523H31.737C32.7279 62.0523 33.5466 61.8524 33.5466 60.7801C33.5466 59.684 32.7279 59.5185 31.737 59.5185H30.1263Z" fill="#F7F2EB"/>
                    <path d="M37.7974 58.0808H40.4908L42.6696 61.7928L44.8083 58.0808H47.5417V66.4951H45.6003V60.5431H45.5736L43.4764 64.3743H41.8791L39.7922 60.6027H39.7655V66.4951H37.7974V58.0808Z" fill="#F7F2EB"/>
                    <path d="M48.6523 66.4949L52.9299 58.0925H55.0167L59.2289 66.4949H57.2221L56.2981 64.6323H51.5312L50.5404 66.4949H48.6523ZM53.9992 59.6718L52.4151 62.9245H55.5447L54.0126 59.6718H53.9992Z" fill="#F7F2EB"/>
                    <path d="M8.98486 72.2246H13.2371C15.6013 72.2246 16.4987 73.5564 16.4987 74.9239C16.4987 76.2914 15.6013 77.6232 13.2371 77.6232H11.0584V80.6403H8.98486V72.2246ZM11.0584 76.1842H12.6691C13.6198 76.1842 14.4904 75.9963 14.4904 74.9226C14.4904 73.849 13.6183 73.661 12.6691 73.661H11.0584V76.1842Z" fill="#F7F2EB"/>
                    <path d="M21.9909 80.7442C19.2974 80.7442 17.1187 78.7995 17.1187 76.3954C17.1187 73.9794 19.2974 72.0347 21.9909 72.0347C24.6709 72.0347 26.8764 73.9794 26.8764 76.3954C26.8764 78.7995 24.6724 80.7442 21.9909 80.7442ZM19.1135 76.3954C19.1135 77.7974 20.4202 78.9649 21.9923 78.9649C23.563 78.9649 24.8445 77.7987 24.8445 76.3954C24.8445 74.9935 23.563 73.814 21.9923 73.814C20.4202 73.814 19.1135 74.9935 19.1135 76.3954Z" fill="#F7F2EB"/>
                    <path d="M28.0791 72.2246H32.146C34.5888 72.2246 36.4235 73.6041 36.4235 76.3842C36.4235 78.8239 35.0234 80.6389 32.146 80.6389H28.0791V72.2246ZM30.1526 79.0834H32.0006C33.202 79.0834 34.3514 78.4229 34.3514 76.5615C34.3514 74.8644 33.6781 73.7802 31.6313 73.7802H30.1526V79.0834Z" fill="#F7F2EB"/>
                    <path d="M42.2212 80.6622C39.5811 80.6622 37.4409 78.7532 37.4409 76.3955C37.4409 74.0615 39.5796 72.1288 42.2212 72.1288C44.0307 72.1288 45.5613 73.0237 46.3666 74.3091C45.5613 74.6864 45.4945 74.7222 44.5972 75.11C44.1345 74.3912 43.2371 73.8961 42.2212 73.8961C40.6757 73.8961 39.4224 75.028 39.4224 76.3942C39.4224 77.7736 40.6772 78.8922 42.2212 78.8922C43.2773 78.8922 44.2012 78.3852 44.6773 77.5843C45.5747 77.9973 45.6013 78.0436 46.4468 78.3852C45.6414 79.7421 44.0826 80.6622 42.2212 80.6622Z" fill="#F7F2EB"/>
                    <path d="M46.8296 80.6387L51.107 72.2363H53.1939L57.406 80.6387H55.3993L54.4753 78.7761H49.7084L48.7176 80.6387H46.8296ZM52.1778 73.8143L50.5939 77.067H53.7234L52.1912 73.8143H52.1778Z" fill="#F7F2EB"/>
                    <path d="M59.7968 78.1404C60.0074 79.2485 61.1168 79.4007 61.8836 79.4007C62.6103 79.4007 63.7183 79.2128 63.7183 78.3522C63.7183 76.5611 58.1074 77.7155 58.1074 74.5688C58.1074 72.8358 59.9287 72.023 61.633 72.023C63.5996 72.023 65.4091 72.7896 65.4091 74.7342L63.4024 74.4748C63.1517 73.4964 62.1876 73.4607 61.5409 73.4607C60.881 73.4607 60.1157 73.7082 60.1157 74.4151C60.1157 75.04 60.565 75.1816 62.9277 75.6887C63.6278 75.8423 65.7264 76.2301 65.7264 78.1404C65.7264 79.684 64.3798 80.8397 61.8049 80.8397C59.693 80.8397 57.7915 79.921 57.7915 77.8466L59.7968 78.1404Z" fill="#F7F2EB"/>
                    <path d="M69.3441 73.78H66.3467V72.2363H74.3884V73.7918H71.4176V80.6387H69.3441V73.78Z" fill="#F7F2EB"/>
                    <path d="M10.6092 88.972V94.7944H8.7998V86.3442H11.1758L15.3881 91.6011V86.3442H17.1441V94.7944H15.3881L10.6092 88.972Z" fill="#F7F2EB"/>
                    <path d="M20.539 93.2146H25.8606V94.7705H18.5322V86.332H25.4112V87.8875H20.539V89.7846H24.8432V91.4221H20.539V93.2146Z" fill="#F7F2EB"/>
                    <path d="M29.7436 87.9224H26.7461V86.3788H34.7878V87.9344H31.8171V94.7815H29.7436V87.9224Z" fill="#F7F2EB"/>
                    <path d="M44.9548 94.7824H42.8946L41.2973 89.0541H41.2705L39.6999 94.7824H37.5997L35.1035 86.368H37.177L38.5104 92.1187L38.6957 92.0949L40.3332 86.3667H42.2747L43.8854 92.1651L44.0708 92.1767L45.4575 86.3667H47.491L44.9548 94.7824Z" fill="#F7F2EB"/>
                    <path d="M52.6008 94.8884C49.9073 94.8884 47.7285 92.9436 47.7285 90.5397C47.7285 88.1237 49.9073 86.179 52.6008 86.179C55.2809 86.179 57.4863 88.1237 57.4863 90.5397C57.4863 92.9436 55.2809 94.8884 52.6008 94.8884ZM49.7219 90.5397C49.7219 91.9416 51.0286 93.1095 52.6008 93.1095C54.1714 93.1095 55.4528 91.9429 55.4528 90.5397C55.4528 89.1364 54.1714 87.9582 52.6008 87.9582C51.0286 87.9582 49.7219 89.1378 49.7219 90.5397Z" fill="#F7F2EB"/>
                    <path d="M64.061 91.6699L66.7011 94.7926H64.1663L61.7903 91.7639H60.7743V94.7926H58.6875V86.3667H62.9398C65.3158 86.3667 66.228 87.6985 66.228 89.066C66.228 90.2098 65.5546 91.3642 63.9839 91.6699H64.061ZM60.7743 87.8044V90.3382H62.385C63.3758 90.3382 64.1945 90.1382 64.1945 89.066C64.1945 87.9699 63.3758 87.8044 62.385 87.8044H60.7743Z" fill="#F7F2EB"/>
                    <path d="M76.5272 94.7824H73.6751L71.219 92.4265L69.9909 93.9455V94.7824H67.8789V86.3564H69.9909V91.1287L73.6751 86.3564H76.2499L72.6976 91.1287L76.5272 94.7824Z" fill="#F7F2EB"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_330_2643">
                    <rect width="106" height="106" fill="white"/>
                    </clipPath>
                    </defs>
                </svg>
            </router-link>
        </div>

        <div class="bg-[#121212] laptop:rounded-[10px] laptop:mt-4 overflow-hidden shadow-card-shadow">
            <div class="flex flex-col gap-y-2 laptop:gap-y-0 text-center">

                    <!-- <div class="">
                        <svg width="16" height="15" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.707 0.293031C11.5194 0.105559 11.2651 0.000244141 11 0.000244141C10.7348 0.000244141 10.4805 0.105559 10.293 0.293031L3.29296 7.29303L1.29296 9.29303C1.19745 9.38528 1.12127 9.49562 1.06886 9.61763C1.01645 9.73963 0.988862 9.87085 0.987709 10.0036C0.986555 10.1364 1.01186 10.2681 1.06214 10.391C1.11242 10.5139 1.18667 10.6255 1.28056 10.7194C1.37446 10.8133 1.48611 10.8876 1.60901 10.9379C1.7319 10.9881 1.86358 11.0134 1.99636 11.0123C2.12914 11.0111 2.26036 10.9835 2.38236 10.9311C2.50437 10.8787 2.61471 10.8025 2.70696 10.707L2.99996 10.414V17C2.99996 17.7957 3.31603 18.5587 3.87864 19.1214C4.44125 19.684 5.20431 20 5.99996 20H16C16.7956 20 17.5587 19.684 18.1213 19.1214C18.6839 18.5587 19 17.7957 19 17V10.414L19.293 10.707C19.4816 10.8892 19.7342 10.99 19.9964 10.9877C20.2586 10.9854 20.5094 10.8803 20.6948 10.6948C20.8802 10.5094 20.9854 10.2586 20.9876 9.99643C20.9899 9.73423 20.8891 9.48163 20.707 9.29303L11.707 0.293031Z" fill="#CCCCCC"/>
                        </svg>
                    </div>
                    <span class="font-semibold text-white text-base">
                        Home
                    </span> -->


                <span @click="openSearch" class="p-2 pt-3 text-white/80 text-base hover:text-white active:text-white/40 active:bg-[#282828]/20 font-semibold cursor-pointer transition">
                    Search
                </span>

                
                <span @click.stop="routeToSAudiencehows" :class="[route.name === 'audienceShows' || route.name === 'show' ?  'bg-white/5' : '']" class="p-2 text-white/80 font-semibold text-base hover:text-white active:text-white/40 active:bg-[#282828]/20 cursor-pointer transition">
                    Shows
                </span>

                <span @click="routeToForum()" :class="[route.name === 'audienceforums' || route.name === 'audienceforum' ? 'bg-white/5' : '']" class="p-2 text-white/80 font-semibold text-base hover:text-white active:text-white/40 active:bg-[#282828]/20 cursor-pointer transition">
                    Let's talk
                </span>
                

                
            </div>
        </div>

        <div class="bg-[#121212] laptop:rounded-[10px] laptop:mt-4 overflow-hidden shadow-card-shadow">
            <div class="flex flex-col text-center">

                <!-- <span @click="routeToplaylist" :class="[route.name === 'playList' || route.name === 'playList' ? 'bg-white/20' : '']" class="p-2 text-white/80 text-base hover:bg-white/20 active:text-white/40 font-semibold active:bg-[#282828]/20 cursor-pointer transition">
                    Playlist
                </span> -->

                <span @click="routeTofavorite" :class="[route.name === 'myFavorite' || route.name === 'myFavorite' ? 'bg-white/5' : '']" class="p-2 text-white/80 text-base hover:text-white active:text-white/40 font-semibold active:bg-[#282828]/20 cursor-pointer transition">
                    Library
                </span>

                <router-link :class="route.name === 'about' ? 'bg-white/5' : ''" class="p-2 pt-3 text-white/80 text-base hover:text-white active:text-white/40 active:bg-[#282828]/20 cursor-pointer transition flex gap-x-2 items-center justify-center" :to="{name : 'about'}">
                    <span class="font-semibold text-base">
                        About us
                    </span>
                </router-link>
             
                
            </div>
        </div>

        <div v-if="(userStore.isAdmin || userStore.isHost || userStore.iscoHost) && userStore.token" class="bg-[#121212]  laptop:rounded-[10px] laptop:mt-4 overflow-hidden">
            <div class="flex flex-col gap-y-2 laptop:gap-y-0 text-center">

                <span :class="[route.name === 'Adminforum' || route.name === 'forumShow' ? 'bg-white/5' : '']" @click="routeToAdminForum()" class="p-2 text-white/80 text-base font-semibold hover:text-white active:text-white/40 active:bg-[#282828]/20 cursor-pointer transition">
                    forums
                </span>

                <span :class="[route.name === 'adminManageHosts' ? 'bg-white/5' : '']" @click.stop="routeToAdminHost"  class="p-2 text-white/80 text-base hover:text-white/80 font-semibold active:text-white/40 active:bg-[#282828]/20 cursor-pointer transition">
                    Hosts
                </span>
                
                <span :class="[route.name === 'adminManageShows' || route.name === 'adminShow' ? 'bg-white/5' : '']" @click.stop="routeToManageShows" class="p-2 pt-3 text-white/80 font-semibold text-base hover:text-white active:text-white/40 active:bg-[#282828]/20 cursor-pointer transition">
                    Manage shows
                </span>

                <span :class="[route.name === 'showStatic' || route.name === 'showStatic' ? 'bg-white/5' : '']" @click.stop="routeToAdminStatic" class="p-2 pt-3 text-white/80 font-semibold text-base hover:text-white active:text-white/40 active:bg-[#282828]/20 cursor-pointer transition">
                    Shows Statistic
                </span>
                
            </div>
        </div>
    </div>
</template>

<script setup>
import { useRoute, useRouter } from 'vue-router';
import { useUserStore } from '../stores/userStore';
import { useSearchStore } from '../stores/searchStore';

const userStore = useUserStore();
const router = useRouter();
const route = useRoute();
const searchStore = useSearchStore();

function openSearch() {
    searchStore.openSearch = true;
}

function routeToForum() {
    router.push({
        name : 'audienceforums'
    });
}

function routeToAdminForum() {
    router.push({
        name : 'Adminforum'
    });
}

function routeToSAudiencehows() {
    router.push({
        name : 'audienceShows'
    })
}

function routeToManageShows() {
    router.push({
        name : 'adminManageShows'
    });
}

function routeToAdminHost () {
    router.push({
        name : 'adminManageHosts'
    });
}

function routeToAdminStatic () {
    router.push({
        name : 'showStatic'
    });
}

function routeTofavorite() {
    router.push({
        name : 'myFavorite',
    });
}

// function routeToplaylist() {
//     router.push({
//         name : 'playList'
//     });
// }

</script>

<style>
</style>