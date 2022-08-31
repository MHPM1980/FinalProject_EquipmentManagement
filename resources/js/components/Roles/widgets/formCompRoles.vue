<template>
    <form @submit.prevent="mode ? updateData() : createNew()">
        <div class="form-group">
            <input v-model="form.name" type="text" name="name" placeholder="Nome"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
            <has-error :form="form" field="name"></has-error>
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
            link:'roles',
            mode:this.mode,
            form: new Form({
                name: '',
            })
        }
    },
    // function that trigger when editmode is changed and update data
    watch:{
        editMode: function (val) {
            this.mode=val
        }
    },
    mixins:[createMixin, updateMixin],
}
</script>
