<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title mt-2">Listagem de Reservas</h3>
                    </div>
                    <!-- ------------------------ LOADING SKELETON ---------------------------------- -->
                    <b-skeleton-table v-if="!dataFetched"
                                      :rows="10"
                                      :columns="7"
                                      :table-props="{ bordered: true, striped: true }">
                    </b-skeleton-table>

                    <!-- ------------------------------------- INICIO DA TABALEA ----------------------------------- -->
                    <div v-else class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                            <tr>
                                <th  class="text-center" v-if="$gate.isAdmin() || $gate.isGestor()">Utilizador</th>
                                <th v-for="thead in theaders1" class="text-center">{{thead}}</th>
                                <th class="text-center"  v-if="$gate.isAdmin() || $gate.isGestor()" >Aprovação</th>
                                <th v-for="thead in theaders2" class="text-center">{{thead}}</th>
                                <th class="text-center" v-if="$gate.isAdmin()">Cancelar</th>
                            </tr>
                            </thead>
                            <!-- ---------------------------------- CORPO TABELA ----------------------------------- -->
                            <tbody>
                            <tr name="tr" v-for="reservation in reservations.data" :key="reservation.id" :class="[reservation.approved === 1 ? 'text-success' : reservation.approved === 0 ? 'text-danger' : 'bg-warning']">

                                <td class="align-middle text-center" v-if="$gate.isAdmin() || $gate.isGestor()" >{{reservation.user.name}}</td>
                                <td class="align-middle text-center">{{ reservation.product.name }}</td>
                                <td class="align-middle text-center">{{ reservation.warehouse.entity.name }} - {{ reservation.warehouse.name }}</td>
                                <td class="align-middle text-center">{{ reservation.registry_date }}</td>
                                <td class="align-middle text-center">{{ reservation.start_date }}</td>
                                <td class="align-middle text-center">{{ reservation.end_date }}</td>

                                    <!------------------------------ COLUNA DE APROVAÇÃO --------------------------- -->
                                <td class="align-middle text-center" v-if="$gate.isAdmin() || $gate.isGestor()" >
                                    <form @submit.prevent="">
                                        <button class="btn btn-primary" v-if="reservation.approved === null" @click="reservationApproved(reservation.id)">Sim</button>
                                        <button class="btn btn-danger" v-if="reservation.approved === null" @click="reservationDenied(reservation.id)">Não</button>
                                    </form>
                                    <div v-if="reservation.approved === 1">Aprovada</div>
                                    <div v-if="reservation.approved === 0">Recusada</div>

                                </td>
                                    <!------------------------------ COLUNA DE LEVANTAMENTO ------------------------ -->
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
                                <!------------------------------ COLUNA DE DEVOLUÇÃO ------------------------------- -->
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
                                <td class="align-middle text-center" v-if="$gate.isAdmin()">
                                    <div v-if="(reservation.approved === 1 && reservation.delivered != 1) || (reservation.approved != 1 && reservation.approved != 0)">
                                            <a href="#" @click="deleteItem(reservation.id)">
                                                <i class="fa fa-trash text-red"></i>
                                            </a>
                                    </div>
                                    <div v-if="reservation.approved === 0 || reservation.returned === 1 || reservation.delivered === 1">
                                        <button class="btn" disabled>
                                            <i class="fa fa-trash text-red"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                            <pagination :data="reservations" @pagination-change-page="getResults"></pagination>
                            <p class="text-right legenda pb-0">
                                <span class="text-success px-3 col-6 col-sm-2">Reserva Aprovada</span>
                                <span class="text-danger px-3 col-6 col-sm-2">Reserva Recusada</span>
                                <span class=" px-3 col-4 col-sm-2"><i class="fa-solid fa-circle fa-md fa-green"></i>&nbsp; Ação concluída </span>
                                <span class=" px-3 col-4 col-sm-2"><i class="fa-solid fa-circle fa-md fa-yellow"></i>&nbsp; A aguardar aprovação</span>
                                <span class=" px-3 col-4 col-sm-2"><i class="fa-solid fa-circle fa-md fa-red"></i>&nbsp; Ação em falta</span>
                            </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {deleteMixin} from "../mixins/deleteMixin";
    import {searchMixin} from "../mixins/searchMixin";

    export default {
        data(){
            return{
                dataFetched:false,
                reservations: {},
                profile: {},
                theaders1: [
                    'Equipamento',
                    'Destino',
                    'Data Reserva',
                    'Início Reserva',
                    'Fim Reserva',
                    'Ação'
                ],
                theaders2: [
                    'Levantado',
                    'Devolvido',
                ],
                form: new Form({
                    id:'',
                }),
                link:'reservations',
            }
        },

        mixins:[deleteMixin, searchMixin],

        created(){
            Fire.$on('AfterCreate',()=>{
                axios
                    .get("api/reservations/")
                    .then(({ data }) => (this.reservations = data))
            });
        },

        mounted() {
            axios
                .get("api/reservations/")
                .then(({ data }) => (this.reservations = data))
                    .finally(()=>{
                        this.dataFetched=true;
                    })
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
            getResults(page = 1){
                axios
                    .get('api/reservations?page=' + page)
                    .then(response => {
                        this.reservations = response.data;
                    });
            },

        }
    }
</script>
