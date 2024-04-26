import { createRouter, createWebHistory } from 'vue-router';
import login from '@/components/login'
import bienvenida from './components/bienvenida.vue';

const routes = [
  {path: '/', name: 'login', component: login},
  {path: '/bienvenida', name: 'bienvenida', component: bienvenida},
];

const router = createRouter({
    history: createWebHistory(),
    routes
  });

export default router;