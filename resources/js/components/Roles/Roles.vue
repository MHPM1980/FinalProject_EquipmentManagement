<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestão de Permissões</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addNew">
                                Novo <i class="fa-solid fa-euro-sign"></i></button>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Utilizadores</th>
                                <th>Tools</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="role in roles" :key="role.id">
                                <td>{{ role.id }}</td>
                                <td>{{ role.name }}</td>
                                <td >
                                    <p v-for="users in role.users">
                                        {{ users.name }}
                                    </p>
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
        <modal-comp title="Criar Permissão">
            <form-comp-roles></form-comp-roles>
        </modal-comp>
    </div>

</template>

<script>
    import ModalComp from "../widgets/modalComp";
    import formCompRoles from "./widgets/formCompRoles";
    export default {
        data(){
            return{
                roles: {},
            }
        },
        created(){
            this.loadRoles();
            //costum Event to reload DOM
            Fire.$on('AfterCreate',()=>{
                this.loadRoles();
            });
        },
        components: {
            ModalComp,
            formCompRoles
        },
        methods:{
            loadRoles(){
                axios
                    .get("api/roles/")
                    .then(({ data }) => (this.roles = data.data));
            },
        }
    }
</script>
