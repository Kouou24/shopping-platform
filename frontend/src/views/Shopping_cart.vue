quantity<template>
    <div class="cart-page">
      <header class="cart-header">
        <h1>購物車</h1>
      </header>
  
      <section class="cart-items-section" v-if="cartItems.length">
        <div v-for="item in cartItems" :key="item.Product_ID" class="cart-item">
          <img :src="item.imgLink" :alt="item.Product_Name" class="cart-item-image" />
          <div class="cart-item-info">
            <h3 class="cart-item-name">{{ item.Product_Name }}</h3>
            <p>單價：${{ item.Price }}</p>
            <div class="quantity-control">
              <button @click="updateQuantity(item.Product_ID, -1)" :disabled="item.currentStockQuantity === 1">-</button>
              <span>{{ item.currentStockQuantity }}</span>
              <button @click="updateQuantity(item.Product_ID, 1)" :disabled="item.currentStockQuantity === item.Stock_quantity">+</button>
            </div>
          </div>
          <div class="cart-item-actions">
            <p>小計：${{ (item.Price * item.currentStockQuantity).toFixed(2) }}</p>
            <button class="remove-item" @click="removeItem(item.Product_ID)">刪除</button>
          </div>
        </div>
      </section>
  
      <section class="cart-summary" v-else>
        <p>您的購物車是空的。</p>
      </section>
  
      <footer v-if="cartItems.length" class="cart-footer">
        <div class="total-price">總計：${{ totalPrice }}</div>
        <router-link to="/checkout"><button class="checkout-button" @click="checkout">前往結帳</button></router-link>
      </footer>
    </div>
  </template>

  <script setup>
  import { ref, computed, onMounted } from 'vue';
  import { useAuthStore } from '../stores/auth';
  import axios from 'axios';

  const authStore = useAuthStore();
  
  const cartItems = ref([]);
  const ProductLoad = async () => {
    const loadedItems = [];
    for (const id of authStore.shoppingCartList) {
      try {
        const { data } = await axios.get("http://127.0.0.1:8000/api/products/" + id);
        if(loadedItems.some(item => item.Product_ID === data[0].Product_ID))
        {
          const item = loadedItems.find(item => item.Product_ID === data[0].Product_ID)
          item.currentStockQuantity += 1;
        }
        else
        {
          data[0].currentStockQuantity = 1;
          loadedItems.push(data[0]);
        }
      } catch (error) {
        console.error("Error loading product with id:", id, error);
      }
    }
    cartItems.value = loadedItems;
    console.log("所有商品已加載:", cartItems.value);
  };

  const totalPrice = computed(() => {
    return cartItems.value
      .reduce((total, item) => total + item.Price * item.currentStockQuantity, 0)
      .toFixed(2);
  });
  
  const updateQuantity = (id, delta) => {
    const item = cartItems.value.find((item) => item.Product_ID === id);
    if (item) {
      item.currentStockQuantity += delta;
      console.log(item);
    }
  };
  
  const removeItem = (id) => {
    console.log(id);
    cartItems.value = cartItems.value.filter((item) => item.Product_ID !== id);
    authStore.removeShoppingCartListById(id);
  };
  
  const checkout = () => {
    alert("前往結帳，總計金額：$" + totalPrice.value);
    // 這裡可以添加跳轉到結帳頁面的邏輯
  };

  onMounted(() => {
    ProductLoad();
  });
  </script>
  
  
  <style>
  .cart-page {
    padding: 20px;
    background-color: #f9f9f9;
  }
  
  .cart-header {
    text-align: center;
    margin-bottom: 20px;
  }
  
  .cart-items-section {
    background: white;
    border-radius: 8px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
  }
  
  .cart-item {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    border-bottom: 1px solid #ddd;
    padding-bottom: 10px;
  }
  
  .cart-item-image {
    width: 80px;
    height: 80px;
    margin-right: 20px;
    border-radius: 8px;
    object-fit: cover;
  }
  
  .cart-item-info {
    flex: 1;
  }
  
  .cart-item-name {
    font-size: 1.2rem;
    margin-bottom: 5px;
  }
  
  .quantity-control {
    display: flex;
    align-items: center;
  }
  
  .quantity-control button {
    background: #ff5722;
    color: white;
    border: none;
    padding: 5px 10px;
    margin: 0 5px;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .quantity-control button:disabled {
    background: #ccc;
    cursor: not-allowed;
  }
  
  .cart-item-actions {
    text-align: right;
  }
  
  .remove-item {
    background: #e64a19;
    color: white;
    border: none;
    padding: 5px 10px;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .cart-summary {
    text-align: center;
    padding: 20px;
    font-size: 1.2rem;
  }
  
  .cart-footer {
    margin-top: 20px;
    text-align: center;
  }
  
  .total-price {
    font-size: 1.5rem;
    margin-bottom: 10px;
  }
  
  .checkout-button {
    background: #4caf50;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 1rem;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .checkout-button:hover {
    background: #45a049;
  }
  </style>
  