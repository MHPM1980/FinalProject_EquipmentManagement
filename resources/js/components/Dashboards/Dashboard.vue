<template>
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-md-12">
                <div v-if="$gate.isAdmin()">
                    <admin-dashboard></admin-dashboard>
                </div>
                <div v-if="$gate.isGestor()">
                    <gestor-dashboard></gestor-dashboard>
                </div>
                <div v-if="$gate.isFormador()">
                    <formador-dashboard></formador-dashboard>
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
            console.log('Component mounted.')
        }
    }
</script>
