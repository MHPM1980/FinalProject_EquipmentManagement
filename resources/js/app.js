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
        component: require('./components/Dashboard.vue').default},
    { path: '/profile',
        component: require('./components/Profile.vue').default },
    { path: '/users',
        component: require('./components/Users/Users.vue').default },
]

const router = new VueRouter({
    mode:'history',
    routes
})

//Uppercase the first letter, how to use -> ( text | upText )
Vue.filter('upText',function (text){
    return text.charAt(0).toUpperCase()+text.slice(1);
})

// Format date to (16/08/2022)
Vue.filter('myDate',function(date){
    return moment(date).format('L');
})

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
    router
});
