<template>
    <form @submit.prevent="createNew">
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

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Criar</button>
        </div>
    </form>
</template>

<script>
import {createMixin} from "../../mixins/createMixin";

export default {
    props:{
        editForm: Object
    },
    mounted() {
        this.form=this.editForm;
    },
    data () {
        return {
            link:'categories',
            form: new Form({
                name: '',
                description: '',
            })
        }
    },
    mixins:[createMixin],
}
</script>
