	import { defineStore } from "pinia";
import axiosClient from '../axios';
export const useUserStore = defineStore('UserStore', {
    state : () => {
        return {
            users : [],
            audience : getAudienceFromStorage(),
            token : localStorage.getItem('token'),
            user_level : Number(localStorage.getItem('user_level')),
            user_id : Number(localStorage.getItem('user_id')),
            logs : [],
            prev_url : '',
            next_url : '',
            current_page : '',
            total_page : '',
        }
    },
    actions : {
        fetchLog () {
            return axiosClient.get('fetchLog').then(res => {
                if (res.status === 200) {
                    this.logs = res.data.log.data;
                    this.prev_url = res.data.log.prev_page_url;
                    this.next_url = res.data.log.next_page_url;
                    this.current_page = res.data.log.current_page;
                    this.total_page = res.data.log.last_page;
                }
            })
        },
        getNextLog () {
            if (this.next_url) {
                return axiosClient.get(this.next_url).then(res => {
                    if (res.status === 200) {
                        this.logs = res.data.log.data;
                        this.prev_url = res.data.log.prev_page_url;
                        this.next_url = res.data.log.next_page_url;
                        this.current_page = res.data.log.current_page;
                        this.total_page = res.data.log.last_page;
                    }
                })
            }
        },
        getPrevLog () {
            if (this.prev_url) {
                return axiosClient.get(this.prev_url).then(res => {
                    if (res.status === 200) {
                        this.logs = res.data.log.data;
                        this.prev_url = res.data.log.prev_page_url;
                        this.next_url = res.data.log.next_page_url;

                        this.current_page = res.data.log.current_page;
                        this.total_page = res.data.log.last_page;
                    }
                })
            }
        },
      async getUsers() {
            return axiosClient.get('users').then((res) => {

                this.users = res.data.users;
                return res.data;

            })
        },
        login (payload) {
            return axiosClient.post('/login', payload).then(res => {
                console.log('from then');
                localStorage.setItem('token', res.data.token);
                localStorage.setItem('user_level', res.data.user_level);
                localStorage.removeItem('audience');
                localStorage.setItem('user_id', res.data.user_id);
                this.token = res.data.token;
                this.user_level = res.data.user_level;
                this.user_id = res.data.user_id;
                return res;
            })
        },
        register(payload) {
            return axiosClient.post('/signin', payload).then(res => {
                if (res.data.success) {
                    this.users.push(res.data.user);
                    return res;
                }
            })
        },
        logout () {
            return axiosClient.post('/logout').then(res => {
                if (res.data.success) {
                    this.token = '';
                    this.users = [];
                    localStorage.removeItem('token');
                    localStorage.removeItem('user_level');
                    localStorage.removeItem('user_id');
                    return res.data
                }
            })
        },
        addAudience (payload) {
            return axiosClient.post('audience', payload).then(res => {
                if (res.status === 200) {
                    this.audience = res.data.audience;
                    localStorage.setItem('audience', JSON.stringify(res.data.audience));
                   
                    return res;
                }
            })
        },
        updateUser (payload, userId) {
            const config = {
                Headers : {
                    'Content-Type' : 'multipart/form-data'
                },
                params : {
                    _method : 'PUT'
                }
            }
            return axiosClient.post(`updateUser/${userId}`, payload, config).then(res => {
                if (res.status === 200) {
                    for (let i = 0; i < this.users.length; i++) {
                        if (this.users[i].id === res.data.user.id) {
                            this.users[i] = res.data.user;
                            return res;
                        }
                    }
                }
            })
        },
        deleteUser (userId) {
            return axiosClient.delete(`deleteUser/${userId}`).then(res => {
                if (res.status === 200) {
                    this.users = this.users.filter(usr => {
                        return usr.id !== res.data.user.id;
                    });
                    return res;
                }
            })
        },
        resendVerify (payload) {
            return axiosClient.post('email/resend', payload).then(res => {
                return res;
            })
        },
        forgotPwd (payload) {
            return axiosClient.post('forgotPwd', payload).then(res => {
                return res;
            })
        },
        resetPwd (payload) {
            return axiosClient.post('resetPwd', payload).then(res => {
                return res;
            })
        }
    },
    getters : {
        hasValideToken : (state) => {
            return (state.token) ? true : false;
        },
        isAdmin : (state) => {
            return state.user_level === 3 ? true : false;
        },
        isHost : (state) => {
            return state.user_level === 2 ? true : false;
        },
        iscoHost : (state) => {
            return state.user_level === 1 ? true : false;
        }
    }
})

function getAudienceFromStorage() {
    const audience = localStorage.getItem('audience');
    return audience ? JSON.parse(localStorage.getItem('audience')) : {};
}
