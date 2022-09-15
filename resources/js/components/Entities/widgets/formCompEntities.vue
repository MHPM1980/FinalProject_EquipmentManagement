<template>
    <form @submit.prevent="mode ? updateData() : createNew()">
        <div class="form-group">
            <input v-model="form.name" type="text" name="name" placeholder="Nome"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
            <has-error :form="form" field="name"></has-error>
        </div>

        <div class="form-group">
            <input v-model="form.address" type="address" name="address" placeholder="Morada"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('address') }">
            <has-error :form="form" field="address"></has-error>
        </div>

        <div class="form-group">
            <input v-model="form.phone_number" maxlength="9" type="text" name="phone_number" placeholder="Contacto"
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
            link:'entities',
            mode:this.mode,
            form: new Form({
                name: '',
                address: '',
                phone_number: '',
            })
        }
    },
    mixins:[createMixin, updateMixin],
}
</script>
