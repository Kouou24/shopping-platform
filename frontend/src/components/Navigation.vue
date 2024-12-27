<template>
    <nav class="nav">
        <!-- <router-link to="/" class="nav-item">首頁</router-link> -->
        <router-link to="/shop" class="nav-item">商場</router-link>
        <router-link to="/activity" class="nav-item">活動</router-link>
        <router-link to="/coupon" class="nav-item">優惠券</router-link>
        <router-link to="/client-service" class="nav-item">客戶服務</router-link>
  </nav>
</template>

<script>

</script>

<style scoped>
    .nav {
    display: flex;
    justify-content: center;
    background-color: #fff;
    padding: 10px 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .nav-item {
    margin: 0 15px;
    text-decoration: none;
    color: #333;
    font-size: 16px;
    }

    .nav-item.router-link-active {
    font-weight: bold;
    text-decoration: underline;
    color: #FF5CCD;
    }
</style>