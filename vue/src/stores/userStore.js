import { defineStore } from "pinia";
import axiosClient from '../axios';
export const useUserStore = defineStore('UserStore', {
    state : () => {
        return {
            users : [],
            audience : getAudienceFromStorage(),
            token : localStorage.getItem('token'),
            user_level : Number(localStorage.getItem('user_level')),
        }
    },
    actions : {
      async getUsers() {
            return axiosClient.get('users').then((res) => {

                this.users = res.data.users;
                return res.data;

            })
        },
        login (payload) {
            return axiosClient.post('/login', payload).then(res => {
                localStorage.setItem('token', res.data.token);
                localStorage.setItem('user_level', res.data.user_level);
                localStorage.removeItem('audience');
                this.token = res.data.token;
                this.user_level = res.data.user_level;
                return res.data;
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
        }
    },
    getters : {
        hasValideToken : (state) => {
            return (state.user_level === 2 && state.token) ? true : false;
        }
    }
})

function getAudienceFromStorage() {
    const audience = localStorage.getItem('audience');
    return audience ? JSON.parse(localStorage.getItem('audience')) : {};
}
