import { defineStore } from "pinia";

export const useProgressStore = defineStore('progress', {
    state : () => {
        return {
            progress : 0

        }
    },

    actions : {
        setProgress (pro) {
            console.log(pro);
            this.progress = pro;
        }
    }

})