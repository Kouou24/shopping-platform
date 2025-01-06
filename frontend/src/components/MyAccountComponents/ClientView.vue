<template>
    <div class="my-account-container">
        <div class="sidebar">
        <ul>
            <li @click="showSection('info')" :class="{ active: currentSection === 'info' }">我的資訊</li>
            <li @click="showSection('orders')" :class="{ active: currentSection === 'orders' }">我的訂單</li>
            <li @click="showSection('coupon')" :class="{ active: currentSection === 'coupon' }">我的優惠券</li>
            <li @click="showSection('settings')" :class="{ active: currentSection === 'settings' }">帳號設定</li>
        </ul>
        </div>

        <div class="content">
            <div v-for="member in memberResult">
                <div v-if="currentSection === 'info'">
                    <h3>我的資訊</h3>
                    <p>名稱: {{ member.Nickname }}</p>
                    <p>電子郵件: {{ member.Email }}</p>
                    <p>地址: {{ member.Address }}</p>
                </div>
            </div>

            <div v-if="currentSection === 'orders'" class="order-container">
                <div class="order-list">
                    <h3>我的訂單</h3>
                    <table>
                        <thead>
                        <tr>
                            <th>訂單編號</th>
                            <th>訂單時間</th>
                            <th>運送地址</th>
                            <th>總金額</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="order in orderResult" :key="order.Order_ID">
                            <td>{{ order.Order_ID }}</td>
                            <td>{{ order.Order_Date }}</td>
                            <td>{{ order.Deliver_Address }}</td>
                            <td>{{ order.TotalPrice }}</td>
                            <td>
                                <button @click="setShowModal(true);orderDetailsLoad(order.Order_ID)">查看詳情</button>
                                <button v-if="order.Order_Status !== 'deliverd'" @click="deleteOrder(order.Order_ID)">刪除訂單</button>
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
            <div v-if="currentSection === 'coupon'">
            <div class="member-list">
                <table>
                    <thead>
                    <tr>
                        <th>優惠券ID</th>
                        <th>優惠名稱</th>
                        <th>優惠碼</th>
                        <th>折扣力度</th>
                        <th>起始時間</th>
                        <th>結束時間</th>
                        <th>類型</th>
                        <th>使用</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="coupon in couponInfo" :key="coupon.Coupon_ID">
                        <td>{{ coupon.Coupon_ID }}</td>
                        <td>{{ coupon.Coupon_Name }}</td>
                        <td>{{ coupon.Discount_Code }}</td>
                        <td>{{ coupon.Discount }}</td>
                        <td>{{ coupon.Start_time }}</td>
                        <td>{{ coupon.End_time }}</td>
                        <td>{{ coupon.Type }}</td>
                        <td>
                            <p v-if="coupon.Used">已使用</p>
                            <p v-if="!coupon.Used">尚未使用</p>
                        </td>
                        <td>
                            <button v-if="!coupon.Used" @click="deleteMyCoupon(coupon)">刪除</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            </div>
            <div v-if="currentSection === 'settings'">
                <h3>帳號設定</h3>
                <button @click="logout">登出</button>
            </div>
        </div>
        <div v-if="showModal" class="modal-overlay" @click="setShowModal(false)">
        <div class="modal-content" @click.stop>
            <table>
            <thead>
            <tr>
                <th>商品編號</th>
                <th>商品名稱</th>
                <th>件數</th>
                <th>單價</th> 
                <th>配送狀態</th>  
            </tr>
            </thead>
            <tbody>
            <tr v-for="order in orderDetails" :key="orderDetails.Product_ID">
                <td>{{ order.Product_ID }}</td>
                <td>{{ order.Product_Name }}</td>
                <td>{{ order.Quantity }}</td>
                <td>{{ order.Price }}</td>
                <td>{{ order.Order_Status}}</td>
            </tr>
            </tbody>
            </table>
        </div>
    </div>
    </div>
</template>
  
<script setup>
    import { ref, onMounted } from 'vue';
    import { useAuthStore } from '../../stores/auth';
    import axios from 'axios';

    const authStore = useAuthStore();
    const currentSection = ref('info');
    const memberResult = ref([]);
    const orderResult = ref([]);
    const showModal = ref(false);
    const orderDetails = ref([]);
    const couponInfo = ref([]);
    
    const CouponLoad = () =>{
        const page = "http://127.0.0.1:8000/api/hascoupon/" + authStore.memberID;
        axios.get(page).then(({ data }) => {
            couponInfo.value = data;
        });
    };
    const setShowModal = (booleanType) =>{
        showModal.value = booleanType;
    };
    const orderDetailsLoad = (id) =>{
        const page = "http://127.0.0.1:8000/api/order/products/customer/" + id;
        axios.get(page).then(({data})=>{
            orderDetails.value = data;
            console.log(orderDetails.value);
        });
    };
    // 切換欄位
    const showSection = (section) => {
    currentSection.value = section;
    };

    // 加載使用者資訊
    const MemberLoad = () => {
        const page = "http://127.0.0.1:8000/api/members/" + authStore.memberID;
        axios.get(page).then(({ data }) => {
            memberResult.value = data;
        });
    };

    // 加載使用者訂單
    const OrdersLoad = () => {
        const page = "http://127.0.0.1:8000/api/orders/" + authStore.memberID;
        axios.get(page).then(({ data }) => {
            orderResult.value = data;
            console.log(orderResult.value);
        });
    };
    const deleteOrder = (id) =>{
        const page = "http://127.0.0.1:8000/api/orders/" + id;
        axios.delete(page).then(()=>{
            alert('刪除訂單成功');
            OrdersLoad();
        });
    };
    const deleteMyCoupon = (coupon) =>{
        console.log(coupon);
        const page = `http://127.0.0.1:8000/api/hascoupon/?Coupon_ID=${coupon.Coupon_ID}&Customer_ID=${coupon.Customer_ID}`;
        axios.delete(page).then(()=>{
            CouponLoad();
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
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 0 auto;
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
}
</style>
