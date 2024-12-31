// src/stores/authStore.js
import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    isLoggedIn: false,
    memberID: null, // 新增 memberID 屬性
    shoppingCartList:[],
  }),
  actions: {
    login() {
      this.isLoggedIn = true;
    },
    logout() {
      this.isLoggedIn = false;
      this.memberID = null; // 登出時清除 memberID
      this.addShopingCartList = [];
    },
    setMemberID(memberID) {
      this.memberID = memberID; // 設定 memberID
    },
    addShopingCartList(productID){
      this.shoppingCartList.push(productID);
      this.shoppingCartList.sort((a, b) => a - b);
    },
  },
});
