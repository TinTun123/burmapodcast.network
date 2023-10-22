
import { defineStore } from 'pinia'
import axiosClient from '../axios'

export const useStatisticStore = defineStore('Statistic', {
    state : () => {
        return {
            weekArr : ['week-1', 'week-2', 'week-3', 'week-4', 'week-5'],
            monthArr : [
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
            ],
            showData : {},
            temporalShowData : [],
            likeTotalTemData : {
                data : [],
                labels : []
            },
            commentsTotalTemData : {
                data : [],
                labels : []
            },
            listenTotalTemData : {
                data : [],
                labels : []
            },
            shareTotalTemData : {
                data : [],
                labels : []
            },
            downloadTotalTemData : {
                data : [],
                labels : []
            },
            geoShowData : [],
            likeTotalGeoData : {
                data : [],
                labels : []
            },
            commentsTotalGeoData : {
                data : [],
                labels : []
            },
            listenTotalGeoData : {
                data : [],
                labels : []
            },
            shareTotalGeoData : {
                data : [],
                labels : []
            },
            downloadTotalGeoData : {
                data : [],
                labels : []
            },

            temporalEpiData : [],
            likeEpiTemData : {
                data : [],
                labels : []
            },
            commentsEpiTemData : {
                data : [],
                labels : []
            },
            listenEpiTemData : {
                data : [],
                labels : []
            },
            shareEpiTemData : {
                data : [],
                labels : []
            },
            downloadEpiTemData : {
                data : [],
                labels : []
            },
            geoEpiData : [],
            likeEpiGeoData : {
                data : [],
                labels : []
            },
            commentsEpiGeoData : {
                data : [],
                labels : []
            },
            listenEpiGeoData : {
                data : [],
                labels : []
            },
            shareEpiGeoData : {
                data : [],
                labels : []
            },
            downloadEpiGeoData : {
                data : [],
                labels : []
            }
        }
    },
    actions : {
        resetData () {
            this.listenTotalTemData = {
                data : [],
                labels : []
            };

            this.likeTotalTemData = {
                data : [],
                labels : []
            };

            this.shareTotalTemData = {
                data : [],
                labels : []
            };

            this.commentsTotalTemData = {
                data : [],
                labels : []
            };

            this.downloadTotalTemData = {
                data : [],
                labels : []
            };
        },
        epiResetData () {
            this.listenEpiTemData = {
                data : [],
                labels : []
            };

            this.likeEpiTemData = {
                data : [],
                labels : []
            };

            this.shareEpiTemData = {
                data : [],
                labels : []
            };

            this.commentsEpiTemData = {
                data : [],
                labels : []
            };

            this.downloadEpiTemData = {
                data : [],
                labels : []
            };

        },
        getDataByWeek (monthstr, episodeId, showId) {
            if (episodeId === 0) {
                this.resetData();
            } else {
                this.epiResetData();
            }

            return axiosClient.get(`getStatisticByWeek/${episodeId}/${showId}`, {
                params : {
                    month : monthstr
                }
            }).then((res) => {


                if (episodeId === 0) {
                    this.temporalShowData = res.data.statistic;
                    const dataMap = new Map(this.temporalShowData.map(item => [item.week_number, item]));

                    for (let i = 0; i < this.weekArr.length; i++) {

                        if (dataMap.has(this.weekArr[i])) {

                            this.likeTotalTemData.labels.push(this.weekArr[i]);
                            this.likeTotalTemData.data.push(dataMap.get(this.weekArr[i]).like_count);
                        
                            this.listenTotalTemData.labels.push(this.weekArr[i]);
                            this.listenTotalTemData.data.push(dataMap.get(this.weekArr[i]).listen_count);

                            this.shareTotalTemData.labels.push(this.weekArr[i]);
                            this.shareTotalTemData.data.push(dataMap.get(this.weekArr[i]).share_count);

                            this.downloadTotalTemData.labels.push(this.weekArr[i]);
                            this.downloadTotalTemData.data.push(dataMap.get(this.weekArr[i]).download_count);

                            this.commentsTotalTemData.labels.push(this.weekArr[i]);
                            this.commentsTotalTemData.data.push(dataMap.get(this.weekArr[i]).comment_count);

                        } else {

                            this.likeTotalTemData.labels.push(this.weekArr[i]);
                            this.likeTotalTemData.data.push(0);

                            this.listenTotalTemData.labels.push(this.weekArr[i]);
                            this.listenTotalTemData.data.push(0);

                            this.shareTotalTemData.labels.push(this.weekArr[i]);
                            this.shareTotalTemData.data.push(0);

                            this.downloadTotalTemData.labels.push(this.weekArr[i]);
                            this.downloadTotalTemData.data.push(0);

                            this.commentsTotalTemData.labels.push(this.weekArr[i]);
                            this.commentsTotalTemData.data.push(0);

                        }
                    }

                    return res;
                } else {

                    this.temporalEpiData = res.data.statistic;

                    const dataMap = new Map(this.temporalEpiData.map(item => [item.week_number, item]));

                    for (let i = 0; i < this.weekArr.length; i++) {

                        if (dataMap.has(this.weekArr[i])) {

                            this.likeEpiTemData.labels.push(this.weekArr[i]);
                            this.likeEpiTemData.data.push(dataMap.get(this.weekArr[i]).like_count);
                        
                            this.listenEpiTemData.labels.push(this.weekArr[i]);
                            this.listenEpiTemData.data.push(dataMap.get(this.weekArr[i]).listen_count);

                            this.shareEpiTemData.labels.push(this.weekArr[i]);
                            this.shareEpiTemData.data.push(dataMap.get(this.weekArr[i]).share_count);

                            this.downloadEpiTemData.labels.push(this.weekArr[i]);
                            this.downloadEpiTemData.data.push(dataMap.get(this.weekArr[i]).download_count);

                            this.commentsEpiTemData.labels.push(this.weekArr[i]);
                            this.commentsEpiTemData.data.push(dataMap.get(this.weekArr[i]).comment_count);

                        } else {

                            this.likeEpiTemData.labels.push(this.weekArr[i]);
                            this.likeEpiTemData.data.push(0);

                            this.listenEpiTemData.labels.push(this.weekArr[i]);
                            this.listenEpiTemData.data.push(0);

                            this.shareEpiTemData.labels.push(this.weekArr[i]);
                            this.shareEpiTemData.data.push(0);

                            this.downloadEpiTemData.labels.push(this.weekArr[i]);
                            this.downloadEpiTemData.data.push(0);

                            this.commentsEpiTemData.labels.push(this.weekArr[i]);
                            this.commentsEpiTemData.data.push(0);

                        }
                    }

                    return res;
                }
                
            })
        },
        getDataByMonth (yearStr, episodeId, showId) {
            if (episodeId === 0) {
                this.resetData();
            } else {
                this.epiResetData();
            }

            return axiosClient.get(`getStatisticByMonth/${episodeId}/${showId}`, {
                params : {
                    year : yearStr
                }
            }).then(res => {
                if (episodeId === 0) {

                    this.temporalShowData = res.data.statistic;
             
                    const dataMap = new Map(this.temporalShowData.map(item => [item.month, item]));
    
                    for (let i = 0; i < this.monthArr.length; i++) {
    
                        if (dataMap.has(this.monthArr[i])) {
    
                            this.likeTotalTemData.labels.push(this.monthArr[i]);
                            this.likeTotalTemData.data.push(dataMap.get(this.monthArr[i]).like_count);
                        
                            this.listenTotalTemData.labels.push(this.monthArr[i]);
                            this.listenTotalTemData.data.push(dataMap.get(this.monthArr[i]).listen_count);
    
                            this.shareTotalTemData.labels.push(this.monthArr[i]);
                            this.shareTotalTemData.data.push(dataMap.get(this.monthArr[i]).share_count);
    
                            this.downloadTotalTemData.labels.push(this.monthArr[i]);
                            this.downloadTotalTemData.data.push(dataMap.get(this.monthArr[i]).download_count);
    
                            this.commentsTotalTemData.labels.push(this.monthArr[i]);
                            this.commentsTotalTemData.data.push(dataMap.get(this.monthArr[i]).comment_count);
    
                        } else {
    
                            this.likeTotalTemData.labels.push(this.monthArr[i]);
                            this.likeTotalTemData.data.push(0);
    
                            this.listenTotalTemData.labels.push(this.monthArr[i]);
                            this.listenTotalTemData.data.push(0);
    
                            this.shareTotalTemData.labels.push(this.monthArr[i]);
                            this.shareTotalTemData.data.push(0);
    
                            this.downloadTotalTemData.labels.push(this.monthArr[i]);
                            this.downloadTotalTemData.data.push(0);
    
                            this.commentsTotalTemData.labels.push(this.monthArr[i]);
                            this.commentsTotalTemData.data.push(0);
    
                        }
                    }
                } else {
                    this.temporalEpiData = res.data.statistic;
             
                    const dataMap = new Map(this.temporalEpiData.map(item => [item.month, item]));

                    for (let i = 0; i < this.monthArr.length; i++) {

                        if (dataMap.has(this.monthArr[i])) {

                            this.likeEpiTemData.labels.push(this.monthArr[i]);
                            this.likeEpiTemData.data.push(dataMap.get(this.monthArr[i]).like_count);
                        
                            this.listenEpiTemData.labels.push(this.monthArr[i]);
                            this.listenEpiTemData.data.push(dataMap.get(this.monthArr[i]).listen_count);

                            this.shareEpiTemData.labels.push(this.monthArr[i]);
                            this.shareEpiTemData.data.push(dataMap.get(this.monthArr[i]).share_count);

                            this.downloadEpiTemData.labels.push(this.monthArr[i]);
                            this.downloadEpiTemData.data.push(dataMap.get(this.monthArr[i]).download_count);

                            this.commentsEpiTemData.labels.push(this.monthArr[i]);
                            this.commentsEpiTemData.data.push(dataMap.get(this.monthArr[i]).comment_count);

                        } else {

                            this.likeEpiTemData.labels.push(this.monthArr[i]);
                            this.likeEpiTemData.data.push(0);

                            this.listenEpiTemData.labels.push(this.monthArr[i]);
                            this.listenEpiTemData.data.push(0);

                            this.shareEpiTemData.labels.push(this.monthArr[i]);
                            this.shareEpiTemData.data.push(0);

                            this.downloadEpiTemData.labels.push(this.monthArr[i]);
                            this.downloadEpiTemData.data.push(0);

                            this.commentsEpiTemData.labels.push(this.monthArr[i]);
                            this.commentsEpiTemData.data.push(0);

                        }
                    }
                }
                   

                return res;
            })

        },
        getDataByYear (episodeId, showId) {
            if (episodeId === 0) {
                this.resetData();
            } else {
                this.epiResetData();
            }

            return axiosClient.get(`getStatisticByYear/${episodeId}/${showId}`).then(res => {

                if (episodeId === 0) {
                    this.temporalShowData = res.data.statistic;

                    for (let i = 0; i < this.temporalShowData.length; i++) {
                        this.likeTotalTemData.labels.push(this.temporalShowData[i].year);
                        this.likeTotalTemData.data.push(this.temporalShowData[i].like_count);
                    
                        this.listenTotalTemData.labels.push(this.temporalShowData[i].year);
                        this.listenTotalTemData.data.push(this.temporalShowData[i].listen_count);
    
                        this.shareTotalTemData.labels.push(this.temporalShowData[i].year);
                        this.shareTotalTemData.data.push(this.temporalShowData[i].share_count);
    
                        this.downloadTotalTemData.labels.push(this.temporalShowData[i].year);
                        this.downloadTotalTemData.data.push(this.temporalShowData[i].download_count);
    
                        this.commentsTotalTemData.labels.push(this.temporalShowData[i].year);
                        this.commentsTotalTemData.data.push(this.temporalShowData[i].comment_count);
                    }
                } else {
                    this.temporalEpiData = res.data.statistic;

                    for (let i = 0; i < this.temporalEpiData.length; i++) {
                        this.likeEpiTemData.labels.push(this.temporalEpiData[i].year);
                        this.likeEpiTemData.data.push(this.temporalEpiData[i].like_count);
                    
                        this.listenEpiTemData.labels.push(this.temporalEpiData[i].year);
                        this.listenEpiTemData.data.push(this.temporalEpiData[i].listen_count);
    
                        this.shareEpiTemData.labels.push(this.temporalEpiData[i].year);
                        this.shareEpiTemData.data.push(this.temporalEpiData[i].share_count);
    
                        this.downloadEpiTemData.labels.push(this.temporalEpiData[i].year);
                        this.downloadEpiTemData.data.push(this.temporalEpiData[i].download_count);
    
                        this.commentsEpiTemData.labels.push(this.temporalEpiData[i].year);
                        this.commentsEpiTemData.data.push(this.temporalEpiData[i].comment_count);
                    }
                }
                
                return res;
            });

        },

        getDataByGeo (episodeId, showId) {

        

            return axiosClient.get(`getStatisticByGeo/${episodeId}/${showId}`).then(res => {

                if (episodeId === 0) {
                    this.geoShowData = res.data.statistic;

                    for (let i = 0; i < this.geoShowData.length; i++) {
                        this.likeTotalGeoData.labels.push(this.geoShowData[i].city);
                        this.likeTotalGeoData.data.push(this.geoShowData[i].like_count);
                    
                        this.listenTotalGeoData.labels.push(this.geoShowData[i].city);
                        this.listenTotalGeoData.data.push(this.geoShowData[i].listen_count);
    
                        this.shareTotalGeoData.labels.push(this.geoShowData[i].city);
                        this.shareTotalGeoData.data.push(this.geoShowData[i].share_count);
    
                        this.downloadTotalGeoData.labels.push(this.geoShowData[i].city);
                        this.downloadTotalGeoData.data.push(this.geoShowData[i].download_count);
    
                        this.commentsTotalGeoData.labels.push(this.geoShowData[i].city);
                        this.commentsTotalGeoData.data.push(this.geoShowData[i].comment_count);
                    }
                    return res;
                } else {
                    this.geoEpiData = res.data.statistic;

                for (let i = 0; i < this.geoEpiData.length; i++) {
                    this.likeEpiGeoData.labels.push(this.geoEpiData[i].city);
                    this.likeEpiGeoData.data.push(this.geoEpiData[i].like_count);
                
                    this.listenEpiGeoData.labels.push(this.geoEpiData[i].city);
                    this.listenEpiGeoData.data.push(this.geoEpiData[i].listen_count);

                    this.shareEpiGeoData.labels.push(this.geoEpiData[i].city);
                    this.shareEpiGeoData.data.push(this.geoEpiData[i].share_count);

                    this.downloadEpiGeoData.labels.push(this.geoEpiData[i].city);
                    this.downloadEpiGeoData.data.push(this.geoEpiData[i].download_count);

                    this.commentsEpiGeoData.labels.push(this.geoEpiData[i].city);
                    this.commentsEpiGeoData.data.push(this.geoEpiData[i].comment_count);
                }
                return res;
                }
               
            })
        },
        getShowData (showId) {
            return axiosClient.get(`getShowData/${showId}`).then(res => {
                
                this.showData = res.data.showData;

            })
        }
    }
})