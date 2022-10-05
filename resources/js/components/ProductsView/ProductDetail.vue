<template>
    <div class="container pt-3">
        <div class="row justify-content-center">
            <div class="card">
                <div class="card-header">Detalhes de Equipamento</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <img class="offset-md-3" :src="'img/products/'+ form.image" alt="Product Image"
                                 style="width: 350px; height: 350px; object-fit: contain">
                        </div>
                        <div class="col-12 col-lg-6 justify-content-center">
                            <div>
                                <form>

                                    <label class="col-3 text-right pb-3" for="EquipmentName">Nome:</label>
                                    <input class="col-8" id="EquipmentName" type="text" v-model="form.name" disabled>

                                    <label class="col-3 text-right pb-3" for="EquipmentDescription">Descrição:</label>
                                    <input class="col-8" id="EquipmentDescription" type="text" v-model="form.description" disabled>

                                    <label class="col-3 text-right pb-3" for="EquipmentSerialNumber">Nº de Série:</label>
                                    <input class="col-8" id="EquipmentSerialNumber" type="text" v-model="form.serial_number" disabled>

                                    <label class="col-3 text-right pb-3" for="EquipmentCategory">Categoria:</label>
                                    <input class="col-8" id="EquipmentCategory" type="text" v-model="form.category.name" disabled>

                                    <label class="col-3 text-right pb-3" for="EquipmentEntity">Entidade:</label>
                                    <input class="col-8" id="EquipmentEntity" type="text" v-model="form.warehouse.entity_id" disabled>

                                    <label class="col-3 text-right pb-3" for="EquipmentWarehouse">Armazém:</label>
                                    <input class="col-8" id="EquipmentWarehouse" type="text" v-model="form.warehouse.name" disabled>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="text-center" style="width: 100%; height: 330px; border: solid black 1px;">
                        <v-date-picker v-model="range" is-range is-expanded/>
                    </div>
                    <div class="text-right pt-3">
                        <button class="btn btn-danger" @click="hideModal">Fechar</button>
                        <button class="btn btn-primary" @click="$router.push('reservations')">Reservar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from "moment/moment";
let m= moment();

    export default {
        props:{
            editForm: Object,
        },
        mounted() {
            this.form=this.editForm;
        },
        data () {
            return {
                categories: {},
                warehouses: {},
                entities:{},
                range: {
                    start: new Date(),
                    end: new Date()
                },
                form: new Form({
                    image:'',
                    name: '',
                    description: '',
                    serial_number:'',
                    category: {},
                    warehouse: {},
                })
            }
        },
        created(){
            this.loadWarehouses();
            this.loadEntities()
        },

        methods:{
            loadWarehouses(){
                axios
                    .get("api/warehouses/")
                    .then(({ data }) => (this.warehouses = data.data))
                ;
            },
            loadEntities(){
                axios
                    .get("api/entities/")
                    .then(({ data }) => (this.entities = data.data))
                ;
            },
            hideModal(){
                $('#addNew').modal('hide');
                console.log(moment(this.range.start).format('DD/MM/YYYY'))
                console.log(moment(this.range.end).format('DD/MM/YYYY'))
            }
        }
    }
</script>

