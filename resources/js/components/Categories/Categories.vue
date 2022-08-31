<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestão de Categorias Equipamentos</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">
                                Novo <i class="fa-solid fa-gears"></i></button>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Tools</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="category in categories" :key="category.id">
                                <td>{{ category.id }}</td>
                                <td>{{ category.name }}</td>
                                <td>{{ category.description }}</td>
                                <td>
                                    <a href="#" @click="editModal(category)">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" @click="deleteItem(category.id)">
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
        <modal-comp title="Criar Categoria">
            <form-comp-categories :edit-form="form"></form-comp-categories>
        </modal-comp>
    </div>

</template>

<script>
    import ModalComp from "../widgets/modalComp";
    import formCompCategories from "./widgets/formCompCategories";
    import {deleteMixin} from "../mixins/deleteMixin";

    export default {
        data(){
            return{
                categories: {},
                form: new Form({
                    name: '',
                    description: '',
                }),
                link:'categories'
            }
        },
        mixins:[deleteMixin],
        created(){
            this.loadCategories();
            //custom Event to reload DOM
            Fire.$on('AfterCreate',()=>{
                this.loadCategories();
            });
        },
        components: {
            ModalComp,
            formCompCategories
        },
        methods:{
            newModal(){
                $('#addNew').modal('show');
                this.form.reset();
            },
            editModal(category){
                $('#addNew').modal('show');
                this.form.fill(category);
            },
            loadCategories(){
                axios
                    .get("api/categories/")
                    .then(({ data }) => (this.categories = data.data));
            },
        }
    }
</script>
