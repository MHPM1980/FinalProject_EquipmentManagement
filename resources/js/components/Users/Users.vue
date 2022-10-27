<template>
    <div class="container" >
        <div class="row mt-3" v-if="$gate.isAdmin() || $gate.isGestor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mt-2">Gestão de Utilizadores</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">
                                Novo <i class="fa-solid fa-user-plus"></i></button>
                        </div>
                    </div>
                    <!-- ------------------------ LOADING SKELETON ---------------------------------- -->
                    <b-skeleton-table v-if="!dataFetched"
                        :rows="10"
                        :columns="7"
                        :table-props="{ bordered: true, striped: true }">
                    </b-skeleton-table>

                    <!-- ------------------------------------- INICIO DA TABALEA ----------------------------------- -->
                    <div v-else class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th v-for="thead in theaders" class="text-center">{{thead}}</th>
                            </tr>
                            </thead>
                            <!-- ---------------------------------- CORPO TABELA ----------------------------------- -->
                            <tbody>
                            <tr v-for="user in users.data" :key="user.id">
                                <td class="align-middle text-center">{{ user.id }}</td>
                                <td class="align-middle text-center">{{ user.name }}</td>
                                <td class="align-middle text-center">{{ user.email }}</td>
                                <td class="align-middle text-center">{{ user.phone_number }}</td>
                                <td class="align-middle text-center">{{ user.role?.name }}</td>
                                <td class="align-middle text-center">{{ user.cost?.designation }}</td>
                                <td class="align-middle text-center">
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
import NotFound from "../NotFound";
import ModalComp from "../widgets/modalComp";
import formComp from "./widgets/formComp";
import {deleteMixin} from "../mixins/deleteMixin";
import {searchMixin} from "../mixins/searchMixin";
import {newModalMixin} from "../mixins/newModalMixin";

export default {
    name: 'Users',
    data(){
        return{
            dataFetched:false,
            users: {},
            theaders: [
                'ID',
                'Nome',
                'Email',
                'Contacto',
                'Permissão',
                'Centro Custo',
                'Ação'
            ],
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
    mixins:[deleteMixin, searchMixin, newModalMixin],
    created(){
        //custom Event to reload DOM
        Fire.$on('AfterCreate',()=>{
            if(this.$gate.isAdmin() || this.$gate.isGestor()){
                axios
                    .get("api/users/")
                    .then(({ data }) => (this.users = data))
            }
        });
    },
    components: {
        ModalComp,
        formComp,
        NotFound
    },
    //Fetch dos dados da API
    mounted() {
        if(this.$gate.isAdmin() || this.$gate.isGestor()){
            axios
                .get("api/users/")
                .then(({ data }) => (this.users = data))
                .finally(()=>{
                    this.dataFetched=true;
                })
        }
    },
    methods:{
        //Paginação
        getResults(page = 1){
            axios
                .get('api/users?page=' + page)
                .then(response => {
                    this.users = response.data;
                });
        },
        //Preencher Formulário de Edição
        editModal(user){
            this.mode=true;
            $('#addNew').modal('show');
            this.form.clear();
            this.form.fill(user);
        },
    }
}
</script>
