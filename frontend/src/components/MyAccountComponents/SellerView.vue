<template>
    <div class="my-account-container">
        <div class="sidebar">
        <ul>
            <li @click="showSection('info')" :class="{ active: currentSection === 'info' }">我的商店</li>
            <li @click="showSection('orders')" :class="{active: currentSection === 'orders'}">訂單管理</li>
             <li @click="showSection('coupon')" :class="{ active: currentSection === 'coupon' }">優惠管理</li>
            <li @click="showSection('settings')" :class="{ active: currentSection === 'settings' }">帳號設定</li>
        </ul>
        </div>

        <div class="content">
           
            <div v-if="currentSection === 'info'">
                <button @click="SetShowAddProductModalTrue();setModify(false)">新增商品</button>
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
            
            <div v-if="currentSection === 'orders'">
                <table>
                <thead>
                <tr>
                    <th>訂單編號</th>
                    <th>商品編號</th>
                    <th>商品名稱</th>
                    <th>訂購數量</th>
                    <th>商品單價</th>
                    <th>配送狀態</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="order in orderResult" :key="orderResult.Order_ID">
                    <td>{{ order.Order_ID }}</td>
                    <td>{{ order.Product_ID }}</td>
                    <td>{{ order.Product_Name }}</td>
                    <td>{{ order.Quantity }}</td>
                    <td>{{ order.Price }}</td>
                    <td>
                        <p v-if="!order.isOrderModify">{{ order.Order_Status }}</p>
                        <select v-if="order.isOrderModify" v-model="order.new_Status">
                            <option>{{ order.new_Status }}</option>
                            <option v-if="order.new_Status!=='received'" value="received">received</option>
                            <option v-if="order.new_Status!=='processing'" value="processing">processing</option>
                            <option v-if="order.new_Status!=='shipping'" value="shipping">shipping</option>
                            <option v-if="order.new_Status!=='completed'" value="completed">completed</option>
                        </select>
                    </td>
                    <td>
                        <button v-if="!order.isOrderModify" @click="setOrderModify(order, true)">修改配送狀態</button>
                        <button v-if="order.isOrderModify" @click="setOrderModify(order, false);changeOrderStatus(order,order.new_Status)">確定</button>
                        <button v-if="!order.isOrderModify && order.Order_Status !== 'completed'" @click="deleteOrder(order)">取消訂單</button>
                        <button v-if="order.isOrderModify" @click="setOrderModify(order, false)">取消修改</button>
                    </td>
                </tr>
                </tbody>
                </table>
            </div>
            <div v-if="currentSection === 'settings'">
                <h3>帳號設定</h3>
                <button @click="logout">登出</button>
            </div>

            <div v-if="currentSection === 'coupon'">
            <div class="member-list">
                <table>
                    <thead>
                    <tr>
                        <th>優惠券ID</th>
                        <th>優惠名稱</th>
                        <th>優惠碼</th>
                        <th>商品名稱</th>
                        <th>折扣力度</th>
                        <th>起始時間</th>
                        <th>結束時間</th>
                        <th>類型</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="coupon in couponInfo" :key="coupon.Coupon_ID">
                        <td>{{ coupon.Coupon_ID }}</td>
                        <td>{{ coupon.Coupon_Name }}</td>
                        <td>{{ coupon.Discount_Code }}</td>
                        <td>{{ coupon.Product_Name }}</td>
                        <td>{{ coupon.Discount }}</td>
                        <td>{{ coupon.Start_time }}</td>
                        <td>{{ coupon.End_time }}</td>
                        <td>{{ coupon.Type }}</td>
                        <td>
                            <button @click="setDefineCoupon(true);setModifyCoupon(coupon,true)">修改</button>
                            <button @click="deleteCoupon(coupon.Coupon_ID)">刪除</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
    <div v-if="defineCoupon || modifyCoupon" class="modal-overlay">
            <div class="add-product-form">
            <form @submit.prevent="save">
                <div class="form-group">
                <label for="account">優惠名稱:</label>
                <input v-model="newCoupon.Coupon_Name" type="text" id="account" required />
                </div>
                <div class="form-group">
                <label for="account">優惠碼:</label>
                <input v-model="newCoupon.Discount_Code" type="text" id="account" required />
                </div>
                <div class="form-group">
                <label for="account">折扣:</label>
                <input v-model="newCoupon.Discount" type="number" placeholder="0.9" id="account" min="0.1" max="0.99" step="0.05" required />
                </div>
                <div class="form-group">
                <label for="release-date">起始日期:</label>
                <input v-model="newCoupon.Start_time" type="datetime-local" id="release-date" class="date-input" required />
                </div>
                <div class="form-group">
                <label for="release-date">結束日期:</label>
                <input v-model="newCoupon.End_time" type="datetime-local" id="release-date" class="date-input" required />
                </div>
            <button @click="insertCoupon(newCoupon.Coupon_ID)">確認</button>
            <button @click="setDefineCoupon(false);setModifyCoupon(false)" class="cancel-button">取消</button>
            </form>
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
            <button @click="closeModal">關閉</button>
            <button @click="SetShowAddProductModalTrue();setModify(true)">修改</button>
            <button @click="deleteProduct(selectedProduct.Product_ID)">刪除</button>
            <button @click="setDefineCoupon(true);setProductCoupon(selectedProduct.Product_ID)">新增優惠</button>
        </div>
    </div>
    <div v-if="showAddProductModal" class="modal-overlay">
    <div class="add-product-form">
        <form @submit.prevent="save">
            <div class="form-field">
                <label for="product-name">商品名稱:</label>
                <input v-if="modifyProduct" v-model="modifySelectedProduct.Product_Name" type="text" id="product-name" required />
                <input v-if="!modifyProduct" v-model="addProduct.Product_Name" type="text" id="product-name" required />   
            </div>
            <div class="form-field">
                <label for="product-description">商品描述:</label>
                <input v-if="modifyProduct" v-model="modifySelectedProduct.Product_Description" type="text" id="product-description" required />
                <input v-if="!modifyProduct" v-model="addProduct.Product_Description" type="text" id="product-description" required />
            </div>
            <div class="form-field">
                <label for="product-price">商品價格:</label>
                <input v-if="modifyProduct" v-model="modifySelectedProduct.Price" type="text" id="product-price" required />
                <input v-if="!modifyProduct" v-model="addProduct.Price" type="text" id="product-price" required />
            </div>
            <div class="form-field">
                <label for="release-date">商品出售日期:</label>
                <input v-if="modifyProduct" v-model="modifySelectedProduct.Release_date" type="date" id="release-date" class="date-input"  required />
                <input v-if="!modifyProduct" v-model="addProduct.Release_date" type="date" id="release-date" class="date-input"  required />
            </div>
            <div class="form-field">
                <label for="stock-quantity">商品庫存:</label>
                <input v-if="modifyProduct" v-model="modifySelectedProduct.Stock_quantity" type="text" id="stock-quantity" required />
                <input v-if="!modifyProduct" v-model="addProduct.Stock_quantity" type="text" id="stock-quantity" required />
            </div>
            <div class="form-field">
                <label for="product-image">商品圖片:</label>
                <input v-if="modifyProduct" v-model="modifySelectedProduct.imgLink" type="text" id="product-image" required />
                <input v-if="!modifyProduct" v-model="addProduct.imgLink" type="text" id="product-image" required />
            </div>
            <div class="form-buttons">
                <div v-if="modifyProduct">
                <button type="submit" @click="modifyData(selectedProduct.Product_ID)">確認</button>
                </div>
                <div v-else>
                <button type="submit" @click="saveData">確認</button>
                </div>
                <button type="button" class="cancel-button" @click="SetShowAddProductModalFalse">取消</button>
            </div>
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
    const modifySelectedProduct = ref({});
    const showModal = ref(false);
    const showAddProductModal = ref(false);
    const modifyProduct = ref(false);
    const productNum = 0;
    const defineCoupon = ref(false);
    const modifyCoupon = ref(false);
    const couponInfo = ref([]);
    const addProduct = ref({
        'Seller_ID': authStore.memberID,
        'Product_Name': '',
        'Product_Description': '',
        'Price': '' ,
        'Release_date': '',
        'Stock_quantity': '',
        'imgLink': 'https://img.freepik.com/premium-vector/default-image-icon-vector-missing-picture-page-website-design-mobile-app-no-photo-available_87543-11093.jpg',
    });
    const CouponLoad = () =>{
        const page = "http://127.0.0.1:8000/api/coupons/" + authStore.memberID;
        axios.get(page).then(({ data }) => {
            couponInfo.value = data;
        });
    };
    const newCoupon = ref({
        Coupon_Name: '',
        Discount: 0.9,
        Discount_Code: '',
        End_time: '' ,
        Limit: '',
        Member_ID: authStore.memberID,
        Product_ID: '',
        Start_time:'',
        Type: "event",
    });
    const setDefineCoupon = (booleanType) =>{
        defineCoupon.value = booleanType;
        showModal.value=false;
    };
    const setProductCoupon = (id) =>{
        console.log(id);
        newCoupon.value.Product_ID = id;
        console.log(newCoupon);
    };
    const setModifyCoupon = (coupon, booleanType) =>{
        modifyCoupon.value =booleanType;
        if( booleanType == true){
            newCoupon.value=JSON.parse(JSON.stringify(coupon));
        }
    };
    const deleteCoupon = (id) =>{
        const page = "http://127.0.0.1:8000/api/coupons/" + id;
        axios.delete(page).then(()=>{
            alert("刪除優惠成功");
            CouponLoad();
        });
    };
    const insertCoupon = (id) =>{
        if(!modifyCoupon.value){
            const page = "http://127.0.0.1:8000/api/coupons";
            axios.post(page, newCoupon.value).then(()=>{
                alert('新增優惠 成功');
                CouponLoad();
                defineCoupon.value = false;
                resetNewCoupon();
            });
        }
        else{
            const page = "http://127.0.0.1:8000/api/coupons/" + id;
            axios.put(page, newCoupon.value).then(()=>{
                alert('修改優惠成功');
                CouponLoad();
                defineCoupon.value = false;
                modifyCoupon.value = false;
                resetNewCoupon();
            });
        }
    };
    const resetNewCoupon = () =>{
        newCoupon.value = {
            Coupon_Name: '',
            Discount: 0.9,
            Discount_Code: '',
            End_time: '' ,
            Limit: '',
            Member_ID: authStore.memberID,
            Product_ID: '',
            Start_time:'',
            Type: "event",
        };
    };
    //詳細資訊
    const showDetails = (product) => {
    selectedProduct.value = product;
    showModal.value = true;
    };
    // 切換欄位
    const showSection = (section) => {
    currentSection.value = section;
    };
    const setOrderModify = (order,booleanType) =>{
        order.isOrderModify = booleanType;
        if(booleanType == true){
            order.new_Status = order.Order_Status;
        }
    };
    
    // 加載商店資訊
    const MemberLoad = () => {
        const page = "http://127.0.0.1:8000/api/seller/products/" + authStore.memberID;
        axios.get(page).then(({ data }) => {
            productResult.value = data;
        });
    };

    const setModify = (type) =>{
        if(type===true){
            modifySelectedProduct.value = Object.assign({}, selectedProduct.value);
        }
        modifyProduct.value = type;
    };
    const SetShowAddProductModalTrue = () =>{
        showAddProductModal.value = true;
    };
    const SetShowAddProductModalFalse = () =>{
        showAddProductModal.value = false;
    };
    const closeModal = () => {
        showModal.value = false;
        modifySelectedProduct.value = Object.assign({}, selectedProduct.value);
    };
    const changeOrderStatus = (order, status) =>{
        console.log(status);
        order.Order_Status = status;
        const page="http://127.0.0.1:8000/api/belongto"
        axios.put(page, order);
    };
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
    };

    const modifyData = (id) =>{
        const page = "http://127.0.0.1:8000/api/products/" + id;
        axios.put(page,modifySelectedProduct.value).then(()=>{
            alert("修改資料成功");
            MemberLoad();
            showAddProductModal.value = false;
            closeModal();
        })
        .catch(error => {
            alert("無法修改資料，請檢查網路或伺服器設定");
        });
    };
    const deleteOrder = (order) =>{
        const page = `http://127.0.0.1:8000/api/belongto?Product_ID=${order.Product_ID}&Order_ID=${order.Order_ID}`;
        console.log(page);
        
        axios.delete(page).then(()=>{
            alert("成功刪除訂單");
            OrdersLoad();
        });
    };
    const deleteProduct = (id) =>{
        const page = "http://127.0.0.1:8000/api/products/" + id;
        axios.delete(page).then(()=>{
            alert("刪除商品成功");
            MemberLoad();
            showModal.value = false;
        })
        .catch(error =>{
            alert("無法刪除資料，請檢查網路或伺服器設定");
        });
    };
    // 加載商店訂單
    const OrdersLoad = () => {
        const page = "http://127.0.0.1:8000/api/order/products/seller/" + authStore.memberID;
        axios.get(page).then(({ data }) => {
            const newData = data.map(order =>({
                ...order,
                isOrderModify:false,
            }));
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
    CouponLoad();
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
    display: flex;
    flex-wrap: nonwrap;
    gap: 50px;
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

.add-product-form form {
    max-width: 100%; /* 增加表單的寬度 */
    margin: 0 auto;
    background-color: #ffffff;
    padding: 40px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    font-family: Arial, sans-serif;
}

.add-product-form .form-field {
    margin-bottom: 25px;
    margin-left: 0px;
    margin-right: 30px;
}

.add-product-form label {
    font-size: 16px;
    font-weight: bold;
    color: #333333;
    display: block;
    margin-bottom: 8px;
}

.add-product-form input[type="text"] {
    width: 500px; /* 設定輸入框的固定寬度 */
    padding: 12px 8px;
    border: 1px solid #ccc;
    border-radius: 8px;
    text-align: left;
    font-size: 16px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;         
}

.add-product-form input[type="text"]:focus {
    border-color: #4caf50;
    box-shadow: 0 0 6px rgba(76, 175, 80, 0.4);
    outline: none;
}

.add-product-form .form-buttons {
    display: flex;
    justify-content: flex-end;
    gap: 15px;
}

.add-product-form button {
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    color: #ffffff;
    background-color: #4caf50;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s ease-in-out, transform 0.2s ease;
}

.add-product-form button:hover {
    background-color: #45a049;
    transform: translateY(-2px);
}

.add-product-form button.cancel-button {
    background-color: #f44336;
}

.add-product-form button.cancel-button:hover {
    background-color: #d32f2f;
}

/* 增加表單整體的動態效果 */
.add-product-form form {
    animation: fadeIn 0.4s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}
.date-input {
    width: 500px; /* 調整日期輸入框的寬度 */
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.date-input:focus {
    border-color: #4caf50;
    box-shadow: 0 0 6px rgba(76, 175, 80, 0.4);
    outline: none;
}

table {
    width: 100%;
    border-collapse: collapse;
}

thead {
    background-color: #f4f4f4;
}

thead th {
    padding: 10px;
    border-bottom: 2px solid #ddd;
    text-align: left;
}

tbody tr {
    border-bottom: 1px solid #ddd;
}

tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

tbody td {
    padding: 10px;
}

tbody tr:hover {
    background-color: #f1f1f1;
}
</style>
