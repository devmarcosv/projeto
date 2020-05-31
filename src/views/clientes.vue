<template id="add-cliente">
    <div>
        <form action="">
         <div class="alert alert-success" role="alert" v-if="success">
             Cadastro realizado com sucesso !
        </div>
        <div class="alert alert-danger" role="alert" v-if="error">
         {{error}}
        </div>
        <div class="alert alert-secondary" role="alert" v-if="vazio">
         Preencha todos os campos
        </div>
        <div class="form-group">
            <label for="Nome"> Nome:</label>
            <input type="text" class="form-control" id="nome_cliente" v-model="cliente.nome_cliente">
        </div>
        <div class="form-group">
            <label for="sexo"> Sexo: </label>
            <select class="form-control" id="sexo_cliente" v-model="cliente.sexo_cliente">
                <option value="F"> Feminino </option>
                <option value="H"> Masculino </option>
            </select>
        </div>
        <div class="form-group">
            <label for="idade">Idade: </label>
            <input type="number" class="form-control" id="idade_cliente" v-model="cliente.idade_cliente">
        </div>
        <button type="button" class="btn btn-outline-success" @click="save()">Salvar</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
export default {
    name:'clientes',
    data(){
        return{
            cliente: {
                id:"",
                nome_cliente: "",
                sexo_cliente: "",
                idade_cliente:"",
            },
            clientes: [],
            error: false,
            success:false,
            vazio:false,
        }      
    },
    methods: {
        reset(){
            this.error = false;
            this.success = false;
            this.vazio = false;

            this.cliente = {
                id: "",
                nome_cliente: "",
                sexo_cliente:"",
                idade_cliente:""
            };
        },
          save(){
            // Reset campos
        
            let cliente = this.cliente;

            axios.post(`https:/apirevisoes.herokuapp.com/clientes/add`, cliente).then((result)=>{
                if(result.data.success){
                    this.success = true;
                    
                    // reset campos 
                     this.reset();
                }else{
                    this.vazio = true;
                }
            }).catch((err)=>{
                this.error = err;
            })
        },
        getClientes(){

            this.cliente = [];

            axios.get(`https:/apirevisoes.herokuapp.com/clientes`).then((result)=>{
                this.cliente = result.data.clientes;
            }).catch(error=>{
                console.error(error);
            })
        }
    },
    created(){
        // Carregar clientes
        this.getClientes();
    }
 }
    
</script>

<style>

</style>