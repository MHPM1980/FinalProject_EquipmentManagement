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
            }),

            Fire.$on('searchEntity',() => {
                let query = this.$parent.search;
                axios
                    .get('api/findEntity?q='+ query)
                    .then(response => {
                        this.entities = response.data
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }),

            Fire.$on('searchProduct',() => {
                let query = this.$parent.search;
                axios
                    .get('api/findProduct?q='+ query)
                    .then(response => {
                        this.products = response.data
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }),

            Fire.$on('searchReservation',() => {
                let query = this.$parent.search;
                axios
                    .get('api/findReservation?q='+ query)
                    .then(response => {
                        console.log(response.data)
                        this.reservations = response.data

                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }),

            Fire.$on('searchRole',() => {
                let query = this.$parent.search;
                axios
                    .get('api/findRole?q='+ query)
                    .then(response => {
                        this.roles = response.data
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            }),

            Fire.$on('searchWarehouse',() => {
                let query = this.$parent.search;
                axios
                    .get('api/findWarehouse?q='+ query)
                    .then(response => {
                        this.warehouses = response.data
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            })

    },
}
