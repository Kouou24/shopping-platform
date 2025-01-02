<template>
    <div class="activity-page">
        <!-- 活動區塊 -->
        <header class="activity-header">
            <div class="header-content">
                <h1>曉靡超值活動限時開跑</h1>
                <p>全場 8 折起，滿額再送好禮！</p>
                <p>活動倒數：<span class="countdown">{{ countdown }}</span></p>
            </div>
        </header>

        <!-- 活動商品列表 -->
        <section class="product-section">
            <h2>熱賣商品推薦</h2>
            <div class="product-grid">
                <div v-for="product in products" :key="product.id" class="product-card">
                    <img :src="product.image" :alt="product.name" class="product-image">
                    <div class="product-info">
                        <h3 class="product-name">{{ product.name }}</h3>
                        <p class="product-prices">
                            <span class="original-price">${{ product.originalPrice }}</span>
                            <span class="discount-price">${{ product.discountPrice }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script>
export default {
    data() {
        return {
            eventEndTime: null, // 活動結束時間
            countdown: '', // 倒計時
            products: [
                {
                    id: 1,
                    name: "曉靡無線耳機",
                    image: "https://i01.appmifile.com/v1/MI_18455B3E4DA706226CF7535A58E875F0267/pms_1615866254.98086140!400x400!85.png",
                    originalPrice: 4490,
                    discountPrice: 3592,
                },
                {
                    id: 2,
                    name: "曉靡智能手錶",
                    image: "https://i01.appmifile.com/v1/MI_18455B3E4DA706226CF7535A58E875F0267/pms_1609745689.92113599!400x400!85.png",
                    originalPrice: 3000,
                    discountPrice: 2599,
                },
                {
                    id: 3,
                    name: "曉靡掃地機器人",
                    image: "https://i02.appmifile.com/443_item_tw/12/08/2024/de041bf449587220696a3547cc63e51c!400x400!85.png",
                    originalPrice: 4495,
                    discountPrice: 3596,
                },
                {
                    id: 4,
                    name: "曉靡55吋電視",
                    image: "https://i01.appmifile.com/v1/MI_18455B3E4DA706226CF7535A58E875F0267/pms_1628492500.50683306!400x400!85.png",
                    originalPrice: 10000,
                    discountPrice: 8000,
                },
            ],
        };
    },
    mounted() {
        this.initEventEndTime(); // 初始化活動結束時間
        this.updateCountdown();
        setInterval(this.updateCountdown, 1000);
    },
    methods: {
        initEventEndTime() {
            const savedEndTime = localStorage.getItem('eventEndTime');

            if (savedEndTime) {
                this.eventEndTime = parseInt(savedEndTime, 10);
            } else {
                this.eventEndTime = new Date().getTime() + 72 * 60 * 60 * 1000; // 預設72小時後
                localStorage.setItem('eventEndTime', this.eventEndTime);
            }
        },
        updateCountdown() {
            const now = new Date().getTime();
            const distance = this.eventEndTime - now;

            if (distance > 0) {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                this.countdown = `${days}天 ${hours}時 ${minutes}分 ${seconds}秒`;
            } else {
                this.countdown = "活動已結束";
            }
        },
        addToCart(product) {
            alert(`已將 ${product.name} 加入購物車！`);
        },
    },
};
</script>

<style>
/* 活動區塊樣式 */
.activity-header {
    background: linear-gradient(to right, #ff7e5f, #feb47b);
    color: white;
    text-align: center;
    padding: 40px 20px;
}

.header-content h1 {
    font-size: 2.5rem;
    margin-bottom: 10px;
}

.header-content p {
    font-size: 1.2rem;
    margin-bottom: 20px;
}

/* 商品區樣式 */
.product-section {
    padding: 20px;
    background-color: #f9f9f9;
}

.product-section h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.8rem;
}

.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.product-card {
    background: white;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.product-image {
    width: 100%;
    height: auto;
}

.product-info {
    padding: 15px;
    text-align: center;
}

.product-name {
    font-size: 1.1rem;
    margin-bottom: 10px;
}

.product-prices {
    margin-bottom: 15px;
}

.original-price {
    text-decoration: line-through;
    color: #999;
    margin-right: 5px;
}

.discount-price {
    color: #ff5722;
    font-weight: bold;
}

.add-to-cart {
    background: #ff5722;
    color: white;
    border: none;
    padding: 8px 15px;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.add-to-cart:hover {
    background: #e64a19;
}
</style>