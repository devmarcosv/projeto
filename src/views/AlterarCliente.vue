<template id="alterar-cliente">
    <div>
        <form>
         <div class="alert alert-success" role="alert" v-if="success">
             Cadastro alterado com sucesso !
        </div>
        <div class="alert alert-danger" role="alert" v-if="error">
         {{error}}
        </div>
        <div class="form-group">
            <label>Nome:</label>
            <input type="text" class="form-control" v-model="cliente.nome_cliente">
        </div>
        <div class="form-group">
            <label>Sexo:</label>
            <select class="form-group" v-model="cliente.sexo_cliente" id="">
                <option value="F"> Feminino </option>
                <option value="H"> Masculino </option>
            </select>
        </div>
         <div class="form-group">
            <label for="idade">Idade</label>
            <input type="number" class="form-control" v-model="cliente.idade_cliente" id="idade_cliente">
        </div>
        <button type="button" class="btn btn-outline-success" @click="save()">Salvar</button>
        </form>
    </div>
  
</template>

<script>
export default {
    data(){
        return{
            cliente: {
                id: "",
                nome: "",
                sexo: "",
                idade: "",
            }
        }
    },
    methods: {
        reset(){
            this.error = false;
            this.success = false;
            this.vazio = false;
        },
        save(){
            this.reset();

            let cliente= this.cliente;

            axios.post(`https://apirevisoes.herokuapp.com/clientes/edit/${cliente.id}`, cliente).then((result)=>{
                if(result.data.success){
                    this.success.true
                }else{
                    this.vazio.true
                }
            }).catch((err)=>{
                console.log(error);
            })
        },
        getCliente(id){
            axios.get(`https:/apirevisoes.herokuapp.com/clientes/view/${id}`).then((result)=>{
                this.cliente = result.data.clientes;
            }).catch(error=>{
                console.error(error);
            })

        }
    },
    created(){
        let cliente_id = this.$route.params.id;
        this.getCliente(cliente_id);

        this.getCliente;
    }

}
</script>

<style>

</style>