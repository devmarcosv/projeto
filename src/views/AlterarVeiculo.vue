<template id="alterar-veiculo">
    <div>
        <form>
        <div class="alert alert-success" role="alert" v-if="success">
             Cadastro alterado com sucesso !
        </div>
        <div class="alert alert-danger" role="alert" v-if="error">
         {{error}}
        </div>
        <div class="alert alert-secondary" role="alert" v-if="vazio">
         Preencha todos os campos
        </div>
        <div class="form-group">
            <label for="placa">Placa:</label>
            <input type="text" class="form-control" id="placa" v-model="veiculo.placa">
        </div>
        <div class="form-group">
            <label for="nome_carro">Nome Carro:</label>
            <input type="text" class="form-control" id="nome_carro" v-model="veiculo.nome_carro">
        </div>
        <div class="form-group">
            <label for="cor_carro">Cor:</label>
            <input type="text" class="form-control" id="cor_carro"  v-model="veiculo.cor_carro">
        </div>
        <div class="form-group">
            <label for="ano_carro">Ano:</label>
            <input type="text" class="form-control" id="ano_carro" v-model="veiculo.ano_carro">
        </div>
         <div class="form-group">
            <label for="marca_carro">Marca:</label>
            <input type="text" class="form-control" id="marca_carro" v-model="veiculo.marca_carro">
        </div>
        <div class="form-group">
            <label for="combustivel_carro">Combustivel:</label>
            <input type="text" class="form-control" id="combustivel_carro" v-model="veiculo.combustivel_carro">
        </div>
         <div class="form-group">
            <label for="cliente_id">Cliente:</label>
            <select class="form-control" id="cliente_id" v-model="veiculo.cliente_id">
                <option v-for="cliente in clientes" :key="cliente.id" :value=cliente.id>
                    {{cliente.nome_cliente}}
                </option>
            </select>
        </div>
            <button type="button" class="btn btn-outline-success" @click="save()">Salvar</button>
        </form>
    </div>
</template>

<script>

import axios from 'axios';

export default {
    name:"alterar-veiculo",
    data(){
        return{
            veiculo: {
                id: "",
                placa: "",
                nome_carro: "",
                cor_carro: "",
                ano_carro: "",
                marca_carro: "",
                combustivel_carro: "",
                cliente_id: ""
            },
            clientes:[],
            success: false,
            error: false,
            vazio: false
        }
    },
    methods:{
        reset(){
            this.error = false;
            this.success = false;
            this.vazio =  false;
        },
        save(){
            // Reset campos
            
            this.reset();

            let veiculo = this.veiculo;

            axios.post(`https:/apirevisoes.herokuapp.com/carros/edit/${veiculo.id}`, veiculo).then((result)=>{
                if(result.data.success){
                    this.success = true;
                }else{
                    this.vazio = true;
                }
            }).catch((err)=>{
                this.error = err;
            })
        },
        getVeiculo(id){
            axios.get(`https:/apirevisoes.herokuapp.com/carros/view/${id}`).then((result)=>{
                this.veiculo = result.data.carro;
            }).catch(error=>{
                console.error(error);
            })
        },
        getClientes(){

            this.clientes = [];

            axios.get(`https:/apirevisoes.herokuapp.com/clientes`).then((result)=>{
                this.clientes = result.data.clientes;
            }).catch(error=>{
                console.error(error);
            })
        }
    },
    created(){
        // Buscar dados do veiculo
        let veiculo_id =  this.$route.params.id;
        this.getVeiculo(veiculo_id);

        // Carregar clientes
        this.getClientes();
    }
}
</script>

<style>

</style>