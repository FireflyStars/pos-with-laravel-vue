<template>
<svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="side-icons" @click="selectedIcon">
    <rect width="35" height="35" rx="8" :fill="[isActive ? colorIconSelected : colorIconDefault ]"  />
  <image :href="imageurl" height="32" width="32"/>
   <path d="M10 11H6" stroke="white" stroke-linecap="round"/>
</svg>
</template>

<script>
import {ref} from 'vue';
export default {
     name: "Icon",
    props: ["imageurl"],
    setup(props) {
 let colorIconDefault=ref("#FFFFFF");
let colorIconSelected=ref("#FFA500");

 let isActive=ref(false);
 function selectedIcon(){
this.isActive = !this.isActive;
console.log(isActive.value);
 }
 return {
    colorIconDefault,selectedIcon,colorIconSelected,isActive
 }
}
}
</script>

<style>
.side-icons:first-child{
    margin-top:114px;

}
.side-icons{
    margin-bottom: 32px;
    cursor: pointer !important

}
.isActive{
fill:#FFA500;
}
</style>

