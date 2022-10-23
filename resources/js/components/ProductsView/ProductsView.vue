<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div v-if="$gate.isFormando()" class="d-flex justify-content-start align-items-center">
                            <h3 class="align-middle mt-2">Listagem de Equipamentos</h3>
                            <h6 class="ml-2 mt-2">(Para reservar contacte um Formador!)</h6>
                        </div>
                        <div v-else>
                            <h3 class="card-title mt-2">Listagem de Equipamentos</h3>
                        </div>

                        <div class="card-tools">

                        </div>
                    </div>
                    <b-skeleton-table v-if="!dataFetched"
                                      :rows="10"
                                      :columns="7"
                                      :table-props="{ bordered: true, striped: true }">
                    </b-skeleton-table>
                    <div v-else class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th class="th-imagem text-center">Imagem</th>
                                <th class="text-center">Nome</th>
                                <th class="text-center">Descrição</th>
                                <th class="text-center">Número Série</th>
                                <th class="text-center">Categoria</th>
                                <th class="text-center">Proprietário</th>
                                <th class="text-center">Estado</th>
                                <th v-if="!$gate.isFormando()" class="text-center">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="product in products.data" :key="product.id" class="altura-row">
                                <td class="td-imagem align-middle">
                                    <img class="imagem-equipamento" :src="'img/products/'+ product.image " alt="" title="">
                                </td>
                                <td class="align-middle text-center">{{ product.name }}</td>
                                <td class="align-middle text-center">{{ product.description }}</td>
                                <td class="align-middle text-center">{{ product.serial_number }}</td>
                                <td class="align-middle text-center">{{ product.category.name }}</td>
                                <td class="align-middle text-center">{{ product.warehouse.entity.name }} - {{ product.warehouse.name }}</td>
                                <td class="align-middle text-center">
                                    <div v-if="isBetween(product.reservations)">
                                        <i  class="fa-solid fa-circle fa-lg fa-green"></i>
                                    </div>
                                    <div v-else>
                                        <i  class="fa-solid fa-circle fa-lg fa-red"></i>
                                    </div>
                                </td>
                                <td v-if="!$gate.isFormando()" class="align-middle text-center">
                                    <a class="btn-primary btn" @click="[numberApReservation(product.id), listEquipment(product)]">Detalhe</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="products" @pagination-change-page="getResults"></pagination>
                    </div>

                </div>
            </div>
        </div>
        <modal-product title="Reservar Equipamento">
            <product-detail :edit-form="form" :edit-reservations="reservations" ></product-detail>
        </modal-product>
    </div>

</template>

<script>
import moment from "moment/moment";

import productDetail from "./ProductDetail";
import modalProduct from "./modalProduct";
import {searchMixin} from "../mixins/searchMixin";

export default {
    data(){
        return{
            dataFetched:false,
            products: {},
            reservations:[],
            form: new Form({
                id:'',
                image:'',
                name: '',
                description: '',
                serial_number:'',
                category: {},
                warehouse: {},
            }),
        }
    },
    mixins:[searchMixin],
    created(){
        //custom Event to reload DOM
        Fire.$on('AfterCreate',()=>{
            axios
                .get("api/products/")
                .then(({ data }) => (this.products = data))
        });
    },
    components: {
        modalProduct,
        productDetail
    },
    mounted() {
        axios
            .get("api/products/")
            .then(({ data }) => (this.products = data))
            .finally(()=>{
                this.dataFetched=true;
            })
    },
    methods:{
        getResults(page = 1){
            axios
                .get('api/products?page=' + page)
                .then(response => {
                    this.products = response.data;
                });
        },
        isBetween(reservations){
            let flag = false

            for (let reservation of reservations) {
                if (moment().isBetween(reservation.start_date, reservation.end_date)) flag = true
            }

            return !flag;
        },
        numberApReservation(id){
            axios
                .get(`api/findProductReservations/?product_id=`+id+`&approved!=0`)
                .then(({ data }) => (this.reservations=data.trim().split(" ")))
        },
        listEquipment(product){
            this.form.fill(product);
            $('#addNew').modal('show');
            this.form.fill(product);
        },
    }
}
</script>
