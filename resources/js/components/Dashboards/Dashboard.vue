<template>
    <div class="container">
        <div class="row text-center d-flex align-items-center justify-content-center">
            <div class="col-md-12 pt-5">
                <div>
                    <h1 class="text-light welcome-msg">Bem-Vindo, {{this.profile.name}} !</h1>
                </div>
                <div v-if="$gate.isAdmin()">
                    <admin-dashboard></admin-dashboard>
                </div>
                <div v-if="$gate.isGestor()">
                    <gestor-dashboard></gestor-dashboard>
                </div>
                <div v-if="$gate.isFormador()">
                    <formador-dashboard ></formador-dashboard>
                </div>
                <div v-if="$gate.isFormando()">
                    <products-view></products-view>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import AdminDashboard from "./AdminDashboard";
    import GestorDashboard from "./GestorDashboard";
    import FormadorDashboard from "./FormadorDashboard";
    import ProductsView from "../ProductsView/ProductsView";

    export default {
        components: {ProductsView,FormadorDashboard, GestorDashboard, AdminDashboard},
        mounted() {
            axios.get("api/profile")
                .then(({ data }) => (this.profile = data));
        },
        data(){
            return{
                profile: {}
            }
        }
    }
</script>
