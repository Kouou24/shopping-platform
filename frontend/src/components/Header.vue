<template>
    <div class="header">
      <router-link to="/" class = "logo">批西好死</router-link>
      <!-- <div class="search-bar"> -->
        <!-- <input type="text" placeholder="註冊獲得全站優惠券與免運費" /> -->
        <!-- <button>搜尋</button> -->
      <!-- </div> -->
      <div class="user-options" v-if="authStore.isLoggedIn === false">
        <router-link to="/register" class="nav-item">註冊</router-link>
        <router-link to="/login" class="nav-item">登入</router-link>
        <a href="#"><img src="/picture/shopping-cart.png" alt="購物車" /></a>
      </div>
      <div class="user-options" v-if="authStore.isLoggedIn === true">
        <router-link to="/myaccount" class="nav-item">我的帳戶</router-link>
        <router-link to="/" class="nav-item" @click="handleLogout">登出</router-link>
        <a href="#"><img src="/picture/shopping-cart.png" alt="購物車" /></a>
      </div>
    </div>
  </template>

<script setup>
import { useAuthStore } from '../stores/auth';

const authStore = useAuthStore();

const handleLogout = () =>{
  authStore.logout()
};
</script>

<style scoped>
    .header {
        background-color: #FF5CCD;
        padding: 10px 20px;
        color: white;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .header a.logo {
        font-size: 24px;
        font-weight: bold;
        color: white;
        text-decoration: none; 
    }

    .header a.logo:hover {
        color: white;
        text-decoration: none;
    }
    .user-options {
    display: flex;
    align-items: center;
    gap: 15px;
}

.user-options a {
    color: white;
    text-decoration: none;
    font-size: 16px;
}

.user-options img {
    width: 24px;
    height: 24px;
    vertical-align: middle;
}
.nav-item {
    margin: 0 15px;
    text-decoration: none;
    color: #333;
    font-size: 16px;
    }
</style>