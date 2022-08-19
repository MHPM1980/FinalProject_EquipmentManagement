<template>
    <form @submit.prevent="createCategory">
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

export default {
    data () {
        return {

            form: new Form({
                name: '',
                description: '',
            })
        }
    },
    created(){

    },
    methods:{
        createCategory(){
            this.$Progress.start()
            this.form.post('api/categories')
                .then(()=>{
                    //costum Event to reload DOM
                    Fire.$emit('AfterCreate');
                    //Success toast
                    $('#addNew').modal('hide');
                    toast.fire({
                        icon: 'success',
                        title: 'Categoria criada com sucesso'
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
