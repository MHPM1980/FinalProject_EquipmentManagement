<template>
    <form @submit.prevent="mode ? updateData() : createNew()">
        <div class="form-group">
            <input v-model="form.name" type="text" name="name" placeholder="Nome"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
            <has-error :form="form" field="name"></has-error>
        </div>

        <div class="form-group">
            <select class="form-control" name="entity_id" v-model="form.entity_id" :class="{ 'is-invalid': form.errors.has('entity_id') }">
                <option disabled value="">Escolha a entidade</option>
                <option name="entity_id" v-for="entity in entities" v-bind:value="entity.id">
                    {{entity.name}}
                </option>
            </select>
            <has-error :form="form" field="entity_id"></has-error>
        </div>

        <div class="form-group">
            <input v-model="form.description" type="text" name="name" placeholder="Descrição"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
            <has-error :form="form" field="description"></has-error>
        </div>

        <div class="form-group">
            <input v-model="form.address" type="text" name="address" placeholder="Morada"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
            <has-error :form="form" field="address"></has-error>
        </div>

        <div class="form-group">
            <input v-model="form.phone_number" type="text" name="phone_number" placeholder="Contacto"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('phone_number') }">
            <has-error :form="form" field="phone_number"></has-error>
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
            entities: {},
            link:'warehouses',
            mode:this.mode,
            form: new Form({
                name: '',
                entity_id: '',
                description: '',
                address:'',
                phone_number: '',
            })
        }
    },
    created(){
        this.loadEntities();
    },
    mixins:[createMixin, updateMixin],
    methods:{
        loadEntities(){
            axios
                .get("api/entities/")
                .then(({ data }) => (this.entities = data.data))
            ;
        },
    }
}
</script>
