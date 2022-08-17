<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestão de Categorias Equipamentos</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addNew">
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
                                    <a href="#">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#">
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
        <modal-comp title="Criar Categoria"></modal-comp>
    </div>

</template>

<script>
    import ModalComp from "../widgets/modalComp";
    export default {
        data(){
            return{
                categories: {},
            }
        },
        created(){
            this.loadCategories();
            //costum Event to reload DOM
            Fire.$on('AfterCreate',()=>{
                this.loadCategories();
            });
        },
        components: {
            ModalComp,
        },
        methods:{
            loadCategories(){
                axios
                    .get("api/categories/")
                    .then(({ data }) => (this.categories = data.data));
            },
        }
    }
</script>
