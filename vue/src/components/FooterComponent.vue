<template>
    <div class="bg-transparent px-4 border-t border-white/20 py-4">
        <div class="flex flex-col justify-center gap-y-2">
          <div class="flex justify-between lg-tablet:justify-around items-center laptop:justify-evenly">
            
            <div class="flex flex-col justify-center gap-y-2">
              <span v-if="!userStore.token" @click="open = true" class="text-white cursor-pointer text-sm active:text-white/60 hover:text-white/80">
                Login
              </span>

              <span v-else @click="userStore.logout(); router.push({name : 'home'})"  class="text-white text-sm cursor-pointer active:text-white/60 hover:text-white/80">
                Logout
              </span>

              <span v-if="userStore.user_level === 3 && userStore.token" class="text-white text-sm cursor-pointer active:text-white/60 hover:text-white/80">
                Admin
              </span>

              <span v-if="userStore.user_level === 2 && userStore.token" class="text-white text-sm cursor-pointer active:text-white/60 hover:text-white/80">
                Host
              </span>

              <span v-if="userStore.user_level === 1 && userStore.token" class="text-white text-sm cursor-pointer active:text-white/60 hover:text-white/80">
                Co-Host
              </span>
              
            </div>

            <div class="flex flex-col justify-center gap-y-2">

              <router-link :to="{name : 'about'}">

                <span  class="text-white text-sm cursor-pointer active:text-white/60 hover:text-white/80">
                  About us
                </span>

              </router-link>



              <span class="text-white text-sm cursor-pointer active:text-white/60 hover:text-white/80">
                Contact
              </span>

              <span class="text-white text-sm cursor-pointer active:text-white/60 hover:text-white/80">
                Data Privacy
              </span>

              <div class="flex gap-x-2">
                <div class="cursor-pointer">
                  <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.04986 0C3.64986 0 0.0498657 3.60643 0.0498657 8.04819C0.0498657 12.0643 2.97786 15.3976 6.80186 16V10.3775H4.76986V8.04819H6.80186V6.27309C6.80186 4.25703 7.99386 3.14859 9.82585 3.14859C10.6979 3.14859 11.6099 3.30121 11.6099 3.30121V5.28514H10.6019C9.60985 5.28514 9.29785 5.90362 9.29785 6.53815V8.04819H11.5219L11.1619 10.3775H9.29785V16C11.183 15.7011 12.8996 14.7354 14.1378 13.2772C15.376 11.819 16.0541 9.96437 16.0498 8.04819C16.0498 3.60643 12.4499 0 8.04986 0Z" fill="white"/>
                  </svg>
                </div>

                <div class="cursor-pointer">
                  <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.03655 5.17578C7.28764 5.17578 6.5694 5.47329 6.03984 6.00285C5.51027 6.53241 5.21277 7.25065 5.21277 7.99956C5.21277 8.74847 5.51027 9.46671 6.03984 9.99628C6.5694 10.5258 7.28764 10.8233 8.03655 10.8233C8.78546 10.8233 9.5037 10.5258 10.0333 9.99628C10.5628 9.46671 10.8603 8.74847 10.8603 7.99956C10.8603 7.25065 10.5628 6.53241 10.0333 6.00285C9.5037 5.47329 8.78546 5.17578 8.03655 5.17578Z" fill="white"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.49245 0.251077C6.51261 -0.0836924 9.56052 -0.0836924 12.5807 0.251077C14.2306 0.435275 15.5609 1.73421 15.7546 3.39025C16.1128 6.45267 16.1128 9.54639 15.7546 12.6088C15.5609 14.2648 14.2306 15.5638 12.5815 15.7489C9.5611 16.0837 6.5129 16.0837 3.49245 15.7489C1.84249 15.5638 0.512274 14.2648 0.318519 12.6097C-0.0396855 9.54697 -0.0396855 6.45296 0.318519 3.39025C0.512274 1.73421 1.84249 0.435275 3.49245 0.251077ZM12.3808 2.7864C12.1504 2.7864 11.9294 2.87794 11.7665 3.04088C11.6035 3.20382 11.512 3.42482 11.512 3.65525C11.512 3.88569 11.6035 4.10668 11.7665 4.26963C11.9294 4.43257 12.1504 4.52411 12.3808 4.52411C12.6113 4.52411 12.8323 4.43257 12.9952 4.26963C13.1582 4.10668 13.2497 3.88569 13.2497 3.65525C13.2497 3.42482 13.1582 3.20382 12.9952 3.04088C12.8323 2.87794 12.6113 2.7864 12.3808 2.7864ZM3.9095 7.99953C3.9095 6.90497 4.34431 5.85523 5.11829 5.08126C5.89226 4.30728 6.942 3.87247 8.03656 3.87247C9.13113 3.87247 10.1809 4.30728 10.9548 5.08126C11.7288 5.85523 12.1636 6.90497 12.1636 7.99953C12.1636 9.0941 11.7288 10.1438 10.9548 10.9178C10.1809 11.6918 9.13113 12.1266 8.03656 12.1266C6.942 12.1266 5.89226 11.6918 5.11829 10.9178C4.34431 10.1438 3.9095 9.0941 3.9095 7.99953Z" fill="white"/>
                  </svg>
                </div>

                <div class="cursor-pointer">
                  <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_96_4293)">
                    <path d="M15.9987 1.56467C15.9916 1.4602 15.9539 1.36014 15.8902 1.27697C15.8266 1.19379 15.7399 1.13118 15.641 1.09694C15.542 1.06271 15.4352 1.05836 15.3338 1.08444C15.2324 1.11052 15.1409 1.16588 15.0707 1.24361C14.722 1.63481 14.268 1.91735 13.763 2.05747C13.082 1.41995 12.1838 1.06564 11.251 1.06654C10.7552 1.06682 10.2644 1.16474 9.80653 1.35471C9.34864 1.54467 8.93265 1.82297 8.58231 2.1737C8.23198 2.52443 7.95415 2.94074 7.7647 3.39884C7.57525 3.85694 7.47789 4.34787 7.47817 4.84361V5.31294C4.28777 5.06654 2.58324 2.64201 2.12137 1.41321C2.08502 1.31583 2.021 1.23119 1.93719 1.16971C1.85338 1.10823 1.75343 1.07258 1.64963 1.06714C1.54583 1.0617 1.4427 1.08671 1.35292 1.1391C1.26315 1.19148 1.19064 1.26896 1.1443 1.36201C0.0275032 3.59774 -0.14423 5.76734 0.667503 7.61481C1.3779 9.23294 2.80724 10.5215 4.8339 11.3759C3.91337 12.0276 2.3635 12.7999 0.55657 12.7999C0.442052 12.7997 0.33053 12.8365 0.238501 12.9046C0.146473 12.9728 0.0788266 13.0687 0.045569 13.1783C0.0123114 13.2879 0.0152091 13.4053 0.0538335 13.5131C0.0924578 13.6209 0.164757 13.7134 0.260037 13.7769C1.99337 14.9332 3.8099 14.9332 5.49737 14.9332H5.54857C10.7336 14.9332 14.9352 10.7241 14.9352 5.53374V5.02281C15.3224 4.62814 15.6243 4.22601 15.8099 3.70441C16.0158 3.12201 16.0574 2.44787 15.9987 1.56467Z" fill="white"/>
                    </g>
                    <defs>
                    <clipPath id="clip0_96_4293">
                    <rect width="16" height="16" fill="white" transform="translate(0.0232544)"/>
                    </clipPath>
                    </defs>
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <div>
            <div class="flex justify-center gap-x-1">
              <div>
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M8 1.5C6.71442 1.5 5.45772 1.88122 4.3888 2.59545C3.31988 3.30968 2.48676 4.32484 1.99479 5.51256C1.50282 6.70028 1.37409 8.00721 1.6249 9.26809C1.8757 10.529 2.49477 11.6872 3.40381 12.5962C4.31285 13.5052 5.47104 14.1243 6.73192 14.3751C7.99279 14.6259 9.29973 14.4972 10.4874 14.0052C11.6752 13.5132 12.6903 12.6801 13.4046 11.6112C14.1188 10.5423 14.5 9.28558 14.5 8C14.4982 6.27665 13.8128 4.62441 12.5942 3.40582C11.3756 2.18722 9.72335 1.50182 8 1.5ZM8 13.5C6.91221 13.5 5.84884 13.1774 4.94437 12.5731C4.0399 11.9687 3.33495 11.1098 2.91867 10.1048C2.50238 9.09977 2.39347 7.9939 2.60568 6.927C2.8179 5.86011 3.34173 4.8801 4.11092 4.11091C4.8801 3.34172 5.86011 2.8179 6.92701 2.60568C7.9939 2.39346 9.09977 2.50238 10.1048 2.91866C11.1098 3.33494 11.9687 4.03989 12.5731 4.94436C13.1774 5.84883 13.5 6.9122 13.5 8C13.4983 9.45818 12.9184 10.8562 11.8873 11.8873C10.8562 12.9184 9.45819 13.4983 8 13.5ZM6 8C6 8.41976 6.13208 8.82889 6.37752 9.16942C6.62296 9.50995 6.96932 9.76463 7.36755 9.89737C7.76577 10.0301 8.19567 10.0342 8.59634 9.90903C8.99701 9.78387 9.34814 9.53581 9.6 9.2C9.67965 9.09391 9.79818 9.02381 9.92951 9.00512C10.0608 8.98642 10.1942 9.02066 10.3003 9.10031C10.4064 9.17996 10.4765 9.29849 10.4952 9.42982C10.5139 9.56116 10.4797 9.69454 10.4 9.80062C10.0221 10.3042 9.49539 10.6761 8.89441 10.8637C8.29344 11.0513 7.64866 11.0451 7.05142 10.8459C6.45417 10.6468 5.93472 10.2647 5.56663 9.75397C5.19854 9.24321 5.00047 8.62958 5.00047 8C5.00047 7.37042 5.19854 6.75679 5.56663 6.24603C5.93472 5.73526 6.45417 5.35324 7.05142 5.15407C7.64866 4.95491 8.29344 4.94868 8.89441 5.13628C9.49539 5.32389 10.0221 5.69581 10.4 6.19938C10.4394 6.2519 10.4681 6.31169 10.4845 6.37531C10.5008 6.43893 10.5045 6.50515 10.4952 6.57018C10.4859 6.63521 10.464 6.69778 10.4305 6.75431C10.3971 6.81085 10.3528 6.86025 10.3003 6.89969C10.2478 6.93913 10.188 6.96783 10.1244 6.98416C10.0608 7.0005 9.99454 7.00414 9.92951 6.99488C9.86448 6.98563 9.80191 6.96365 9.74538 6.93021C9.68884 6.89678 9.63944 6.85253 9.6 6.8C9.34814 6.46419 8.99701 6.21613 8.59634 6.09097C8.19567 5.96581 7.76577 5.96989 7.36755 6.10263C6.96932 6.23537 6.62296 6.49005 6.37752 6.83058C6.13208 7.17111 6 7.58024 6 8Z" fill="white" fill-opacity="0.4"/>
                </svg>
              </div>
              <span class="text-white/40 text-xx-sm font-semibold">2023 REBEL WISDOM PODCAST</span>
            </div>

          </div>
        </div>

    </div>

    <Teleport to="body">
        <transition name="modal">
        
            <div v-if="open" class="modal-mask">
                <div class="modal-container laptop:w-[20%] rounded-[15px] relative">
                    <button @click="open = false; showResend = false; password = ''; email = ''" class="absolute left-[-16px] top-[-16px] group" type="button">
                      <div class="w-8 h-8">
                        <svg class="w-full h-full" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6.2376 11.2624L8.5008 9ZM10.7632 6.7376L8.5008 9ZM8.5008 9L6.2376 6.7376ZM8.5008 9L10.7632 11.2624ZM8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="fill-white/80 group-hover:fill-white/40 group-active:fill-white/60"/>
                          <path d="M6.2376 11.2624L8.5008 9M8.5008 9L10.7632 6.7376M8.5008 9L6.2376 6.7376M8.5008 9L10.7632 11.2624M8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="stroke-black/40" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>
                    </button>

                    <div class="flex gap-x-2 overflow-x-hidden">
                      <div class="login flex-none w-full" ref="loginref">
                        <h1 class="modal-header mb-4 text-white/80 text-lg font-semibold text-center">Host Login</h1>

                        <div class="flex flex-col mb-4 gap-y-4">
                            <!-- <label for="email">Email</label> -->
                            <input type="mail" id="email" name="email" v-model="email" 
                            class="focus:outline-none
                            appearance-none
                            border
                            border-white/40 
                            pl-2 py-1 
                            rounded-[10px] 
                            text-base 
                            text-white/80 focus:border-white/80
                            bg-transparent"
                            placeholder="Email">

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
                          </div>
                          <div class="">
                            <span @click="resendVerify" class="text-white/60 inline text-sm font-medium border-b border-white/40 mr-4 laptop:cursor-pointer laptop:hover:text-white/80" v-if="showResend">resend verification email</span>
                            <span @click="scrollToforgotPwd" class="text-white/60 inline text-sm font-medium border-b border-white/40 mr-4 laptop:cursor-pointer laptop:hover:text-white/80">forgot password</span>
                          <button 
                          class="modal-footer 
                          modal-default-button 
                          text-black/80
                          bg-white/80
                          rounded-full
                          px-4  py-1
                          float-right
                          font-medium" @click="login">Login</button>
                          </div>
                      </div>

                      <div class="flex-none w-full flex flex-col gap-y-2" ref="forgotPwdref">
                        <h1 class="modal-header mb-4 text-white/80 text-lg font-semibold text-center">Password reset</h1>
                        <input type="mail" id="email" name="email" v-model="emailforgot" 
                            class="focus:outline-none
                            appearance-none
                            border
                            border-white/40 
                            pl-2 py-1 
                            rounded-[10px] 
                            text-base 
                            text-white/80 focus:border-white/80
                            bg-transparent
                            w-full"
                            placeholder="Email">

                            <div class="mt-auto flex gap-x-2 justify-end">
                              <button 
                              class=" 
                              text-black/80
                              bg-white/80
                              rounded-full
                              px-4  py-1
                              float-right
                              font-medium" @click="scrollTologin">back</button>
                              <button 
                              class="
                              text-black/80
                              bg-white/80
                              rounded-full
                              px-4  py-1
                              float-right
                              font-medium" @click="resetPwd">Submit</button>
                          </div>
                      </div>
                    </div>

                </div>

            </div>                
        </transition>

    </Teleport>
</template>

<script setup>

import { ref } from 'vue';
import { useUserStore } from '../stores/userStore';
import { useRouter } from 'vue-router';
import { useNotificationStore } from '../stores/NotiStore';

const userStore = useUserStore();
const router = useRouter();
const open = ref(false);
const email = ref('');
const emailforgot = ref('');
const password = ref('');
const error = ref('');
const showResend = ref(false);
const notiStore = useNotificationStore();

const loginref =ref(null);
const forgotPwdref = ref(null);

function login() {

    error.value = '';

    if (email.value && password.value) {
        const formData = new FormData();

        formData.append('email', email.value);
        formData.append('password', password.value);
        // eslint-disable-next-line no-unused-vars
        userStore.login(formData).then(res => {
          error.value = '';
          if (res.status === 200) {
            email.value = '';
            password.value = '';
            showResend.value = '';
            open.value = false;
            router.push({
                path : '/adminDashboard/shows'
            });

          } else if (res.status === 403) {
            showResend.value = true;
          }

        }).catch(error => {
            if (error.response.status === 403) {
              showResend.value = true;
            }
        })

    } else {
        error.value = 'Require email & password!';
        notiStore.showNotification(error.value, 'error');
    }

}

function resetPwd() {
  if (emailforgot.value) {

    const formData = new FormData();

    formData.append('email', emailforgot.value);

    userStore.forgotPwd(formData).then(res => {
      if (res.status === 200) {
        return '';
      }
    })
  } else {
    error.value = 'Email require'
  }
}

function scrollTologin() {
  loginref.value.scrollIntoView({behavior : 'smooth', inline : 'end'});
}

function scrollToforgotPwd() {
  forgotPwdref.value.scrollIntoView({behavior : 'smooth', inline : 'end'});
}

function resendVerify() {
  if (email.value) {
    const formData = new FormData();

    formData.append('email', email.value);

    userStore.resendVerify(formData).then(res => {
      return res;
    })
  }
}

</script>

<style>
</style>