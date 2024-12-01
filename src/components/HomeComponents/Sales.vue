<template>
    <div class="hot-products">
      <h2>熱門商品</h2>
      <div class="product-list">
        <!-- 商品卡片 -->
        <div v-for="product in products" :key="product.id" class="product-card">
          <!-- TOP 標籤 -->
          <div v-if="product.isTop" class="top-label">TOP</div>
          <!-- 商品圖片 -->
          <img :src="product.image" :alt="product.name" class="product-image" />
          <!-- 商品名稱 -->
          <p class="product-name">{{ product.name }}</p>
          
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        products: [
          {
            id: 1,
            name: "Apple iPhone 16 Pro",
            image: "/picture/iphone16pro.png",
            isTop: true,
          },
          {
            id: 2,
            name: "電競鍵盤",
            image: "/picture/電競鍵盤.png",
            isTop: true,
          },
          {
            id: 3,
            name: "電競耳機",
            image: "/picture/電競耳機.png",
            isTop: true,
          },
          {
            id: 4,
            name: "平板電腦",
            image: "/picture/平板.png",
            isTop: true,
          },
          {
            id: 5,
            name: "筆記型電腦",
            image: "/picture/筆電.png",
            isTop: true,
          },
          {
            id: 6,
            name: "螢幕",
            image: "/picture/螢幕.png",
            isTop: true,
          },
        ],
      };
    },
  };
  </script>
  
  <style scoped>
  .hot-products {
  width: 90%;
  margin: 0 auto;
  text-align: center;
}

.product-list {
  display: flex;
  justify-content: center; /* 將商品列表置中 */
  gap: 20px; /* 卡片間距 */
  overflow-x: auto; /* 支持橫向滾動 */
  padding: 20px 0;
}

.product-card {
  width: 150px;
  border: 1px solid #ddd;
  border-radius: 8px;
  padding: 10px;
  text-align: center; /* 確保卡片內容置中 */
  background-color: #fff;
  position: relative;
}

.product-card .top-label {
  position: absolute;
  top: -10px;
  left: 50%;
  transform: translateX(-50%);
  background-color: orange;
  color: white;
  padding: 5px;
  font-size: 12px;
  font-weight: bold;
  border-radius: 4px;
}

.product-image {
  width: 100%;
  height: auto;
  margin-bottom: 10px;
}

.product-name {
  font-size: 14px;
  color: #333;
  margin-bottom: 5px;
}
  
  </style>
  