<template>
    <form @submit.prevent="mode ? updateData() : createNew()">
        <div class="form-group">
            <input type="file" @change="insertImage" name="image" placeholder="Imagem"
                   class="form-input">
            <has-error :form="form" field="image"></has-error>
        </div>

        <div class="form-group">
            <input v-model="form.name" type="text" name="name" placeholder="Nome"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
            <has-error :form="form" field="name"></has-error>
        </div>

        <div class="form-group">
            <input v-model="form.description" type="text" name="name" placeholder="Descrição"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
            <has-error :form="form" field="description"></has-error>
        </div>

        <div class="form-group">
            <input v-model="form.serial_number" type="text" name="serial_number" placeholder="Número Série"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('serial_number') }">
            <has-error :form="form" field="serial_number"></has-error>
        </div>

        <div class="form-group row d-flex justify-content-between mr-1">
            <label for="category" class="col-4 align-middle mt-1">Escolher Categoria: </label>
            <select class="form-control col-7" id="category" name="category_id" v-model="form.category_id" :class="{ 'is-invalid': form.errors.has('category_id') }">
                <option name="category_id" v-for="category in categories" v-bind:value="category.id">
                    {{category.name}}
                </option>
            </select>
            <has-error :form="form" field="category_id" class="ml-3"></has-error>
        </div>

        <div class="form-group row d-flex justify-content-between mr-1">
            <label for="entity" class="col-4 align-middle mt-1">Escolher Entidade: </label>
            <select class="form-control col-7" id="entity" name="entity_id" v-model="form.entity_id" :class="{ 'is-invalid': form.errors.has('entity_id') }">
                <option name="entity_id" v-for="entity in entities" v-bind:value="entity.id">
                    {{entity.name}}
                </option>
            </select>
            <has-error :form="form" field="entity_id"></has-error>
        </div>

        <div class="form-group row d-flex justify-content-between mr-1">
            <label for="warehouse" class="col-4 align-middle mt-1">Escolher Armazém: </label>
            <select class="form-control col-7" id="warehouse" name="warehouse_id" v-model="form.warehouse_id" :class="{ 'is-invalid': form.errors.has('warehouse_id') }">
                <option name="warehouse_id" v-for="warehouse in warehouses" v-bind:value="warehouse.id">
                    {{warehouse.name}}
                </option>
            </select>
            <has-error :form="form" field="warehouse_id" class="ml-3"></has-error>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            <button v-show="!editMode" type="submit" class="btn btn-primary">Criar</button>
            <button v-show="editMode" type="submit" class="btn btn-primary">Atualizar</button>
        </div>
    </form>
</template>

<script>
import {createMixin} from "../../mixins/createMixin";
import {updateMixin} from "../../mixins/updateMixin";

export default {
    props:{
        editForm: Object,
        editMode: Boolean,
    },
    mounted() {
        this.form=this.editForm;
        this.mode=this.editMode;
        this.loadCategories();
        this.loadEntities();
    },
    data () {
        return {
            link:'products',
            mode:this.mode,
            products: {},
            categories: {},
            entities: {},
            warehouses: {},
            form: new Form({
                image:'',
                name: '',
                description: '',
                serial_number:'',
                category_id: '',
                entity_id: '',
                warehouse_id:''
            })
        }
    },
    created(){

    },
    mixins:[createMixin, updateMixin],
    watch:{
        'form.entity_id':function (value){
            axios
                .get("api/loadWarehousesSection/?entity_id="+this.form.entity_id)
                .then( data  =>
                    (this.warehouses = data.data)
                )},
    },
    methods:{
        loadCategories(){
            axios
                .get("api/categories/")
                .then(({ data }) => (this.categories = data.data))
            ;
        },
        loadEntities() {
            axios
                .get("api/entities/")
                .then(({data}) => (this.entities = data.data))
            ;
        },
        insertImage(e){
            let file= e.target.files[0];
            //console.log(file);
            let reader= new FileReader();

            if(file['size'] < 211117755){
                reader.onloadend = (file) => {
                    //console.log('RESULT',reader.result)
                    this.form.image = reader.result;
                }
                reader.readAsDataURL(file);
            }else{
                swal({
                    type: 'error',
                    title: 'Ooops...',
                    text: 'Imagem inválida'
                })
            }

        }
    }
}
</script>
