<template>
    <div class="text-center pt-5 align-middle">
        <div class="row">
            <card background="bg-secondary" size="col-md-6" text="Equipamentos" :number=equipments rota="/equipmentsView"></card>
            <card background="bg-success" size="col-md-6" text="Reservas aprovadas" :number=approved rota="/reservations"></card>
            <card background="bg-warning" size="col-md-6" text="Reservas pendentes" :number=pendings rota="/reservations"></card>
            <card background="bg-danger" size="col-md-6" text="Equipamentos por devolver" :number=returned rota="/reservations"></card>
        </div>
    </div>
</template>

<script>
import card from "./widgets/card";
export default {
    data(){
        return{
            equipments:0,
            approved:0,
            pendings:0,
            returned:0
        }
    },
    created(){
        this.numberEquipments();
        this.numberApReservation();
        this.numberPendReservation();
        this.numberReturReservation();
    },
    components:{
        card
    },
    methods:{
        numberEquipments(){
            axios
                .get("api/products/")
                .then(({ data }) => (this.equipments=Object.keys(data.data).length))
        },
        numberApReservation(){
            axios
                .get('api/findReservations/?approved=1')
                .then(({ data }) => (this.approved=data))
        },
        numberPendReservation(){
            axios
                .get('api/findPendReservations/?approved=')
                .then(({ data }) => (this.pendings=data))
        },
        numberReturReservation(){
            axios
                .get('api/findReturReservations/?returned=0')
                .then(({ data }) => (this.returned=data))
        },
    }
}
</script>
