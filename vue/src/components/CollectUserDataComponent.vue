<template>
    <div>
        <Teleport to="body">
          <div>
        <transition name="modal">
        
            <div v-if="open" class="modal-mask">
                <div class="modal-container rounded-[10px] relative">
                    <button @click="open = false;" class="absolute left-1 top-1 group" type="button">
                      <div class="w-8 h-8">
                        <svg class="w-full h-full" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6.2376 11.2624L8.5008 9ZM10.7632 6.7376L8.5008 9ZM8.5008 9L6.2376 6.7376ZM8.5008 9L10.7632 11.2624ZM8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="fill-white/80 group-hover:fill-white/40 group-active:fill-white/60"/>
                          <path d="M6.2376 11.2624L8.5008 9M8.5008 9L10.7632 6.7376M8.5008 9L6.2376 6.7376M8.5008 9L10.7632 11.2624M8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="stroke-black/40" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>
                    </button>

                    <div class="flex overflow-hidden">
                        <div class="w-full flex-none flex flex-col">
                            <h1 class="modal-header mb-4 mt-4 text-white/80 text-lg font-semibold text-center">What should you call you?</h1>
                            <input 
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
                            placeholder="Nick name"
                            type="text" v-model="audiencename">
                            <button
                            class="
                            mt-4 
                            text-black/80
                            bg-white/80
                            hover:bg-white/60
                            active:bg-white/80
                            rounded-full
                            px-4  py-1
                            font-medium"
                            type="button"
                            @click="addAudience">Next</button>
                        </div>
                    </div>


                </div>

            </div>                
        </transition>
        </div>

    </Teleport>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useUserStore } from '../stores/userStore';

const userStore = useUserStore();
const open = ref(false);
const audiencename = ref('');
const emittype = ref('');
const payloadArg = ref();
const emit = defineEmits(['createAnswer', 'likeEpisode', 'saveAudio'])
async function openModal(emittypepara, payload) {
    open.value = true;
    emittype.value = emittypepara;
    payloadArg.value = payload;
    console.log(payload);
}

defineExpose({
    openModal
});

function addAudience() {

    if (audiencename.value) {
        const formData = new FormData();

        formData.append('audienceName', audiencename.value);

        userStore.addAudience(formData).then(res => {
            emit(emittype.value, payloadArg.value);
            audiencename.value = '';
            open.value = false;
            return res;
        })
        
    }
}

</script>

<style>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  transition: opacity 0.3s ease;
}

.modal-container {
  margin: auto;
  padding: 20px 30px;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;

}

.modal-enter-from {
  opacity: 0;
}

.modal-leave-to {
  opacity: 0;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

</style>