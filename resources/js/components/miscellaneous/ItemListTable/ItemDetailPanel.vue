<template>
<div class="back-layer"></div> 
<div class="od" :style="{width:width}">
     <i class="icon-close" @click="close"></i>
    <h2>Hello world</h2>
</div>
</template>

<script>
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
   
    export default {
        name: "ItemDetailPanel",
        
    props: { 
        width: {
            required: false,
            type: String,
            default:'684px'
            
        },
        closebtn:{
            required: false,
            type:Boolean,
            default:true
        }
    },
        setup(props){

            const store=useStore();
            const router=useRouter();
                const close=()=>{
                   // store.dispatch(`${ORDERLIST_MODULE}${ORDERLIST_SELECT_CURRENT}`,'');
                   // store.commit(`${ORDERDETAIL_MODULE}${ORDERDETAIL_SET_DETAILS}`,{});
                    router.back();
                }
             return {
                 close,
                 width:props.width,
             }
        }
    }
</script>

<style scoped>

.od{
      
        background: #FFF;
        height: calc(100% - var(--mainlogoheight));
        position: fixed;
        top: var(--mainlogoheight);
        overflow-y: auto;
        right: 0;
        z-index: 10001;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.18);
        padding: 0 20px;
    }
     .icon-close{
        top:24px;
        right: 24px;
    }

    .back-layer {
        background: rgba(224, 224, 224,0.6);
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        z-index: 9999;
    }
</style>