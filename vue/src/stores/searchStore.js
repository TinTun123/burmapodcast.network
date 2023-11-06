import { defineStore } from "pinia";
import axiosClient from "../axios";

export const useSearchStore = defineStore('SearchStore', {
    state : () => {
        return {
            episodes : [],
            openSearch : false,
            query : '',
            searching : false,
        }
    },

    actions : {
        searchQuery (text, category) {
            this.searching = true;
            return axiosClient.get(`search?query=${text}&category=${category}`).then(res => {
                if (res.status === 200) {
                    this.episodes = res.data.episodes;
                    this.searching = false;
                    return res;
                }
            }).catch(error => {
                this.searching = false;
                console.log(error);
            })
        },
        searchByHost(id) {
            this.searching = true;

            return axiosClient.get(`searchByHost?id=${id}`).then(res => {
                if (res.status === 200) {
                    this.episodes = res.data.episodes;
                    this.searching = false;
                    return res;
                }
            }).catch (error => {
                this.searching = false;
                console.log(error);
            });
        }
    }
})