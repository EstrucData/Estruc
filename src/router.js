import { createRouter, createWebHistory } from 'vue-router';
import login from '@/components/login'
import bienvenida from './components/bienvenida.vue';
import materias from '@/components/materias.vue'
import plan from '@/components/plan'
import draganddrop from './components/draganddrop.vue';
import logica from './components/logica.vue';

const routes = [
  {path: '/', name: 'login', component: login},
  {path: '/bienvenida', name: 'bienvenida', component: bienvenida},
  {path: '/materias', name: 'materias', component: materias},
  {path: '/plan', name: 'plan', component: plan},
  {path: '/draganddrop', name: 'draganddrop', component: draganddrop},
  {path: '/logica', name: 'logica', component: logica},
];

const router = createRouter({
    history: createWebHistory(),
    routes
  });

export default router;