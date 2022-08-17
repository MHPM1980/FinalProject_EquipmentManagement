<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestão de Entidades</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addNew">
                                Add New <i class="fa-solid fa-building"></i></button>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Morada</th>
                                <th>Telefone</th>
                                <th>Armazéns</th>
                                <th>Tools</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="entity in entities" :key="entity.id">
                                <td>{{ entity.id }}</td>
                                <td>{{ entity.name }}</td>
                                <td>{{ entity.address }}</td>
                                <td>{{ entity.phone_number }}</td>
                                <td v-for="waresouses in entity.warehouses">
                                        {{ waresouses.name }}
                                </td>
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
        <modal-comp title="Criar Entidade"></modal-comp>
    </div>

</template>

<script>
    import ModalComp from "../widgets/modalComp";
    export default {
        data(){
            return{
                entities: {},
            }
        },
        created(){
            this.loadEntities();
            //costum Event to reload DOM
            Fire.$on('AfterCreate',()=>{
                this.loadEntities();
            });
        },
        components: {
            ModalComp,
        },
        methods:{
            loadEntities(){
                axios
                    .get("api/entities/")
                    .then(({ data }) => (this.entities = data.data));
            },
        }
    }
</script>
