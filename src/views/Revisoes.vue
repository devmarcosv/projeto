<template>
  <div class="revisoes">
      <div class="table-responsive">
          <div>
              <a class="btn txt-color btn-sm" href="/AddRevisao" role="button">
                    <span class="material-icons txt-color">add</span>Nova Revisão
              </a>
          </div>
          <div class="table">
              <thead>
                  <tr>
                      <th scope="col" class="text-center">Data</th>
                      <th scope="col" class="text-center">Descrição</th>
                      <th scope="col" class="text-center">Valor</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="revisao in revision" :key="revisao.id">
                      <td class="text-center">{{ revisao.data_revisao}}</td>
                      <td class="text-center">{{ revisao.descricao_revisao}}</td>
                      <td class="text-center">{{ revisao.valor_descricao}}</td>

                       <a class="btn txt-color btn-sm" role="button" @click="deletar(revisao.id)">Deletar</a>
                       <a class="btn txt-color btn-sm" :href="'/AlterarCliente/' + revisao.id" role="button">Alterar</a>
                  </tr>
              </tbody>
          </div>

      </div>
  </div>
</template>

<script>
import axios from 'axios';
export default {
    name:"Revisoes",
    data(){
        return{
            revision: [],

        }
    },
    methods: {
        getAll(){
            
        this.revision = [];
            
        axios.get('https:/apirevisoes.herokuapp.com/revisoes').then((result)=>{
        this.revision = result.data.revisoes;
      }).catch(error=>{
        console.error(error);
      })
    },
    deletar(id){
      if(confirm('Deseja deletar revisao ?')){
        axios.delete(`https:/apirevisoes.herokuapp.com/revisoes/delete/${id}`);

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