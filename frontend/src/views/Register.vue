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
      <h3>註冊帳戶</h3>
      <form @submit.prevent="save">
        <div class="form-group"> 
          <label for="account">用戶名稱:</label>
          <input v-model="member.Nickname" type="text" id="account" required />
          <p>{{ member.Nickname }}</p>
        </div>
        <div class="form-group"> 
          <label for="account">帳號:</label>
          <input v-model="member.User_Account" type="text" id="account" required />
          <p>{{ member.User_Account }}</p>
        </div>
        <div class="form-group">
          <label for="address">密碼:</label>
          <input v-model="member.User_Password" type="password" id="address" />
          <p>{{ member.User_Password }}</p>
        </div>
        <div class="form-group">
          <label for="address">E-mail:</label>
          <input v-model="member.Email" type="e-mail" id="address" />
          <p>{{ member.Email }}</p>
        </div>
        <div class="form-group">
          <label for="address">地址:</label>
          <input v-model="member.Address" type="e-mail" id="address" />
          <p>{{ member.Address }}</p>
        </div>
        <div class="form-group">
          <label>選擇身份:</label>
          <div class="role-selector">
            <label>
              買家
              <input type="radio" value="買家" v-model="member.Role" checked/>
            </label>
            <label>
              賣家
              <input type="radio" value="賣家" v-model="member.Role" />
            </label>
          </div>
        </div>

        <button type="submit" @click="saveData">註冊</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

// const Nickname = ref("")
// const Account = ref("")
// const Password = ref("")
// const MailAccount = ref("")
// const Address = ref("")

const isLoggedIn = ref(false)  // 改為 ref，以便修改其值
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
  Role:'買家',
});
const inDB = ref(false);
const selectedMember = ref({});
const lastID = ref();
// 預設載入會員資料
const MemberLoad = () => {
  const page = "http://127.0.0.1:8000/api/members";
  axios.get(page).then(({ data }) => {
    result.value = data;
  });
};

const saveData = () => {
  const page = "http://127.0.0.1:8000/api/members";
  axios.post(page, member.value)
    .then(({ data }) => {
      alert("註冊成功");
      MemberLoad(); // 重新載入資料
      if(member.value.Role == "賣家"){
        sellerSave();
      }
      else{
        customerSave();
      }
      resetMember();
    })
    .catch(error => {
      console.error("Error saving data:", error.response ? error.response.data : error.message);
      alert("無法儲存資料，請檢查網路或伺服器設定");
    });
   
};

const sellerSave = () =>{
  const lastID=ref({Member_ID:'', Seller_description:'商家'});
  const insertPage = "http://127.0.0.1:8000/api/seller/" ;
  const page = "http://127.0.0.1:8000/api/members";
  axios.get(page).then(({data})=>{
    lastID.value.Member_ID=data.at(-1).Member_ID;
    axios.post(insertPage, lastID.value)
  });
};

const customerSave = () =>{
  const lastID=ref({Member_ID:''});
  const insertPage = "http://127.0.0.1:8000/api/customer/" ;
  const page = "http://127.0.0.1:8000/api/members";
  axios.get(page).then(({data})=>{
    lastID.value.Member_ID=data.at(-1).Member_ID;
    axios.post(insertPage, lastID.value)
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
    nickname: '',
    user_account: '',
    user_password: '',
    email: '',
    address: '',
    created_at: '',
    updated_at: '',
    Role:'買家',
  };
  lastID.value = null;
};

const handleRegister = () => {
  // 使用 .value 訪問 ref，並判斷帳號密碼是否在資料中
  // isInList.value = result.value.some(item => item.User_Account === Account.value && item.User_Password === Password.value);

  if (isInList.value) {
    isLoggedIn.value = true;
    alert('登入成功');
  } else {
    isLoggedIn.value = false;
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

.role-selector {
  display:flex;
  gap: 20px; /* 控制每個選項之間的間距 */
  margin-top: 10px;
}

.role-selector label {
  display: flex;
  align-items: center;
  cursor: pointer;
}

.role-selector input[type="radio"] {
  margin-left: 10px; /* 按鈕與文字的間距 */
  cursor: pointer;
}

</style>
