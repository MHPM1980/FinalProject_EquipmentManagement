import moment from "moment/moment";

export const createReservationMixin={
    data(){
        return {

        }
    },
    methods:{
        makeReservation(){
            this.$Progress.start()
            this.form.post(`api/reservations`)
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
        picker(){
            this.form.product_id = this.form.id
            this.form.user_id = this.profile.id
            this.form.registry_date = moment().format('YYYY-MM-DD')
            this.form.start_date = moment(this.range.start).format('YYYY-MM-DD')
            this.form.end_date = moment(this.range.end).format('YYYY-MM-DD')
        },
    }
}
