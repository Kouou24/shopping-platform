// src/stores/authStore.js
import { defineStore } from 'pinia';

export const useAuthStore = defineStore('auth', {
  state: () => ({
    isLoggedIn: false,
    memberID: null, // 新增 memberID 屬性
    shoppingCartList:[],
    totalMoney:0,
  }),
  actions: {
    login() {
      this.isLoggedIn = true;
    },
    logout() {
      this.isLoggedIn = false;
      this.memberID = null; // 登出時清除 memberID
      this.totalMoney = 0;
    },
    setMemberID(memberID) {
      this.memberID = memberID; // 設定 memberID
    },
    setMoney(money){
      this.totalMoney = money;
    },
    addShopingCartList(productID){
      this.shoppingCartList.push(productID);
      this.shoppingCartList.sort((a, b) => a - b);
    },
    removeOneShoppingCartItem(productID){
      const index = this.shoppingCartList.indexOf(productID);
      if(index != -1){
        this.shoppingCartList.splice(index, 1);
      }
    },
    removeShoppingCartListById(productID){
      this.shoppingCartList = this.shoppingCartList.filter(item => item !== productID);
      console.log(this.shoppingCartList);
    },
    removeAllShoppingCart(){
      while(this.shoppingCartList.length){
        this.shoppingCartList.pop();
      }
    }
  },
});
