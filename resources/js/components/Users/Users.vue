<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestão de Utilizadores</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addNew">
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
                                <th>Tools</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="user in users" :key="user.id">
                                <td>{{ user.id }}</td>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.phone_number }}</td>
                                <td>{{ user.role.name }}</td>
                                <td>{{ user.cost.designation }}</td>
                                <td>
                                    <a href="#">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" @click="deleteUser(user.id)">
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
        <modal-comp title="Criar Utilizador" >
            <form-comp ></form-comp>
        </modal-comp>
    </div>

</template>

<script>
    import ModalComp from "../widgets/modalComp";
    import formComp from "./widgets/formComp";
    export default {
        data(){
            return{
                users: {},
                form: new Form({})
            }
        },
        created(){
            this.loadUsers();
            //costum Event to reload DOM
            Fire.$on('AfterCreate',()=>{
                this.loadUsers();
            });
        },
        components: {
            ModalComp,
            formComp,
        },
        methods:{
            loadUsers(){
                axios
                    .get("api/users/")
                    .then(({ data }) => (this.users = data.data));
            },
            deleteUser(id){
                Swal.fire({
                    title: 'Confirmar',
                    text: "A ação não pode ser revertida!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, apagar!'
                }).then((result) => {
                    if (result.isConfirmed){
                        //Send request to the server
                        this.form.delete('api/users/'+id).then(()=>{
                            Swal.fire(
                                'Apagado!',
                                'O registo foi apagado.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');
                        }).catch(()=>{
                            swal("Failed!","There was something wrong.","warning");
                        });
                    }
                })
            }
        }
    }
</script>
