export const createMixin={
    data(){
        return {
            link: 'link'
        }
    },
    methods:{
        createNew(){
            this.$Progress.start()
            this.form.post(`api/${this.link}`)
                .then(()=>{
                    //custom Event to reload DOM
                    Fire.$emit('AfterCreate');
                    //Clear form
                    this.form.reset();
                    $('#addNew').modal('hide');
                    //Success toast
                    toast.fire({
                        icon: 'success',
                        title: 'Registo criado com sucesso!'
                    })
                    this.$Progress.finish();

                })
                .catch(()=>{
                    this.$Progress.fail()
                })
        },
    }
}
