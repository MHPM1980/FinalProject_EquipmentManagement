<template>
    <div class="text-center pt-5 align-middle">
        <div class="row">
            <formador-card background="bg-secondary" size="col-md-3" text="Total de Equipamentos" :number=equipments rota="/equipmentsView"></formador-card>
            <formador-card background="bg-success" size="col-md-3" text="Reservas aprovadas" :number=approved rota="/reservations"></formador-card>
            <formador-card background="bg-warning" size="col-md-3" text="Reservas pendentes" :number=pendings rota="/reservations"></formador-card>
            <formador-card background="bg-danger" size="col-md-3" text="Equipamentos por devolver" :number=returned rota="/reservations"></formador-card>
        </div>
        <div>
            <v-calendar :availableDates="reservations" :attributes='attributes' is-expanded is-dark class="mb-4"/>
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
            returned:0,
            reservations:[],
        }
    },
    created(){
        this.numberEquipments();
        this.numberApReservation();
        this.numberPendReservation();
        this.numberReturReservation();
        this.loadReservations();
    },
    computed:{
        attributes(){
            console.log(this.reservations)
            return this.reservations.map(r => {
                return {
                    highlight: {

                        start: { fillMode: 'outline',color: 'green' },
                        base: { fillMode: 'solid',color: 'green', },
                        end: { fillMode: 'outline',color: 'green', },
                    },
                    dates: r,
                };
            })
        }
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
                .get(`api/findFormReservations/?approved=1`)
                .then(({ data }) => (this.approved=data))
        },
        numberPendReservation(){
            axios
                .get(`api/findFormPendReservations/?approved=`)
                .then(({ data }) => (this.pendings=data))
        },
        numberReturReservation(){
            axios
                .get(`api/findFormReturReservations/?returned=0`)
                .then(({ data }) => (this.returned=data))
        },
        loadReservations(){
            axios
                .get("api/reservations")
                .then(
                    ({ data }) => {
                        this.reservations = data.data.map(r => {
                            console.log(typeof r.start_date)
                            return {"start": r.start_date, "end": r.end_date}
                        });
                    }
                )
        },
    }
}
</script>
