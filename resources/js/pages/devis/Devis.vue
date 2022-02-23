
<template>
    <router-view v-slot="{ Component }">
      
            <div class="container-fluid h-100 bg-color">
                <main-header />

                <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap" style="z-index:100" >
                    
                    <side-bar />
            <transition enter-active-class="animate__animated animate__fadeIn" >
                    <div class="col main-view container" v-if="showcontainer">
                            <page-title icon="edit" name="DEVIS" class="almarai_extrabold_normal_normal"/>

            <div class="row m-0 ml-5 mr-5">
                        <div class="col">
                            <tab-pane :tabs="{first:'First tab',second:'Second tab',third:'Third tab'}" class="almarai_700_normal">
                                <template v-slot:first>
                                    1st
                                </template>
                                <template v-slot:second>
                                    2nd
                                </template>
                               <template v-slot:third>
                                    3rd
                                </template>
                            </tab-pane>
                        </div>
                         
            </div>
            
                        <component :is="Component" />

                    </div>
            </transition>
                </div>
            </div>
 
    </router-view>
</template>

<script>

import MainHeader from '../../components/layout/MainHeader.vue';
import SideBar from '../../components/layout/SideBar.vue';
import { ref, onMounted, nextTick } from 'vue';

export default {

    name: "Devis",

    components: {
      MainHeader,
      SideBar,
    },

    setup() {

        const showcontainer = ref(false)

        onMounted(() => {
            nextTick(() => {
                showcontainer.value=true
            })

        })

        return {
            showcontainer
        }

  }

}
</script>

<style lang="scss" scoped>
.lcdt-logo {
    padding-left: 0
}

</style>
