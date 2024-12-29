<template>
  <div class="member-container">
    <h2>會員管理</h2>

    <!-- 會員列表 -->
    <div class="member-list">
      <table>
        <thead>
          <tr>
            <th>會員ID</th>
            <th>暱稱</th>
            <th>帳號</th>
            <th>密碼</th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="member in result" :key="member.Member_ID">
            <td>{{ member.Member_ID }}</td>
            <td>{{ member.Nickname }}</td>
            <td>{{ member.User_Account }}</td>
            <td>{{ member.User_Password }}</td>
            <td>
              <button @click="loginAccount(member)">查看詳情</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- 詳情 Modal -->
    <div v-if="inDB" class="modal-overlay">
      <div class="modal-content">
        <h3>會員詳情</h3>
        <div class="modal-body">
          <p><strong>暱稱:</strong> {{ selectedMember.Nickname }}</p>
          <p><strong>帳號:</strong> {{ selectedMember.User_Account }}</p>
          <p><strong>電子郵件:</strong> {{ selectedMember.Email }}</p>
          <p><strong>地址:</strong> {{ selectedMember.Address }}</p>
          <button @click="closeModal">關閉</button>
        </div>
      </div>
    </div>

    <!-- 會員表單 -->
    <div class="member-form">
      <h3>登入</h3>
      <form @submit.prevent="save">
        <div class="form-group"> 
          <label for="account">帳號:</label>
          <input v-model="Account" type="text" id="account" required />
          <p>{{ Account }}</p>
        </div>
        <div class="form-group">
          <label for="address">密碼:</label>
          <input v-model="Password" type="password" id="address" />
          <p>{{ Password }}</p>
        </div>
        <button type="submit" @click="handleLogin">登入</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useRouter } from 'vue-router';
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useAuthStore } from '../stores/auth';


const router = useRouter();
const Account = ref("")
const Password = ref("")
const authStore = useAuthStore();

const result = ref([]);
const isInList = ref(false);
const member = ref({
  Member_ID: '',
  Nickname: '',
  User_Account: '',
  User_Password: '',
  Email: '',
  Address: '',
  created_at: '',
  updated_at: '',
});
const inDB = ref(false);
const selectedMember = ref({});

// 預設載入會員資料
const MemberLoad = () => {
  const page = "http://127.0.0.1:8000/api/member";
  axios.get(page).then(({ data }) => {
    result.value = data;
  });
};

// 登入帳號顯示會員資料
const loginAccount = (selected) => {
  selectedMember.value = selected;
  inDB.value = true;
};

// 關閉 Modal
const closeModal = () => {
  inDB.value = false;
};

// 重置會員資料
const resetMember = () => {
  member.value = {
    Member_ID: '',
    Nickname: '',
    User_Account: '',
    User_Password: '',
    Email: '',
    Address: '',
    created_at: '',
    updated_at: '',
  };
};

const handleLogin = () => {
  // 使用 .value 訪問 ref，並判斷帳號密碼是否在資料中
  isInList.value = result.value.some(item => item.User_Account === Account.value && item.User_Password === Password.value);

  if (isInList.value) {
    // 找到符合條件的會員資料
    const loggedInMember = result.value.find(item => item.User_Account === Account.value && item.User_Password === Password.value);

    // 設定 memberID 到 authStore
    authStore.setMemberID(loggedInMember.Member_ID);

    // 設定登入狀態
    authStore.login();
    router.push('/');
  } else {
    alert('登入失敗');
  }
};

// 在組件掛載後載入資料
onMounted(() => {
  MemberLoad();
});
</script>



<style scoped>
.member-container {
  padding: 20px;
}

h2 {
  text-align: center;
  margin-bottom: 20px;
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
  padding: 6px 12px;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button:hover {
  background-color: #45a049;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}

.modal-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  width: 400px;
}

.modal-body {
  margin-bottom: 20px;
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

.member-form button {
  width: 100%;
  padding: 12px;
  background-color: #4caf50;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.member-form button:hover {
  background-color: #45a049;
}
</style>
