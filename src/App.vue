<template>
    <webheader />
    <navigation />
    <router-view></router-view>
    <webfooter />
</template>

<script setup>
  import webheader from "./components/Header.vue"
  import navigation from "./components/Navigation.vue"
  import webfooter from "./components/Footer.vue"
</script>

<style scoped>

</style>
