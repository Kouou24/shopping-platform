<template>
    <div v-for="member in memberResult" :key="member.Member_ID">
        <div v-if="member.Member_ID === authStore.memberID && adminResult.some(item => item.Member_ID === authStore.memberID)">
            <p>你好 {{ member.Nickname }} 管理員</p>
            <AdminView/>
        </div>
        <div v-if="member.Member_ID === authStore.memberID && !sellerResult.some(item => item.Member_ID === authStore.memberID) && !adminResult.some(item => item.Member_ID === authStore.memberID)">
            <p>你好 {{ member.Nickname }} 用戶</p>
            <ClientView/>
        </div>
        <div v-if="member.Member_ID === authStore.memberID && sellerResult.some(item => item.Member_ID === authStore.memberID)">
            <p>你好 {{ member.Nickname }} 賣家</p>
            <SellerView/>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useAuthStore } from '../stores/auth';
import axios from 'axios';
import ClientView from '../components/MyAccountComponents/ClientView.vue';
import SellerView from '../components/MyAccountComponents/SellerView.vue';
import AdminView from '../components/MyAccountComponents/AdminView.vue';
const memberResult = ref([]);
const sellerResult = ref([]);
const adminResult = ref([]);
const authStore = useAuthStore();

const MemberLoad = () => {
  const page = "http://127.0.0.1:8000/api/members";
  axios.get(page).then(({ data }) => {
    memberResult.value = data;
  });
};

const SellerLoad = () => {
  const page = "http://127.0.0.1:8000/api/seller";
  axios.get(page).then(({ data }) => {
    sellerResult.value = data;
  });
};

const AdminLoad = () => {
  const page = "http://127.0.0.1:8000/api/administrator";
  axios.get(page).then(({ data }) => {
    adminResult.value = data;
  });
};
onMounted(() => {
  AdminLoad();
  MemberLoad();
  SellerLoad();
});
</script>

<style>
</style>