// src/stores/authStore.js
import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    isLoggedIn: false,
    memberID: null, // 新增 memberID 屬性
  }),
  actions: {
    login() {
      this.isLoggedIn = true;
    },
    logout() {
      this.isLoggedIn = false;
      this.memberID = null; // 登出時清除 memberID
    },
    setMemberID(memberID) {
      this.memberID = memberID; // 設定 memberID
    },
  },
});
