<template>
    <h2>JB購物商場</h2>

    <!-- 篩選欄 -->
    <div class="filters">
        <!-- 商品分類選項 -->
        <div class="category-filters">
            <h3>商品分類</h3>
            <button>電子產品</button>
            <button>服飾</button>
            <button>居家生活</button>
            <button>美妝保養</button>
            <button>更多...</button>
        </div>

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
            <button>加入購物車</button> 
            <button @click="closeModal">關閉</button>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'Product',
    data() {
        return {
            result: [],
            sortOrder: 'asc', // 預設排序方式
            showModal: false,
            selectedProduct: {},
        };
    },
    created() {
        this.ProductLoad();
    },
    computed: {
        sortedResult() {
            return this.result.slice().sort((a, b) => {
                if (this.sortOrder === 'asc') {
                    return a.Price - b.Price;
                } else if (this.sortOrder === 'desc') {
                    return b.Price - a.Price;
                } else if (this.sortOrder === 'newest') {
                    return a.Product_ID - b.Product_ID; // 最新上架依 Product_ID 排序
                } else {
                    return 0;
                }
            });
        },
    },
    methods: {
        ProductLoad() {
            axios.get("http://127.0.0.1:8000/api/products")
                .then(({ data }) => {
                    this.result = data;
                });
        },
        sortProducts() {
            // 這個方法用於觸發排序更新，實際邏輯由 computed 處理
        },
        showDetails(product) {
            this.selectedProduct = product;
            this.showModal = true;
        },
        closeModal() {
            this.showModal = false;
        },
    },
};
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
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: space-between;
    margin-bottom: 40px;
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
</style>
