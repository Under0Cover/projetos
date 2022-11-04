<template>
    <Mensagem :msg="msg" v-show="msg"/>
    <div id="burger-table">
        <div id="burger-table-heading">
            <div class="order-id">#:</div>
            <div>Cliente:</div>
            <div>Pão:</div>
            <div>Carne:</div>
            <div>Opcionais:</div>
            <div>Ações:</div>
        </div>
        <div id="burger-table-rows">
            <div class="burger-table-row" v-for="burger in burgers" :key="burger.id">
                <div class="order-number">{{ burger.id }}</div>
                <div class="nome-cliente">{{ burger.nome }}</div>
                <div class="pao">{{ burger.pao }}</div>
                <div class="carne">{{ burger.carne }}</div>
                <div class="opcionais">
                    <ul>
                        <li v-for="(opcional, index) in burger.opcionais" :key="index">{{ opcional }}</li>
                    </ul>
                </div>
                <div class="acoes">
                    <select name="status" id="status" class="status" @change="updateBurger($event, burger.id)">
                        <option value="">Selecione</option>
                        <option v-for="statu in status" :value="statu.tipo" :key="statu.id" :selected="burger.status == statu.tipo">{{ statu.tipo }}</option>
                    </select>
                    <button class="delete-btn" @click="deleteBurger(burger.id)">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Mensagem from './Mensagem.vue';

export default {
    name: "Dashboard",
    data() {
        return {
            burgers: null,
            burger_id: null,
            status: [],
            msg: null
        }
    },
    components: {
        Mensagem
    },
    methods: {
        async getPedidos() {
            const requisao = await fetch("http://localhost:3000/burgers");
            const data = await requisao.json();
            this.burgers = data;

            this.getStatus();

        },
        async getStatus() {
            const requisao = await fetch("http://localhost:3000/status");
            const data = await requisao.json();
            this.status = data;

        },
        async deleteBurger(burger_id) {
            console.log('click');
            const requisao = await fetch(`http://localhost:3000/burgers/${burger_id}`, {
                method: "DELETE"
            });

            this.msg = "Pedido removido com sucesso!";
            setTimeout(() => this.msg = "", 3000);

            const resposta = await requisao.json();
            this.getPedidos();
        },
        async updateBurger(event, burger_id) {
            const option = event.target.value;
            const dataJson = JSON.stringify({status: option});

            const requisao = await fetch(`http://localhost:3000/burgers/${burger_id}`, {
                method: "PATCH",
                headers: {"Content-Type": "application/json"},
                body: dataJson
            });

            const resposta = await requisao.json();
            this.msg = `Pedido número ${resposta.id}, atualizado para: ${resposta.status}!`;
            setTimeout(() => this.msg = "", 3000);

        }
    },
    mounted() {
        this.getPedidos();
    }
}
</script>

<style scoped>
    #burguer-table {
        max-width: 1200px;
        margin: 0 auto;
    }

    #burger-table-heading, #burger-table-rows, .burger-table-row {
        display: flex;
        flex-wrap: wrap;
    }

    #burger-table-heading {
        font-weight: bold;
        padding: 12px;
        border-bottom: 3px solid #333;
    }

    #burger-table-heading div, .burger-table-row div {
        width: 19%;
    }

    .burger-table-row {
        width: 100%;
        padding: 12px;
        border-bottom: 1px solid #CCC;
    }

    .order-id, .order-number {
        width: 5% !important;
    }

    select {
        padding: 12px 6px;
        margin-right: 12px;
    }

    .delete-btn {
        background-color: #222;
        color: #FCBA03;
        font-weight: bold;
        border: 2px solid #222;
        padding: 10px;
        margin: 0 auto;
        cursor: pointer;
        transition: 0.5s;
    }

    .delete-btn:hover {
        background-color: transparent;
        color: #222;
    }

</style>
