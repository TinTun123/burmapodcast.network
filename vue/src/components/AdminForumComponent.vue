<template>
    <div class="mx-4 mt-8 tablet:mx-8">
        <!-- <button @click="openAddTopic = true">New Thread</button> -->


            <div v-for="(show, i) in forumStore.forums" :key="i">

                <div v-if="show.forum.length > 0" class="flex items-center gap-x-2 my-8">
                    <span class="text-white/80 font-semibold text-lg">{{ show.title }}</span>
                    <div class="w-[90%]">
                        <svg class="w-full" height="2" viewBox="0 0 1000 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="1000" height="2" fill="#CCCCCC" fill-opacity="0.4"/>
                        </svg>
                    </div>
                </div>

                <div class="grid grid-cols-1 tablet:grid-cols-2 gap-4">   

                    <div v-for="(forum , j) in show.forum" :key="j" @click.stop="routeTo(forum.id, show.id)" 
                    class="col-span-1 
                    bg-[#D9D9D9]/10  
                    rounded-[15px] p-4
                    transition
                    hover:bg-[#D9D9D9]/5
                    active:bg-[#D9D9D9]/10
                    relative">

                    <button class="absolute top-4 right-4 group"  @click.stop="editForum(forum)">
                        <div class="w-4 h-4">
                            <svg class="w-full h-full" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="fill-[#CCCCCC] group-hover:fill-[#CCCCCC]/80 group-active:fill-[#CCCCCC]" d="M15.74 3.59283C16.0867 3.24622 16.0867 2.66852 15.74 2.33968L13.6603 0.259964C13.3315 -0.0866546 12.7538 -0.0866546 12.4072 0.259964L10.7718 1.8864L14.1047 5.21928M0 12.6671V16H3.33287L13.1626 6.16137L9.82975 2.8285L0 12.6671Z"/>
                            </svg>
                        </div>

                    </button>

                    <div class="flex gap-x-2">

                        <div class="flex gap-x-2 rounded-full overflow-hidden  px-2 bg-[#404040] group-active:bg-[#404040]/80 py-1">
                            <span class="text-x-sm text-white/60 font-bold">{{ getDate(forum.created_at) }}</span>
                        </div>

                        <div class="flex gap-x-2 items-center rounded-full overflow-hidden  px-2 bg-[#404040] group-active:bg-[#404040]/80 py-1">
                            <span class="text-x-sm text-white/60 font-bold">{{ forum.answers ? forum.answers.length : 0 }}</span>
                            <div>
                                <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path class="fill-white/60" d="M7 12.5C7 12.5 6 12.5 6 11.5C6 10.5 7 7.5 11 7.5C15 7.5 16 10.5 16 11.5C16 12.5 15 12.5 15 12.5H7ZM11 6.5C11.7956 6.5 12.5587 6.18393 13.1213 5.62132C13.6839 5.05871 14 4.29565 14 3.5C14 2.70435 13.6839 1.94129 13.1213 1.37868C12.5587 0.816071 11.7956 0.5 11 0.5C10.2044 0.5 9.44129 0.816071 8.87868 1.37868C8.31607 1.94129 8 2.70435 8 3.5C8 4.29565 8.31607 5.05871 8.87868 5.62132C9.44129 6.18393 10.2044 6.5 11 6.5ZM5.216 12.5C5.06776 12.1878 4.99382 11.8455 5 11.5C5 10.145 5.68 8.75 6.936 7.78C6.30909 7.58684 5.65595 7.49237 5 7.5C1 7.5 0 10.5 0 11.5C0 12.5 1 12.5 1 12.5H5.216ZM4.5 6.5C5.16304 6.5 5.79893 6.23661 6.26777 5.76777C6.73661 5.29893 7 4.66304 7 4C7 3.33696 6.73661 2.70107 6.26777 2.23223C5.79893 1.76339 5.16304 1.5 4.5 1.5C3.83696 1.5 3.20107 1.76339 2.73223 2.23223C2.26339 2.70107 2 3.33696 2 4C2 4.66304 2.26339 5.29893 2.73223 5.76777C3.20107 6.23661 3.83696 6.5 4.5 6.5Z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                        
                        <!-- <button class="float-right" @click.stop="editForum(forum)">Edit</button> -->
                        <h4 class="text-white/80 mt-2 text-base font-semibold leading-[24px]">{{ forum.title }}</h4>
                        <p class="text-white text-lg leading-[30px]">{{ forum.body }}</p>

                    </div>



                </div>

            </div>
            <div
            @click="openAddTopic = true" 
            class="
            mt-8
            text-end
            cursor-pointer">
                <span 
                class="
                text-base 
                text-white 
                font-medium
                bg-[#D9D9D9]/10  
                rounded-[15px]
                px-4 py-2
                transition
                hover:bg-[#D9D9D9]/5
                active:bg-[#D9D9D9]/10">
                    New
                </span>
            </div>
        
    </div>


    <Teleport to="body">
        <transition name="modal">
        
            <div v-if="openAddTopic" class="modal-mask">
                <div class="modal-container rounded-[10px] relative">
                    
                    <button @click="openAddTopic = false; isEdit = false; resetForm();" class="absolute left-1 top-1 group" type="button">

                      <div class="w-8 h-8">
                        <svg class="w-full h-full" viewBox="0 0 17 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6.2376 11.2624L8.5008 9ZM10.7632 6.7376L8.5008 9ZM8.5008 9L6.2376 6.7376ZM8.5008 9L10.7632 11.2624ZM8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="fill-white/80 group-hover:fill-white/40 group-active:fill-white/60"/>
                          <path d="M6.2376 11.2624L8.5008 9M8.5008 9L10.7632 6.7376M8.5008 9L6.2376 6.7376M8.5008 9L10.7632 11.2624M8.5 17C12.9184 17 16.5 13.4184 16.5 9C16.5 4.5816 12.9184 1 8.5 1C4.0816 1 0.5 4.5816 0.5 9C0.5 13.4184 4.0816 17 8.5 17Z" class="stroke-black/40" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                      </div>

                    </button>

                    <div class="flex flex-col gap-y-2 overflow-hidden">

                        <h3 class="modal-header mb-4 text-white/80 text-lg font-semibold text-center">New Thread</h3>

                        <select 
                        class="rounded-full bg-[#2F2F2F] text-white text-sm px-2 py-1 font-semibold"
                        name="showId" id="showId" v-model="showId">
                            <option value="" disabled >Show</option>
                            <option v-for="(show, i) in showStore.shows" :key="i" :value="show.id">{{ show.title }}</option>
                        </select>

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
                        placeholder="title"
                        v-model="title" type="text" id="title" >

                        <textarea 
                        placeholder="question"
                        class="bg-transparent h-[20vh] appearance-none focus:outline-none text-white w-full p-2 rounded-[15px] border border-[#D6D6D6]/60 focus:border-[#D6D6D6] placeholder:text-white/40"
                        v-model="topic" name="topic" id="topic" cols="10" rows="5"></textarea>


                        <div class="flex gap-x-2 justify-end">
                            <button v-if="isEdit" 
                            class=" 
                            text-black/80
                            bg-[#FF0F00]/60
                            hover:bg-[#FF0F00]/40
                            active:bg-[#FF0F00]/60
                            rounded-full
                            px-4  py-1
                            font-medium"
                            type="button" @click="deleteForum(forumId, showId)">
                                delete
                            </button>
                            <button 
                            class=" 
                            text-black/80
                            bg-white/80
                            hover:bg-white/60
                            active:bg-white/80
                            rounded-full
                            px-4  py-1
                            font-medium"
                            type="button" @click="addTopic">
                                {{ isEdit ? 'Edit' : 'Create' }}
                            </button>
                        </div>




                    </div>


                </div>

            </div>                
        </transition>

    </Teleport>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useShowsStore } from '../stores/ShowsStore';
import { useForumStore } from '../stores/forumStore';
import { useRouter } from 'vue-router';
import { useNotificationStore } from '../stores/NotiStore';


const router = useRouter();
const openAddTopic = ref(false);
const showStore = useShowsStore();
const forumStore = useForumStore();
const showId = ref('');
const orShowId = ref();
const topic = ref('');
const title = ref('');
const forumId = ref('');
const isEdit  =ref(false);
const notiStore = useNotificationStore();

onMounted(() => {
    if (!forumStore.forums.length) {
        forumStore.getForums();
    }

    if (!showStore.shows.length) {
        showStore.fetchShows();
    }
})

function getDate(date) {
    const created_at = new Date(date);

    return created_at.toLocaleDateString(undefined, {
        month : 'short',
        day : 'numeric'
    });
}

function addTopic() {
    if (showId.value && topic.value && title.value) {

        const formData = new FormData();

        formData.append('title',title.value);
        formData.append('showID', showId.value);
        formData.append('topic', topic.value);

        if (isEdit.value && forumId.value) {
         
            forumStore.editTopic(formData, forumId.value, orShowId.value) .then(res => {
                if (res.status === 200) {
                    resetForm();
                    openAddTopic.value = false;
                    isEdit.value = false;
                }
            })
        } else {
            forumStore.addTopic(formData).then(res => {
            if (res.status === 200) {
                resetForm();
                openAddTopic.value = false;
                isEdit.value = false;
            }
        })
        }
    } else {

        notiStore.showNotification('Please fill all require fields.', 'error');
    }
}


function deleteForum(forumId, showID) {
    forumStore.deleteForum(forumId, showID).then(res => {
        if (res.status === 200) {
            resetForm();
            openAddTopic.value = false;
        }
    })
}

function resetForm() {
    showId.value = [];
    topic.value = '';
    title.value = '';
    orShowId.value = '';
    forumId.value = '';
    return '';
}

function editForum(forum) {

    isEdit.value = true;
    showId.value = forum.show_id;
    orShowId.value = forum.show_id;
    topic.value = forum.body;
    title.value = forum.title;
    forumId.value = forum.id;
    openAddTopic.value = true;

}

function routeTo(forumId, showId) {
    router.push({
        name : 'forumShow',
        params : {
            showId : showId,
            forumid : forumId
        }
    });
}


</script>

<style>
</style>