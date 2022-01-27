<template>
<div class="main">
 <div  v-for="items in myobj" :key="items.id" class="div-for">

     <check-box
                    :id="items.id"
                    checked_checkbox="true"
                    :name="items.value"
                    >

                     <!-- <label class="check-val"> -->
                        {{items.value}}
                        </check-box>
                         <!-- </label> -->




<!--
     @checkbox-clicked="updateSelectedList"
!-->
  </div>
  </div>
</template>

<script>
import { ref } from "@vue/reactivity";
//import { useStore } from "vuex";
//import { GET_SELECTED_BOXES, SET_SELECTED_BOXES } from "../../store/types/types";
import CheckBox from './CheckBox.vue'
export default {
name: "CheckBoxMain",
  components:{CheckBox},
   setup(){
        // const store = useStore();
      const myobj = ref([
         { id:1 ,value:'Perdu'},
             { id:2,value:'Gagne'},
                 { id:3,value:'Abondonne'},
                     { id:4,value:'AttenteClient'}
      ]);
          return {
                 myobj,
                 //updateSelectedList: (event) =>store.dispatch(SET_SELECTED_BOXES, event)
        };
    }
}

</script>

<style>
.main {
width: 15%;
float: left;
display: inline;
border-radius: 0px 0px 6px 6px;
background: #C4CFD7;
}
.div-for{
    position:relative;
    display: inline;
}
.check-val {
padding: 0px 0px 5px 2px !important;
font-weight: lighter;
display: inline-flex;
flex-direction: row;
}
</style>
