<template>
    <div class="col-12 px-3 py-1" :class="size">
        <div class="small-box" :class="background">
            <div class="inner row p-4 p-lg-5">
                <h1 class="col-12">{{ number }}</h1>
                <h4 class="col-12">{{text}}</h4>
            </div>
            <a :href="rota" class="small-box-footer">Mais info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</template>
<script>
export default{

    props:{
        background: String,
        size: String,
        text: String,
        rota: String,
        number: Number,
    },
}
</script>
