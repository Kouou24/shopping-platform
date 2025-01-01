<template>
    <div class="my-account-container">
        <div class="sidebar">
        <ul>
            <li @click="showSection('info')" :class="{ active: currentSection === 'info' }">我的商店</li>
            <li @click="showSection('orders')" :class="{ active: currentSection === 'orders' }">我的訂單</li>
            <li @click="showSection('settings')" :class="{ active: currentSection === 'settings' }">帳號設定</li>
        </ul>
        </div>

        <div class="content">
           
            <div v-if="currentSection === 'info'">
                <button @click="SetShowAddProductModalTrue">新增商品</button>
            </div >
           <div v-for="product in productResult">
                <div v-if="currentSection === 'info'">
                    <div class="product-list">
                        <div class="product-item">
                            <img :src="product.imgLink" alt="商品">
                            <div class="product-info">
                                <h4>{{ product.Product_Name }}</h4>
                                <p>價格：${{ product.Price }}</p>
                                <p>{{ product.Product_Description }}</p>
                                <button @click="showDetails(product)">詳細資訊</button>
                            </div>
                        </div>
                    </div>      
                </div>
            </div>

             
       

            <div v-if="currentSection === 'orders'" class="order-container">
                <div class="order-list">
                    <h3>我的訂單</h3>
                    <table>
                        <thead>
                        <tr>
                            <th>訂單ID</th>
                            <th>訂單時間</th>
                            <th>付費日期</th>
                            <th>運送地址</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="order in orderResult" :key="order.Order_ID">
                            <td >{{ order.Order_ID }}</td>
                            <td>{{ order.Order_Date }}</td>
                            <td>{{ order.Paid_Date }}</td>
                            <td>{{ order.Deliver_Address }}</td>
                            <td>
                                <button @click="loginAccount(member)">查看詳情</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <ul>
                <li v-for="order in orders" :key="order.id">
                    訂單編號: {{ order.id }} - 狀態: {{ order.status }}
                </li>
                </ul>
            </div>

            <div v-if="currentSection === 'settings'">
                <h3>帳號設定</h3>
                <button @click="logout">登出</button>
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
            <button @click="closeModal">關閉</button>
        </div>
    </div>
    <div v-if="showAddProductModal" class="modal-overlay">
    <div class="member-form">
        <form @submit.prevent="save">
            <div class="form-group">
                <label for="address">商品名稱:</label>
                <input v-model="addProduct.Product_Name" type="text" id="address" required />
            </div>
            <div class="form-group">
                <label for="address">商品描述:</label>
                <input v-model="addProduct.Product_Description" type="text" id="address" required />
            </div>
            <div class="form-group">
                <label for="address">商品價格:</label>
                <input v-model="addProduct.Price" type="text" id="address" required />
            </div>
            <div class="form-group">
                <label for="address">商品出售日期:</label>
                <input v-model="addProduct.Release_date" type="text" id="address" required />
            </div>
            <div class="form-group">
                <label for="address">商品庫存:</label>
                <input v-model="addProduct.Stock_quantity" type="text" id="address" required />
            </div>
            <button type="submit" @click="saveData">確認</button>
            <button @click="SetShowAddProductModalFalse">取消</button>
        </form>
    </div>
    </div>
</template>
<script setup>
    import { ref, onMounted } from 'vue';
    import { useAuthStore } from '../../stores/auth';
    import axios from 'axios';

    const authStore = useAuthStore();
    const currentSection = ref('info');
    const productResult = ref([]);
    const orderResult = ref([]);
    const selectedProduct = ref({});
    const showModal = ref(false);
    const showAddProductModal = ref(false);
    const productNum = 0;
    const addProduct = ref({
        'Seller_ID': authStore.memberID,
        'Product_Name': '',
        'Product_Description': '',
        'Price': '' ,
        'Release_date': '',
        'Stock_quantity': '',
        'imgLink': 'https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg',
    });
    //詳細資訊
    const showDetails = (product) => {
    selectedProduct.value = product;
    showModal.value = true;
    };
    // 切換欄位
    const showSection = (section) => {
    currentSection.value = section;
    };

    // 加載商店資訊
    const MemberLoad = () => {
        const page = "http://127.0.0.1:8000/api/seller/products/" + authStore.memberID;
        axios.get(page).then(({ data }) => {
            productResult.value = data;
        });
    };
    const SetShowAddProductModalTrue = () =>{
        showAddProductModal.value = true;
    }
    const SetShowAddProductModalFalse = () =>{
        showAddProductModal.value = false;
    }
    const closeModal = () => {
        showModal.value = false;
    }
    
    const saveData = () =>{
        const page = "http://127.0.0.1:8000/api/products";
        console.log(addProduct.value);

        axios.post(page, addProduct.value)
            .then(({ data }) => {
                alert("新增商品成功");
                MemberLoad();
                addProduct.value = {
                    'Seller_ID': authStore.memberID,
                    'Product_Name': '',
                    'Product_Description': '',
                    'Price': '' ,
                    'Release_date': '',
                    'Stock_quantity': '',
                    'imgLink': 'https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg',
                };
            })
        .catch(error => {
            alert("無法儲存資料");
        });
        showAddProductModal.value = false;
    }
    // 加載商店訂單
    const OrdersLoad = () => {
        const page = "http://127.0.0.1:8000/api/orders/" + authStore.memberID;
        axios.get(page).then(({ data }) => {
            orderResult.value = data;
        });
    };

    // 登出功能
    const logout = () => {
    authStore.logout();
    alert('已成功登出');
    window.location.href = '/';
    };

    onMounted(() => {
    MemberLoad();
    OrdersLoad();
    });
</script>

<style scoped>
    .my-account-container {
    display: flex;
    gap: 20px;
    }

    .sidebar {
    width: 200px;
    background-color: #f4f4f4;
    padding: 20px;
    border-radius: 8px;
    }

    .sidebar ul {
    list-style: none;
    padding: 0;
    }

    .sidebar li {
    cursor: pointer;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 4px;
    transition: background-color 0.2s;
    }

    .sidebar li:hover,
    .sidebar li.active {
    background-color: #4caf50;
    color: white;
    }

    .content {
    flex: 1;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .order-list table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    }

    .order-list th, .order-list td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
    }

    .order-container {
    padding: 20px;
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

.form-group {
  margin-bottom: 10px;
}

.form-group label {
  display: block;
  font-weight: bold;
}

.form-group input {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

.member-form form {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}
</style>
