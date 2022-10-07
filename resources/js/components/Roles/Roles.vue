<template>
    <div class="container">
        <div class="row mt-3" v-if="$gate.isAdmin() || $gate.isGestor()">
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
                                <th class="text-center">ID</th>
                                <th class="text-center">Nome</th>
                                <th class="text-center">Utilizadores</th>
                                <th class="text-center">Descrição</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="role in roles" :key="role.id">
                                <td class="align-middle text-center">{{ role.id }}</td>
                                <td class="align-middle text-center">{{ role.name }}</td>
                                <td class="align-middle text-center" >
                                    <p v-for="users in role.users">
                                        {{ users.name }}
                                    </p>
                                </td>
                                <td class="align-middle text-center">
                                    <p v-for="(permission, index) in permissions[role.id]" :key="index">{{permission}}</p>
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
        <div v-if="!$gate.isAdmin() && !$gate.isGestor()">
            <not-found></not-found>
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

import Vue from 'vue'
import VSwitch from 'v-switch-case'

Vue.use(VSwitch)

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
            permissions:{
                1:[ "Visualizar equipamentos",
                    "Criar reservas de equipamentos",
                    "Gerir as próprias reservas",
                    "Gerir utilizadores",
                    "Gerir equipamentos",
                    "Gerir categorias de equipamentos",
                    "Gerir entidades",
                    "Gerir armazéns",
                    "Gerir centros de custo"
                ],
                2:[ "Visualizar equipamentos",
                    "Criar reservas de equipamentos",
                    "Gerir as próprias reservas",
                    "Gerir utilizadores",
                    "Gerir equipamentos",
                    "Gerir categorias de equipamentos",
                    "Gerir entidades",
                    "Gerir armazéns"
                ],
                3:[ "Visualizar equipamentos",
                    "Criar reservas de equipamentos",
                    "Gerir as próprias reservas"
                ],
                4:[ "Visualizar equipamentos"
                ]
            }
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
            if(this.$gate.isAdmin() || this.$gate.isGestor()){
                axios
                    .get("api/roles/")
                    .then(({ data }) => (this.roles = data.data))
            };
        },
    }
}
</script>
