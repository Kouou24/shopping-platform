<template>
    <h1>coupon</h1>
    <div class="member-list">
        <table>
            <thead>
            <tr>
                <th>優惠券ID</th>
                <th>優惠名稱</th>
                <th>優惠碼</th>
                <th>商品名稱</th>
                <th>折扣力度</th>
                <th>起始時間</th>
                <th>結束時間</th>
                <th>類型</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="coupon in couponInfo" :key="coupon.Coupon_ID">
                <td>{{ coupon.Coupon_ID }}</td>
                <td>{{ coupon.Coupon_Name }}</td>
                <td>{{ coupon.Discount_Code }}</td>
                <td>{{ coupon.Product_Name }}</td>
                <td>{{ coupon.Discount }}</td>
                <td>{{ coupon.Start_time }}</td>
                <td>{{ coupon.End_time }}</td>
                <td>{{ coupon.Type }}</td>
                <td>
                    <button v-if="coupon.Type !== 'shipping'" @click="insertHasCoupon(coupon.Coupon_ID)">領取</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</template>

<script setup> 
  import { ref, onMounted } from 'vue';
  import { useAuthStore } from '../stores/auth';
  import axios from 'axios';
  const authStore = useAuthStore();
  const couponInfo = ref([]);
  const myCouponInfo = ref([]);

  const hascoupon=ref({
    Coupon_ID:'',
    Member_ID:authStore.memberID,
  });
  const CouponLoad = () =>{
      const page = "http://127.0.0.1:8000/api/coupons";
      axios.get(page).then(({ data }) => {
          couponInfo.value = data.filter(allCoupon => !(myCouponInfo.value.some(myCoupon=>myCoupon.Coupon_ID===allCoupon.Coupon_ID)));
      });
  };
  const myCouponLoad = () =>{
        const page = "http://127.0.0.1:8000/api/hascoupon/" + authStore.memberID;
        axios.get(page).then(({ data }) => {
            myCouponInfo.value = data;
        });
  };
  const insertHasCoupon = (id) =>{
    hascoupon.value.Coupon_ID = id;
    const page = "http://127.0.0.1:8000/api/hascoupon";
    axios.post(page, hascoupon.value).then(()=>{
      myCouponLoad();
      CouponLoad();
    })
  };
  onMounted(()=>{
    myCouponLoad();
    CouponLoad();
  });
</script>

<style scoped>
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
</style>