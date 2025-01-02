<template>
    <div class="my-account-container">
        <div class="sidebar">
        <ul>
            <li @click="showSection('info')" :class="{ active: currentSection === 'info' }">帳戶資訊</li>
            <li @click="showSection('settings')" :class="{ active: currentSection === 'settings' }">帳號設定</li>
        </ul>
        </div>
        <div class="contant">
            <div v-if="currentSection === 'info'">
                <div class="member-list">
                    <table>
                        <thead>
                        <tr>
                            <th>會員ID</th>
                            <th>暱稱</th>
                            <th>帳號</th>
                            <th>密碼</th>
                            <th>Email</th>
                            <th>地址</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="member in memberInfo" :key="member.Member_ID">
                            <td>{{ member.Member_ID }}</td>
                            <td>{{ member.Nickname }}</td>
                            <td>{{ member.User_Account }}</td>
                            <td>{{ member.User_Password }}</td>
                            <td>{{ member.Email }}</td>
                            <td>{{ member.Address }}</td>
                            <td>
                            <button @click="deleteMember(member.Member_ID)">刪除</button>
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
    </div>
</template>

<script setup>
    import { ref, onMounted } from 'vue';
    import { useAuthStore } from '../../stores/auth';
    import axios from 'axios';

    const authStore = useAuthStore();
    const currentSection = ref('info');
    const memberInfo = ref([]);

    const showSection = (section) =>{
        currentSection.value = section;
    };

    const deleteMember = (id) =>{
        const page = "http://127.0.0.1:8000/api/members/" + id;
        axios.delete(page).then(()=>{
            alert("刪除會員成功");
            MemberLoad();
        })
        .catch(error => {
            alert("無法刪除資料，請檢查網路或伺服器設定");
        });
    };

    const MemberLoad = () =>{
        const page = "http://127.0.0.1:8000/api/members";
        axios.get(page).then(({ data }) => {
            memberInfo.value = data.filter(item => item.Member_ID !== authStore.memberID);
        });
    };

    const logout = () => {
    authStore.logout();
    alert('已成功登出');
    window.location.href = '/';
    };

    onMounted(() => {
        MemberLoad();
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
    .member-list table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
    }

    .member-list th, .member-list td {
    padding: 10px;
    border: 1px solid #ccc;
    text-align: left;
    }

    button {
    padding: 8px 15px;
    margin-top: 10px;
    background-color:rgb(241, 0, 0);
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    }

    button:hover {
        background-color: #e0218a;
    }
</style>