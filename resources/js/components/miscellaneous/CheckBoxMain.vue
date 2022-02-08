<template>
<div class="main">
    <input type="text" class="select-item" :placeholder="selectedValue" v-model="selectedValue">
 <div  v-for="items in myobj" :key="items.id" class="div-for">
     <check-box
                    :id="items.id"
                     v-model:checked_checkbox.sync="items.check"
                    :name="items.value"
                    @click="getSelectedValue(items)"
                    >
                        {{items.value}}
                        </check-box>

  </div>
  </div>
</template>

<script>
import { ref} from "@vue/reactivity";

import CheckBox from './CheckBox.vue'
export default {
name: "CheckBoxMain",

  components:{CheckBox},
   setup(){
        let selectedValue=ref('');
      const myobj = ref([
         { id:1 ,value:'Perdu',check:false},
             { id:2,value:'Gagne',check:false},
                 { id:3,value:'Abondonne',check:false},
                     { id:4,value:'AttenteClient',check:false}
      ]);


        const getSelectedValue = (item) => {
         selectedValue.value="";
         myobj.value.forEach((element) => {

             if(element.check==true){
            // console.log(element.check);
            selectedValue.value+=element.value+',';

             }


        });
        //  console.log(selectedValue.value);
        }
          return {
                 myobj, getSelectedValue,selectedValue
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
.select-item{
display: inline-flex;
flex-direction: row;
}
</style>
