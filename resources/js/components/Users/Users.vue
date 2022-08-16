<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users Managment</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" data-toggle="modal" data-target="#addNew">
                                Add New <i class="fa-solid fa-user-plus"></i></button>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>Role</th>
                                <th>Cost Center</th>
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
                                    <a href="#">
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
        <modal-comp title="Create User"></modal-comp>
    </div>

</template>

<script>
    import ModalComp from "../widgets/modalComp";
    export default {
        data(){
            return{
                users: {},
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
        },
        methods:{
            loadUsers(){
                axios
                    .get("api/users/")
                    .then(({ data }) => (this.users = data.data));
            },
        }
    }
</script>
