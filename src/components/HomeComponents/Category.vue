<template>
    <div class="categories">
        <div class="category">
            <img src="/picture/JB商城.png" alt="Category Icon">
            <p>JB商城</p>
        </div>
        <div class="category">
            <img src="/picture/JB特價.png" alt="Category Icon">
            <p>JB特價</p>
        </div>
        <div class="category">
            <img src="/picture/JB優選.png" alt="Category Icon">
            <p>JB優選</p>
        </div>
        <div class="category">
            <img src="/picture/更多.png" alt="Category Icon">
            <p>更多商品</p>
        </div>
    </div>
</template>

<script setup>

</script>

<style scoped>
    .categories {
        display: flex;
        justify-content: space-around;
        margin: 20px 0;
        padding: 10px;
        background-color: #fff;
    }
    .category {
        text-align: center;
        width: 120px;
    }

    .category img {
        width: 50px;
        height: 50px;
        object-fit: contain;
    }
</style>