import { defineStore } from "pinia";

export const useMainStore = defineStore("main", {
  state: () => ({
    /* User */
    userName: null,
    userEmail: null,
    userAvatar: null,
    userNotification: null,

    /* Field focus with ctrl+k (to register only once) */
    isFieldFocusRegistered: false,
  }),
  actions: {
    setUser(payload) {
      if (payload.name) {
        this.userName = payload.name;
      }
      if (payload.email) {
        this.userEmail = payload.email;
      }
      if (payload.avatar) {
        this.userAvatar = payload.avatar;
      }
      if (payload.email_subscribe) {
        if (payload.email_subscribe === 1) {
          this.userNotification = true;
        } else {
          this.userNotification = false;
        }
      }
    },
  },
});
