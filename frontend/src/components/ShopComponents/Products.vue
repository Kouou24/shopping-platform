<template>
    <!-- 篩選欄 -->
    <div class="filters">
        <!-- 排序條件 -->
        <div class="sort-filters">
            <h3>排序條件</h3>
            <select v-model="sortOrder" @change="sortProducts">
                <option value="asc">價格：低到高</option>
                <option value="desc">價格：高到低</option>
                <option value="newest">最新上架</option>
            </select>
        </div>
    </div>

    <div>
    <input type="text" v-model="keyword" @keyup.enter ="LoadSearch" placeholder="搜尋商品"/>
    </div>

    <div class="product-list">
        <div v-for="product in sortedResult" v-bind:key="product.Product_ID" class="product-item">
            <img :src="product.imgLink" alt="商品">
            <div class="product-info">
                <h4>{{ product.Product_Name }}</h4>
                <p>價格：${{ product.Price }}</p>
                <p>{{ product.Product_Description }}</p>
                <button @click="showDetails(product)">詳細資訊</button>
            </div>
        </div>
    </div>

    <!-- 模態框 -->
    <div v-if="showModal" class="modal-overlay" @click="closeModal">
        <div class="modal-content" @click.stop>
            <img :src="selectedProduct.imgLink" class="model_img">
            <h3>{{ selectedProduct.Product_Name }}</h3>
            <p>描述：{{ selectedProduct.Product_Description }}</p>
            <p>價格：${{ selectedProduct.Price }}</p>
            <p>數量：{{ selectedProduct.Stock_quantity }}</p>
            <p>發佈日期：{{ selectedProduct.Release_date }}</p>
            <p>賣家：{{ selectedProduct.Seller_ID }}</p>
            <button @click="addToShoppingCart(selectedProduct.Product_ID)">加入購物車</button> 
            <button @click="closeModal">關閉</button>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { useAuthStore } from '../../stores/auth';

const router = useRouter();
const authStore = useAuthStore();

// 響應式資料
const result = ref([]);
const sortOrder = ref('asc'); // 預設排序方式
const showModal = ref(false);
const selectedProduct = ref({});
const keyword = ref('');
// 加載產品資料
const ProductLoad = () => {
  axios.get("http://127.0.0.1:8000/api/products")
    .then(({ data }) => {
      result.value = data;
    })
    .catch(error => {
      console.error("Error loading products:", error);
    });
};

const LoadSearch = () => {
    const page=`http://127.0.0.1:8000/api/search?Item=${ keyword.value }`;
    console.log(page);

    axios.get(page)
    .then(({ data }) => {
      result.value = data;
    })
};
// 排序後的結果
const sortedResult = computed(() => {
  return result.value.slice().sort((a, b) => {
    if (sortOrder.value === 'asc') {
      return a.Price - b.Price;
    } else if (sortOrder.value === 'desc') {
      return b.Price - a.Price;
    } else if (sortOrder.value === 'newest') {
      return b.Product_ID - a.Product_ID; // 最新上架依 Product_ID 排序
    } else {
      return 0;
    }
  });
});

// 顯示產品詳情
const showDetails = (product) => {
    selectedProduct.value = product;
    showModal.value = true;
};

const addToShoppingCart = (Product_id) =>{
    if (authStore.isLoggedIn) {
        authStore.addShopingCartList(Product_id);
        alert('已加入購物車');
    } else {
        alert("請先登入帳號");
        router.push('/login');
    }
};

// 關閉詳情視窗
const closeModal = () => {
  showModal.value = false;
};

// 組件掛載時載入產品
onMounted(() => {
  ProductLoad();
});
</script>


<style scoped>
/* 篩選區樣式 */
.filters {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 40px;
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.category-filters {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 10px;
}

.category-filters h3 {
    margin-right: 10px;
    color: #333;
}

.category-filters button {
    background-color: #f0f0f0;
    border: 1px solid #ddd;
    padding: 8px 12px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
}

.category-filters button:hover {
    background-color: #ff5ccd;
    color: white;
}

.sort-filters {
    display: flex;
    align-items: center;
    margin-left: auto;
    gap: 10px;
}

.sort-filters h3 {
    margin-right: 10px;
    color: #333;
}

.sort-filters select {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f9f9f9;
    cursor: pointer;
}

/* 商品列表外框 */
.product-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
    justify-content: center;
}

/* 單個商品樣式 */
.product-item {
    background-color: #fff;
    flex: 1 1 calc(33% - 20px);
    max-width: 300px;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s;
    text-align: center;
}

.product-item:hover {
    transform: translateY(-5px);
}

.product-item img {
    width: 100%;
    height: auto;
}

.product-info {
    padding: 15px;
    text-align: center;
}

button {
    padding: 8px 15px;
    margin-top: 10px;
    background-color: #ff5ccd;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

button:hover {
    background-color: #e0218a;
}

/* 模態框樣式 */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 300px;
    text-align: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.model_img {
    width: 100%;
    height: auto;
}
input[type="text"] {
    width: 100%;
    max-width: 400px;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 16px;
    outline: none;
    transition: box-shadow 0.3s ease, border-color 0.3s ease;
    margin-bottom: 20px;
}

input[type="text"]:focus {
    border-color: #007bff;
    box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
}
</style>
