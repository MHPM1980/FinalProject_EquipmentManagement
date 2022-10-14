<template>
    <div class="container">
        <div class="row mt-3" v-if="$gate.isAdmin() || $gate.isGestor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestão de Categorias Equipamentos</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">
                                Novo <i class="fa-solid fa-gears"></i></button>
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
                                <th class="text-center">Descrição</th>
                                <th class="text-center">Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="category in categories.data" :key="category.id">
                                <td class="align-middle text-center">{{ category.id }}</td>
                                <td class="align-middle text-center">{{ category.name }}</td>
                                <td class="align-middle text-center">{{ category.description }}</td>
                                <td class="align-middle text-center">
                                    <a href="#" @click="editModal(category)">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" @click="deleteItem(category.id)">
                                        <i class="fa fa-trash text-red"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="categories" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="!$gate.isAdmin() && !$gate.isGestor()">
            <not-found></not-found>
        </div>
        <modal-comp title="Gerir Categoria">
            <form-comp-categories :edit-form="form" :edit-mode="mode"></form-comp-categories>
        </modal-comp>
    </div>

</template>

<script>
import ModalComp from "../widgets/modalComp";
import formCompCategories from "./widgets/formCompCategories";
import {deleteMixin} from "../mixins/deleteMixin";
import {searchMixin} from "../mixins/searchMixin";
export default {
    data(){
        return{
            dataFetched:false,
            categories: {},
            form: new Form({
                id:'',
                name: '',
                description: '',
            }),
            link:'categories',
            mode: false,
        }
    },
    mixins:[deleteMixin, searchMixin],
    created(){
        //custom Event to reload DOM
        Fire.$on('AfterCreate',()=>{
            if(this.$gate.isAdmin() || this.$gate.isGestor()){
                axios
                    .get("api/categories/")
                    .then(({ data }) => (this.categories = data));}
        });
    },
    components: {
        ModalComp,
        formCompCategories
    },
    mounted() {
        if(this.$gate.isAdmin() || this.$gate.isGestor()){
            axios
                .get("api/categories/")
                .then(({ data }) => (this.categories = data))
                .finally(()=>{
                    this.dataFetched=true;
                })
        }
    },
    methods:{
        getResults(page = 1){
            axios
                .get('api/categories?page=' + page)
                .then(response => {
                    this.categories = response.data;
                });
        },
        newModal(){
            this.mode=false;
            $('#addNew').modal('show');
            this.form.reset();
        },
        editModal(category){
            this.mode=true;
            $('#addNew').modal('show');
            this.form.fill(category);
        },
    }
}
</script>
