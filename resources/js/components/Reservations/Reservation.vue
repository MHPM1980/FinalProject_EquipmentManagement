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
                                <th class="text-center">ID</th>
                                <th  class="text-center" v-if="$gate.isAdmin() || $gate.isGestor()">User</th>
                                <th class="text-center" >Equipamento</th>
                                <th class="text-center" >Data Reserva</th>
                                <th class="text-center" >Início Reserva</th>
                                <th class="text-center" >Fim Reserva</th>
                                <th class="text-center"  v-if="$gate.isAdmin() || $gate.isGestor()" >Aprovação</th>
                                <th class="text-center" >Entregue</th>
                                <th class="text-center" >Devolvido</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="reservation in reservations.data" :key="reservation.id" >
                                <td class="align-middle text-center">{{reservation.id}}</td>
                                <td class="align-middle text-center" v-if="$gate.isAdmin() || $gate.isGestor()" >{{reservation.user.name}}</td>
                                <td class="align-middle text-center">{{ reservation.product.name }}</td>
                                <td class="align-middle text-center">{{ reservation.registry_date }}</td>
                                <td class="align-middle text-center">{{ reservation.start_date }}</td>
                                <td class="align-middle text-center">{{ reservation.end_date }}</td>
                                <td class="align-middle text-center" v-if="$gate.isAdmin() || $gate.isGestor()" >{{ 7 }}</td>
                                <td class="align-middle text-center">{{ reservation.delivered }}</td>
                                <td class="align-middle text-center">{{ reservation.returned }}</td>
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
            }
        },
        created(){
            this.loadReservations();
        },
        methods:{
            loadReservations(){
                    axios
                        .get("api/reservations/")
                        .then(({ data }) => (this.reservations = data))
            },

        }
    }



</script>
