export const updateProfileMixin={
    data(){
        return {

        }
    },
    methods:{
        updateInfo(){
            this.$Progress.start();
            this.form.put('api/profile')
                .then(()=>{
                    Swal.fire(
                        'Atualizado!',
                        'O perfil foi Atualizado.',
                        'success'
                    )
                    this.$Progress.finish();
                })
                .catch(()=>{
                    this.$Progress.fail()
                    Swal.fire("Erro!","Não é possível atualizar o registo.","warning");
                });
        },
    }
}
