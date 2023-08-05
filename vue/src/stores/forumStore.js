
import { defineStore } from 'pinia';
import axiosClient from '../axios';

export const useForumStore = defineStore('Forum', {
  state : () => {
    return {
        forums : [],
        answers : [],
    }
  },
  actions : {
    addTopic (payload) {
        return axiosClient.post('forum', payload).then(res => {
            if (res.status === 200) {
              for(let i = 0; i < this.forums.length; i++) {
                if (this.forums[i].id === Number(res.data.forum.show_id)) {
                  
                  this.forums[i].forum.push(res.data.forum);
                  return res;
                }
              }
            }
            return res;
        })
    },
    deleteForum(forumId, showId) {
      return axiosClient.delete(`/forum/${forumId}`).then(res => {
        if (res.status === 200) {
          for (let i = 0; i < this.forums.length; i++) {
            if (this.forums[i].id === Number(showId)) {
              console.log('found matching show id');
              this.forums[i].forum = this.forums[i].forum.filter(foru => {
                return foru.id !== res.data.forumId;
              });
              return res;
            }
          }     
        }


        return res;
      })
    },
    // eslint-disable-next-line no-unused-vars
    editTopic (payload, forumId, showId) {

      const config = {

        Headers : {
            'Content-Type' : 'multipart/form-data'
        },
        params : {
            _method : 'PUT'
        }

    }

      return axiosClient.post(`forum/${forumId}`, payload, config).then(res => {
        
        if (res.status === 200) {
          // for (let i = 0; i < this.forums.length; i++) {
          //   if (this.forums[i].id === showId) {
              
          //     this.forums[i].forum = this.forums[i].forum.filter(forum => {
          //       return forum.id !== Number(res.data.forum.id);
          //     });


          //     if (showId === Number(res.data.forum.show_id)) {
            
          //       this.forums[i].forum.push(res.data.forum);
          //       return res;
          //     }

          //     for (let j = 0; j < this.forums.length; j++) {
          //       if (this.forums[j].id == Number(res.data.forum.show_id)) {
                 
          //         this.forums[j].forum.push(res.data.forum);
          //         return res;
          //       }
          //     }
              
          //   }
          // }
          this.getForums();
          return res;
        }
        
      })
    },
    createAnswer (payload, forumid, showId) {
      return axiosClient.post(`answer/${forumid}`, payload).then(res => {
        
        if (res.status === 200) {
          for (let i = 0; i < this.forums.length; i++) {
           
            if (this.forums[i].id === Number(showId)) {
             ;
              for (let j = 0; j < this.forums[i].forum.length; j++) {

                if (this.forums[i].forum[j].id === Number(forumid)) {

                  this.forums[i].forum[j].answers.push(res.data.answer);
                 
                  return res;
                }
              }
            }
          }
        }
      })
    },
    deleteAnswer (answerId, forumId, showId) {

      return axiosClient.delete(`answer/${answerId}`).then(res => {
        if (res.status === 200) {

          for (let i = 0; i < this.forums.length; i++) {
            if (this.forums[i].id === showId) {

              for(let j = 0; j < this.forums[i].forum.length; j++) {

                if (this.forums[i].forum[j].id === forumId) {

                  this.forums[i].forum[j].answers = this.forums[i].forum[j].answers.filter(ans => {
                    return ans.id !== answerId;
                  })

                  return '';

                }
              }
            }
            
          }
        }
        return res;
      })
    },
    createReply (payload, Id, type, showId, forumId) {
      return axiosClient.post(`reply/${Id}?type=${type}`, payload).then(res => {
        
        if (res.status === 200) {
          for (let i = 0; i < this.forums.length; i++) {

            if (this.forums[i].id === Number(showId)) {

              for (let j = 0; j < this.forums[i].forum.length; j++) {

                if (this.forums[i].forum[j].id === Number(forumId)) {

                  for (let k = 0; k < this.forums[i].forum[j].answers.length; k++) {

                    if (this.forums[i].forum[j].answers[k].id === Number(Id)) {
                     
                      this.forums[i].forum[j].answers[k].replies.push(res.data.reply);
                      return res;
                    }
                  }
                  return res;
                }
              }
            }
          }
        }
        return res;
      })
    },
    deleteReply (replyId, answerId, forumId, showId)  {
      return axiosClient.delete(`reply/${replyId}`).then(res => {
        if (res.status === 200) {
          for (let i = 0; i < this.forums.length; i++) {
            if (this.forums[i].id === showId) {

              for(let j = 0; j < this.forums[i].forum.length; j++) {

                if (this.forums[i].forum[j].id === forumId) {
                  
                  for (let k = 0; k < this.forums[i].forum[j].answers.length; k++) {

                    if (this.forums[i].forum[j].answers[k].id === answerId) {

                      this.forums[i].forum[j].answers[k].replies = this.forums[i].forum[j].answers[k].replies.filter(rep => {
                        return rep.id !== replyId;
                      })
                      return '';
                    }
                  }
                }
              }
            }
            
          }
        }
      })
    },
    getForums () {
      return axiosClient.get('forum').then(res => {
        if (res.status === 200) {
          this.forums = res.data.forums;
          return res;
        }
        return res;
      })
    }
  },
  getters : {
    getTopics :  (state) => {

        return (forumid, showId) =>  {
          let forum = [];
          const show = state.forums.find((show) => {
           
            return show.id === Number(showId)
          });

          if (show) {
            forum = show.forum.find((forumpara) => {
              return forumpara.id === Number(forumid);
            })
          }

          return forum;
        }
    },
    getFoumsList : (state) => {
      return (showId) => {
        let forums = [];
        const show = state.forums.find((show) => {
         
          return show.id === Number(showId);
        })

        if (Object.keys(show).length) {
          forums = show.forum;
        }



        return forums;
      }
    },
    getforums : (state) => {
      const forums = state.forums.filter(show => {
        return show.forum[0];
      });
      return forums;
    }
    }
})
