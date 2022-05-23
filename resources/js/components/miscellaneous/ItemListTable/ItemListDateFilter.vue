<template>
   <item-list-date-picker  :col="col" name="from" :disabledFromDate="disabledFromDate" :droppos="droppos" placeHolder="début" @changed="filterdate"></item-list-date-picker>
   <item-list-date-picker  :col="col" name="to" :disabledToDate="disabledToDate" :droppos="droppos" placeHolder="fin" @changed="filterdate"></item-list-date-picker>
</template>

<script>
import ItemListDatePicker from './ItemListDatePicker.vue';
import {ref} from 'vue';

export default {
    name: "ItemListDateFilter",
    components:{
        ItemListDatePicker
    },

    props:{
                name:{
                    type: String,
                    required: true
                },
                col:{
                    type:Object,
                    required:true
                }
    },
    emits: ['onDateFiltered'],
    setup(props,context){
        const droppos=ref({top:"20px",right:'auto',bottom:'auto',left:'0',transformOrigin:'top center'});
        const disabledToDate=ref('');
        const disabledFromDate=ref('');
        const filterdate=(input)=>{
            if(input.name=='from'){
                disabledToDate.value=input.date;
            }
                  if(input.name=='to'){
                disabledFromDate.value=input.date;
            }
            context.emit('onDateFiltered',{name:props.name,col:props.col,date:{'from':disabledToDate.value,'to':disabledFromDate.value}});
        }

        return {
            droppos,
            filterdate,
            disabledToDate,
            disabledFromDate
        }
    }
}
</script>

<style lang="scss" scoped>

</style>