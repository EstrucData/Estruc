import { createRouter, createWebHistory } from 'vue-router';
import Inicio from './components/inicio.vue';

const routes = [
    {path: '/', name: 'Inicio', component: Inicio},
];

const router = createRouter({
    history: createWebHistory(),
    routes
  });

export default router;