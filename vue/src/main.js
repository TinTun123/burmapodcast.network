
import './assets/main.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'

if ('serviceWorker' in navigator) {

    navigator.serviceWorker.register('https://burmapodcast.network/service-worker.js')
    .then(registeration => {
        if(registeration.installing) {

            console.log('service worker installing');

        } else if (registeration.waiting) {

            console.log('service worker installed');

        } else if (registeration.active) {

            console.log('service worker active');

        }

    })
    .catch(error => {
        console.log('Service worker registeration failed:', error);
    })
}

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.mount('#app')
