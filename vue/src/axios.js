import axios from 'axios';
import { useNotificationStore } from './stores/NotiStore';

const axiosClient = axios.create({
    baseURL : 'https://burmapodcast.network/api'
    // baseURL : 'http://localhost:8000/api'
})

axiosClient.interceptors.request.use((config) => {
    const token = window.localStorage.getItem('token');

    if(token) {
        config.headers.Authorization = `Bearer ${token}`;
    }

    return config;
})

axiosClient.interceptors.response.use(
    (response) => {
        const notiStore = useNotificationStore();
      
        if(response.data.errors && typeof response.data.errors === 'object') {
            const errors = Object.values(response.data.errors)
            .map((errorArray) => errorArray.join(', '))
            .join(', ');

            notiStore.showNotification(errors, 'error');

        } else if (response.data.success) {

            notiStore.showNotification(response.data.success, 'info');

        }

        return response;
    },
    (error) => {
        const notiStore = useNotificationStore();

        if (error.response.status === 503) {
            notiStore.showNotification(error.response.data.msg, 'error');
        }
        if (error.response && error.response.data.errors && typeof error.response.data.errors === 'object') {
            console.log(error);
            const errors = Object.values(error.response.data.errors)
            .map((errorArray) => errorArray.join(', '))
            .join(', ');

            notiStore.showNotification(errors, 'error');
        } else if (error.response && error.response.data.error) {
            notiStore.showNotification(error.response.data.error, 'error');
        }

        return Promise.reject(error);
    }
)

export default axiosClient;