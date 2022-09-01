<template>
    <form @submit.prevent="mode ? updateData() : createNew()">
        <div class="form-group">
            <input v-model="form.designation" type="text" name="designation" placeholder="Designação"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('designation') }">
            <has-error :form="form" field="designation"></has-error>
        </div>
        <div class="form-group">
            <input v-model="form.description" type="text" name="description" placeholder="Descrição"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('description') }">
            <has-error :form="form" field="description"></has-error>
        </div>


        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Criar</button>
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
            link:'costs',
            mode:this.mode,
            form: new Form({
                designation: '',
                description: ''
            })
        }
    },
    mixins:[createMixin, updateMixin],
}
</script>
