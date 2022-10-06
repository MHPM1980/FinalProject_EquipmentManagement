<template>
    <div class="text-center pt-5 align-middle">
        <div class="row">
            <card background="bg-info" size="col-md-6" text="Total de Utilizadores" rota="/users"></card>
            <card background="bg-secondary" size="col-md-6" text="Total de equipamentos" rota="/equipments"></card>
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

            }
        },
        components:{
            card
        }
    }
</script>
