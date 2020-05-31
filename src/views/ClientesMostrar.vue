<template>
  <div class="clientes">
      <div class="table-responsive">
          <div>
             <a class="btn txt-color btn-sm" href="/clientes" role="button">
                <span class="material-icons txt-color">add</span>Novo Cliente
             </a>
          </div>
          <table class="table">
              <thead>
                  <tr>
                     <th scope="col" class="text-center">Código</th>
                     <th scope="col" class="text-center">Nome</th>
                     <th scope="col" class="text-center">Sexo</th>
                     <th scope="col" class="text-center">Idade</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="cliente in clients" :key="cliente.id">
                      <td class="text-center">{{cliente.id}}</td>
                      <td class="text-center">{{cliente.nome_cliente}}</td>
                      <td class="text-center">{{cliente.sexo_cliente}}</td>
                      <td class="text-center">{{cliente.idade_cliente }}</td>
                      <td>
                        <a class="btn txt-color btn-sm" role="button" @click="deletar(cliente.id)">Deletar</a>
                        <a class="btn txt-color btn-sm" :href="'/AlterarCliente/' + cliente.id" role="button">Alterar</a>
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
    data(){
        return{
            clients: [],

        }
    },
    methods: {
        getAll(){
            
        this.clients = [];
            
        axios.get('https:/apirevisoes.herokuapp.com/clientes').then((result)=>{
        this.clients = result.data.clientes;
      }).catch(error=>{
        console.error(error);
      })
    },
    deletar(id){
      if(confirm('Deseja deletar cliente ?')){
        axios.delete(`https:/apirevisoes.herokuapp.com/clientes/delete/${id}`);

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