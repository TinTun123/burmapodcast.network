<template>
    <div class="z-[9999]">
        <h1 class="modal-header mb-4 text-white/80 text-lg font-semibold text-center">{{ currentShow.isEdit ? 'Edit show' : 'New show' }}</h1>
        <div class="flex flex-col gap-y-2 mb-4">
            <div :style="{'background-image' : `url(${coverImg})`}"  @click="openFile" class="img_block bg-white/20 w-[45%] flex justify-center items-center rounded-[15px] cursor-pointer hover:bg-white/30 transition aspect-square overflow-hidden group">

              <div v-if="!coverImg" class="w-12 h-12">
                <svg  class="w-full h-full" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path class="fill-[#CCCCCC] group-hover:fill-[#CCCCCC]/80 group-active:fill-[#CCCCCC]" d="M21.6 0H2.4C1.0764 0 0 1.0764 0 2.4V16.8C0 18.1236 1.0764 19.2 2.4 19.2H21.6C22.9236 19.2 24 18.1236 24 16.8V2.4C24 1.0764 22.9236 0 21.6 0ZM5.4 3.6C5.87739 3.6 6.33523 3.78964 6.67279 4.12721C7.01036 4.46477 7.2 4.92261 7.2 5.4C7.2 5.87739 7.01036 6.33523 6.67279 6.67279C6.33523 7.01036 5.87739 7.2 5.4 7.2C4.92261 7.2 4.46477 7.01036 4.12721 6.67279C3.78964 6.33523 3.6 5.87739 3.6 5.4C3.6 4.92261 3.78964 4.46477 4.12721 4.12721C4.46477 3.78964 4.92261 3.6 5.4 3.6ZM12 15.6H3.6L8.4 9.6L10.2 12L13.8 7.2L20.4 15.6H12Z"/>
                </svg>
              </div>


            </div>

            <input ref="imageImput" hidden type="file" id="file" name="file" @change="filePicked" accept="image/*" 
            class="focus:outline-none border pl-2 py-1 rounded-[10px] text-primary text-black/80 focus:border-black/40">
        </div>
        <div class="flex flex-col gap-y-2">
            <input type="text" id="title" name="title" v-model="title" 
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
                        placeholder="Title">
        </div>



        <div class="flex flex-col my-4">
            <textarea name="desc" v-model="desc" id="desc" cols="15" rows="3" 
            class="bg-transparent 
            h-[20vh] 
            appearance-none 
            focus:outline-none 
            text-white 
            w-full p-2 
            rounded-[15px] 
            border border-[#D6D6D6]/60 focus:border-[#D6D6D6] 
            placeholder:text-white/40"
            placeholder="description"></textarea>
        </div>
        <span v-if="error" class="text-sm text-red-300">{{error}}</span>

        <div class="flex gap-x-2 justify-end">
          <button v-if="currentShow.isEdit"
          class=" 
              text-black/80
              bg-[#FF0F00]/60
              hover:bg-[#FF0F00]/40
              active:bg-[#FF0F00]/60
              rounded-full
              px-4  py-1
              font-medium" @click="deleteShow(currentShow.id)">delete</button>

              <button 
              class=" 
              text-black/80
              bg-white/80
              hover:bg-white/60
              active:bg-white/80
              rounded-full
              px-4  py-1
              font-medium" @click="newShowCreate">{{ currentShow.title ? 'edit' : 'create' }}</button>
        </div>


    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
// import {useUserStore} from '../stores/userStore';
import {useShowsStore} from '../stores/ShowsStore';
import { useRouter } from 'vue-router';

const title = ref('');
const desc = ref('');
const img_file = ref();
const imageImput = ref(null);
const coverImg = ref('');
// const userStore = useUserStore();
const showStore = useShowsStore();
const error = ref('');
const emit = defineEmits(['close']);

const props = defineProps(['currentShow'])
const router = useRouter();
onMounted(() => {

  if (props.currentShow) {
    if (props.currentShow.isEdit) {
      title.value = props.currentShow.title;
      desc.value = props.currentShow.description;
      coverImg.value = props.currentShow.cover_img;
    }

  }

})

function openFile() {
  imageImput.value.click();
}

function filePicked(e) {
  const files = e.target.files;
  if (files[0]) {

    const reader = new FileReader();

    reader.onload = (e) => {
      coverImg.value = e.target.result;
    }

    reader.readAsDataURL(files[0]);
    img_file.value = files[0];
  }
}

function resetForm() {
  title.value = '';
  desc.value = '';
  error.value = '';
  img_file.value = '';
}


function newShowCreate() {
  if (title.value && desc.value && img_file.value) {
    const formData = new FormData();
    formData.append('title', title.value);
    formData.append('img_file', img_file.value);
    formData.append('desc' , desc.value);

    if (props.currentShow.isEdit) {
      formData.append('_method', 'PUT');
      showStore.editShow(formData, props.currentShow.id).then(res => {
        
        return res;
      })
    } else {
      showStore.createShow(formData).then(res => {
        if (res.data.success) {
          resetForm();
          emit('close');
        }
        return res;
      })
    }


  } else {
    error.value = 'Please fill all field!';
  }
}

function deleteShow(id) {
  showStore.deleteShow(id).then(res => {
    if (res.data.success) {
      emit('close');
      resetForm();
      router.push({name : 'adminDashboard'});
    }

  })
}
</script>


<style>


.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}

.modal-body {
  margin: 20px 0;
}

.modal-default-button {
  float: right;
}

.img_block {
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center;
}

</style>