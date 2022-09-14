<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestão de Permissões</h3>
                        <div class="card-tools">
<!--                            <button class="btn btn-success" @click="newModal">
                                Novo <i class="fa-solid fa-euro-sign"></i></button>-->
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Utilizadores</th>
                                <th>Descrição</th>
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
<!--                                    <a href="#" @click="editModal(role)">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" @click="deleteItem(role.id)">
                                        <i class="fa fa-trash text-red"></i>
                                    </a>-->
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <modal-comp title="Gerir Permissão">
            <form-comp-roles :edit-form="form" :edit-mode="mode"></form-comp-roles>
        </modal-comp>
    </div>

</template>

<script>
    import ModalComp from "../widgets/modalComp";
    import formCompRoles from "./widgets/formCompRoles";
    import {deleteMixin} from "../mixins/deleteMixin";

    export default {

        data(){
            return{
                roles: {},
                form: new Form({
                    id:'',
                    name: '',
                }),
                link:'roles',
                mode: false,
            }
        },
        mixins:[deleteMixin],
        created(){
            this.loadRoles();
            //custom Event to reload DOM
            Fire.$on('AfterCreate',()=>{
                this.loadRoles();
            });
        },
        components: {
            ModalComp,
            formCompRoles
        },
        methods:{
            newModal(){
                this.mode=false;
                $('#addNew').modal('show');
                this.form.reset();
            },
            editModal(role){
                this.mode=true;
                $('#addNew').modal('show');
                this.form.fill(role);
            },
            loadRoles(){
                axios
                    .get("api/roles/")
                    .then(({ data }) => (this.roles = data.data));
            },
        }
    }
</script>
