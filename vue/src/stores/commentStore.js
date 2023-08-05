
import { defineStore } from 'pinia'
import axiosClient from '../axios'
import { useNotificationStore } from './NotiStore'

export const useCommentStore = defineStore('comment', {
    state : () => {
        return {
            comments : [],
            currentComList : []
        }
    },
    actions : {

        createComment (payload, epiId) {
            return axiosClient.post(`comment/${epiId}`, payload).then(res => {
                if (res.status === 200) {

                    for (let i = 0; i < this.comments.length; i++) {
                        if (this.comments[i].episode_id === Number(epiId)) {
                            this.comments[i].comment.push(res.data.comment.comments)
                        }
                    }
                    this.currentComList.push(res.data.comment.comments);

                    console.log(this.comments);
                }
                return res;
            }).catch(error => {

                return error;
            })
        },
        deleteComment (commentId, episodeId) {
            // eslint-disable-next-line no-unused-vars
            return axiosClient.delete(`comment/${commentId}`).then(res => {
                if (res.status === 200) {
                    for (let i = 0; i < this.comments.length; i++) {
                        if (Number(this.comments[i].episode_id) === Number(episodeId)) {
                            console.log(this.comments[i].comments);
                            this.comments[i].comments = this.comments[i].comments.filter(cmt => {
                                return cmt.id !== Number(commentId);
                            })
                            console.log(this.comments[i].comments);

                            this.currentComList = this.currentComList.filter(cmt => {
                                return cmt.id !== Number(commentId);
                            })
                            return '';
                        }
                    }
                }
            })
        }

    },
    getters : {

        getComments : (state) => {
            return (epiId) => {
                let commentsRet = [];

                commentsRet = state.comments.find(comment => {
                    if (comment) {

                        return comment.episode_id === Number(epiId);
                    }
                });

                if (commentsRet) {
                    state.currentComList = commentsRet.comments;
                }

                axiosClient.get(`comments/${epiId}`).then(res => {
                    state.comments.push(res.data.episode);
           
                    state.currentComList = res.data.episode.comments;
                }).catch(error => {
                    const notiStore = useNotificationStore();
                    if (error.response.status === 503) {
                        notiStore.showNotification(error.response.data.msg, 'error');
                    }
                });

            }
        }

    }
})
