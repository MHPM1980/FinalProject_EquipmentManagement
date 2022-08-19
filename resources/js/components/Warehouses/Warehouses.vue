<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestão de Armazéns</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addNew">
                                Novo <i class="fa-solid fa-warehouse"></i></button>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Descrição</th>
                                <th>Morada</th>
                                <th>Telefone</th>
                                <th>Entidade</th>
                                <th>Tools</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="warehouse in warehouses" :key="warehouse.id">
                                <td>{{ warehouse.id }}</td>
                                <td>{{ warehouse.name }}</td>
                                <td>{{ warehouse.description }}</td>
                                <td>{{ warehouse.address }}</td>
                                <td>{{ warehouse.phone_number }}</td>
                                <td>{{ warehouse.entity.name }}</td>
                                <td>
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
        <modal-comp title="Criar Armazém">
            <form-comp-warehouses></form-comp-warehouses>
        </modal-comp>
    </div>

</template>

<script>
    import ModalComp from "../widgets/modalComp";
    import formCompWarehouses from "./widgets/formCompWarehouses";
    export default {
        data(){
            return{
                warehouses: {},
            }
        },
        created(){
            this.loadWarehouses();
            //costum Event to reload DOM
            Fire.$on('AfterCreate',()=>{
                this.loadWarehouses();
            });
        },
        components: {
            ModalComp,
            formCompWarehouses
        },
        methods:{
            loadWarehouses(){
                axios
                    .get("api/warehouses/")
                    .then(({ data }) => (this.warehouses = data.data));
            },
        }
    }
</script>
