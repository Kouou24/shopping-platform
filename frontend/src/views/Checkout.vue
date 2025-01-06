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
        <div>
          <h3>可用優惠</h3>
          <table>
              <thead>
              <tr>
                  <th>折扣描述</th>
                  <th>折扣碼</th>
                  <th>折扣力度</th>
              </tr>
              </thead>
              <tbody>
              <tr v-for="coupon in availableCoupon" :key="coupon.Coupon_ID">
                  <td>{{ coupon.Coupon_Name }}</td>
                  <td>{{ coupon.Discount_Code }}</td>
                  <td>{{ coupon.Discount }}</td>
              </tr>
              </tbody>
          </table>
        </div>
        <section class="cart-items-section" v-if="cartItems.length">
        <div v-for="item in cartItems" :key="item.Product_ID" class="cart-item">
          <div class="cart-item-info">
            <p>{{ item.Product_Name }}</p>
            <p v-if="item.Product_Name !== '運費'">單價：${{ item.Price }}</p>
          </div>
          <div class="cart-item-actions">
            <p v-if="item.Product_Name !== '運費'">數量：{{ item.currentStockQuantity }}</p>
            <p v-if="item.Product_Name !== '運費'">小計：${{ (item.Price * item.currentStockQuantity).toFixed(2) }}</p>
            <p v-if="item.Product_Name === '運費'">小計：${{ item.Price.toFixed(2) }}</p>
          </div>
        </div>
        </section>

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
  const couponInfo = ref([]);
  const myCouponInfo = ref([]);
  const availableCoupon = ref([]);
  const couponInfoShipping = ref({});
  const order = ref({
    Customer_ID:authStore.memberID,
    Deliver_Address:'',
    TotalPrice:'',
  });
  
  const cartItems = ref([]);
  const ProductLoad = async () => {
    const loadedItems = [{Product_Name:'運費',Price:0}];
    for (const id of authStore.shoppingCartList) {
      try {
        const { data } = await axios.get("http://127.0.0.1:8000/api/products/" + id);
        if(loadedItems.some(item => item.Product_ID === data[0].Product_ID))
        {
          const item = loadedItems.find(item => item.Product_ID === data[0].Product_ID)
          item.currentStockQuantity += 1;
        }
        else
        {
          data[0].currentStockQuantity = 1;
          loadedItems.push(data[0]);
        }
      } catch (error) {
        console.error("Error loading product with id:", id, error);
      }
    }
    if(totalAmount.value < couponInfoShipping.value.Limit){
      loadedItems[0].Price = authStore.shipCost;
      totalAmount.value = (parseFloat(totalAmount.value) + parseFloat(authStore.shipCost)).toFixed(2);
    }
    cartItems.value = loadedItems;
    console.log("所有商品以加載",cartItems.value);
  };
  const CouponLoad = () =>{
      const page = "http://127.0.0.1:8000/api/coupons";
      axios.get(page).then(({ data }) => {
          couponInfo.value = data;
          couponInfoShipping.value= data.find(item => item.Type === 'shipping');
      });
  };
  const myCouponLoad = async () =>{
      const page = "http://127.0.0.1:8000/api/hascoupon/" + authStore.memberID;
      axios.get(page).then(({ data }) => {
          myCouponInfo.value = data;
          availableCouponLoad();
          console.log(myCouponInfo.value);
      });
  };
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
    console.log(order);
    setOrder();
    //router.push('/');
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
            });
        }  
        authStore.removeAllShoppingCart()
      });
  };

  const availableCouponLoad = () =>{
    const couponSeason = myCouponInfo.value.filter(item => item.Type === 'seasoning');
    const productIncart = myCouponInfo.value.filter(item => cartItems.value.some(cart=>cart.Product_ID===item.Product_ID));
    const combine=[...couponSeason, ...productIncart];
    
    for (const item of combine){
      const startTime=new Date(item.Start_time);
      const endTime=new Date(item.End_time);
      const currentTime=new Date();
      if(currentTime>=startTime && currentTime<=endTime && !item.Used ){
        availableCoupon.value.push(item);
      }
    }
  };
  const applyCoupon = () =>{
    const currentCoupon = availableCoupon.value.find(item=>item.Discount_Code === couponCode.value)
    console.log(currentCoupon);
    if (currentCoupon) {
      if(currentCoupon.Type == 'seasoning'){
        totalAmount.value = Math.ceil(totalAmount.value * currentCoupon.Discount).toFixed(2);
        console.log(totalAmount.value);
      }
      else{
        const currentProduct = cartItems.value.find(item=>item.Product_ID === currentCoupon.Product_ID)
        const diffPrice=currentProduct.Price-Math.ceil(currentProduct.Price * currentCoupon.Discount);
        currentProduct.Price = currentProduct.Price - diffPrice;
        totalAmount.value = totalAmount.value - (diffPrice*currentProduct.currentStockQuantity);
      }
      couponUsed(currentCoupon);
    } else {
      alert('Invalid coupon code.');
    }
  };

  const couponUsed = (coupon) => {
    coupon.Used=true;
    const page="http://127.0.0.1:8000/api/hascoupon";
    axios.put(page,coupon).then(()=>{
      myCouponLoad();
      availableCoupon.value=[];
    });
  };
  async function loadAll(){
    await ProductLoad();
    await myCouponLoad();
  };
  onMounted(()=>{
    moneyLoad();
    CouponLoad();
    loadAll();
    
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
