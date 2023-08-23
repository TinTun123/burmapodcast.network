<template>
    <div class="mx-4 mt-8 tablet:mx-8">
        <div class="rounded-[15px] p-4">

            <h2 class="text-white/80 mt-2 text-base font-semibold leading-[24px]">{{ topic.title }}</h2>
            <p class="text-white text-lg leading-[30px]">{{ topic.body }}</p>

            </div>

            <div class="flex flex-col gap-y-4">

            <!-- <label for="answer">Response</label> -->

            <textarea v-model="answer" name="answer" id="answer" cols="5" placeholder="your response" class="bg-transparent h-[20vh] appearance-none focus:outline-none text-white w-full p-2 rounded-[15px] border border-[#D6D6D6]/60 focus:border-[#D6D6D6] placeholder:text-white/40"></textarea>

            <div class="text-end mt-4">
                <span class="inline-block bg-white rounded-full px-2 py-1 text-black/80 text-sm font-medium"  @click.stop="createAnswer">Response</span>
            </div>

            <div class="flex flex-col gap-y-4">
                <div v-for="(answer, i) in topic.answers" :key="i" class="relative">

                    <div class="">
                        <svg class="w-full" height="2" viewBox="0 0 1000 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="1000" height="2" fill="#CCCCCC" fill-opacity="0.4"/>
                        </svg>
                    </div>

                    <div class="flex flex-col mt-4 ml-8 laptop:ml-8">
                        <span class="text-white/80 text-sm font-semibold">{{ answer.user ? answer.user.name : answer.audience.name }}</span>
                        <span class="text-[#D6D6D6]/80 text-x-sm font-semibold">{{ answer.human_created_at }}</span>
                    </div>

                    <h1 class="text-base text-white font-medium ml-12 mt-2 laptop:ml-12">{{ answer.answer }}</h1>
                    

                    <div class="gap-x-2 mt-8">
                        <div class="flex flex-col gap-y-4 items-end laptop:min-w-[40%] laptop:max-w-[90%] laptop:ml-auto" >
                            <div v-for="(reply, index) in answer.replies" :key="index" class="bg-white/10 p-2 inline-block rounded-t-[15px] rounded-br-[15px] laptop:p-4 relative">
                                <div class="flex flex-col">
                                    <span class="text-sm fone-semibold text-white/80">{{ reply.user ? reply.user.name : reply.audience.name }}</span>
                                    <span class="text-x-sm font-semibold text-[#D6D6D6]/80">{{ reply.human_created_at }}</span>
                                </div>

                                <p class="text-sm font-medium leading-[20.8px] text-white ml-4 mt-2">
                                    {{ reply.content }}
                                </p>

                            </div>
                        </div>
                    </div>
                    
                    <div class="text-right my-4 laptop:mr-8">
                        <span class="text-sm text-white/60 font-medium border-b border-white/40" @click.stop="dropReply(answer.id)">{{ answer.id === dropId ? 'close' : 'replies' }}</span>
                    </div>

                    <transition name="slide-down">
                        <div v-if="dropId === answer.id" class="flex gap-x-2 w-full laptop:w-auto justify-end">
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
                                    laptop:w-auto" 
                                    placeholder="reply"
                                    type="text" v-model="reply">
                            <button class="px-2 py-1 bg-white text-black/80 font-medium rounded-full text-sm" @click="replyAns(0, answer.id)" type="button">Reply</button>
                        </div>                            
                    </transition>

                </div>
            </div>

            </div>
    </div>
    <CollectUserDataComponent @create-answer="createAnswer(answerId)" @reply="replyAns(replyId, answerId)" ref="collectUserData"/>

</template>


<script setup>

import { onMounted, ref } from 'vue';
import { useForumStore } from '../stores/forumStore';
import { useRoute } from 'vue-router';
import { useShowsStore } from '../stores/ShowsStore';
import CollectUserDataComponent from '../components/CollectUserDataComponent.vue';
import { useUserStore } from '../stores/userStore';

const route = useRoute();
const forumStore = useForumStore();
const showStore = useShowsStore();
const userStore = useUserStore();
const topic = ref({});
const answer = ref('');
const reply = ref('');
const dropId = ref();
const collectUserData = ref(null);

onMounted(async () => {

    if(!forumStore.forums.length) {

        await forumStore.getForums(); 

    }

    if (!showStore.shows.length) {

        await showStore.fetchShows();

    }

    topic.value = forumStore.getTopics(route.params.forumid, route.params.showId);

})

function dropReply(answerid) {
    if (answerid === dropId.value) {
        dropId.value = 0;
    } else {
        dropId.value = answerid;
    }
} 

async function collectData(emittype) {
    await collectUserData.value.openModal(emittype);
}

// eslint-disable-next-line no-unused-vars
function createAnswer(forumId) {
    if (answer.value) {

        if (!Object.keys(userStore.audience).length && !userStore.token) {
            collectData('createAnswer');
            return '';
        }

        const formData = new FormData();

        formData.append('answer', answer.value);

        if (Object.keys(userStore.audience).length) {
            formData.append('audienceId', userStore.audience.id);
        }

        forumStore.createAnswer(formData, route.params.forumid, route.params.showId).then(res => {
            answer.value = '';
            
            return res;
        })
    }
}


function replyAns(repyid, answerid) {
    if (reply.value) {

        if (!Object.keys(userStore.audience).length && !userStore.token) {
                collectData('reply');
                return '';
            }

        const formData = new FormData();

        if (Object.keys(userStore.audience).length) {
            formData.append('audienceId', userStore.audience.id);
        }

        formData.append('reply', reply.value);
        forumStore.createReply(formData, answerid, 'answer', route.params.showId, route.params.forumid).then(res => {
            reply.value = '';
            return res;

        })
    }
}



</script>

<style>
</style>