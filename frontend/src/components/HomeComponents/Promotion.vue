<template>
    <div class="promo-wrapper">
        <div class="promo">
            曉靡超值活動正在如火如荼進行中！！
        </div>
    </div>
</template>

<script setup>

</script>

<style scoped>
/* 包裹區域 */
.promo-wrapper {
    overflow: hidden; /* 隱藏超出範圍的部分 */
    position: relative;
    width: 100%; /* 讓跑馬燈寬度和頁面一致 */
    height: 50px; /* 設定高度，根據需要調整 */
    background-color: #f00056; /* 背景色 */
}

/* 文字跑馬燈 */
.promo {
    display: inline-block;
    white-space: nowrap;
    position: absolute;
    color: white;
    font-size: 1.5rem;
    font-weight: bold;
    line-height: 50px; /* 與容器高度一致，讓文字垂直置中 */
    animation: marquee 10s linear infinite; /* 動畫名稱、時間、線性效果、無限循環 */
}

/* 動畫定義 */
@keyframes marquee {
    0% {
        transform: translateX(600%); /* 從容器右側外開始 */
    }
    100% {
        transform: translateX(-100%); /* 移動到容器的左側外 */
    }
}
</style>
