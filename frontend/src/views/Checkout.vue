<template>
    <div class="checkout">
      <h1 class="title">結帳</h1>
  
      <form @submit.prevent="submitOrder" class="checkout-form">
        <div class="payment-methods">
          <h2>付款方式</h2>
  
          <label>
            <input type="radio" name="payment" value="credit-card" v-model="selectedPaymentMethod" />
            信用卡
          </label>
          <label>
            <input type="radio" name="payment" value="cash-on-delivery" v-model="selectedPaymentMethod"/>
            貨到付款
          </label>
        </div>
  
        <div v-if="selectedPaymentMethod === 'credit-card'" class="credit-card-details">
          <h3>信用卡資訊</h3>
          <input type="text" placeholder="持有信用卡人的名字" required />
          <input type="text" placeholder="卡號" maxlength="16" required />
          <div class="card-expiry-cvc">
            <input type="text" placeholder="MM/YY" maxlength="5" required />
            <input type="text" placeholder="CVC" maxlength="3" required />
          </div>
        </div>
  
        <div class="coupon-section">
          <h2>優惠碼</h2>
          <input type="text" v-model="couponCode" placeholder="輸入優惠碼" />
          <button type="button" @click="applyCoupon" style="margin-top: 10px;">使用</button>
        </div>
  
        <div class="total-section">
          <h2>總金額: ${{ totalAmount }}</h2>
        </div>
  
        <button type="submit" class="submit-button">下單</button>
      </form>
    </div>
</template>

<script setup>
  import { useRouter } from 'vue-router';
  import { ref, computed, onMounted } from 'vue';
  import { useAuthStore } from '../stores/auth'; 
  import axios from 'axios';

  const router = useRouter();
  const authStore = useAuthStore();
  const selectedPaymentMethod = ref('');
  const couponCode=ref('');
  const totalAmount = ref(0);
  const order = ref({
    Customer_ID:authStore.memberID,
    Coupon_ID:null,
    Deliver_Address:'',
    TotalPrice:'',
  });

  const moneyLoad = () =>{
    totalAmount.value = authStore.totalMoney; 
  };
  const submitOrder = () =>{
    if (selectedPaymentMethod.value == '') {
      alert('Please select a payment method.');
      return;
    }
    alert("下訂成功，請至我的帳戶查看訂單");
    order.value.TotalPrice = totalAmount.value;
    setOrder();
    router.push('/');
    
  };
  const setOrder  = () =>{
    const page = "http://127.0.0.1:8000/api/orders";
    axios.post(page,order.value).then(()=>{
      setBelongto();
    });
  };
  const setBelongto = () =>{
    const getPage="http://127.0.0.1:8000/api/orders";
      axios.get(getPage).then(({data})=>{
        const productQuantity = authStore.shoppingCartList.reduce((acc, value)=>{
          acc[value]=(acc[value]||0)+1;
          return acc;
        },{});
        const belongtoPage="http://127.0.0.1:8000/api/belongto";
        for(const key in productQuantity){
            const belongto={
              Product_ID:key,
              Order_ID:data.at(-1).Order_ID,
              Quantity:productQuantity[key],
              Order_Status:'received',
            };
            axios.post(belongtoPage,belongto).then(()=>{
              console.log(belongto);
            });
        }  
        authStore.removeAllShoppingCart()
      });
  };
  const applyCoupon = () =>{
    if (this.couponCode === 'DISCOUNT10') {
      this.totalAmount *= 0.9;
      alert('Coupon applied! 10% discount.');
    } else {
      alert('Invalid coupon code.');
    }
  };
  onMounted(()=>{
    moneyLoad();
    const page = "http://127.0.0.1:8000/api/members/" + authStore.memberID;
    axios.get(page).then(({data})=>{
      order.value.Deliver_Address = data[0].Address;
    });
  });
</script>

<style scoped>
.checkout {
  max-width: 500px;
  margin: 50px auto;
  padding: 20px;
  border: 1px solid #ccc;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  background-color: #fff;
}

.title {
  text-align: center;
  color: #333;
}

.checkout-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.payment-methods label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
  color: #555;
}

.credit-card-details {
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.card-expiry-cvc {
  display: flex;
  gap: 10px;
}

.coupon-section input {
  padding: 10px;
  width: calc(100% - 80px);
  margin-right: 10px;
}

.coupon-section button {
  padding: 10px 20px;
  background-color: #28a745;
  color: #fff;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

.coupon-section button:hover {
  background-color: #218838;
}

.total-section h2 {
  text-align: center;
  color: #333;
}

.submit-button {
  background-color: #007bff;
  color: #fff;
  padding: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s;
}

.submit-button:hover {
  background-color: #0056b3;
}
</style>
