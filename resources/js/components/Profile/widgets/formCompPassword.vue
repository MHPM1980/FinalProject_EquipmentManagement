<template>
    <form>
        <div class="form-group">
            <label for="inputPasswordNew">Nova Password:</label>
            <input type="password" class="form-control"
                   id="inputPasswordNew" placeholder="Nova Password">
        </div>
        <div class="form-group">
            <label for="inputPasswordNew2">Confirmar Password:</label>
            <input type="password" class="form-control"
                   id="inputPasswordNew2" placeholder="Confirmar Nova Password">
        </div>
        <div class="modal-footer pb-0">
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </div>
    </form>
</template>

<script>
export default {
    data() {
        return {}
    },
    components: {},

}
</script>
