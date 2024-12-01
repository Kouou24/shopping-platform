import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Shop from '../views/Shop.vue';
import Activity from '../views/Activity.vue';
import Coupon from '../views/Coupon.vue';
import ClientService from '../views/ClientService.vue';
import Register from '../views/Register.vue';
import Login from '../views/Login.vue';

const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/shop', name: 'Shop', component: Shop },
  { path: '/activity', name: 'Activity', component: Activity },
  { path: '/coupon', name: 'Coupon', component: Coupon },
  { path: '/client-service', name: 'ClientService', component: ClientService },
  { path: '/Register', name: 'Register', component: Register },
  { path: '/Login', name: 'Login', component: Login },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
