/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import moment from 'moment'
// Vform implementation
import Form from 'vform'
import {
    Button,
    HasError,
    AlertError,
    AlertErrors,
    AlertSuccess
} from 'vform/src/components/bootstrap5'

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);

window.Form=Form;
Vue.component(Button.name, Button)
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)
Vue.component(AlertErrors.name, AlertErrors)
Vue.component(AlertSuccess.name, AlertSuccess)

//Vue
import Vue from 'vue'
//VueRouter implementation
import VueRouter from 'vue-router'
Vue.use(VueRouter)

//Progress bar implementation
import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
    color: 'rgb(143, 255, 199)',
    failedColor: 'red',
    height: '5px'
})

//Sweetalert2 implementation
import Swal from 'sweetalert2'
window.Swal=Swal
const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.toast=Swal

//VueRoutes implementation
let routes = [
    { path: '/dashboard',
        component: require('./components/Dashboards/Dashboard.vue').default},
    { path: '/profile',
        component: require('./components/Profile/Profile.vue').default },
    { path: '/users',
        component: require('./components/Users/Users.vue').default },
    { path: '/entities',
        component: require('./components/Entities/Entities.vue').default },
    { path: '/warehouses',
        component: require('./components/Warehouses/Warehouses.vue').default },
    { path: '/costs',
        component: require('./components/Costs/Costs.vue').default },
    { path: '/roles',
        component: require('./components/Roles/Roles.vue').default },
    { path: '/categories',
        component: require('./components/Categories/Categories.vue').default },
    { path: '/equipments',
        component: require('./components/Products/Products.vue').default },
    { path: '/equipmentsView',
        component: require('./components/ProductsView/ProductsView.vue').default },
    { path: '/developer',
        component: require('./components/Developer.vue').default },
    { path: '/equipmentdetails',
        component: require('./components/ProductsView/ProductDetail.vue').default },

    { path: '/error',
        component: require('./components/Error500.vue').default },
    { path: '/reservations',
        component: require('./components/Reservations/Reservation').default },

]

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);
Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);
Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);
Vue.component(
    'not-found',
    require('./components/NotFound').default
);
Vue.component(
    'pagination',
    require('laravel-vue-pagination')
);



const router = new VueRouter({
    mode:'history',
    routes
})

//Uppercase the first letter, how to use -> ( text | upText )
Vue.filter('upText',function (text){
    return text.charAt(0).toUpperCase()+text.slice(1);
})


window.Fire = new Vue();


// V-Calendar implementation
import VCalendar from 'v-calendar';
Vue.use(VCalendar, {
    //componentPrefix: 'vc',  // Use <vc-calendar /> instead of <v-calendar />
        // ...other defaults
});

//Bootstrap Vue
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
// Import Bootstrap and BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router,
    data:{
        search: ''
    },
    methods:{
        searchit(){
            if(this.$route.path == '/users'){
                Fire.$emit('searchUser');
            } else if(this.$route.path == '/categories'){
                Fire.$emit('searchCategory');
            } else if(this.$route.path == '/costs') {
                Fire.$emit('searchCost');
            } else if(this.$route.path == '/entities') {
                Fire.$emit('searchEntity');
            } else if(this.$route.path == '/equipments') {
                Fire.$emit('searchProduct');
            } else if(this.$route.path == '/equipmentsView') {
                Fire.$emit('searchProduct');
            }
        }
    }
});
