<template>
    
    <transition name="slide-fade" appear>

    <div class="mx-4 tablet:mx-8">

        <div class="flex flex-col gap-y-4">
            <div v-for="(forum, index) in forums" :key="index" class="bg-[#D9D9D9]/10  rounded-[15px] p-4">
                <div class="flex gap-x-2">
                    <div class="flex gap-x-2 rounded-full overflow-hidden  px-2 bg-[#404040] group-active:bg-[#404040]/80 py-1">
                        <span class="text-x-sm text-white/40 font-bold">show</span>
                        <span class="text-x-sm text-white/80 line-clamp-1 fount-semibold leading-5 break-all">{{ showName }}</span>
                    </div>

                    <div class="flex gap-x-2 flex-none rounded-full overflow-hidden  px-2 bg-[#404040] group-active:bg-[#404040]/80 py-1">
                        <span class="text-x-sm text-white/60 font-bold">{{ getDate(forum.created_at) }}</span>
                    </div>

                    <div class="flex gap-x-2 flex-none items-center rounded-full overflow-hidden  px-2 bg-[#404040] group-active:bg-[#404040]/80 py-1">
                        <span class="text-x-sm text-white/60 font-bold">{{ forum.answers ? forum.answers.length : 0 }}</span>
                        <div>
                            <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="fill-white/60" d="M7 12.5C7 12.5 6 12.5 6 11.5C6 10.5 7 7.5 11 7.5C15 7.5 16 10.5 16 11.5C16 12.5 15 12.5 15 12.5H7ZM11 6.5C11.7956 6.5 12.5587 6.18393 13.1213 5.62132C13.6839 5.05871 14 4.29565 14 3.5C14 2.70435 13.6839 1.94129 13.1213 1.37868C12.5587 0.816071 11.7956 0.5 11 0.5C10.2044 0.5 9.44129 0.816071 8.87868 1.37868C8.31607 1.94129 8 2.70435 8 3.5C8 4.29565 8.31607 5.05871 8.87868 5.62132C9.44129 6.18393 10.2044 6.5 11 6.5ZM5.216 12.5C5.06776 12.1878 4.99382 11.8455 5 11.5C5 10.145 5.68 8.75 6.936 7.78C6.30909 7.58684 5.65595 7.49237 5 7.5C1 7.5 0 10.5 0 11.5C0 12.5 1 12.5 1 12.5H5.216ZM4.5 6.5C5.16304 6.5 5.79893 6.23661 6.26777 5.76777C6.73661 5.29893 7 4.66304 7 4C7 3.33696 6.73661 2.70107 6.26777 2.23223C5.79893 1.76339 5.16304 1.5 4.5 1.5C3.83696 1.5 3.20107 1.76339 2.73223 2.23223C2.26339 2.70107 2 3.33696 2 4C2 4.66304 2.26339 5.29893 2.73223 5.76777C3.20107 6.23661 3.83696 6.5 4.5 6.5Z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <h3 class="text-white/80 mt-2 text-base font-semibold leading-[24px]">{{ forum.title }}</h3>

                <p class="text-white text-lg leading-[30px]">{{ forum.body }}</p>

                <span @click.stop="drop(forum.id)" class="float-right text-white border-b border-white/80 cursor-pointer">{{ forum.id === answerId ? 'close' : 'responses'}}</span>
                
                <transition name="slide-down">
                    <div v-if="answerId === forum.id" :class="[answerId === forum.id ? 'max-h-[1000px]' : 'max-h-0']" class="mt-12">
                        <div class="flex items-center justify-between laptop:justify-end gap-x-2 mb-8">
                            <div>
                                <svg width="9" height="8" viewBox="0 0 9 8" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="4.9292" cy="4" r="4" fill="white"/>
                                </svg>
                            </div>

                            <div class="w-[90%] laptop:hidden">
                                <svg class="w-full" height="2" viewBox="0 0 306 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="306" height="2" fill="#CCCCCC" fill-opacity="0.4"/>
                                </svg>
                            </div>


                            <div class="hidden laptop:block h-[2px]">
                                <svg class="w-full h-full" viewBox="0 0 800 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="800" height="2" fill="#CCCCCC" fill-opacity="0.4"/>
                                </svg>
                            </div>
                        </div>
                        <div class="laptop:relative">
                            <textarea class="bg-transparent h-[20vh] appearance-none focus:outline-none text-white w-full p-2 rounded-[15px] border border-[#D6D6D6]/60 focus:border-[#D6D6D6] placeholder:text-white/40" placeholder="let us know what you think!" v-model="answer" name="answer" id="answer" cols="20"></textarea>
                            
                            <div class="text-end mt-4 laptop:absolute bottom-2 right-2">
                                <button class="inline-block bg-white rounded-full px-2 py-1 text-black/80 text-sm font-medium" @click.stop="createAnswer(forum.id)">Response</button>
                            </div>


                        </div>

                        <div v-for="(answer, i) in forum.answers" :key="i" class="mt-4">

                            <div class="w-[100%]">
                                <svg class="w-full" height="2" viewBox="0 0 1000 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="1000" height="2" fill="#CCCCCC" fill-opacity="0.4"/>
                                </svg>
                            </div>

                            <div class="flex flex-col mt-4 laptop:ml-8">
                                <span class="text-white/80 text-sm font-semibold">{{ answer.user ? answer.user.name : answer.audience.name }}</span>
                                <span class="text-[#D6D6D6]/80 text-x-sm font-semibold">{{ answer.human_created_at }}</span>
                            </div>

                            <h1 class="text-base text-white font-medium ml-4 mt-2 laptop:ml-12">{{ answer.answer }}</h1>

                            <div class="text-right my-4 laptop:mr-8">
                                <span class="text-sm text-white/60 font-medium border-b border-white/40" @click.stop="dropReply(answer.id)">{{ answer.id === replyId ? 'close' : `${answer.replies.length ? '+' + answer.replies.length : ''} replies` }}</span>
                            </div>

                        

                            <transition name="slide-down">

                                <div v-if="replyId === answer.id" :class="[replyId === answer.id ? 'max-h-[1000px]' : 'max-h-0']" class="flex flex-col gap-y-4 items-end laptop:min-w-[40%] laptop:max-w-[90%] laptop:ml-auto">
                                    <div v-for="(reply) in answer.replies" :key="reply.id" class="bg-white/10 p-2 inline-block rounded-t-[15px] rounded-br-[15px] laptop:p-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm fone-semibold text-white/80">{{ reply.user ? reply.user.name : reply.audience.name }}</span>
                                            <span class="text-x-sm font-semibold text-[#D6D6D6]/80">{{ reply.human_created_at }}</span>
                                        </div>

                                        <p class="text-sm font-medium leading-[20.8px] text-white ml-4 mt-2">
                                            {{ reply.content }}
                                        </p>

                                    </div>
                                    <div class="flex gap-x-2 w-full laptop:w-auto justify-end">
                                        <input 
                                        class="appearance-none 
                                        rounded-full 
                                        focus:outline-none 
                                        border border-white/60
                                        focus:border-white/80
                                        placeholder:text-white/40 placeholder:text-sm placeholder:font-medium 
                                        text-sm
                                        font-medium 
                                        bg-transparent 
                                        px-2 py-1 
                                        text-white/80
                                        w-full
                                        " placeholder="comment" type="text" v-model="replyContent">
                                        <button class="px-2 py-1 bg-white text-black/80 font-medium rounded-full text-sm" @click.stop="reply(answer.id, forum.id)">reply</button>
                                    </div>
                                </div>

                            </transition>
                        </div>
                    </div>
                </transition>
            </div>

        </div>


    </div>

    </transition>

    <CollectUserDataComponent @create-answer="createAnswer(answerId)" @reply="reply(replyId, answerId)" ref="collectUserData"/>

</template>

<script setup>

import { useRoute } from 'vue-router';
import { useForumStore } from '../stores/forumStore';
import { onMounted, ref } from 'vue';
import CollectUserDataComponent from '../components/CollectUserDataComponent.vue';
import { useUserStore } from '../stores/userStore';
const route = useRoute();
const forumStore = useForumStore();
const forums = ref([]);
const answerId = ref(0);
const replyId = ref(0);
const answer = ref();
const userStore = useUserStore();
const replyContent = ref('');
const collectUserData = ref(null);

onMounted(async () => {

    if(!forumStore.forums.length) {

        await forumStore.getForums(); 

    }

    forums.value = forumStore.getFoumsList(route.params.id);

})

// eslint-disable-next-line no-unused-vars
const props = defineProps(['showName']);

function getDate(date) {
    const created_at = new Date(date);

    return created_at.toLocaleDateString(undefined, {
        month : 'short',
        day : 'numeric'
    });
}


async function collectData(emittype) {
    await collectUserData.value.openModal(emittype);
}


async function createAnswer(forumId) {


    if (!Object.keys(userStore.audience).length && !userStore.token) {
        collectData('createAnswer');
        return '';
    }

    if (answer.value) {
        const formData = new FormData();
        
        formData.append('answer', answer.value);
        if (Object.keys(userStore.audience).length) {
            formData.append('audienceId', userStore.audience.id);
        }

    

        forumStore.createAnswer(formData, forumId, route.params.id).then(res => {
            answer.value = '';
            return res;
        })
    }
}

function reply(answerid, forumid) {

    if (!Object.keys(userStore.audience).length && !userStore.token) {
        collectData('reply');
        return '';
    }

    if (replyContent.value) {
        const formData = new FormData();
        formData.append('reply', replyContent.value);

        if (Object.keys(userStore.audience).length) {
            formData.append('audienceId', userStore.audience.id);
        }

        forumStore.createReply(formData, answerid, 'answer', route.params.id, forumid).then(res => {
            replyContent.value = '';
            return res;
        })
    }
}

function drop(forumId) {
    if (answerId.value !== Number(forumId)) {
        answerId.value = forumId;
        replyId.value = 0;
    } else {
        answerId.value = 0;
        
    }

}

function dropReply(answerId) {

    if (replyId.value !== Number(answerId)) {
        replyId.value = answerId
    } else {
        replyId.value = 0;
    }
}

</script>

<style>
.slide-down-enter-active,
.slide-down-leave-active {
    transition: 0.3s ease-in-out;
}

.slide-down-enter-from {
    max-height: 0px;
    opacity: 0;
}

.slide-down-enter-to {
    max-height: 1000px;
    opacity: 1;
}

.slide-down-leave-from {
    max-height: 0px;
    opacity: 0;
}

.slide-down-leave-to {
    max-height: 0px;
    opacity: 0;
}

</style>