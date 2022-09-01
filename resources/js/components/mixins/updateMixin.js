export const updateMixin={
    data(){
        return {
            link: 'link'
        }
    },
    methods:{
        updateData(){
            this.$Progress.start()
            this.form.put(`api/${this.link}/`+this.form.id)
                .then(()=>{
                    $('#addNew').modal('hide');
                    Swal.fire(
                        'Atualizado!',
                        'O registo foi Atualizado.',
                        'success'
                    )
                    this.$Progress.finish();
                    //custom Event to reload DOM
                    Fire.$emit('AfterCreate');
                })
                .catch(()=>{
                    this.$Progress.fail()
                    Swal.fire("Failed!","There was something wrong.","warning");
                })
        },
    }
}
