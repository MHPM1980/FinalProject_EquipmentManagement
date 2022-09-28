<template>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Gestão de Equipamentos</h3>
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
                            <tr class="">
                                <td class="align-middle text-center">{{ 1 }}</td>
                                <td class="align-middle text-center" v-if="$gate.isAdmin() || $gate.isGestor()" >{{ 2 }}</td>
                                <td class="align-middle text-center">{{ 3 }}</td>
                                <td class="align-middle text-center">{{ 4 }}</td>
                                <td class="align-middle text-center">{{ 5 }}</td>
                                <td class="align-middle text-center">{{ 6 }}</td>
                                <td class="align-middle text-center" v-if="$gate.isAdmin() || $gate.isGestor()" >{{ 7 }}</td>
                                <td class="align-middle text-center">{{ 8 }}</td>
                                <td class="align-middle text-center">{{ 9 }}</td>
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
        methods:{
            loadReservations(){

                    axios
                        .get("api/reservations/")
                        .then(({ data }) => (this.reservations = data.data))

            },
        }
    }



</script>
