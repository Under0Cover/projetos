<template>
    <div>
        <Mensagem :msg="msg" v-show="msg"/>
        <div>
            <form id="burguer-form" @submit="createBurguer">
                <div class="input-container">
                    <label for="nome">Nome do cliente:</label>
                    <input type="text" name="nome" id="nome" v-model="nome" placeholder="Digite o seu nome">
                </div>
                <div class="input-container">
                    <label for="pao">Escolha o seu pão:</label>
                    <select name="pao" id="pao" v-model="pao">
                        <option v-for="pao in paes" :key="pao.id" :value="pao.tipo">{{ pao.tipo }}</option>
                    </select>
                </div>
                <div class="input-container">
                    <label for="carne">Escolha a sua carne:</label>
                    <select name="carne" id="carne" v-model="carne">
                        <option v-for="carne in carnes" :key="carne.id" :value="carne.tipo">{{ carne.tipo }}</option>
                    </select>
                </div>
                <div id="opcionais-container" class="input-container">
                    <label id="opcionais-title" for="opcionais">Escolha os seus opcionais:</label>
                    <div class="checkbox-container" v-for="opcional in opcionais" :key="opcional.id">
                        <input type="checkbox" :id="opcional.id" name="opcionais" v-model="opcionaisSelecionados" :value="opcional.tipo">
                        <span>{{ opcional.tipo }}</span>
                    </div>
                </div>
                <div class="input-container">
                    <input type="submit" value="Criar o meu Burguer" class="submit-btn">
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Mensagem from './Mensagem.vue';

export default {
    name: "BuguerForm",
    data() {
        return {
            paes: null,
            carnes: null,
            opcionais: null,
            nome: null,
            pao: null,
            carne: null,
            opcionaisSelecionados: [],
            status: "Solicitado",
            msg: null
        }
    },
    methods: {
        async getIngredientes() {
            const req = await fetch("http://localhost:3000/ingredientes");
            const data = await req.json();
            
            this.paes = data.paes;
            this.carnes = data.carnes;
            this.opcionais = data.opcionais;
        },
        async createBurguer(event) {
            event.preventDefault();

            const data = {
                nome: this.nome,
                carne: this.carne,
                pao: this.pao,
                opcionais: Array.from(this.opcionaisSelecionados),
                status: "Solicitado"
            }
            
            const dataJason = JSON.stringify(data);

            const requisao = await fetch("http://localhost:3000/burgers", {
                method: "POST",
                headers: {"Content-Type": "application/json"},
                body: dataJason
            });

            const resposta = await requisao.json();

            this.msg = `Pedido Número ${resposta.id} Enviado com Sucesso!`;

            setTimeout(() => this.msg = "", 3000);

            this.nome = "";
            this.carne = "";
            this.pao = "";
            this.opcionaisSelecionados = [];
        }
    },
    mounted() {
        this.getIngredientes();
    },
    components: {
        Mensagem
    }
}
</script> 

<style scoped>
    #burguer-form {
        max-width: 400px;
        margin: 0 auto;
    }

    .input-container {
        display: flex;
        flex-direction: column;
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
        margin-bottom: 15px;
        color: #222;
        padding: 5px 10px;
        border-left: 4px solid #FCBA03;
    }

    input, select {
        padding: 5px 10px;
        width: 300px;
    }

    #opcionais-container {
        flex-direction: row;
        flex-wrap: wrap;
    }

    #opcionais-title {
        width: 100%;
    }

    .checkbox-container {
        display: flex;
        align-items: flex-start;
        width: 50%;
        margin-bottom: 20px;
    }

    .checkbox-container span, .checkbox-container input {
        width: auto;
    }

    .checkbox-container span {
        margin-left: 6px;
        font-weight: bold;
    }

    .submit-btn {
        background-color: #222;
        color: #FCBA03;
        font-weight: bold;
        border: 2px solid #222;
        padding: 10px;
        font-size: 16px;
        margin: 0 auto;
        cursor: pointer;
        transition: .5s;
    }

    .submit-btn:hover {
        background-color: transparent;
        color: #222;
    }

</style>
