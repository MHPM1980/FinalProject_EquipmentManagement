<template>
    <div class="container">
        <div class="row mt-3" v-if="$gate.isAdmin() || $gate.isGestor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestão de Equipamentos</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">
                                Novo <i class="fa-solid fa-screwdriver-wrench"></i></button>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="th-imagem text-center">Imagem</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Número Série</th>
                                <th>Categoria</th>
                                <th>Armazém</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="product in products.data" :key="product.id" class="altura-row">
                                <td class="align-middle text-center">{{ product.id }}</td>
                                <td class="td-imagem align-middle">
                                    <img class="imagem-equipamento" :src="'img/products/'+ product.image " alt="" title="">
                                </td>
                                <td class="align-middle">{{ product.name }}</td>
                                <td class="align-middle">{{ product.description }}</td>
                                <td class="align-middle">{{ product.serial_number }}</td>
                                <td class="align-middle">{{ product.category.name }}</td>
                                <td class="align-middle">{{ product.warehouse.name }}</td>
                                <td class="align-middle">
                                    <a href="#" @click="editModal(product)">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" @click="deleteItem(product.id)">
                                        <i class="fa fa-trash text-red"></i>
                                    </a>
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
        <div v-if="!$gate.isAdmin() && !$gate.isGestor()">
            <not-found></not-found>
        </div>
        <modal-comp title="Gerir Equipamento">
            <form-comp-products :edit-form="form" :edit-mode="mode"></form-comp-products>
        </modal-comp>
    </div>

</template>

<script>
    import ModalComp from "../widgets/modalComp";
    import formCompProducts from "./widgets/formCompProducts";
    import {deleteMixin} from "../mixins/deleteMixin";
    import {searchMixin} from "../mixins/searchMixin";

    export default {
        data(){
            return{
                products: {},
                form: new Form({
                    id:'',
                    image:'',
                    name: '',
                    description: '',
                    serial_number:'',
                    category_id: '',
                    warehouse_id:'',
                }),
                link:'products',
                mode: false,
            }
        },
        mixins:[deleteMixin,searchMixin],
        created(){
            this.loadProducts();
            //custom Event to reload DOM
            Fire.$on('AfterCreate',()=>{
                this.loadProducts();
            });
        },
        components: {
            ModalComp,
            formCompProducts
        },
        methods:{
            getResults(page = 1){
                axios
                    .get('api/products?page=' + page)
                    .then(response => {
                        this.products = response.data;
                    });
            },
            newModal(){
                this.mode=false;
                $('#addNew').modal('show');
                this.form.reset();
            },
            editModal(product){
                this.mode=true;
                $('#addNew').modal('show');
                this.form.fill(product);
            },
            loadProducts(){
                if(this.$gate.isAdmin() || this.$gate.isGestor()){
                axios
                    .get("api/products/")
                    .then(({ data }) => (this.products = data))
                };
            },
        }
    }
</script>
