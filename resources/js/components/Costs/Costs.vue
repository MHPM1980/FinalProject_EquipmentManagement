<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestão de Centros de Custo</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">
                                Novo <i class="fa-solid fa-euro-sign"></i></button>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Designação</th>
                                <th>Descrição</th>
                                <th>Utilizadores</th>
                                <th>Tools</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="cost in costs" :key="cost.id">
                                <td>{{ cost.id }}</td>
                                <td>{{ cost.designation }}</td>
                                <td>{{ cost.description }}</td>
                                <td >
                                    <p v-for="users in cost.users">
                                        {{ users.name }}
                                    </p>
                                </td>
                                <td>
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
                </div>
            </div>
        </div>
        <modal-comp title="Criar Centro de Custo">
            <form-comp-costs :edit-form="form"></form-comp-costs>
        </modal-comp>
    </div>

</template>

<script>
    import ModalComp from "../widgets/modalComp";
    import formCompCosts from "./widgets/formCompCosts";
    import {deleteMixin} from "../mixins/deleteMixin";

    export default {
        data(){
            return{
                costs: {},
                form: new Form({
                    designation: '',
                    description: '',
                }),
                link:'cost'
            }
        },
        mixins:[deleteMixin],
        created(){
            this.loadCosts();
            //custom Event to reload DOM
            Fire.$on('AfterCreate',()=>{
                this.loadCosts();
            });
        },
        components: {
            ModalComp,
            formCompCosts
        },
        methods:{
            newModal(){
                $('#addNew').modal('show');
                this.form.reset();
            },
            editModal(user){
                $('#addNew').modal('show');
                this.form.fill(cost);
            },
            loadCosts(){
                axios
                    .get("api/costs/")
                    .then(({ data }) => (this.costs = data.data));
            },
        }
    }
</script>
