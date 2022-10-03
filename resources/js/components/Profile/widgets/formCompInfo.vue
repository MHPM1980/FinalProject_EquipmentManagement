<template>
    <form>
        <div class="form-group">
            <label for="Nome">Nome: </label>
            <input id="Nome" v-model="form.name" type="text" name="name" placeholder="Nome"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('nome') }">
            <has-error :form="form" field="name"></has-error>
        </div>
        <div class="form-group">
            <label for="Contacto">Contacto:</label>
            <input id="Contacto" v-model="form.phone_number" type="text" name="phone_number" placeholder="Contacto"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('contacto') }">
            <has-error :form="form" field="phone_number"></has-error>
        </div>

        <div class="form-group">
            <label for="Email">Email:</label>
            <input id="Email" v-model="form.email" type="email" name="email" placeholder="Email"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
            <has-error :form="form" field="email"></has-error>
        </div>
        <div class="modal-footer pb-0">
        <button type="submit" class="btn btn-primary" @click.prevent="updateInfo">
            Atualizar
        </button>
        </div>
    </form>
</template>

<script>
import {updateProfileMixin} from "../../mixins/updateProfileMixin";

export default {
    props:{
        editForm: Object,
    },
    mixins:[updateProfileMixin],
    mounted() {
        this.form=this.editForm;
    },
    data(){
        return{
            form: new Form({
                name: '',
                phone_number: '',
                email: '',
            }),
        }
    },
    components: {

    },

}
</script>
