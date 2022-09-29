<template>
    <div class="container">
        <div class="row mt-3" v-if="$gate.isAdmin() || $gate.isGestor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Listagem de Equipamentos</h3>
                        <div class="card-tools">

                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th class="th-imagem text-center">Imagem</th>
                                <th class="text-center">Nome</th>
                                <th class="text-center">Descrição</th>
                                <th class="text-center">Número Série</th>
                                <th class="text-center">Categoria</th>
                                <th class="text-center">Entidade</th>
                                <th class="text-center">Armazém</th>
                                <th class="text-center">Estado</th>
                                <th class="text-center">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="product in products.data" :key="product.id" class="altura-row">
                                <td class="td-imagem align-middle">
                                    <img class="imagem-equipamento" :src="'img/products/'+ product.image " alt="" title="">
                                </td>
                                <td class="align-middle text-center">{{ product.name }}</td>
                                <td class="align-middle">{{ product.description }}</td>
                                <td class="align-middle">{{ product.serial_number }}</td>
                                <td class="align-middle">{{ product.category.name }}</td>
                                <td class="align-middle text-center">{{ product.warehouse.entity_id }}</td>
                                <td class="align-middle ">{{ product.warehouse.name }}</td>
                                <td class="align-middle text-center">
                                    <div v-if="product.status == 1">
                                        <i  class="fa-solid fa-circle fa-lg fa-green"></i>
                                    </div>
                                    <div v-else>
                                        <i  class="fa-solid fa-circle fa-lg fa-red"></i>
                                    </div>
                                </td>
                                <td class="align-middle text-center">
                                    <a class="btn-primary btn" @click="listEquipment(product)">Detalhe</a>

<!--                                   <a href="#" @click="editModal(product)">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" @click="deleteItem(product.id)">
                                        <i class="fa fa-trash text-red"></i>
                                    </a>-->
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
        <modal-product title="Reservar Equipamento">
            <product-detail :edit-form="form"></product-detail>
        </modal-product>
    </div>

</template>

<script>
    import productDetail from "./ProductDetail";
    import modalProduct from "./modalProduct";

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
                    category: {},
                    warehouse: {},
                }),
            }
        },
        created(){
            this.loadProducts();
            //custom Event to reload DOM
            Fire.$on('AfterCreate',()=>{
                this.loadProducts();
            });
        },
        components: {
            modalProduct,
            productDetail

        },
        methods:{
            getResults(page = 1){
                axios
                    .get('api/products?page=' + page)
                    .then(response => {
                        this.products = response.data;
                    });
            },
            listEquipment(product){
                this.form.fill(product);
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
