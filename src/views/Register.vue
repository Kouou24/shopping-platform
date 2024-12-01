<template>
    <div class="register-container">
      <h1>註冊</h1>
      <form @submit.prevent="handleSubmit">
        <div class="form-group">
          <label for="username">使用者名稱</label>
          <input
            type="text"
            id="username"
            v-model="form.username"
            placeholder="請輸入使用者名稱"
            required
          />
        </div>
  
        <div class="form-group">
          <label for="email">電子郵件</label>
          <input
            type="email"
            id="email"
            v-model="form.email"
            placeholder="請輸入電子郵件"
            required
          />
        </div>
  
        <div class="form-group">
          <label for="password">密碼</label>
          <input
            type="password"
            id="password"
            v-model="form.password"
            placeholder="請輸入密碼"
            required
          />
        </div>
  
        <div class="form-group">
          <label for="confirmPassword">確認密碼</label>
          <input
            type="password"
            id="confirmPassword"
            v-model="form.confirmPassword"
            placeholder="請再次輸入密碼"
            required
          />
        </div>
  
        <button type="submit" class="register-button">註冊</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        form: {
          username: "",
          email: "",
          password: "",
          confirmPassword: "",
        },
      };
    },
    methods: {
      handleSubmit() {
        if (this.form.password !== this.form.confirmPassword) {
          alert("密碼與確認密碼不一致！");
          return;
        }
  
        // 提示用户注册成功
        alert(`註冊成功！歡迎，${this.form.username}！`);
      },
    },
  };
  </script>
  
  <style scoped>
  .register-container {
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
  
  .register-button {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
  
  .register-button:hover {
    background-color: #0056b3;
  }
  </style>
  