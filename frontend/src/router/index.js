import { createRouter, createWebHistory } from 'vue-router';
import Home from '../views/Home.vue';
import Shop from '../views/Shop.vue';
import Activity from '../views/Activity.vue';
import Coupon from '../views/Coupon.vue';
import ClientService from '../views/ClientService.vue';
import Register from '../views/Register.vue';
import Login from '../views/Login.vue';
import MyAccount from '../views/MyAccount.vue';
import Shoppingcart from '../views/Shopping_cart.vue';
import Checkout from '../views/Checkout.vue';


const routes = [
  { path: '/', name: 'Home', component: Home },
  { path: '/shop', name: 'Shop', component: Shop },
  { path: '/activity', name: 'Activity', component: Activity },
  { path: '/coupon', name: 'Coupon', component: Coupon },
  { path: '/client-service', name: 'ClientService', component: ClientService },
  { path: '/register', name: 'Register', component: Register },
  { path: '/login', name: 'Login', component: Login },
  { path: '/myaccount', name: 'MyAccount', component: MyAccount },
  { path: '/shopping_cart', name: 'Shoppingcart', component: Shoppingcart },
  { path: '/checkout', name: 'Checkout', component: Checkout },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
