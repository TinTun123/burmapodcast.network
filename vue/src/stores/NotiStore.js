// notificationStore.js
import { defineStore } from 'pinia';

export const useNotificationStore = defineStore('notification', {
  state: () => ({
    message: null,
    type: null,
  }),
  getters: {
    hasMessage: (state) => state.message !== null,
  },
  actions: {
    showNotification(message, type = 'info') {
      this.message = message;
      this.type = type;
      
      setTimeout(() => this.closeNotification(), 5000); // Automatically close after 5 seconds
    },
    closeNotification() {
      this.message = null;
      this.type = null;
    },
  },
});
