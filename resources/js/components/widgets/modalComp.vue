<template>
    <div class="modal fade" id="addNew" tabindex="-1" aria-labelledby="addNew" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewLabel">{{title}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form-comp></form-comp>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import FormComp from "../Users/widgets/formComp";
    export default {
        components: {
            FormComp
        },
        props:{
            title: String
        }
    }
</script>
