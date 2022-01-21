<template>
    <!-- <button class="filter-reset">
        <div class="text-filter">Reinitialisation</div>
    </button> -->
    <button class="button-filter">
        <div class="text-filter">Filtre</div>

        <div class="rectangle"></div>
        <div class="rectangle2"></div>
        <div class="rectangle3"></div>
    </button>
</template>

<script>
export default {
    setup() {},
};
</script>

<style scoped>
.filter-reset {
    height: 40px;
    width: 116px;
    left: 0px;
    top: 0px;
    margin: 10px 10px 0px 0px;
    /* dark gre */

    border: 1px solid #47454b;
    box-sizing: border-box;
    border-radius: 5px;
}
.button-filter {
    /* Rectangle 423 */
    height: 40px;
    width: 116px;
    left: 0px;
    top: 0px;
    margin: 1% 3% 0% 0%;
    /* dark gre */

    border: 1px solid #47454b;
    box-sizing: border-box;
    border-radius: 5px;
}
.rectangle {
    height: 2.410329818725586px;
    width: 21px;

    /* Rectangle 420 */

    position: relative;
    left: 68.1%;
    right: 13.79%;
    bottom: 35%;

    /* dark grey */

    background: #47454b;
    border-radius: 5px;
}
.rectangle2 {
    height: 2.4103260040283203px;
    width: 13.674415588378906px;

    border-radius: 5px;

    /* Rectangle 420 */

    position: relative;
    left: 71.26%;
    right: 16.95%;
    bottom: 25%;

    /* dark grey */

    background: #47454b;
    border-radius: 5px;
}
.rectangle3 {
    height: 2.4103336334228516px;
    width: 6.3488311767578125px;

    /* Rectangle 422 */

    position: relative;
    left: 74.42%;
    right: 20.11%;
    bottom: 15%;

    /* dark grey */

    background: #47454b;
    border-radius: 5px;
}
.text-filter {
    height: 12px;
    width: 69px;
    left: 12px;
    top: 14px;

    font-family: Almarai;
    font-style: normal;
    font-weight: bold;
    font-size: 14px;
    line-height: 140%;
    /* or 20px */

    display: flex;
    align-items: center;

    /* dark grey */

    color: #47454b;
}
</style>
