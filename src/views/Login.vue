<template>
    <div class="login-container">
      <h1>登入</h1>
      <form @submit.prevent="handleSubmit">
        <div class="form-group">
          <label for="email">電子郵件或使用者名稱</label>
          <input
            type="text"
            id="email"
            v-model="form.email"
            placeholder="請輸入您的電子郵件或使用者名稱"
            required
          />
        </div>
  
        <div class="form-group">
          <label for="password">密碼</label>
          <input
            type="password"
            id="password"
            v-model="form.password"
            placeholder="請輸入您的密碼"
            required
          />
        </div>
  
        <button type="submit" class="login-button">登入</button>
  
        <div class="register-link">
          <p>還沒有帳號？ <router-link to="/register">立即註冊</router-link></p>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          email: "",
          password: "",
        },
      };
    },
    methods: {
      handleSubmit() {
        if (!this.form.email || !this.form.password) {
          alert("請填寫所有欄位！");
          return;
        }
  
        // 模擬成功登入
        alert("登入成功！");
      },
    },
  };
  </script>
  
  <style scoped>
  .login-container {
    max-width: 360px;
    margin: 60px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #f9f9f9;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  
  h1 {
    text-align: center;
    margin-bottom: 20px;
    color: #333;
  }
  
  .form-group {
    margin-bottom: 15px;
  }
  
  label {
    display: block;
    font-weight: 600;
    margin-bottom: 5px;
    color: #555;
  }
  
  input {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
  }
  
  input:focus {
    border-color: #007bff;
    outline: none;
  }
  
  .login-button {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .login-button:hover {
    background-color: #0056b3;
  }
  
  .register-link {
    margin-top: 20px;
    text-align: center;
  }
  
  .register-link a {
    color: #007bff;
    text-decoration: none;
  }
  
  .register-link a:hover {
    text-decoration: underline;
  }
  </style>
  