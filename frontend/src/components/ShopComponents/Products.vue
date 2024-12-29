<template>
    <h2>JB購物商場</h2>
    <div class="product-list">
        <div v-for="product in result" v-bind:key="product.Product_ID" class="product-item">
            <img :src="product.imgLink" alt="商品1">
            <div class="product-info">
                <h4>{{ product.Product_Name }}</h4>
                <p>價格：${{ product.Price }}</p>
                <p>{{ product.Product_Description }}</p>
                <button @click="showDetails(product)">詳細資訊</button>
            </div>
        </div>
    </div>

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

export default{
    name: 'Product',
    data(){
        return {
            result:{},
            product:{
                Product_ID: '',
                Seller_ID: '',
                Product_Name: '',
                Product_Description: '',
                Price: '',
                Release_date: '',
                Stock_quantity: '',
                imgLink: '',
            },
            showModal: false,
            selectedProduct: {},
        }
    },
    created() {
        this.ProductLoad();
    },
    mounted(){
        console.log("123");
    },

    methods: {
        ProductLoad()
        {
            var page = "http://127.0.0.1:8000/api/products"
            axios.get(page)
            .then(
                ({data})=>{
                    this.result = data;
                }
            );
        },

        save()
        {
            if(this.product.id == ''){
                this.saveData();
            }
            else{
                this.updateData();
            }
        },

        saveData()
        {
            axios.post("http://127.0.0.1:8000/api/products", this.product)
            .then(
              ({data})=>{
                this.product = {
                    Product_ID: '',
                    Seller_ID: '',
                    Product_Name: '',
                    Product_Description: '',
                    Price: '',
                    Release_date: '',
                    Stock_quantity: '',
                    imgLink: '',
                };
              }
            )
        },

        updateData()
        {
            var editrecords = 'http://127.0.0.1:8000/api/products'+ this.product.id;
            axios.put(editrecords, this.product)
            .then(
            ({data})=>{
                this.ProductLoad();
                this.product.Product_ID= '',
                this.product.Seller_ID= '',
                this.product.Product_Name= '',
                this.product.Product_Description= '',
                this.product.Price= '',
                this.product.Release_date= '',
                this.product.tock_quantity= '',
                this.product.imgLink= ''
            }
            );
        },
        showDetails(product) 
        {
            this.selectedProduct = product;
            this.showModal = true;
        },
        closeModal()
        {
            this.showModal = false;
        },
    }
}
</script>

<style scoped>
    /* 商品列表外框 */
    .product-list {
        display: flex;
        flex-wrap: wrap; /* 讓多行顯示 */
        gap: 20px; /* 每個商品之間的間距 */
        justify-content: space-between; /* 左右對齊 */
    }

    /* 單個商品的樣式 */
    .product-item {
        background-color: #fff;
        flex: 1 1 calc(33% - 20px); /* 寬度約為三分之一 */
        max-width: 300px; /* 設置最大寬度 */
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .product-item:hover {
        transform: translateY(-5px); /* 滑鼠懸停效果 */
    }

    .product-item img {
        width: 100%; /* 確保圖片寬度填滿 */
        height: auto;
    }

    .product-info {
        padding: 15px;
        text-align: center;
    }

    /* 按鈕樣式 */
    button {
        padding: 8px 15px;
        margin-top: 10px;
        background-color: #ff5ccd;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        color: black;
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
        width: 300px;
    }
</style>