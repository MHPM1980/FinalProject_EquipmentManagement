<template>
    <form @submit.prevent="mode ? updateData() : createNew()">

        <div class="form-group row d-flex justify-content-between mr-1">
            <label for="permission" class="col-4 align-middle mt-1">Escolher Permissão: </label>
            <select class="form-control col-7" id="permission" name="role_id"  v-model="form.role_id" :class="{ 'is-invalid': form.errors.has('permissão') }">
                <option name="role_id"  v-for="role in roles" v-bind:value="role.id">
                    {{role.name}}
                </option>
            </select>
            <has-error :form="form" field="role_id" class="ml-3"></has-error>
        </div>
        <div class="form-group row d-flex justify-content-between mr-1">
            <label for="centroCusto" class="col-4 align-middle mt-1">Centro de Custo: </label>
            <select class="form-control col-7" id="centroCusto" name="cost_id" v-model="form.cost_id" :class="{ 'is-invalid': form.errors.has('centro custo') }">
                <option name="cost_id" v-for="cost in costs" v-bind:value="cost.id">
                    {{cost.description}}
                </option>
            </select>
            <has-error :form="form" field="cost_id" class="ml-3"></has-error>
        </div>

        <div class="form-group">
            <input v-model="form.name" type="text" name="name" placeholder="Nome"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('nome') }">
            <has-error :form="form" field="name"></has-error>
        </div>

        <div class="form-group">
            <input v-model="form.email" type="email" name="email" placeholder="Email"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
            <has-error :form="form" field="email"></has-error>
        </div>

        <div class="form-group">
            <input v-model="form.phone_number" maxlength="9" type="text" name="phone_number" placeholder="Contacto"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('contacto') }">
            <has-error :form="form" field="phone_number"></has-error>
        </div>

        <div class="form-group">
            <input v-model="form.password" type="password" name="password" placeholder="Password"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
            <has-error :form="form" field="password"></has-error>
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
            roles: {},
            costs:{},
            link:'users',
            mode:this.mode,
            form: new Form({
                name: '',
                role_id: '',
                cost_id:'',
                phone_number: '',
                email: '',
                password: ''
            })
        }
    },
    mixins:[createMixin,updateMixin],
    created(){
        this.loadRoles();
        this.loadCosts();
    },

    methods:{
        loadRoles(){
            axios
                .get("api/roles/")
                .then(({ data }) => (this.roles = data.data))
            ;
        },
        loadCosts(){
            axios
                .get("api/costs/")
                .then(({ data }) => (this.costs = data.data))
            ;
        },
    }
}
</script>
