<template>
    <div class="container">
        <div class="row mt-3" v-if="$gate.isAdmin()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mt-2">Gestão de Centros de Custo</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">
                                Novo <i class="fa-solid fa-euro-sign"></i></button>
                        </div>
                    </div>
                    <!-- ------------------------ LOADING SKELETON ---------------------------------- -->
                    <b-skeleton-table v-if="!dataFetched"
                                      :rows="10"
                                      :columns="7"
                                      :table-props="{ bordered: true, striped: true }">
                    </b-skeleton-table>
                    <!-- ----------------------------------- INICIO DA TABELA -------------------------------------- -->
                    <div v-else class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th v-for="thead in theaders" class="text-center">{{thead}}</th>
                            </tr>
                            </thead>
                            <!-- ------------------------------------ CORPO DA TABELA ------------------------------ -->
                            <tbody>
                            <tr v-for="cost in costs.data" :key="cost.id">
                                <td class="align-middle text-center">{{ cost.id }}</td>
                                <td class="align-middle text-center">{{ cost.designation }}</td>
                                <td class="align-middle text-center">{{ cost.description }}</td>
                                <td class="align-middle text-center">
                                    <p v-for="users in cost.users">
                                        {{ users.name }}
                                    </p>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="#" @click="editModal(cost)">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" @click="deleteItem(cost.id)">
                                        <i class="fa fa-trash text-red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="costs" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!$gate.isAdmin()">
            <not-found></not-found>
        </div>
        <modal-comp title="Gerir Centro de Custo">
            <form-comp-costs :edit-form="form" :edit-mode="mode"></form-comp-costs>
        </modal-comp>
    </div>

</template>

<script>
    import NotFound from "../NotFound";
    import ModalComp from "../widgets/modalComp";
    import formCompCosts from "./widgets/formCompCosts";
    import {deleteMixin} from "../mixins/deleteMixin";
    import {searchMixin} from "../mixins/searchMixin";
    import {newModalMixin} from "../mixins/newModalMixin";

    export default {
        data(){
            return{
                dataFetched:false,
                costs: {},
                theaders: [
                    'ID',
                    'Designação',
                    'Descrição',
                    'Utilizadores',
                    'Ação'
                ],
                form: new Form({
                    id:'',
                    designation: '',
                    description: '',
                }),
                link:'costs',
                mode: false,
            }
        },
        mixins:[deleteMixin, searchMixin, newModalMixin],
        created(){
            //custom Event para recarregar a DOM
            Fire.$on('AfterCreate',()=>{
                if(this.$gate.isAdmin()){
                    axios
                        .get("api/costs/")
                        .then(({ data }) => (this.costs = data))
                };
            });
        },
        components: {
            ModalComp,
            formCompCosts,
            NotFound
        },
        //Fetch dos dados da API
        mounted() {
            if(this.$gate.isAdmin()){
                axios
                    .get("api/costs/")
                    .then(({ data }) => (this.costs = data))
                    .finally(()=>{
                        this.dataFetched=true;
                    })
            }
        },
        methods:{
            //Paginação
            getResults(page = 1){
                axios
                    .get('api/costs?page=' + page)
                    .then(response => {
                        this.costs = response.data;
                    });
            },
            //Preencher Formulário de Edição
            editModal(cost){
                this.mode=true;
                $('#addNew').modal('show');
                this.form.fill(cost);
            },
        }
    }
</script>
