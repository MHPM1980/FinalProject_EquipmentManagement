<template>
    <form>
        <div class="form-group">
            <label for="inputPasswordNew">Nova Password:</label>
            <input v-model="form.password" type="password" class="form-control"
                   id="inputPasswordNew" placeholder="Nova Password" :class="{ 'is-invalid': form.errors.has('password') }">
            <has-error :form="form" field="password"></has-error>
        </div>
        <div class="modal-footer pb-0">
            <button type="submit" class="btn btn-primary" @click.prevent="updateInfo">Atualizar</button>
        </div>
    </form>
</template>

<script>
import {updateProfileMixin} from "../../mixins/updateProfileMixin";

export default {
    props:{
        editForm: Object,
    },
    data() {
        return {
            form: new Form({
                password: ''
            }),
        }
    },
    mounted() {
        this.form=this.editForm;
    },
    mixins:[updateProfileMixin],
    components: {

    },

}
</script>
