<template>
    <div class="mx-4 mt-8 tablet:mx-8">

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

                <div v-for="(forum , j) in show.forum" :key="j" @click="routeTo(forum.id, show.id)" 
                class="col-span-1 
                bg-[#D9D9D9]/10  
                rounded-[15px] p-4
                transition
                hover:bg-[#D9D9D9]/5
                active:bg-[#D9D9D9]/10
                relative">

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
    </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { useForumStore } from '../stores/forumStore';
import { onMounted } from 'vue';
import { useShowsStore } from '../stores/ShowsStore';



const router = useRouter();
const forumStore = useForumStore();
const showStore = useShowsStore();

onMounted(async () => {
    if(!forumStore.forums.length) {

        await forumStore.getForums(); 

    }

    if (!showStore.shows.length) {

        await showStore.fetchShows();

    }
})

function getDate(date) {
    const created_at = new Date(date);

    return created_at.toLocaleDateString(undefined, {
        month : 'short',
        day : 'numeric'
    });
}


function routeTo(forumId, showId) {
    router.push({
        name : 'audienceforum',
        params : {
            showId : showId,
            forumid : forumId
        }
    });
}

</script>

<style>

</style>