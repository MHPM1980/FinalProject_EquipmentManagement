<template>
    <form @submit.prevent="createRole">
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

export default {
    data () {
        return {

            form: new Form({
                name: '',
            })
        }
    },
    created(){

    },
    methods:{
        createRole(){
            this.$Progress.start()
            this.form.post('api/roles')
                .then(()=>{
                    //costum Event to reload DOM
                    Fire.$emit('AfterCreate');
                    //Success toast
                    $('#addNew').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'Permissão criada com sucesso'
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
