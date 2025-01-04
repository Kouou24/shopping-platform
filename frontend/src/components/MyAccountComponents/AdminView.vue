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
                <button @click="setModify(true)">新增帳號</button>
            </div >
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
        <!-- 會員表單 -->
        <div v-if="isModified" class="modal-overlay">
            <div class="add-product-form">
            <h3>註冊帳戶</h3>
            <form @submit.prevent="save">
                <div class="form-group"> 
                <label for="account">用戶名稱:</label>
                <input v-model="member.Nickname" type="text" id="account" required />
                </div>
                <div class="form-group"> 
                <label for="account">帳號:</label>
                <input v-model="member.User_Account" type="text" id="account" required />
                </div>
                <div class="form-group">
                <label for="address">密碼:</label>
                <input v-model="member.User_Password" type="password" id="address" />
                </div>
                <div class="form-group">
                <label for="address">E-mail:</label>
                <input v-model="member.Email" type="e-mail" id="address" />
                </div>
                <div class="form-group">
                <label for="address">地址:</label>
                <input v-model="member.Address" type="e-mail" id="address" />
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
                <button type="button" class="cancel-button" @click="setModify(false)">取消</button>
            </form>
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
    const isModified = ref(false);
    const lastID = ref();
    
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
    const setModify = (booleantype) =>{
        isModified.value = booleantype;
    };

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
            console.log(error);
            alert("無法刪除資料，請檢查網路或伺服器設定");
        });
    };

    const MemberLoad = () =>{
        const page = "http://127.0.0.1:8000/api/members";
        axios.get(page).then(({ data }) => {
            memberInfo.value = data.filter(item => item.Member_ID !== authStore.memberID);
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