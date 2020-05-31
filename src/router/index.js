import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Veiculos from '../views/Veiculos.vue'
import AlterarVeiculo from '../views/AlterarVeiculo.vue'
import AddVeiculo from '../views/AddVeiculo.vue'
import clientes from '../views/clientes.vue'
import ClientesMostrar from '../views/ClientesMostrar'
import Revisoes from '../views/Revisoes'

Vue.use(VueRouter)

  const routes = [{
    path:'/ClientesMostrar',
    name:'Clientes Cadastrados',
    component: ClientesMostrar
  },
  {
    path:'/Revisoes',
    name:"Revisoes",
    component:Revisoes
  },
    {
      path:'/clientes',
      name:'clientes',
      component: clientes
    },
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/veiculos',
    name: 'Veiculos',
    component: Veiculos
  },
  {
    path: '/alterar-veiculo/:id',
    name: 'Alterar Veiculo',
    component: AlterarVeiculo
  },
  {
    path: '/novo-veiculo',
    name: 'Novo Veiculo',
    component: AddVeiculo
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
