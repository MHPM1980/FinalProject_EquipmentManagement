export const newModalMixin={
    data(){
        return {

        }
    },
    methods:{
        newModal(){
            this.mode=false;
            $('#addNew').modal('show');
            this.form.reset();
        },
    }
}
