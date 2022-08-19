export const deleteMixin={
    data(){
        return {
            link: 'link'
        }
    },
    methods:{
        deleteItem(id){
            Swal.fire({
                title: 'Confirmar',
                text: "A ação não pode ser revertida!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, apagar!'
            }).then((result) => {
                if (result.isConfirmed){
                    //Send request to the server
                    this.form.delete(`api/${this.link}/`+id)
                        .then(()=>{
                            Swal.fire(
                                'Apagado!',
                                'O registo foi apagado.',
                                'success'
                            )
                            Fire.$emit('AfterCreate');
                    })
                        .catch(()=>{
                            Swal.fire("Failed!","There was something wrong.","warning");
                    });
                }
            })
        }
    }
}
