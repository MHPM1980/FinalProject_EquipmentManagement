<template>
    <div class="container">
        <div class="row justify-content-center mt-3">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Definições de Perfil</div>

                    <div class="card-body">
                        <br>
                        <div class="container p-0">
                            <div class="row">
                                <div class="col-md-5 col-xl-4">

                                    <div class="card profile-card">
                                        <div class="card-header profile-header">
                                            <h5 class="card-title mb-0">Opções</h5>
                                        </div>
                                        <div class="list-group list-group-flush" role="tablist">
                                            <a class="list-group-item list-group-item-action active" data-toggle="list"
                                               href="#account" role="tab">
                                                Informações Pessoais
                                            </a>
                                            <a class="list-group-item list-group-item-action" data-toggle="list"
                                               href="#password" role="tab">
                                                Password
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7 col-xl-8">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="account" role="tabpanel">
                                            <div class="card profile-card">
                                                <div class="card-header profile-header">
                                                    <h5 class="card-title mb-0">Informações Pessoais</h5>
                                                </div>
                                                <div class="card-body">
                                                    <form-comp-info :edit-form="form"></form-comp-info>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="password" role="tabpanel">
                                            <div class="card profile-card">
                                                <div class="card-header profile-header">
                                                    <h5 class="card-title mb-0">Password</h5>
                                                </div>
                                                <div class="card-body">
                                                    <form-comp-password :edit-form="form"></form-comp-password>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
import formCompInfo from "./widgets/formCompInfo";
import formCompPassword from "./widgets/formCompPassword";

export default {
    data(){
      return {
          form: new Form({
              id:'',
              name: '',
              cost_id:'',
              phone_number: '',
              email: '',
              password: ''
          }),
      }
    },
    components: {
        formCompInfo,
        formCompPassword
    },

    mounted() {

    },
    created() {
        axios.get("api/profile")
            .then(({ data }) => (this.form.fill(data)));
    }
}
</script>
