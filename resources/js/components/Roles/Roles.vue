<template>
    <div class="container">
        <div class="row mt-3" v-if="$gate.isAdmin() || $gate.isGestor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mt-2">Gestão de Permissões</h3>
                        <div class="card-tools">

                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th v-for="thead in theaders" class="text-center">{{thead}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="role in roles" :key="role.id">
                                <td class="align-middle text-center">{{ role.name }}</td>
                                <td class="align-middle text-center" >
                                    <p v-for="users in role.users">
                                        {{ users.name }}
                                    </p>
                                </td>
                                <td class="align-middle">
                                    <p class="role-desc" v-for="(permission, index) in permissions[role.id]" :key="index">{{permission}}</p>
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
import {searchMixin} from "../mixins/searchMixin";
import {newModalMixin} from "../mixins/newModalMixin";

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
            theaders: [
                'Nome',
                'Utilizadores',
                'Descrição',
            ],
            permissions:{
                1:[ "Visualizar equipamentos",
                    "Criar reservas de equipamentos",
                    "Eliminar reservas",
                    "Gerir reservas",
                    "Gerir utilizadores",
                    "Gerir equipamentos",
                    "Gerir categorias de equipamentos",
                    "Gerir entidades",
                    "Gerir armazéns",
                    "Gerir centros de custo"
                ],
                2:[ "Visualizar equipamentos",
                    "Criar reservas de equipamentos",
                    "Gerir reservas",
                    "Gerir utilizadores",
                    "Gerir equipamentos",
                    "Gerir categorias de equipamentos",
                    "Gerir entidades",
                    "Gerir armazéns"
                ],
                3:[ "Visualizar equipamentos",
                    "Criar reservas de equipamentos",
                    "Visualizar as próprias reservas"
                ],
                4:[ "Visualizar equipamentos"
                ]
            }
        }
    },
    mixins:[deleteMixin, searchMixin, newModalMixin],
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

