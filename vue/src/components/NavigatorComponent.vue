<template>

    <div class="flex gap-x-2 items-center">
     
            <div class="">

                <svg width="16" height="15" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.707 0.293031C11.5194 0.105559 11.2651 0.000244141 11 0.000244141C10.7348 0.000244141 10.4805 0.105559 10.293 0.293031L3.29296 7.29303L1.29296 9.29303C1.19745 9.38528 1.12127 9.49562 1.06886 9.61763C1.01645 9.73963 0.988862 9.87085 0.987709 10.0036C0.986555 10.1364 1.01186 10.2681 1.06214 10.391C1.11242 10.5139 1.18667 10.6255 1.28056 10.7194C1.37446 10.8133 1.48611 10.8876 1.60901 10.9379C1.7319 10.9881 1.86358 11.0134 1.99636 11.0123C2.12914 11.0111 2.26036 10.9835 2.38236 10.9311C2.50437 10.8787 2.61471 10.8025 2.70696 10.707L2.99996 10.414V17C2.99996 17.7957 3.31603 18.5587 3.87864 19.1214C4.44125 19.684 5.20431 20 5.99996 20H16C16.7956 20 17.5587 19.684 18.1213 19.1214C18.6839 18.5587 19 17.7957 19 17V10.414L19.293 10.707C19.4816 10.8892 19.7342 10.99 19.9964 10.9877C20.2586 10.9854 20.5094 10.8803 20.6948 10.6948C20.8802 10.5094 20.9854 10.2586 20.9876 9.99643C20.9899 9.73423 20.8891 9.48163 20.707 9.29303L11.707 0.293031Z" fill="#CCCCCC"/>
                </svg>

            </div>

            <div>

                <span class="text-white">/</span>

            </div>

            <div>

                <span class="text-white">
                    {{ base }}
                </span>

            </div>

            <div v-if="base">
                <span class="text-white">/</span>
            </div>

            <div>
                <span class="text-white">
                    {{ second }}
                </span>
            </div>

            <div v-if="second">
                <span class="text-white">/</span>
            </div>

            <div>
                <span class="text-white">
                    {{ third }}
                </span>
            </div>
    </div>

</template>

<script setup>
import { onMounted, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import { useShowsStore } from '../stores/ShowsStore';

const route = useRoute();
const base = ref('');
const second = ref('');
const third = ref('');
const showStore = useShowsStore();

onMounted(() => {
    base.value  = '';
    second.value = '';
    third.value = '';
    if (route.name === 'audienceShows') {
        base.value = 'shows';
    }

    if (route.name === 'episode') {
        base.value = 'shows';
        second.value = showStore.currentShow.title;
    }

    if (route.name === 'audienceforums') {
        base.value = 'forums'
    }

    if (route.name === 'audienceforum') {
        base.value = 'forums';
        second.value = showStore.getshowTitle(route.params.showId)
    }

    if (route.name === 'Adminforum') {
        base.value = 'adminDashboard'
    }

    if (route.name === 'forumShow') {
        base.value = 'adminDashBoard';
        second.value = showStore.getshowTitle(route.params.showId);
    }

    if (route.name === 'adminManageShows') {
        base.value = 'adminDashBoard'
    }

    if(route.name === 'adminShow') {
        base.value = 'adminDashBoard';
        second.value = showStore.getshowTitle(route.params.showId);
    }
})

watch(() => route.name, (newName, oldName) => {
    console.log(route.name);
    base.value  = '';
    second.value = '';
    third.value = '';

    if (newName === 'audienceShows') {
        base.value = 'shows';
    }

    if (newName === 'episode') {
        base.value = 'shows';
        second.value = showStore.currentShow.title;
    }

    if (newName === 'audienceforums') {
        base.value = 'forums'
    }

    if (newName === 'audienceforum') {
        base.value = 'forums';
        second.value = showStore.getshowTitle(route.params.showId)
    }

    if (route.name === 'audienceforums') {
        base.value = 'forums'
    }

    if (route.name === 'audienceforum') {
        base.value = 'forums';
        second.value = showStore.getshowTitle(route.params.showId)
    }

    if (route.name === 'Adminforum') {
        base.value = 'adminDashboard'
        second.value = 'forums'
    }

    if (route.name === 'forumShow') {
        base.value = 'adminDashboard';
        second.value = 'forums'
        third.value = showStore.getshowTitle(route.params.showId);
    }

    if (route.name === 'adminManageShows') {
        base.value = 'adminDashboard'
        second.value = 'shows'
    }

    if(route.name === 'adminShow') {
        base.value = 'adminDashboard';
        second.value = 'shows';
        third.value = showStore.currentShow.title;
    }

    if(route.name === 'adminManageHosts') {
        base.value = 'adminDashboard';
        second.value = 'hosts';
    }
})

</script>

<style>

</style>