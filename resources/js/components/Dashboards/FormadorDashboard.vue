<template>
    <div class="text-center pt-5 align-middle">
        <div class="row">
            <formador-card background="bg-secondary" size="col-md-3" text="Total de Equipamentos" :number=equipments rota="/equipmentsView"></formador-card>
            <formador-card background="bg-success" size="col-md-3" text="Reservas aprovadas" :number=approved rota="/reservations"></formador-card>
            <formador-card background="bg-warning" size="col-md-3" text="Reservas pendentes" :number=pendings rota="/reservations"></formador-card>
            <formador-card background="bg-danger" size="col-md-3" text="Equipamentos por devolver" :number=returned rota="/reservations"></formador-card>
        </div>
        <div>
            <v-calendar is-expanded />
        </div>


    </div>
</template>

<script>
import FormadorCard from "./widgets/formadorCard";
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
        FormadorCard
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
