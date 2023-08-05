<template>
    <div class="mx-4 mt-8 tablet:mx-8">

        <div class="rounded-[15px]">

            <h2 class="text-white/80 mt-2 text-base font-semibold leading-[24px]">{{ topic.title }}</h2>
            <p class="text-white text-lg leading-[30px]">{{ topic.body }}</p>

        </div>

        <div class="flex flex-col gap-y-4">

            <!-- <label for="answer">Response</label> -->

            <textarea v-model="answer" name="answer" id="answer" cols="5" placeholder="your response" class="bg-transparent h-[20vh] appearance-none focus:outline-none text-white w-full p-2 rounded-[15px] border border-[#D6D6D6]/60 focus:border-[#D6D6D6] placeholder:text-white/40"></textarea>

            <div class="text-end mt-4">
                <span class="inline-block bg-white rounded-full px-2 py-1 text-black/80 text-sm font-medium"  @click.stop="response">Response</span>
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
                    
                    <button @click.stop="deleteAnswer(answer.id, topic.id)" class="absolute top-4 left-0 group">
                        <div>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path class="fill-[#CCCCCC] group-hover:fill-[#CCCCCC]/80 group-active:fill-[#CCCCCC]" d="M20 5C20.2652 5 20.5196 5.10536 20.7071 5.29289C20.8946 5.48043 21 5.73478 21 6C21 6.26522 20.8946 6.51957 20.7071 6.70711C20.5196 6.89464 20.2652 7 20 7H19L18.997 7.071L18.064 20.142C18.0281 20.6466 17.8023 21.1188 17.4321 21.4636C17.0619 21.8083 16.5749 22 16.069 22H7.93C7.42414 22 6.93707 21.8083 6.56688 21.4636C6.1967 21.1188 5.97092 20.6466 5.935 20.142L5.002 7.072C5.00048 7.04803 4.99982 7.02402 5 7H4C3.73478 7 3.48043 6.89464 3.29289 6.70711C3.10536 6.51957 3 6.26522 3 6C3 5.73478 3.10536 5.48043 3.29289 5.29289C3.48043 5.10536 3.73478 5 4 5H20ZM16.997 7H7.003L7.931 20H16.069L16.997 7ZM14 2C14.2652 2 14.5196 2.10536 14.7071 2.29289C14.8946 2.48043 15 2.73478 15 3C15 3.26522 14.8946 3.51957 14.7071 3.70711C14.5196 3.89464 14.2652 4 14 4H10C9.73478 4 9.48043 3.89464 9.29289 3.70711C9.10536 3.51957 9 3.26522 9 3C9 2.73478 9.10536 2.48043 9.29289 2.29289C9.48043 2.10536 9.73478 2 10 2H14Z"/>
                            </svg>
                        </div>
                    </button>

                    <div class="flex gap-x-2 mt-8">
                        <div class="flex flex-col gap-y-4 items-end laptop:min-w-[40%] laptop:max-w-[90%] laptop:ml-auto" >
                            <div v-for="(reply, index) in answer.replies" :key="index" class="bg-white/10 p-2 inline-block rounded-t-[15px] rounded-br-[15px] laptop:p-4 relative">
                                <div class="flex flex-col">
                                    <span class="text-sm fone-semibold text-white/80">{{ reply.user ? reply.user.name : reply.audience.name }}</span>
                                    <span class="text-x-sm font-semibold text-[#D6D6D6]/80">{{ reply.human_created_at }}</span>
                                </div>

                                <p class="text-sm font-medium leading-[20.8px] text-white ml-4 mt-2">
                                    {{ reply.content }}
                                </p>
                                <button class="absolute top-2 right-2 group" @click.stop="deleteReply(reply.id, answer.id, topic.id)">
                                <div>
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path class="fill-[#CCCCCC] group-hover:fill-[#CCCCCC]/80 group-active:fill-[#CCCCCC]" d="M20 5C20.2652 5 20.5196 5.10536 20.7071 5.29289C20.8946 5.48043 21 5.73478 21 6C21 6.26522 20.8946 6.51957 20.7071 6.70711C20.5196 6.89464 20.2652 7 20 7H19L18.997 7.071L18.064 20.142C18.0281 20.6466 17.8023 21.1188 17.4321 21.4636C17.0619 21.8083 16.5749 22 16.069 22H7.93C7.42414 22 6.93707 21.8083 6.56688 21.4636C6.1967 21.1188 5.97092 20.6466 5.935 20.142L5.002 7.072C5.00048 7.04803 4.99982 7.02402 5 7H4C3.73478 7 3.48043 6.89464 3.29289 6.70711C3.10536 6.51957 3 6.26522 3 6C3 5.73478 3.10536 5.48043 3.29289 5.29289C3.48043 5.10536 3.73478 5 4 5H20ZM16.997 7H7.003L7.931 20H16.069L16.997 7ZM14 2C14.2652 2 14.5196 2.10536 14.7071 2.29289C14.8946 2.48043 15 2.73478 15 3C15 3.26522 14.8946 3.51957 14.7071 3.70711C14.5196 3.89464 14.2652 4 14 4H10C9.73478 4 9.48043 3.89464 9.29289 3.70711C9.10536 3.51957 9 3.26522 9 3C9 2.73478 9.10536 2.48043 9.29289 2.29289C9.48043 2.10536 9.73478 2 10 2H14Z"/>
                                    </svg>
                                </div>
                                </button>
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
                            <button class="px-2 py-1 bg-white text-black/80 font-medium rounded-full text-sm" @click="replyAns(answer.id)" type="button">Reply</button>
                        </div>                            
                    </transition>

                </div>
            </div>

        </div>
        
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useForumStore } from '../stores/forumStore';
import { useRoute } from 'vue-router';
import { useShowsStore } from '../stores/ShowsStore';
const route = useRoute();

const forumStore = useForumStore();
const showStore = useShowsStore();

const topic = ref({});
const answer = ref('');
const reply = ref('');
const dropId = ref();

onMounted(async () => {

    if (!forumStore.forums.length) {
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

function response() {
    if (answer.value) {
        const formData = new FormData();

        formData.append('answer', answer.value);

        forumStore.createAnswer(formData, route.params.forumid, route.params.showId).then(res => {
            answer.value = '';
            
            return res;
        })
    }
}

function deleteAnswer(answerId, forumId) {
    forumStore.deleteAnswer(answerId, forumId, Number(route.params.showId)).then(res => {
        console.log(res);
    })
}

function replyAns(answerid) {
    if (reply.value) {
        const formData = new FormData();

        formData.append('reply', reply.value);
        forumStore.createReply(formData, answerid, 'answer', route.params.showId, route.params.forumid).then(res => {
            reply.value = '';
            return res;
        })
    }
}

function deleteReply(replyId, answerId, forumId) {
    
    forumStore.deleteReply(replyId, answerId, forumId, Number(route.params.showId)).then(res => {
        console.log(res);
    });
}

</script>

<style>
</style>