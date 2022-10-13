<template>
    <div class="container pt-3">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">Detalhes de Equipamento</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-6 text-center">
                            <img class="" :src="'img/products/'+ form.image" alt="Product Image"
                                 style="width: 320px; height: 320px; object-fit: contain">
                        </div>
                        <div class="col-12 col-lg-6 justify-content-center">
                            <div class="mt-4">
                                <form class="align-middle">
                                    <label class="col-4 col-xl-3 pb-lg-3 text-lg-right" for="EquipmentName">Nome:</label>
                                    <input class="col-7 col-xl-8" id="EquipmentName" type="text" v-model="form.name" disabled>

                                    <label class="col-4 col-xl-3 pb-lg-3 text-lg-right" for="EquipmentDescription">Descrição:</label>
                                    <input class="col-7 col-xl-8" id="EquipmentDescription" type="text" v-model="form.description" disabled>

                                    <label class="col-4 col-xl-3 pb-lg-3 text-lg-right" for="EquipmentSerialNumber">Nº de Série:</label>
                                    <input class="col-7 col-xl-8" id="EquipmentSerialNumber" type="text" v-model="form.serial_number" disabled>

                                    <label class="col-4 col-xl-3 pb-lg-3 text-lg-right" for="EquipmentCategory">Categoria:</label>
                                    <input class="col-7 col-xl-8" id="EquipmentCategory" type="text" v-model="form.category.name" disabled>

                                    <label class="col-4 col-xl-3 pb-lg-3 text-lg-right" for="EquipmentEntity">Entidade:</label>
                                    <input class="col-7 col-xl-8" id="EquipmentEntity" type="text" v-model="form.warehouse.entity_id" disabled>

                                    <label class="col-4 col-xl-3 pb-lg-3 text-lg-right" for="EquipmentWarehouse">Armazém:</label>
                                    <input class="col-7 col-xl-8" id="EquipmentWarehouse" type="text" v-model="form.warehouse.name" disabled>
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <h5>Selecionar dados para reserva</h5>
                    <form  @submit.prevent="makeReservation">
                        <div class="form-group">
                            <select class="form-control" name="entity_id" v-model="form.entity_id" :class="{ 'is-invalid': form.errors.has('entity_id') }">
                                <option disabled value="">Escolha a entidade destino</option>
                                <option name="entity_id" v-for="entity in entities" v-bind:value="entity.id">
                                    {{entity.name}}
                                </option>
                            </select>
                            <has-error :form="form" field="entity_id"></has-error>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="warehouse_id" v-model="form.warehouse_id" :class="{ 'is-invalid': form.errors.has('warehouse_id') }">
                                <option disabled value="">Escolha o armazém destino</option>
                                <option name="warehouse_id" v-for="warehouse in warehouses" v-bind:value="warehouse.id">
                                    {{warehouse.name}}
                                </option>
                            </select>
                            <has-error :form="form" field="entity_id"></has-error>
                        </div>
                        <div class="text-center" style="width: 100%; height: 330px;">
                            <v-date-picker v-model="range" :disabled-dates="disabledDays" :min-date='new Date()' is-range is-expanded/>
                        </div>
                        <div class="text-right pt-3">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                            <button class="btn btn-primary" type="submit" @click="picker">Reservar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment/moment";
import {createReservationMixin} from "../mixins/createReservationMixin";
let m= moment();

    export default {
        props:{
            editForm: Object,
            editReservations:Array,
        },
        mounted() {
            this.form=this.editForm;
        },
        data () {
            return {
                categories: {},
                warehouses: {},
                entities:{},
                profile: {},
                disabledDays:[],
                range: {
                    start: null,
                    end: null
                },
                form: new Form({
                    id:'',
                    image:'',
                    name: '',
                    description: '',
                    serial_number:'',
                    entity_id:'',
                    warehouse_id:'',
                    product_id: '',
                    user_id:'',
                    registry_date:'',
                    start_date:'',
                    end_date:'',
                    category: {},
                    warehouse: {},
                }),
            }
        },
        mixins:[createReservationMixin],
        watch:{
            editReservations :function (){
                this.loadReservations();
            },
            'form.entity_id':function (value){
                axios
                    .get("api/loadWarehousesSection/?entity_id="+this.form.entity_id)
                    .then( data  =>
                        (this.warehouses = data.data)
                    )},
        },
        created(){
            this.loadEntities();
            axios.get("api/profile")
                .then(({ data }) => (this.profile = data));
        },
        methods:{
            loadReservations(){
                this.disabledDays=this.editReservations;
            },
            loadEntities(){
                axios
                    .get("api/entities/")
                    .then(({ data }) => (this.entities = data.data))
                ;
            },
            hideModal(){
                $('#addNew').modal('hide');
                this.disabledDays=[]
            }
        }
    }
</script>

