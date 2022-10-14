<template>
    <div class="container">
        <div class="row mt-3" v-if="$gate.isAdmin() || $gate.isGestor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mt-2">Gestão de Entidades</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">
                                Novo <i class="fa-solid fa-building"></i></button>
                        </div>
                    </div>
                    <b-skeleton-table v-if="!dataFetched"
                                      :rows="10"
                                      :columns="7"
                                      :table-props="{ bordered: true, striped: true }">
                    </b-skeleton-table>
                    <div v-else class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Nome</th>
                                <th class="text-center">Morada</th>
                                <th class="text-center">Telefone</th>
                                <th class="text-center">Armazens</th>
                                <th class="text-center">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="entity in entities.data" :key="entity.id">
                                <td class="align-middle text-center">{{ entity.id }}</td>
                                <td class="align-middle text-center">{{ entity.name }}</td>
                                <td class="align-middle text-center">{{ entity.address }}</td>
                                <td class="align-middle text-center">{{ entity.phone_number }}</td>
                                <td class="align-middle text-center">
                                    <p v-for="waresouses in entity.warehouses">
                                        {{ waresouses.name }}
                                    </p>
                                </td>
                                <td class="align-middle text-center">
                                    <a href="#" @click="editModal(entity)">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" @click="deleteItem(entity.id)">
                                        <i class="fa fa-trash text-red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="entities" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!$gate.isAdmin() && !$gate.isGestor()">
            <not-found></not-found>
        </div>
        <modal-comp title="Gerir Entidade">
            <form-comp-entities :edit-form="form" :edit-mode="mode"></form-comp-entities >
        </modal-comp>
    </div>

</template>

<script>
    import ModalComp from "../widgets/modalComp";
    import formCompEntities from "./widgets/formCompEntities.vue";
    import {deleteMixin} from "../mixins/deleteMixin";
    import {searchMixin} from "../mixins/searchMixin";

    export default {
        data(){
            return{
                dataFetched:false,
                entities: {},
                form: new Form({
                    id:'',
                    name: '',
                    address: '',
                    phone_number: '',
                }),
                link:'entities',
                mode: false,
            }
        },
        mixins:[deleteMixin, searchMixin],
        created(){
            //custom Event to reload DOM
            Fire.$on('AfterCreate',()=>{
                if(this.$gate.isAdmin() || this.$gate.isGestor()){
                    axios
                        .get("api/entities/")
                        .then(({ data }) => (this.entities = data))
                };
            });
        },
        components: {
            ModalComp,
            formCompEntities
        },
        mounted() {
            if(this.$gate.isAdmin() || this.$gate.isGestor()){
                axios
                    .get("api/entities/")
                    .then(({ data }) => (this.entities = data))
                    .finally(()=>{
                        this.dataFetched=true;
                    })
            }
        },
        methods:{
            getResults(page = 1){
                axios
                    .get('api/entities?page=' + page)
                    .then(response => {
                        this.entities = response.data;
                    });
            },
            newModal(){
                this.mode=false;
                $('#addNew').modal('show');
                this.form.reset();
            },
            editModal(entity){
                this.mode=true;
                $('#addNew').modal('show');
                this.form.fill(entity);
            },
        }
    }
</script>
