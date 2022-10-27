<template>
    <div class="container">
        <div class="row mt-3" v-if="$gate.isAdmin() || $gate.isGestor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mt-2">Gestão de Armazéns</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">
                                Novo <i class="fa-solid fa-warehouse"></i></button>
                        </div>
                    </div>
                    <!-- ------------------------ LOADING SKELETON ---------------------------------- -->
                    <b-skeleton-table v-if="!dataFetched"
                                      :rows="10"
                                      :columns="7"
                                      :table-props="{ bordered: true, striped: true }">
                    </b-skeleton-table>

                    <!-- -------------------------------------- INICIO DA TABElA ----------------------------------- -->
                    <div v-else class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th v-for="thead in theaders" class="text-center">{{thead}}</th>
                            </tr>
                            </thead>

                            <!-- ------------------------------ CORPO TABELA --------------------------------------- -->
                            <tbody>
                            <tr v-for="warehouse in warehouses.data" :key="warehouse.id">
                                <td>{{ warehouse.id }}</td>
                                <td>{{ warehouse.name }}</td>
                                <td>{{ warehouse.description }}</td>
                                <td>{{ warehouse.address }}</td>
                                <td>{{ warehouse.phone_number }}</td>
                                <td>{{ warehouse.entity.name }}</td>
                                <td>
                                    <a href="#" @click="editModal(warehouse)">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" @click="deleteItem(warehouse.id)">
                                        <i class="fa fa-trash text-red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="warehouses" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!$gate.isAdmin() && !$gate.isGestor()">
            <not-found></not-found>
        </div>
        <modal-comp title="Gerir Armazém">
            <form-comp-warehouses :edit-form="form" :edit-mode="mode"></form-comp-warehouses>
        </modal-comp>
    </div>

</template>

<script>
    import NotFound from "../NotFound";
    import ModalComp from "../widgets/modalComp";
    import formCompWarehouses from "./widgets/formCompWarehouses";
    import {deleteMixin} from "../mixins/deleteMixin";
    import {searchMixin} from "../mixins/searchMixin";
    import {newModalMixin} from "../mixins/newModalMixin";

    export default {
        data(){
            return{
                dataFetched:false,
                warehouses: {},
                theaders: [
                    'ID',
                    'Nome',
                    'Descrição',
                    'Morada',
                    'Telefone',
                    'Entidade',
                    'Ação'
                ],
                form: new Form({
                    id:'',
                    name: '',
                    entity_id: '',
                    description: '',
                    address:'',
                    phone_number: '',
                }),
                link:'warehouses',
                mode: false,
            }
        },
        mixins:[deleteMixin, searchMixin, newModalMixin],
        created(){
            //custom Event to reload DOM
            Fire.$on('AfterCreate',()=>{
                if(this.$gate.isAdmin() || this.$gate.isGestor()){
                    axios
                        .get("api/warehouses/")
                        .then(({ data }) => (this.warehouses = data))
                };
            });
        },
        components: {
            ModalComp,
            formCompWarehouses,
            NotFound
        },
        //Fetch dos dados da API
        mounted() {
            if(this.$gate.isAdmin() || this.$gate.isGestor()){
                axios
                    .get("api/warehouses/")
                    .then(({ data }) => (this.warehouses = data))
                    .finally(()=>{
                        this.dataFetched=true;
                    })
            }
        },
        methods:{
            //Paginação
            getResults(page = 1){
                axios
                    .get('api/warehouses?page=' + page)
                    .then(response => {
                        this.warehouses = response.data;
                    });
            },
            //Preencher Formulário de Edição
            editModal(warehouse){
                this.mode=true;
                $('#addNew').modal('show');
                this.form.fill(warehouse);
            },
        }
    }
</script>
