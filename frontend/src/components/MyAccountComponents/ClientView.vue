<template>
    <div class="my-account-container">
        <div class="sidebar">
        <ul>
            <li @click="showSection('info')" :class="{ active: currentSection === 'info' }">我的資訊</li>
            <li @click="showSection('orders')" :class="{ active: currentSection === 'orders' }">我的訂單</li>
            <li @click="showSection('settings')" :class="{ active: currentSection === 'settings' }">帳號設定</li>
        </ul>
        </div>

        <div class="content">
            <div v-for="member in memberResult">
                <div v-if="currentSection === 'info' && member.Member_ID === authStore.memberID">
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
                            <th>訂單ID</th>
                            <th>訂單時間</th>
                            <th>付費日期</th>
                            <th>運送地址</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="order in orderResult" :key="order.Order_ID">
                            <td v-if="order.Customer_ID === authStore.memberID">{{ order.Order_ID }}</td>
                            <td v-if="order.Customer_ID === authStore.memberID">{{ order.Order_Date }}</td>
                            <td v-if="order.Customer_ID === authStore.memberID">{{ order.Paid_Date }}</td>
                            <td v-if="order.Customer_ID === authStore.memberID">{{ order.Deliver_Address }}</td>
                            <td v-if="order.Customer_ID === authStore.memberID">
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
</template>
  
<script setup>
    import { ref, onMounted } from 'vue';
    import { useAuthStore } from '../../stores/auth';
    import axios from 'axios';

    const authStore = useAuthStore();
    const currentSection = ref('info');
    const memberResult = ref([]);
    const orderResult = ref([]);

    // 切換欄位
    const showSection = (section) => {
    currentSection.value = section;
    };

    // 加載使用者資訊
    const MemberLoad = () => {
        const page = "http://127.0.0.1:8000/api/member";
        axios.get(page).then(({ data }) => {
            memberResult.value = data;
        });
    };

    // 加載使用者訂單
    const OrdersLoad = () => {
        const page = "http://127.0.0.1:8000/api/orders";
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
</style>
