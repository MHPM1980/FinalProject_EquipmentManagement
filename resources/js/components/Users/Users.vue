<template>
    <div class="container" >
        <div class="row mt-3" v-if="$gate.isAdmin() || $gate.isGestor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestão de Utilizadores</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">>
                                Novo <i class="fa-solid fa-user-plus"></i></button>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                <th>Contacto</th>
                                <th>Permissão</th>
                                <th>Centro Custo</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users.data" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.phone_number }}</td>
                                <td>{{ user.role?.name }}</td>
                                <td>{{ user.cost?.designation }}</td>
                                <td>
                                    <a href="#" @click="editModal(user)">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" @click="deleteItem(user.id)">
                                        <i class="fa fa-trash text-red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="users" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!$gate.isAdmin() && !$gate.isGestor()">
            <not-found></not-found>
        </div>
        <modal-comp v-if="$gate.isAdmin() || $gate.isGestor()" title="Gerir Utilizador" >
            <form-comp :edit-form="form" :edit-mode="mode" ></form-comp >
        </modal-comp>
    </div>

</template>

<script>
import ModalComp from "../widgets/modalComp";
import formComp from "./widgets/formComp";
import {deleteMixin} from "../mixins/deleteMixin";
import {searchMixin} from "../mixins/searchMixin";

export default {
    name: 'Users',
    data(){
        return{
            users: {},
            form: new Form({
                id:'',
                name: '',
                role_id: '',
                cost_id:'',
                phone_number: '',
                email: '',
                password: ''
            }),
            link:'users',
            mode: false,
        }
    },
    mixins:[deleteMixin, searchMixin],
    created(){

        this.loadUsers();
        //custom Event to reload DOM
        Fire.$on('AfterCreate',()=>{
            this.loadUsers();
        });
    },
    components: {
        ModalComp,
        formComp,
    },
    computed: {
        userList(){
            return this.users.data

        }
    },
    methods:{
        getResults(page = 1){
            axios
                .get('api/users?page=' + page)
                .then(response => {
                    this.users = response.data;
                });
        },
        newModal(){
            this.mode=false;
            $('#addNew').modal('show');
            this.form.reset();
            this.form.clear();
        },
        editModal(user){
            this.mode=true;
            $('#addNew').modal('show');
            this.form.clear();
            this.form.fill(user);
        },
        loadUsers(){
            if(this.$gate.isAdmin() || this.$gate.isGestor()){
                axios
                    .get("api/users/")
                    .then(({ data }) => (this.users = data));
            }
        },
    }
}
</script>
