import { defineStore } from 'pinia';
import axiosClient from '../axios';
import { useProgressStore } from './progressStore';


export const useShowsStore = defineStore('Shows', {
    // eslint-disable-next-line no-unused-labels
    state : () => {

        return {
            shows : [],
            episodes : [],
            currentShow : {},
            currentEpisode : {},
            myFavorite : JSON.parse(localStorage.getItem('myFavorite')) ? JSON.parse(localStorage.getItem('myFavorite')) : [],
            playList : JSON.parse(localStorage.getItem('playlist')) ? JSON.parse(localStorage.getItem('playlist')) : [],
            preEpisode : {},
            nexrEpisode : {},
            latestEpi : {},
            mostWatchEpi : {},
            likeEpiId : JSON.parse(localStorage.getItem('likeEpiId')) ? JSON.parse(localStorage.getItem('likeEpiId')) : []
        }
    },

    getters : {

        getSeason : (state) => {
            return (id) => {
                return state.shows.find(show => show.id === id).seasons;
            }
        },
        seasonCount : (state) => {
            return state.currentShow.seasons ? state.currentShow.seasons.length : 0;
        },
        isLike : (state) => {
            return (epiId) => {
                
                return state.likeEpiId ? state.likeEpiId.includes(Number(epiId)) : false;
            }
        },
        getshowTitle : (state) => {
            return (showid) => {
                const show  = state.shows.find(sho => sho.id === Number(showid));
                if (show) {
                    return show.title;
                }
                return '';
            }
        }

    },
    actions : {
        createShow (payload) {
            return axiosClient.post('/show/createShow', payload).then(res => {
                if (res.data.success) {
                    this.shows.push(res.data.show);
                }
                return res;
            })
        },
        editShow (payload, id) {
            const config = {
                Headers : {
                    'Content-Type' : 'multipart/form-data'
                },
                params : {
                    _method : 'PUT'
                }
            }
            return axiosClient.post(`/show/${id}`, payload, config).then(res => {
                
                if (res.status === 200) {
                    this.currentShow = res.data.show;
                    for (let i = 0; i < this.shows.length; i++) {
                        console.log(this.shows[i].id === res.data.show.id);
                        if (this.shows[i].id === res.data.show.id) {
                            this.shows[i] = res.data.show;

                            console.log(this.currentShow);
                        }
                    }

                }
                return 'success';
            })
        },
        deleteShow (showId) {
            return axiosClient.delete(`/show/deleteShow/${showId}`).then(res => {
                this.shows = this.shows.filter(show => {
                    return show.id !== Number(res.data.showId);
                })

                return res;
            })
        },
        createEpisode (payload, showId) {

            return axiosClient.post(`/show/createEpisode/${showId}`, payload, {
                onUploadProgress : function (progressEvent) {
                    const progressStore = useProgressStore();
                    const progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    progressStore.setProgress(progress);
                }
            }).then(res => {
                if (res.status === 200) {
                    const progressStore = useProgressStore();
                    progressStore.setProgress(0);

                    if (res.data.episode) {
                        for (let i = 0; i < this.episodes.length; i++) {
                            if (this.episodes[i].id === showId) {
                                for (let j = 0; j < this.episodes[i].seasons.length; j++) {
                                    if (this.episodes[i].seasons[j].id === res.data.episode.season_id) {
                                        this.episodes[i].seasons[j].episodes.push(res.data.episode);
    
                                    }
                                }
                            }
                        }
                        
                        for (let i = 0; i < this.currentShow.seasons.length; i++) {
                            if (this.currentShow.seasons[i].id === res.data.episode.season_id) {
                                this.currentShow.seasons[i].episodes.push(res.data.episode);
                            }
                        }
                    } else if (res.data.season) {
                        for (let i = 0; i < this.episodes.length; i++) {
                            if (this.episodes[i].id === showId) {
                                this.episodes[i].seasons.push(res.data.season);
                            }
                        }

                        this.currentShow.seasons.push(res.data.season);
                        console.log(this.currentShow.seasons);
                    }

                }
                return res;
            // eslint-disable-next-line no-unused-vars
            }).catch(error => {
                const progressStore = useProgressStore();
                progressStore.setProgress(0);
            })
        },
        
        editEpisode (payload, showId, epiId) {
            const progressStore = useProgressStore();

            return axiosClient.post(`show/editEpisode/${showId}/${epiId}`, payload, {
                params : {
                    _method : 'PUT'
                },
                onUploadProgress : (progressEvent) => {
                    
                    const progress = Math.round((progressEvent.loaded * 100) / progressEvent.total);
                    progressStore.setProgress(progress)
                }
            }).then (res => {
                
                if (res.status === 200) {

                    progressStore.setProgress(0);

                    for (let i = 0; i < this.episodes.length; i++) {

                        if (this.episodes[i].id === showId) {

                            for (let j = 0; j < this.episodes[i].seasons.length; j++) {

                                if (this.episodes[i].seasons[j].id === res.data.episode.season_id) {

                                    for (let k = 0; k < this.episodes[i].seasons[j].episodes.length; k++) {

                                        if (this.episodes[i].seasons[j].episodes[k].id === res.data.episode.id) {
                                            
                                            this.episodes[i].seasons[j].episodes[k] = res.data.episode;
                                            
                                            return res;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            })
        },

        deleteEpisode (epID, showId) {

            return axiosClient.delete(`/show/${epID}`).then(res => {
                if (res.status === 200) {
                    for (let i = 0; i < this.episodes.length; i++) {

                        if(this.episodes[i].id === Number(showId)) {
                          
                            for (let j = 0; j < this.episodes[i].seasons.length; j++) {
                                
                                if (this.episodes[i].seasons[j].id === res.data.seasonId) {
                                  
                                    this.episodes[i].seasons[j].episodes = this.episodes[i].seasons[j].episodes.filter(epi => {

                                        return epi.id !== res.data.epId

                                    });

                                    return res;

                                }
                            }
                        }
                    }
                }
                console.log(res.status);
            })
        },

        likeEpisode(epi, showTitle, showId) {
            const index = this.likeEpiId.indexOf(Number(epi.id));
            console.log(index);
            if (index !== -1) {
                return '';
            }
            epi['show_title'] = showTitle;
            epi['show_id'] = showId;
            this.myFavorite.push(epi);
            localStorage.setItem('myFavorite', JSON.stringify(this.myFavorite));

            return axiosClient.post(`likeEpisode/${epi.id}`).then(res => {
                this.likeEpiId.push(res.data.epiId);

                localStorage.setItem('likeEpiId', JSON.stringify(this.likeEpiId));
                return res;
            })
        },

        addplaylist (epi, showId, showTitle) {

            epi['show_id'] = showId;
            epi['show_title'] = showTitle;

            const existIndex = this.playList.findIndex(list => {
                return list.id === epi.id;
            });

            if (existIndex !== -1) {

                this.playList.splice(existIndex, 1);
                
            }


            this.playList.unshift(epi);
            localStorage.setItem('playlist', JSON.stringify(this.playList));

            return '';

        },
        isListen (epi) {
            const index = this.playList.findIndex(list => {
                return list.id === epi.id;
            });

            if (index === -1) {
                return false;
            } else {
                return true;
            }
        },
        incrementEpicount (epiId) {
            return axiosClient.get(`listen/${epiId}`).then(res => {
                console.log(res);
                return res;
            })
        },
        fetchShows() {
          
            return axiosClient.get('/show').then(res => {
                if (res.status === 200 || res.status === 304) {
                    this.shows = res.data.shows
                }
                    
              
                return res.data.success;
            })
        },
        fetchLatest () {

            return axiosClient.get('/latestEpisode').then(res => {

                if (res.status === 200) {
                    this.latestEpi.episode = res.data.episode;
                    this.latestEpi.type = 'Latest'
                   
                }

                return res;
            })

        },
        fetchMostListen() {

            return axiosClient.get('/mostlistenEpisode').then(res => {

                if (res.status === 200) {
                    this.mostWatchEpi.episode = res.data.episode;
                    this.mostWatchEpi.type = 'Most Listen'
                }   

                return res;
            })

        },
        async getShow(id) {

            for(let i = 0; i < this.episodes.length; i++) {
                if (this.episodes[i].id === Number(id)) {

                    this.currentShow = this.episodes[i];
                    return '';

                }
            }
            return axiosClient.get(`/show/${id}`).then(res => {

                if (res.status === 200 || res.status === 304) {

                    this.episodes.push(res.data.episodes);
                    this.currentShow = res.data.episodes;
                    
                }

                console.log('current show', this.currentShow);

                return '';
            })
        },

        getNext (episodeId) {

            for(let i = 0; i < this.currentShow.seasons.length; i++) {
                    
                    const currentIndex = this.currentShow.seasons[i].episodes.findIndex(epi => epi.id === episodeId);
                    
                    if (currentIndex === this.currentShow.seasons[i].episodes.length - 1) {
                        
                        if (this.currentShow.seasons[i + 1]) {

                            return this.currentShow.seasons[i + 1].episodes[0];

                        } else {

                            return {};

                        }
                    }

                    if (currentIndex !== -1) {

                        return this.currentShow.seasons[i].episodes[currentIndex + 1];

                    }

                    return {};
            }
        },
        getPre (episodeId) {
            
            for(let i = 0; i < this.currentShow.seasons.length; i++) {
                    
                const currentIndex = this.currentShow.seasons[i].episodes.findIndex(epi => epi.id === episodeId);

                console.log('currentIndex', currentIndex);

                if (currentIndex === 0) {
                    
                    if (this.currentShow.seasons[i - 1]) {

                        return this.currentShow.seasons[i - 1].episodes[this.currentShow.seasons[i - 1].episodes.length - 1];

                    } else {

                        return {};

                    }
                }

                if (currentIndex !== -1) {

                    return this.currentShow.seasons[i].episodes[currentIndex - 1];

                }

                return {};
            }
        }
    }
})
