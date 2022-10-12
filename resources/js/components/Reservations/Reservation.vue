<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Listagem de Reservas</h3>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th  class="text-center" v-if="$gate.isAdmin() || $gate.isGestor()">Utilizador</th>
                                <th class="text-center" >Equipamento</th>
                                <th class="text-center">Destino</th>
                                <th class="text-center" >Data Reserva</th>
                                <th class="text-center" >Início Reserva</th>
                                <th class="text-center" >Fim Reserva</th>
                                <th class="text-center"  v-if="$gate.isAdmin() || $gate.isGestor()" >Aprovação</th>
                                <th class="text-center" >Levantado</th>
                                <th class="text-center" >Devolvido</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr name="tr" v-for="reservation in reservations.data" :key="reservation.id" :class="[reservation.approved === 1 ? 'text-success' : reservation.approved === 0 ? 'text-danger' : 'bg-warning']">

                                <td class="align-middle text-center" v-if="$gate.isAdmin() || $gate.isGestor()" >{{reservation.user.name}}</td>
                                <td class="align-middle text-center">{{ reservation.product.name }}</td>
                                <td class="align-middle text-center">{{ reservation.warehouse.name }}</td>
                                <td class="align-middle text-center">{{ reservation.registry_date }}</td>
                                <td class="align-middle text-center">{{ reservation.start_date }}</td>
                                <td class="align-middle text-center">{{ reservation.end_date }}</td>

                                    <!------------------------------ COLUNA DE APROVAÇÃO ------------------------- -->
                                <td class="align-middle text-center" v-if="$gate.isAdmin() || $gate.isGestor()" >
                                    <form @submit.prevent="">
                                        <button class="btn btn-primary" v-if="reservation.approved === null" @click="reservationApproved(reservation.id)">Sim</button>
                                        <button class="btn btn-danger" v-if="reservation.approved === null" @click="reservationDenied(reservation.id)">Não</button>
                                    </form>
                                    <div v-if="reservation.approved === 1">Aprovada</div>
                                    <div v-if="reservation.approved === 0">Recusada</div>

                                </td>
                                    <!------------------------------ COLUNA DE LEVANTAMENTO ------------------------- -->
                                <td class="align-middle text-center">
                                    <div v-if="$gate.isAdmin() || $gate.isGestor()">
                                        <form @submit.prevent="">
                                            <button class="btn btn-primary" v-if="reservation.approved===1 && reservation.delivered === 0" @click="equipmentDelivered(reservation.id)">Sim</button>
                                        </form>
                                        <div v-if="reservation.approved === 0"> <i class="fa-solid fa-circle fa-lg fa-red"></i> </div>
                                        <div v-if="reservation.approved === 1 && reservation.delivered === 1"> <i class="fa-solid fa-circle fa-lg fa-green"></i> </div>
                                    </div>

                                    <div v-if="$gate.isFormador()">
                                        <div v-if="reservation.approved === 0"> <i class="fa-solid fa-circle fa-lg fa-red"></i> </div>
                                        <div v-if="reservation.approved === 1 && reservation.delivered === 0"> <i class="fa-solid fa-circle fa-lg fa-yellow"></i> </div>
                                        <div v-if="reservation.delivered === 1"> <i class="fa-solid fa-circle fa-lg fa-green"></i> </div>
                                    </div>

                                </td>
                                <!------------------------------ COLUNA DE DEVOLUÇÃO ------------------------- -->
                                <td class="align-middle text-center">
                                    <div v-if="$gate.isAdmin() || $gate.isGestor()">
                                        <form @submit.prevent="">
                                            <button class="btn btn-primary" v-if="reservation.delivered === 1 && reservation.returned === 0" @click="equipmentReturned(reservation.id)">Sim</button>
                                        </form>
                                        <div v-if="reservation.approved === 0"> <i class="fa-solid fa-circle fa-lg fa-red"></i> </div>
                                        <div v-if="reservation.approved === 1 && reservation.delivered===1 && reservation.returned === 1"> <i class="fa-solid fa-circle fa-lg fa-green"></i> </div>
                                    </div>

                                    <div v-if="$gate.isFormador()">
                                        <div v-if="reservation.approved === 0"> <i class="fa-solid fa-circle fa-lg fa-red"></i> </div>
                                        <div v-if="reservation.delivered === 1 && reservation.returned === 0"> <i class="fa-solid fa-circle fa-lg fa-yellow"></i> </div>
                                        <div v-if="reservation.returned === 1"> <i class="fa-solid fa-circle fa-lg fa-green"></i> </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        data(){
            return{
                reservations: {},
                form: new Form({
                    id:'',
                }),
            }
        },
        created(){
            this.loadReservations();
            Fire.$on('AfterCreate',()=>{
                this.loadReservations();
            });
        },
        methods:{
            loadReservations(){
                    axios
                        .get("api/reservations/")
                        .then(({ data }) => (this.reservations = data))
            },
            reservationDenied(id){
                this.form.approved=0
                this.form.put(`api/reservations/`+id)
                    .then(()=>{
                        this.form.reset();
                        Swal.fire(
                            'Atualizado!',
                            'O registo foi Atualizado.',
                            'success'
                        )
                        this.$Progress.finish();
                        //custom Event to reload DOM
                        Fire.$emit('AfterCreate');
                    })

                    .catch(()=>{
                        this.$Progress.fail()
                        Swal.fire("Erro!","Não é possível atualizar o registo.","warning");
                    })

            },

            reservationApproved(id){
                this.form.approved=1
                this.form.delivered=0
                this.form.put(`api/reservations/`+id)
                    .then(()=>{
                        this.form.reset();
                        Swal.fire(
                            'Atualizado!',
                            'O registo foi Atualizado.',
                            'success'
                        )
                        this.$Progress.finish();
                        //custom Event to reload DOM
                        Fire.$emit('AfterCreate');
                    })
                    .catch(()=>{
                        this.$Progress.fail()
                        Swal.fire("Erro!","Não é possível atualizar o registo.","warning");
                    })
            },

            equipmentDelivered(id){
                this.form.delivered=1
                this.form.returned=0
                this.form.approved=1
                this.form.put(`api/reservations/`+id)
                    .then(()=>{
                        this.form.reset();
                        Swal.fire(
                            'Atualizado!',
                            'O registo foi Atualizado.',
                            'success'
                        )
                        this.$Progress.finish();
                        //custom Event to reload DOM
                        Fire.$emit('AfterCreate');
                    })
                    .catch(()=>{
                        this.$Progress.fail()
                        Swal.fire("Erro!","Não é possível atualizar o registo.","warning");
                    })
            },
            equipmentReturned(id){
                this.form.returned=1
                this.form.delivered=1
                this.form.approved=1
                this.form.put(`api/reservations/`+id)
                    .then(()=>{
                        this.form.reset();
                        Swal.fire(
                            'Atualizado!',
                            'O registo foi Atualizado.',
                            'success'
                        )
                        this.$Progress.finish();
                        //custom Event to reload DOM
                        Fire.$emit('AfterCreate');
                    })
                    .catch(()=>{
                        this.$Progress.fail()
                        Swal.fire("Erro!","Não é possível atualizar o registo.","warning");
                    })
            },

        }
    }
</script>
