<template>
    <h2>JB購物商場</h2>
    <div class="product-list">
        <div class="product-item">
            <img src="https://inews.gtimg.com/om_bt/ObiyLSdimfHw64NsVojNI70vSRasEQyeCEB89xvjP-5nkAA/641" alt="商品1">
            <div class="product-info">
                <h4>莫莫機器人</h4>
                <p>價格：$699</p>
                <button>加入購物車</button>
            </div>
        </div>
        <!-- Product 2 -->
        <div class="product-item">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSGh_3muGxHuLhFgnGhf85gSJYWpHQ-17F1FA&s" alt="商品2">
            <div class="product-info">
                <h4>焦流機器人</h4>
                <p>價格：$799</p>
                <button>加入購物車</button>
            </div>
        </div>
        <!-- Product 3 -->
        <div class="product-item">
            <img src="https://media1.tenor.com/m/TLJLozctLMQAAAAd/yuki-sakuna-vtuber.gif" alt="商品3">
            <div class="product-info">
                <h4>智能Vtuber管家</h4>
                <p>價格：$50000</p>
                <button>加入購物車</button>
            </div>
        </div>
        <!-- More products can be added here -->
    </div>
</template>

<script setup>

</script>

<style scoped>
    .product-list, .activity-list {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        gap: 20px;
    }

    /* 單個商品或活動的樣式 */
    .product-item, .activity-item {
        background-color: #fff;
        width: calc(33% - 20px);
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s;
    }

    .product-item:hover, .activity-item:hover {
        transform: translateY(-5px);
    }

    .product-item img, .activity-item img {
        width: 100%;
        height: auto;
    }

    .product-info, .activity-info {
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
        color:black;
    }

    button:hover {
        background-color: #e0218a;
    }
</style>