<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestão de Entidades</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">
                                Novo <i class="fa-solid fa-building"></i></button>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Morada</th>
                                <th>Telefone</th>
                                <th>Armazens</th>
                                <th>Tools</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="entity in entities" :key="entity.id">
                                <td>{{ entity.id }}</td>
                                <td>{{ entity.name }}</td>
                                <td>{{ entity.address }}</td>
                                <td>{{ entity.phone_number }}</td>
                                <td >
                                    <p v-for="waresouses in entity.warehouses">
                                        {{ waresouses.name }}
                                    </p>
                                </td>
                                <td>
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
                </div>
            </div>
        </div>
        <modal-comp title="Criar Entidade">
            <form-comp-entities :edit-form="form" :edit-mode="mode"></form-comp-entities >
        </modal-comp>
    </div>

</template>

<script>
    import ModalComp from "../widgets/modalComp";
    import formCompEntities from "./widgets/formCompEntities.vue";
    import {deleteMixin} from "../mixins/deleteMixin";

    export default {
        data(){
            return{
                entities: {},
                form: new Form({
                    name: '',
                    address: '',
                    phone_number: '',
                }),
                link:'entities',
                mode: false,
            }
        },
        mixins:[deleteMixin],
        created(){
            this.loadEntities();
            //costum Event to reload DOM
            Fire.$on('AfterCreate',()=>{
                this.loadEntities();
            });
        },
        components: {
            ModalComp,
            formCompEntities
        },
        methods:{
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
            loadEntities(){
                axios
                    .get("api/entities/")
                    .then(({ data }) => (this.entities = data.data));
            },
        }
    }
</script>
