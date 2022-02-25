<template>
    <input class="mulish_400_normal" type="search" placeholder="Rechercher...">
</template>

<script>
    import {ref,watch} from 'vue';
    export default {
        name: "Search",
        props:[],
        setup(){

        }
    }
</script>

<style scoped>
input[type="search"]{
    float: left;
    margin-right: 19px;
    border:1px solid #FFF;
    border-radius: 10px;
    background: transparent;
    margin-top: 18px;
    height: 29px;
    font-size: 12px;
    color:#FFF;
    padding-left:12px;
    width: 217px;
    letter-spacing: 0.2px;
}

input[type="search"]{

    background: url("../../images/search-icon.svg") no-repeat right 14px center ;
}
</style>
