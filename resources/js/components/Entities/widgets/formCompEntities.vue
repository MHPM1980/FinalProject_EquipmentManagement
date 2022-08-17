<template>
    <form @submit.prevent="createEntity">
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
            <input v-model="form.phone_number" type="text" name="phone_number" placeholder="Contacto"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('phone_number') }">
            <has-error :form="form" field="phone_number"></has-error>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            <button type="submit" class="btn btn-primary">Criar</button>
        </div>
    </form>
</template>

<script>

export default {
    data () {
        return {
            form: new Form({
                name: '',
                address: '',
                phone_number: '',
            })
        }
    },
    created(){

    },
    methods:{
        createEntity(){
            this.$Progress.start()
            this.form.post('api/entities')
                .then(()=>{
                    //costum Event to reload DOM
                    Fire.$emit('AfterCreate');
                    //Success toast
                    $('#addNew').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'Entidade criada com sucesso'
                    })
                    this.$Progress.finish()
                })
                .catch(()=>{
                    this.$Progress.fail()
                })
        },
    }
}
</script>
