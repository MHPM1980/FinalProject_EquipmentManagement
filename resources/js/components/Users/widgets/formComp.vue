<template>
    <form @submit.prevent="createUser">
        <div class="form-group">
            <input v-model="form.name" type="text" name="name" placeholder="Name"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
            <has-error :form="form" field="name"></has-error>
        </div>

        <div class="form-group">
            <input v-model="form.email" type="email" name="email" placeholder="Email"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
            <has-error :form="form" field="email"></has-error>
        </div>

        <div class="form-group">
            <input v-model="form.phone_number" type="text" name="phone_number" placeholder="Phone Number"
                       class="form-control" :class="{ 'is-invalid': form.errors.has('phone_number') }">
            <has-error :form="form" field="phone_number"></has-error>
        </div>

        <div class="form-group">
            <select class="form-control" name="role_id" v-model="form.role_id" :class="{ 'is-invalid': form.errors.has('role_id') }">
                <option name="role_id"  v-for="role in roles" v-bind:value="role.id">
                    {{role.name}}
                </option>
            </select>
            <has-error :form="form" field="role_id"></has-error>
        </div>
        <div class="form-group">
            <select class="form-control" name="cost_id" v-model="form.cost_id" :class="{ 'is-invalid': form.errors.has('cost_id') }">
                <option name="cost_id" v-for="cost in costs" v-bind:value="cost.id">
                    {{cost.description}}
                </option>
            </select>
            <has-error :form="form" field="cost_id"></has-error>
        </div>
        <div class="form-group">
            <input v-model="form.password" type="password" name="password" placeholder="Password"
                   class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
            <has-error :form="form" field="password"></has-error>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </form>
</template>

<script>

export default {
    data () {
        return {
            roles: {},
            costs:{},
            form: new Form({
                name: '',
                role_id: '',
                cost_id:'',
                phone_number: '',
                email: '',
                password: ''
            })
        }
    },
    created(){
        this.loadRoles();
        this.loadCosts();
    },
    methods:{
        createUser(){
            this.$Progress.start()
            this.form.post('api/users')
            .then(()=>{
                //costum Event to reload DOM
                Fire.$emit('AfterCreate');
                //Success toast
                $('#addNew').modal('hide');
                toast.fire({
                    icon: 'success',
                    title: 'User created successfully'
                })
                this.$Progress.finish()
            })
            .catch(()=>{
                this.$Progress.fail()
            })
        },
        loadRoles(){
            axios
                .get("api/roles/")
                .then(({ data }) => (this.roles = data.data))
            ;
        },
        loadCosts(){
            axios
                .get("api/costs/")
                .then(({ data }) => (this.costs = data.data))
            ;
        },

    }
}
</script>
