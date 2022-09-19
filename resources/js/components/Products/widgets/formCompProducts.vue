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

        <div class="form-group">
            <select class="form-control" name="category_id" v-model="form.category_id" :class="{ 'is-invalid': form.errors.has('category_id') }">
                <option disabled value="">Escolha a categoria</option>
                <option name="category_id" v-for="category in categories" v-bind:value="category.id">
                    {{category.name}}
                </option>
            </select>
            <has-error :form="form" field="category_id"></has-error>
        </div>

        <div class="form-group">
            <select class="form-control" name="warehouse_id" v-model="form.warehouse_id" :class="{ 'is-invalid': form.errors.has('warehouse_id') }">
                <option disabled value="">Escolha o armazém</option>
                <option name="warehouse_id" v-for="warehouse in warehouses" v-bind:value="warehouse.id">
                    {{warehouse.name}}
                </option>
            </select>
            <has-error :form="form" field="warehouse_id"></has-error>
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
    },
    data () {
        return {
            link:'products',
            mode:this.mode,
            products: {},
            categories: {},
            warehouses: {},
            form: new Form({
                image:'',
                name: '',
                description: '',
                serial_number:'',
                category_id: '',
                warehouse_id:''
            })
        }
    },
    created(){
        this.loadCategories();
        this.loadWarehouses();
    },
    mixins:[createMixin, updateMixin],
    methods:{
        loadCategories(){
            axios
                .get("api/categories/")
                .then(({ data }) => (this.categories = data.data))
            ;
        },
        loadWarehouses(){
            axios
                .get("api/warehouses/")
                .then(({ data }) => (this.warehouses = data.data))
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
