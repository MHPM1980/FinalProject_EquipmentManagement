<template>
    <div class="container">
        <div class="row mt-3" v-if="$gate.isAdmin() || $gate.isGestor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mt-2">Gestão de Equipamentos</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">
                                Novo <i class="fa-solid fa-screwdriver-wrench"></i></button>
                        </div>
                    </div>
                    <!-- ------------------------ LOADING SKELETON ---------------------------------- -->
                    <b-skeleton-table v-if="!dataFetched"
                                      :rows="10"
                                      :columns="7"
                                      :table-props="{ bordered: true, striped: true }">
                    </b-skeleton-table>
                    <!-- ------------------------------------ INICIO DA TABELA ------------------------------------ -->
                    <div v-else class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th v-for="thead in theaders" class="text-center">{{thead}}</th>
                            </tr>
                            </thead>
                            <!-- ---------------------------------- CORPO DA TABELA --------------------------------- -->
                            <tbody>
                            <tr v-for="product in products.data" :key="product.id" class="altura-row">
                                <td class="align-middle text-center">{{ product.id }}</td>
                                <td class="td-imagem align-middle">
                                    <img class="imagem-equipamento" :src="'img/products/'+ product.image " alt="" title="">
                                </td>
                                <td class="align-middle text-center">{{ product.name }}</td>
                                <td class="align-middle text-center">{{ product.description }}</td>
                                <td class="align-middle text-center">{{ product.serial_number }}</td>
                                <td class="align-middle text-center">{{ product.category.name }}</td>
                                <td class="align-middle text-center">{{ product.warehouse.entity.name }} - {{ product.warehouse.name }}</td>
                                <td class="align-middle text-center">
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
    import NotFound from "../NotFound";
    import ModalComp from "../widgets/modalComp";
    import formCompProducts from "./widgets/formCompProducts";
    import {deleteMixin} from "../mixins/deleteMixin";
    import {searchMixin} from "../mixins/searchMixin";
    import {newModalMixin} from "../mixins/newModalMixin";

    export default {
        data(){
            return{
                dataFetched:false,
                products: {},
                theaders: [
                    'ID',
                    'Imagem',
                    'Nome',
                    'Descrição',
                    'Número Série',
                    'Categoria',
                    'Proprietário',
                    'Ação'
                ],
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
        mixins:[deleteMixin,searchMixin, newModalMixin],
        created(){
            //custom Event para recarregar a DOM
            Fire.$on('AfterCreate',()=>{
                if(this.$gate.isAdmin() || this.$gate.isGestor()){
                    axios
                        .get("api/products/")
                        .then(({ data }) => (this.products = data))
                };
            });
        },
        components: {
            ModalComp,
            formCompProducts,
            NotFound
        },
        //Fetch dos dados da API
        mounted() {
            if(this.$gate.isAdmin() || this.$gate.isGestor()){
                axios
                    .get("api/products/")
                    .then(({ data }) => (this.products = data))
                    .finally(()=>{
                        this.dataFetched=true;
                    })
            }
        },
        methods:{
            //Paginação
            getResults(page = 1){
                axios
                    .get('api/products?page=' + page)
                    .then(response => {
                        this.products = response.data;
                    });
            },
            //Preencher Formulário de Edição
            editModal(product){
                this.mode=true;
                $('#addNew').modal('show');
                this.form.fill(product);
            },
        }
    }
</script>
