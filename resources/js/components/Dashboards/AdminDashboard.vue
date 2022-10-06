<template>
    <div class="text-center pt-5 align-middle">
        <div class="row">
            <card background="bg-info" size="col-md-6" text="Total de Utilizadores" :number=users rota="/users"></card>
            <card background="bg-secondary" size="col-md-6" text="Total de equipamentos" :number=equipments rota="/equipments"></card>
            <card background="bg-warning" size="col-md-6" text="Total de reservas aprovadas" rota="/reservations"></card>
            <card background="bg-danger" size="col-md-6" text="Total de reservas pendentes" rota="/reservations"></card>
            <card background="bg-success" text="Total de equipamentos por devolver" rota="/equipments"></card>
        </div>
    </div>
</template>

<script>
    import card from "./widgets/card";
    export default {
        data(){
            return{
                users:0,
                equipments:0
            }
        },
        created(){
            this.numberUsers();
            this.numberEquipments();
            this.numberApReservation();
        },
        components:{
            card
        },
        methods:{
            numberUsers(){
                axios
                    .get("api/users/")
                    .then(({ data }) => (this.users=Object.keys(data.data).length))
            },
            numberEquipments(){
                axios
                    .get("api/products/")
                    .then(({ data }) => (this.equipments=Object.keys(data.data).length))
            },
             numberApReservation(){
                axios
                    .get('api/reservations/findReservations',{
                        params: {
                            delivered: 0
                        }
                    })
                    .then(function (res){
                    console.log(res)
                })
            }
        }
    }
</script>
