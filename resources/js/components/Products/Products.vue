<template>
    <div class="container">
        <div class="row mt-3">
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
                                <th>ID</th>
                                <th>Imagem</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Número Série</th>
                                <th>Categoria</th>
                                <th>Armazém</th>
                                <th>Tools</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="product in products" :key="product.id">
                                <td>{{ product.id }}</td>
                                <td>
                                   <!--   @if {{ product.image }}
                                    <img class="w-25 img-responsive" src="{{ asset('storage/'.$product->image) }}" alt="" title="">
                                    @else
                                    <p>
                                        No Image
                                    </p>
                                    @endif -->
                                    {{ product.image }}
                                </td>
                                <td>{{ product.name }}</td>
                                <td>{{ product.description }}</td>
                                <td>{{ product.serial_number }}</td>
                                <td>{{ product.category.name }}</td>
                                <td>{{ product.warehouse.name }}</td>
                                <td>
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
                </div>
            </div>
        </div>
        <modal-comp title="Criar Equipamento">
            <form-comp-products :edit-form="form" :edit-mode="mode"></form-comp-products>
        </modal-comp>
    </div>

</template>

<script>
    import ModalComp from "../widgets/modalComp";
    import formCompProducts from "./widgets/formCompProducts";
    import {deleteMixin} from "../mixins/deleteMixin";

    export default {
        data(){
            return{
                products: {},
                form: new Form({
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
        mixins:[deleteMixin],
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
                axios
                    .get("api/products/")
                    .then(({ data }) => (this.products = data.data));
            },
        }
    }
</script>
