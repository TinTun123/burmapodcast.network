<template>
    <div class="mx-4 mt-8 tablet:mx-8">
        <div class="relative mb-8">

          <hr class="w-[80%] ml-auto h-px bg-white/30 rounded-full">
          <span class="absolute text-white/80 font-semibold text-lg top-[50%] -translate-y-[50%]">hosts</span>
        </div>

        <div class="grid grid-cols-1 laptop:grid-cols-3 mb-8 gap-4">
          <div v-for="(user, i) in userStore.users" :key="i" class="bg-[#D9D9D9]/10 p-4 rounded-[10px] relative">
            <div class="flex gap-x-2">
              <div  class="w-[15%] tablet:w-12 tablet:h-12 aspect-square">
                  <svg class="w-full h-full" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2.4C10.3209 2.39969 8.67111 2.83978 7.21526 3.67635C5.75942 4.51292 4.54845 5.7167 3.70323 7.16754C2.85801 8.61838 2.4081 10.2655 2.39841 11.9446C2.38872 13.6236 2.81959 15.2759 3.64801 16.7364C4.20794 16.0087 4.92772 15.4195 5.75171 15.0144C6.5757 14.6092 7.48181 14.399 8.4 14.4H15.6C16.5182 14.399 17.4243 14.6092 18.2483 15.0144C19.0723 15.4195 19.7921 16.0087 20.352 16.7364C21.1804 15.2759 21.6113 13.6236 21.6016 11.9446C21.5919 10.2655 21.142 8.61838 20.2968 7.16754C19.4516 5.7167 18.2406 4.51292 16.7847 3.67635C15.3289 2.83978 13.6791 2.39969 12 2.4ZM21.5316 19.2912C23.136 17.1995 24.0039 14.6361 24 12C24 5.37239 18.6276 0 12 0C5.37241 0 1.35039e-05 5.37239 1.35039e-05 12C-0.00394822 14.6361 0.863899 17.1996 2.46841 19.2912L2.46241 19.3128L2.88841 19.8084C4.01387 21.1242 5.41127 22.1803 6.98428 22.9039C8.5573 23.6276 10.2685 24.0015 12 24C14.4328 24.0045 16.8089 23.2655 18.81 21.882C19.6631 21.2925 20.4367 20.5956 21.1116 19.8084L21.5376 19.3128L21.5316 19.2912ZM12 4.79999C11.0452 4.79999 10.1295 5.17928 9.45442 5.85441C8.77929 6.52954 8.4 7.44521 8.4 8.39999C8.4 9.35477 8.77929 10.2704 9.45442 10.9456C10.1295 11.6207 11.0452 12 12 12C12.9548 12 13.8705 11.6207 14.5456 10.9456C15.2207 10.2704 15.6 9.35477 15.6 8.39999C15.6 7.44521 15.2207 6.52954 14.5456 5.85441C13.8705 5.17928 12.9548 4.79999 12 4.79999Z" fill="#CCCCCC"/>
                  </svg>
              </div>

              <div class="flex flex-col">
                  <span class="text-white text-base font-medium">{{ user.name }}</span>
                  <span class="text-white text-sm font-semibold">{{ user.email }}</span>
              </div>
            </div>

            <div class="bg-[#404040] px-2 rounded-full absolute top-2 right-2 flex items-center shadow-card-shadow">
              <span v-if="user.user_level === 3" class="text-white text-x-sm font-semibold">Admin</span>
              <span v-if="user.user_level === 2" class="text-white text-x-sm font-semibold">Host</span>
              <span v-if="user.user_level === 1" class="text-white text-x-sm font-semibold">Co-host</span>
            </div>

            <div @click.stop="openEditUser = true; name = user.name; email = user.email; level = user.user_level; userId = user.id" class="absolute bottom-2 right-2 group cursor-pointer" v-if="((user.user_level <= 2) && (userStore.user_level >= 2)) || user.id === userStore.user_id">
                <div class="w-3 h-3">
                <svg class="w-full h-full" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path class="fill-[#CCCCCC] group-hover:fill-[#CCCCCC]/80 group-active:fill-[#CCCCCC]" d="M15.74 3.59283C16.0867 3.24622 16.0867 2.66852 15.74 2.33968L13.6603 0.259964C13.3315 -0.0866546 12.7538 -0.0866546 12.4072 0.259964L10.7718 1.8864L14.1047 5.21928M0 12.6671V16H3.33287L13.1626 6.16137L9.82975 2.8285L0 12.6671Z" />
                </svg>
                </div>
            </div>
          </div>

          <div class="text-end">
            <div v-if="userStore.user_level === 3 || userStore.user_level === 2" @click="openAddUser = true" class="bg-[#D9D9D9]/10 rounded-[10px] px-4  inline-block cursor-pointer hover:bg-[#D9D9D9]/20 active:bg-[#D9D9D9]/10">
            <span class="text-white text-base font-medium">New</span>
            </div>
          </div>

        </div>

        <ActivitiesLogComponent />
    </div>

    <Teleport to="body">
        <transition name="modal">
        
            <div v-if="openAddUser" class="modal-mask">
                <div class="modal-container rounded-[10px] relative">
                    <button @click="openAddUser = false" class="absolute left-1 top-1 group" type="button">
                      <div class="w-8 h-8">
                        <svg class="w-full h-full" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6.2376 11.2624L8.5008 9ZM10.7632 6.7376L8.5008 9ZM8.5008 9L6.2376 6.7376ZM8.5008 9L10.7632 11.2624ZM8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="fill-white/80 group-hover:fill-white/40 group-active:fill-white/60"/>
                          <path d="M6.2376 11.2624L8.5008 9M8.5008 9L10.7632 6.7376M8.5008 9L6.2376 6.7376M8.5008 9L10.7632 11.2624M8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="stroke-black/40" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>
                    </button>

                    <div class="flex overflow-hidden">

                      <div class="w-full" ref="addShow">
                        <AdduserComponent />
                      </div>
                    </div>


                </div>

            </div>                
        </transition>

    </Teleport>

    <Teleport to="body">
        <transition name="modal">
        
            <div v-if="openEditUser" class="modal-mask">
                <div class="modal-container rounded-[10px] relative">
                    <button @click="openEditUser = false" class="absolute left-1 top-1 group" type="button">

                      <div class="w-8 h-8">

                        <svg class="w-full h-full" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6.2376 11.2624L8.5008 9ZM10.7632 6.7376L8.5008 9ZM8.5008 9L6.2376 6.7376ZM8.5008 9L10.7632 11.2624ZM8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="fill-white/80 group-hover:fill-white/40 group-active:fill-white/60"/>
                          <path d="M6.2376 11.2624L8.5008 9M8.5008 9L10.7632 6.7376M8.5008 9L6.2376 6.7376M8.5008 9L10.7632 11.2624M8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="stroke-black/40" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>

                      </div>

                    </button>

                    <div class="flex overflow-hidden">

                      <div class="w-full" ref="addShow">
                        <h1 class="modal-header mb-4 text-white/80 text-lg font-semibold text-center">Edit user</h1>

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

                            <select
                            class="rounded-full bg-[#2F2F2F] text-white text-sm px-2 py-1 font-semibold"
                            name="level" id="level" v-model="level">
                                <option value="" disabled>user type</option>
                                <option value="1">Co-Host</option>
                                <option value="2">Host</option>
                                <option value="3">Admin</option>
                            </select>

                            <div class="flex gap-x-4 justify-end">
                              <button
                              class=" 
                              text-black/80
                              bg-[#FF0F00]/60
                              hover:bg-[#FF0F00]/40
                              active:bg-[#FF0F00]/60
                              rounded-full
                              px-4  py-1
                              font-medium"
                          @click="deleteUser">delete</button>
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
                          @click="EditUser">Change</button>
                          </div>

                          </div>
                        </div>
                      </div>
                </div>

            </div>                
        </transition>

    </Teleport>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import AdduserComponent from './AdduserComponent.vue';
import { useUserStore } from '../stores/userStore';
import ActivitiesLogComponent from './ActivitiesLogComponent.vue';

const name = ref('');
const email = ref('');
const password = ref('');
const userStore = useUserStore();
const openAddUser = ref(false);
const openEditUser = ref(false);
const userId = ref(0);
const level = ref('');

function resetForm() {
  name.value = '';
  email.value = '';
  password.value = '';
  level.value = '';
  userId.value = 0;
}

onMounted(() => {
    if (!userStore.users.length) {
        userStore.getUsers();
    }
})

function EditUser() {
  if (name.value || level.value || password.value || email.value) {

    const formData = new FormData();

    if (name.value) {
      formData.append('name', name.value);
    }

    if (level.value) {
      formData.append('level', level.value);
    }

    if(email.value) {
      formData.append('email', email.value);
    }

    if(password.value) {
      formData.append('password', password.value);
    }

    userStore.updateUser(formData, userId.value).then(res => {
      if (res.status === 200) {
        resetForm();
        openEditUser.value = false;
      }


    })
  }
}

function deleteUser() {
  userStore.deleteUser(userId.value).then(res => {
    if (res.status === 200) {
      openEditUser.value = false;
      resetForm();
    }
  })
}
</script>

<style>
</style>