
<template>
    <router-view v-slot="{ Component }">
    <transition
            enter-active-class="animate__animated animate__fadeIn"
    >
        <div class="container-fluid h-100 bg-color" v-if="showcontainer">
            <main-header></main-header>
            <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap" style="z-index:100" >
            <side-bar></side-bar>
                <div class="col main-view p-0">
              <h1>Welcome to lcdt. vuejs 3 installed.</h1>



                        <transition   enter-active-class="animate__animated animate__fadeIn"
                                      leave-active-class="animate__animated animate__fadeOut">
                            <component :is="Component" />
                        </transition>


                </div>
            </div>
        </div>
    </transition>
    </router-view>
</template>

<script>
import MainHeader from './layout/MainHeader.vue';
import SideBar from './layout/SideBar.vue';
    import {ref,onMounted,computed,nextTick} from 'vue';
export default {
  name: "Test",
  components:{MainHeader,SideBar},
  setup(){
const  showcontainer=ref(false);
    onMounted(()=>{
                nextTick(()=>{
                    showcontainer.value=true;
                });

            });
    return {
        showcontainer
    }
  }
};
</script>

<style lang="scss" scoped></style>