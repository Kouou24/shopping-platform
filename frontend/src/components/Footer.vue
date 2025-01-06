<template>
    <div class="footer">
        <p class="footer-title">批西好死 © 2024</p>
        
        <div class="social-links">
            <a href="https://www.facebook.com/zuck/?locale=zh_TW" target="_blank" class="social-item">
                <img src="https://store-images.s-microsoft.com/image/apps.30645.9007199266245907.cb06f1f9-9154-408e-b4ef-d19f2325893b.ac3b465e-4384-42a8-9142-901c0405e1bc" alt="Facebook">
            </a>
            <a href="https://www.instagram.com/elonmusk__official__/" target="_blank" class="social-item">
                <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/Instagram_logo_2022.svg/640px-Instagram_logo_2022.svg.png" alt="Instagram">
            </a>
        </div>
        
        <div class="payment-methods">
            <img src="https://asia-public.foodpanda.com/marketing/production/tw/images/nl/Affinity-Partnership_VISA_600x600%20LOGO-01.png?v=1459522682" alt="Visa" class="payment-icon">
            <img src="https://support.apple.com/content/dam/edam/applecare/images/en_US/psp/psp_heroes/mini-hero-applepay.png" alt="Apple Pay" class="payment-icon"> 
        </div>

        <p class="address">北科網路科技有限公司 統編：37465281 新北市 220 板橋區文化路一段 123 號 10 樓 </p>
        <p class="address">食品業者登錄字號：C-37465281-00003-2 版權所有 copyright © 2024 Inc. All Rights Reserved.</p>
    </div>
</template>

<style scoped>
.footer {
    background-color: #ff5ccd;
    padding: 30px 20px;
    text-align: center;
    color: white;
    bottom: 0;
    width: 100%;
}

.footer-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 15px;
}

.social-links {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin: 20px 0;
}

.social-item img {
    width: 40px;
    height: 40px;
    transition: transform 0.3s ease;
}

.social-item img:hover {
    transform: scale(1.1);
}

.payment-methods {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin: 20px 0;
}

.payment-icon {
    width: 100px; /* 調整此數值以改變圖示大小 */
    height: 100px;
}

.address {
    margin-top: 20px;
    font-size: 1.3rem;
    line-height: 1.6;
}
</style>
