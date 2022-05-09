<template>
<item-detail-panel>
<h1>Devis details</h1>
<p> content from slot</p>

</item-detail-panel>
</template>

<script>
   import ItemDetailPanel from '../../components/miscellaneous/ItemListTable/ItemDetailPanel.vue'
    export default {
        name: "DevisDetail",
        components:{ItemDetailPanel},
        setup(){
        
             return {
         
             }
        }
    }
</script>

<style scoped>
</style>