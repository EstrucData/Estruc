import { createRouter, createWebHistory } from 'vue-router';
import home from '@/components/home'
import login from '@/components/login'
import registro from '@/components/registro'
import bienvenida from './components/bienvenida.vue';
import materias from '@/components/materias.vue'
import plan from '@/components/plan'

const routes = [
  {path: '/', name: 'home', component: home},
  {path: '/bienvenida', name: 'bienvenida', component: bienvenida},
  {path: '/materias', name: 'materias', component: materias},
  {path: '/plan', name: 'plan', component: plan},
  {path: '/login', name: 'login', component: login},
  {path: '/registro', name: 'registro', component: registro},
];

const router = createRouter({
    history: createWebHistory(),
    routes
  });

export default router;