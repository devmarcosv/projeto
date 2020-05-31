<template>
  <div class="veiculos">
    <div class="table-responsive">
      <div>
       <a class="btn txt-color btn-sm" href="/novo-veiculo" role="button">
        <span class="material-icons txt-color">add</span>Novo Veiculo
       </a>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th scope="col" class="text-center">Código</th>
            <th scope="col" class="text-center">Ano</th>
            <th scope="col" class="text-center">Combustivel</th>
            <th scope="col" class="text-center">Cor</th>
            <th scope="col" class="text-center">Marca</th>
            <th scope="col" class="text-center">Placa</th>
            <th scope="col" class="text-center">Cliente</th>
            <th scope="col" class="text-center">
              Ações
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="veiculo in veiculos" :key="veiculo.id">
            <td class="text-center">{{veiculo.id}}</td>
            <td class="text-center">{{veiculo.ano_carro}}</td>
            <td class="text-center">{{veiculo.combustivel_carro}}</td>
            <td class="text-center">{{veiculo.cor_carro}}</td>
            <td class="text-center">{{veiculo.marca_carro}}</td>
            <td class="text-center">{{veiculo.placa}}</td>
            <td class="text-center">{{veiculo.cliente.nome_cliente}}</td>
            <td>
              <a class="btn txt-color btn-sm" role="button" @click="deletar(veiculo.id)">Deletar</a>
              <a class="btn txt-color btn-sm" :href="'/alterar-veiculo/' + veiculo.id" role="button">Alterar</a>
              <a class="btn txt-color btn-sm" href="/veiculos-revisoes" role="button">Revisões</a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>

import axios from 'axios';

export default {
  name: 'Veiculos',
  data(){
    return{
      veiculos:[]
    }
  },
  methods:{
    getAll(){

      this.veiculos = [];

      axios.get('https:/apirevisoes.herokuapp.com/carros').then((result)=>{
        this.veiculos = result.data.carros;
      }).catch(error=>{
        console.error(error);
      })
    },
    deletar(id){
      if(confirm('Deseja deletar veiculo ?')){
        axios.delete(`https:/apirevisoes.herokuapp.com/carros/delete/${id}`);

        // Atualizar

        this.getAll();
      }
    }
  },
  created(){
    this.getAll();
  }
}
</script>

<style>

</style>