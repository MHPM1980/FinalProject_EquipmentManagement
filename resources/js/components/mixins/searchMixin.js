export const searchMixin={
    data(){
        return {

        }
    },
    created(){
        Fire.$on('searchUser',() => {
            let query = this.$parent.search;
            axios
                .get('api/findUser?q='+ query)
                .then(response => {
                    this.users = response.data
                })
                .catch((error) => {
                    console.log(error)
                })
        }),

            Fire.$on('searchCategory',() => {
                let query = this.$parent.search;
                axios
                    .get('api/findCategory?q='+ query)
                    .then(response => {
                        this.categories = response.data
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }),

            Fire.$on('searchCost',() => {
                let query = this.$parent.search;
                axios
                    .get('api/findCost?q='+ query)
                    .then(response => {
                        this.costs = response.data
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            })
    },
}
