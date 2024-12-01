<template>
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
    
            <!-- 篩選條件 -->
            <div class="sort-filters">
                <h3>排序條件</h3>
                <select>
                    <option value="popularity">依熱門度排序</option>
                    <option value="price-asc">價格：低到高</option>
                    <option value="price-desc">價格：高到低</option>
                    <option value="newest">最新上架</option>
                </select>
            </div>
    </div>
</template>

<script setup>

</script>

<style scoped>
    .filters {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        background-color: #fff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    }
    .category-filters {
        display: flex;
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

    /* 排序條件選項 */
    .sort-filters {
        display: flex;
        align-items: center;
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
</style>