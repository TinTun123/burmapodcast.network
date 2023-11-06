<template>
    <div>
        <div class="flex justify-between">

            <div class="inline-block mt-4 relative">
                <div @click.stop="dropEpi = !dropEpi" class="flex items-center bg-[#404040] w-[100px] rounded-full justify-between px-2 py-1 gap-x-2 transition-all" :class="[dropEpi ? 'rounded-b-[0px] rounded-t-[15px]' : 'rounded-full']">
                    <div class="flex gap-x-1 items-center justify-center overflow-hidden">
                        <span class="text-sm text-white overflow-hidden whitespace-nowrap leading-6" style="text-overflow: ellipsis;">{{ selectedEpi.title }}</span>
                    </div>

                    <div>
                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1.63605 5.62381C1.82358 5.42463 2.07788 5.31273 2.34305 5.31273C2.60821 5.31273 2.86252 5.42463 3.05005 5.62381L8.00005 10.8832L12.95 5.62381C13.1387 5.43027 13.3913 5.32318 13.6535 5.3256C13.9156 5.32802 14.1665 5.43976 14.3519 5.63676C14.5373 5.83375 14.6424 6.10024 14.6447 6.37883C14.647 6.65741 14.5462 6.9258 14.364 7.12619L8.70705 13.1368C8.51952 13.3359 8.26521 13.4478 8.00005 13.4478C7.73488 13.4478 7.48058 13.3359 7.29305 13.1368L1.63605 7.12619C1.44858 6.92694 1.34326 6.65674 1.34326 6.375C1.34326 6.09326 1.44858 5.82306 1.63605 5.62381Z" fill="#DDDDDD"/>
                        </svg>
                    </div>
                </div>

                <transition name="slide-down">
                    <div v-if="dropEpi" class="bg-[#404040] absolute overflow-hidden w-[100px] rounded-b-[15px]">

                        <ul class="transition-all text-center">
                            <li v-for="(epi, i) in episodes" :key="i" @click.stop="selectedEpi = epi; dropEpi = !dropEpi" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30 overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">{{ epi.title }}</li>
                           
                        </ul>

                    </div>
                </transition>

            </div>

            <div class="flex gap-x-4 items-center">

                <div class="inline-block mt-4 relative">
                    <div @click.stop="droptime = !droptime" class="flex items-center bg-[#404040] w-[100px] rounded-full justify-between px-2 py-1 gap-x-2 transition-all" :class="[droptime ? 'rounded-b-[0px] rounded-t-[15px]' : 'rounded-full']">
                        <div class="flex gap-x-1 items-center justify-center overflow-hidden">
                            <span class="text-sm text-white overflow-hidden whitespace-nowrap leading-6" style="text-overflow: ellipsis;">{{ selectedTime }}</span>
                        </div>


                        <div>
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.63605 5.62381C1.82358 5.42463 2.07788 5.31273 2.34305 5.31273C2.60821 5.31273 2.86252 5.42463 3.05005 5.62381L8.00005 10.8832L12.95 5.62381C13.1387 5.43027 13.3913 5.32318 13.6535 5.3256C13.9156 5.32802 14.1665 5.43976 14.3519 5.63676C14.5373 5.83375 14.6424 6.10024 14.6447 6.37883C14.647 6.65741 14.5462 6.9258 14.364 7.12619L8.70705 13.1368C8.51952 13.3359 8.26521 13.4478 8.00005 13.4478C7.73488 13.4478 7.48058 13.3359 7.29305 13.1368L1.63605 7.12619C1.44858 6.92694 1.34326 6.65674 1.34326 6.375C1.34326 6.09326 1.44858 5.82306 1.63605 5.62381Z" fill="#DDDDDD"/>
                            </svg>
                        </div>
                    </div>

                    <transition name="slide-down">
                        <div v-if="droptime" class="bg-[#404040] absolute overflow-hidden w-[100px] rounded-b-[15px]">

                            <ul class="transition-all text-center">
                                <li @click.stop="selectedTime = 'weeks'; droptime = !droptime; selectedEach = monthArr[0];" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30 overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">weeks</li>
                                <li @click.stop="selectedTime = 'months'; droptime = !droptime; selectedEach = yearsArr[0];" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30 overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">months</li>
                                <li @click.stop="selectedTime = 'years'; droptime = !droptime;" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30  overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">years</li>
                            </ul>

                        </div>
                    </transition>

                </div>

                <div v-if="selectedTime !== 'years'" class="inline-block mt-4 relative">
                    <div @click.stop="dropeach = !dropeach" class="flex items-center bg-[#404040] w-[100px] rounded-full justify-between px-2 py-1 gap-x-2 transition-all laptop:cursor-pointer" :class="[dropeach ? 'rounded-b-[0px] rounded-t-[15px]' : 'rounded-full']">
                        <div  class="flex gap-x-1 items-center justify-center overflow-hidden">
                            <span class="text-sm text-white overflow-hidden whitespace-nowrap leading-6" style="text-overflow: ellipsis;">{{ selectedEach }}</span>
                        </div>


                        <div>
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M1.63605 5.62381C1.82358 5.42463 2.07788 5.31273 2.34305 5.31273C2.60821 5.31273 2.86252 5.42463 3.05005 5.62381L8.00005 10.8832L12.95 5.62381C13.1387 5.43027 13.3913 5.32318 13.6535 5.3256C13.9156 5.32802 14.1665 5.43976 14.3519 5.63676C14.5373 5.83375 14.6424 6.10024 14.6447 6.37883C14.647 6.65741 14.5462 6.9258 14.364 7.12619L8.70705 13.1368C8.51952 13.3359 8.26521 13.4478 8.00005 13.4478C7.73488 13.4478 7.48058 13.3359 7.29305 13.1368L1.63605 7.12619C1.44858 6.92694 1.34326 6.65674 1.34326 6.375C1.34326 6.09326 1.44858 5.82306 1.63605 5.62381Z" fill="#DDDDDD"/>
                            </svg>
                        </div>
                    </div>

                    <transition name="slide-down">
                        <div v-if="dropeach" class="bg-[#404040] overflow-hidden w-[100px] absolute overflow-y-scroll max-h-[150px] rounded-b-[15px]">

                            <ul class="transition-all text-center">
                                <li @click.stop="selectedEach = item; dropeach = !dropeach" v-for="(item, i) in selectedTime === 'weeks' ? monthArr : yearsArr" :key="i" class="p-2 text-white/80 font-medium laptop:hover:bg-white/20 transition-all laptop:cursor-pointer active:bg-white/30 overflow-hidden whitespace-nowrap border-t border-gray-400/20" style="text-overflow: ellipsis;">{{ item }}</li>
                            </ul>

                        </div>
                    </transition>
                </div>

            </div>            

        </div>

        <div class="grid grid-cols-1 laptop:grid-cols-3 gap-4">
            <div>
                <Bar id="my-chart" :options="LikeschatOptions" :data="likesChartData"/>
            </div>

            <div>
                <Bar id="my-chart" :options="DownloadchatOptions" :data="downloadChartData"/>
            </div>

            <div>
                <Bar id="my-chart" :options="CommentschatOptions" :data="commentsChartData"/>                
            </div>
       
            <div>
                <Bar id="my-chart" :options="ListenchatOptions" :data="listenChartData"/>                
            </div>

            <div>
                <Bar id="my-chart" :options="shareChatOptions" :data="shareChartData"/>                
            </div>

        </div>

        <h1 class="mt-4 flex gap-x-4 items-center">
            <div>
                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.21804 0.5V9.28195H16C15.5982 13.3345 12.1784 16.5 8.02005 16.5C3.59058 16.5 0 12.9094 0 8.47995C0 4.32155 3.16551 0.901804 7.21804 0.5ZM8.82205 0.5C10.6626 0.685421 12.3826 1.50124 13.6907 2.80932C14.9988 4.1174 15.8146 5.83736 16 7.67794H8.82205V0.5Z" fill="#969696"/>
                </svg>
            </div>
            <span class="text-white/80 font-semibold">Geo-graphical statistic</span>
        </h1>

        <div class="grid grid-cols-1 laptop:grid-cols-3 gap-4">
            <div>
                <Bar id="my-chart" :options="LikesGeoOptions" :data="likesGeoData"/>
            </div>

            <div>
                <Bar id="my-chart" :options="downloadGeoOptions" :data="downloadGeoData"/>
            </div>

            <div>
                <Bar id="my-chart" :options="CommentsGeoOptions" :data="commentsGeoData"/>                
            </div>
       
            <div>
                <Bar id="my-chart" :options="ListenGeoOptions" :data="listenGeoData"/>                
            </div>

            <div>
                <Bar id="my-chart" :options="shareGeoOptions" :data="shareGeoData"/>                
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue';
import { Bar } from 'vue-chartjs';
import { useStatisticStore } from '../stores/statisticStore';
import { useShowsStore } from '../stores/ShowsStore';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale);

const statisticStore = useStatisticStore();
const showStore = useShowsStore();

const props = defineProps(['episodes', 'show']);

const droptime = ref(false);
const dropEpi = ref(false);
const selectedTime = ref('weeks');
const selectedEach = ref('January');
const selectedEpi = ref({
    title : '',
    id : ''
})

const dropeach = ref(false);

const monthArr = ref([
    'January',
    'February',
    'March',
    'April', 
    'May', 
    'June', 
    'July', 
    'August', 
    'September', 
    'October', 
    'November', 
    'December'
])


const yearsArr = ref([
        '2020',
        '2021',
        '2022',
        '2023',
        '2024'
]);

function getDataByWeek() {
    statisticStore.getDataByWeek(selectedEach.value, selectedEpi.value.id, props.show.id);
}

function getDataByMonths() {

    statisticStore.getDataByMonth(selectedEach.value, selectedEpi.value.id, props.show.id);

}

function getDataByYears() {

    statisticStore.getDataByYear(selectedEpi.value.id, props.show.id);

}

async function getDataByGeo() {
    console.log('getGeoEpiData');
    await statisticStore.getDataByGeo(selectedEpi.value.id, props.show.id);

}

watch([selectedEach, selectedTime, selectedEpi], ([newEach, newTime, newEpi]) => {

    if (selectedTime.value === 'weeks') {

        getDataByWeek();

    } else if (selectedTime.value === 'months') {

        getDataByMonths();

    } else if (selectedTime.value === 'years') {

        getDataByYears();

    }

    // getDataByGeo();

});

onMounted(() => {

    yearsArr.value = statisticStore.showData.years;
    selectedEpi.value = props.episodes[0];

    getDataByGeo();

})

const getLikeTitle = computed(() => {

    let retStr = 'No data available';

    if (selectedTime.value === 'weeks') {

        retStr =  `Weekly likes rate for ${selectedEach.value}`;

    } else if (selectedTime.value === 'months') {

        retStr = `Monthly likes rate for ${selectedEach.value}`;

    } else if (selectedTime.value === 'years') {

        retStr = `Yearly likes rate`;
    }

    return retStr;
})

const getDownloadTitle = computed(() => {

    let retStr = 'No data available';

    if (selectedTime.value === 'weeks') {
        retStr =  `Weekly download rate for ${selectedEach.value}`;
    } else if (selectedTime.value === 'months') {
        retStr = `Monthly download rate for ${selectedEach.value}`
    } else if (selectedTime.value === 'years') {
        retStr = `Yearly download rate`;
    }
    return retStr;
})

const getCommentsTitle = computed(() => {

    let retStr = 'No data available';

    if (selectedTime.value === 'weeks') {
        retStr =  `Weekly comments rate for ${selectedEach.value}`;
    } else if (selectedTime.value === 'months') {
        retStr = `Monthly comments rate for ${selectedEach.value}`
    } else if (selectedTime.value === 'years') {
        retStr = `Yearly comments rate`;
    }
    return retStr;
})

const getListenTitle = computed(() => {

    let retStr = 'No data available';

    if (selectedTime.value === 'weeks') {
        retStr =  `Weekly listen rate for ${selectedEach.value}`;
    } else if (selectedTime.value === 'months') {
        retStr = `Monthly listen rate for ${selectedEach.value}`
    } else if (selectedTime.value === 'years') {
        retStr = `Yearly listen rate`;
    }

    return retStr;
})


const getShareTitle = computed(() => {

    let retStr = 'No data available';

    if (selectedTime.value === 'weeks') {
        retStr =  `Weekly share rate for ${selectedEach.value}`;
    } else if (selectedTime.value === 'months') {
        retStr = `Monthly share rate for ${selectedEach.value}`
    } else if (selectedTime.value === 'years') {
        retStr = `Yearly share rate`;
    }

    return retStr;
})


const likesChartData = computed(() => {
    let chartdataret = {};
    if (statisticStore.likeEpiTemData.data && statisticStore.likeEpiTemData.labels.length) {
        chartdataret = {
            labels : statisticStore.likeEpiTemData.labels,
            datasets : [{
                label : 'Likes',
                backgroundColor : '#f87979', 
                data  : statisticStore.likeEpiTemData.data
            }]
        };
    } else {
        chartdataret = {
            labels : statisticStore.likeEpiTemData.labels,
            datasets : [{
                label : 'Likes',
                backgroundColor : '#f87979', 
                data  : []
            }]
        };
    }

    return chartdataret;
});

const likesGeoData = computed(() => {
    let chartdatare = {};
    if(statisticStore.likeEpiGeoData.data && statisticStore.likeEpiGeoData.labels.length) {
        chartdatare = {
            labels : statisticStore.likeEpiGeoData.labels,
            datasets : [{
                label : 'Likes',
                backgroundColor : '#8CBAFF', 
                data  : statisticStore.likeEpiGeoData.data
            }]
        };
    } else {
        chartdatare = {
            labels : [],
            datasets : [{
                label : 'Likes',
                backgroundColor : '#8CBAFF', 
                data  : []
            }]
        };
    }


    return chartdatare;
});

const downloadChartData = computed(() => {
    let chartdataret = {};

    if (statisticStore.downloadEpiTemData.data && statisticStore.downloadEpiTemData.data.length) {
        chartdataret = {
            labels : statisticStore.downloadEpiTemData.labels,
            datasets : [{
                label : 'Download',
                backgroundColor : '#F2F879', 
                data  : statisticStore.downloadEpiTemData.data
            }]
        };
    } else {
        chartdataret = {
            labels : statisticStore.downloadEpiTemData.labels,
            datasets : [{
                label : 'Download',
                backgroundColor : '#F2F879', 
                data  : []
            }]
        };
    }



    return chartdataret;
});

const downloadGeoData = computed(() => {

    let chartdatare = {};
    if(statisticStore.downloadEpiGeoData.data && statisticStore.downloadEpiGeoData.labels.length) {
        chartdatare = {
            labels : statisticStore.downloadEpiGeoData.labels,
            datasets : [{
                label : 'Download',
                backgroundColor : '#8CFFC8', 
                data  : statisticStore.downloadEpiGeoData.data
            }]
        };
    } else {
        chartdatare = {
            labels : [],
            datasets : [{
                label : 'Download',
                backgroundColor : '#8CFFC8', 
                data  : []
            }]
        };
}


return chartdatare;
});

const commentsChartData = computed(() => {

    let chartdataret = {};

    if (statisticStore.commentsEpiTemData.data && statisticStore.commentsEpiTemData.data.length) {
        chartdataret = {
            labels : statisticStore.commentsEpiTemData.labels,
            datasets : [{
                label : 'Comments',
                backgroundColor : '#83F879', 
                data  : statisticStore.commentsEpiTemData.data
            }]
        };
    } else {
        chartdataret = {
            labels : statisticStore.commentsEpiTemData.labels,
            datasets : [{
                label : 'Comments',
                backgroundColor : '#83F879', 
                data  : []
            }]
        };
    }

    return chartdataret;
});


const commentsGeoData = computed(() => {
    let chartdatare = {};
    if(statisticStore.commentsEpiGeoData.data && statisticStore.commentsEpiGeoData.labels.length) {
        chartdatare = {
            labels : statisticStore.commentsEpiGeoData.labels,
            datasets : [{
                label : 'Comments',
                backgroundColor : '#A3FF8C', 
                data  : statisticStore.commentsEpiGeoData.data
            }]
        };
    } else {
        chartdatare = {
            labels : [],
            datasets : [{
                label : 'Comments',
                backgroundColor : '#A3FF8C', 
                data  : []
            }]
        };
    }


    return chartdatare;
});


const listenChartData = computed(() => {
    let chartdataret = {};

    if (statisticStore.listenEpiTemData.data && statisticStore.listenEpiTemData.data.length) {

        chartdataret = {
            labels : statisticStore.listenEpiTemData.labels,
            datasets : [{
                label : 'Listen',
                backgroundColor : '#79F8F8', 
                data  : statisticStore.listenEpiTemData.data
            }]
        };

    } else {

        chartdataret = {
            labels : statisticStore.listenEpiTemData.labels,
            datasets : [{
                label : 'Listen',
                backgroundColor : '#79F8F8', 
                data  : []
            }]
        };

    }

    return chartdataret;

});

const listenGeoData = computed(() => {
    let chartdatare = {};
    if(statisticStore.listenEpiGeoData.data && statisticStore.listenEpiGeoData.labels.length) {
        chartdatare = {
            labels : statisticStore.listenEpiGeoData.labels,
            datasets : [{
                label : 'Listen',
                backgroundColor : '#FF8C8C', 
                data  : statisticStore.listenEpiGeoData.data
            }]
        };
    } else {
        chartdatare = {
            labels : [],
            datasets : [{
                label : 'Listen',
                backgroundColor : '#FF8C8C', 
                data  : []
            }]
        };
    }
    return chartdatare;
});

const shareChartData = computed(() => {

    let chartdataret = {};

    if (statisticStore.shareEpiTemData.data && statisticStore.shareEpiTemData.data.length) {

        chartdataret = {
            labels : statisticStore.shareEpiTemData.labels,
            datasets : [{
                label : 'Share',
                backgroundColor : '#F879EB', 
                data  : statisticStore.shareEpiTemData.data
            }]
        };

    } else {

        chartdataret = {
            labels : statisticStore.shareEpiTemData.labels,
            datasets : [{
                label : 'Share',
                backgroundColor : '#F879EB', 
                data  : []
            }]
        };

    }

    return chartdataret;
});


const shareGeoData = computed(() => {

    let chartdatare = {};
    if(statisticStore.shareEpiGeoData.data && statisticStore.shareEpiGeoData.labels.length) {
        chartdatare = {
            labels : statisticStore.shareEpiGeoData.labels,
            datasets : [{
                label : 'Share',
                backgroundColor : '#F7FF8C', 
                data  : statisticStore.shareEpiGeoData.data
            }]
        };
    } else {
        chartdatare = {
            labels : [],
            datasets : [{
                label : 'Share',
                backgroundColor : '#F7FF8C', 
                data  : []
            }]
        };
    }

    return chartdatare;
});

// 
const LikeschatOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: getLikeTitle.value,
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

const LikesGeoOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: 'Like user geo-graphical distribution',
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

const DownloadchatOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: getDownloadTitle.value,
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

const downloadGeoOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: 'Download users geo-graphical distribution',
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

// 

const CommentschatOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: getCommentsTitle.value,
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

const CommentsGeoOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: 'Comments users geo-graphical distribution',
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

// 

const ListenchatOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: getListenTitle.value,
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

const ListenGeoOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: 'Geo-graphical representation of listener',
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

const shareChatOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: getShareTitle.value,
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 

const shareGeoOptions = computed(() => {
    return {
        responsive : true,
        plugins: {
            legend : {
                display : true
            },
            title: {
                display: true,
                text: 'Geo-graphical representation of sharer',
                color : '#666666',
                align : 'start'
            }
        }
        
    };
}) 




</script>

<style>

</style>