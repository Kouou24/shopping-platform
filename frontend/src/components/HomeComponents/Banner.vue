<template>
    <div class="banner-container">
      <!-- 幻燈片區域 -->
      <div class="banner-slide" :style="{ transform: `translateX(-${currentSlide * 100}%)` }">
        <img v-for="(slide, index) in slides" :key="index" :src="slide" alt="Banner Slide" />
      </div>
  
      <!-- 左右按鈕 -->
      <div class="banner-controls">
        <button @click="prevSlide">❮</button>
        <button @click="nextSlide">❯</button>
      </div>
  
      <!-- 指示器 -->
      <div class="dots">
        <span
          v-for="(slide, index) in slides"
          :key="index"
          class="dot"
          :class="{ active: index === currentSlide }"
          @click="goToSlide(index)"
        ></span>
      </div>
    </div>
  </template>
  
<script setup>

</script>

  <script>
  export default {
    data() {
      return {
        slides: [
          'https://img1.momoshop.com.tw/ecm/img/online/10/999/00/000/bt_0_247_01/bt_0_247_01_P1_1_e2.jpg',
          'https://img3.momoshop.com.tw/ecm/img/online/10/999/00/000/bt_0_247_01/bt_0_247_01_P1_6_e2.jpg',
          'https://img3.momoshop.com.tw/ecm/img/online/10/999/00/000/bt_0_247_01/bt_0_247_01_P1_8_e2.jpg',
        ],
        currentSlide: 0, // 當前顯示的幻燈片索引
        intervalId: null, // 定時器 ID
      };
    },
    methods: {
      nextSlide() {
        this.currentSlide = (this.currentSlide + 1) % this.slides.length;
      },
      prevSlide() {
        this.currentSlide = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
      },
      goToSlide(index) {
        this.currentSlide = index;
      },
      startAutoSlide() {
        this.intervalId = setInterval(this.nextSlide, 3000); // 每 3 秒切換
      },
      stopAutoSlide() {
        clearInterval(this.intervalId);
      },
    },
    mounted() {
      this.startAutoSlide(); // 頁面載入後啟動自動輪播
    },
    beforeUnmount() {
      this.stopAutoSlide(); // 頁面卸載時清除定時器
    },
  };
  </script>
  
  <style scoped>
  .banner-container {
    position: relative;
    width: 100%;
    max-width: 1000px;
    margin: 20px auto;
    overflow: hidden;
  }
  
  .banner-slide {
    display: flex;
    transition: transform 0.5s ease-in-out;
  }
  
  .banner-slide img {
    width: 100%;
    flex-shrink: 0;
  }
  
  .banner-controls {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    display: flex;
    justify-content: space-between;
  }
  
  .banner-controls button {
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px;
    cursor: pointer;
  }
  
  .dots {
    text-align: center;
    margin-top: 10px;
  }
  
  .dots .dot {
    height: 12px;
    width: 12px;
    margin: 0 4px;
    background-color: #bbb;
    border-radius: 50%;
    display: inline-block;
    cursor: pointer;
  }
  
  .dots .dot.active {
    background-color: #717171;
  }
  </style>
  