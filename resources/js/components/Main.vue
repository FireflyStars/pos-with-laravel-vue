
<template>
    <RouterView v-slot="{ Component }">
        <transition
            enter-active-class="animate__animated animate__fadeIn"
        >
            <div class="container-fluid h-100 bg-color" v-if="showcontainer">
                <MainHeader />

                <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap" style="z-index:100" >
                    
                    <SideBar />

                    <div class="col main-view container">

                        <!-- <transition  enter-active-class="animate__animated animate__fadeIn"
                            leave-active-class="animate__animated animate__fadeOut"> -->
                            <component :is="Component" />
                        <!-- </transition> -->

                    </div>

                </div>
            </div>
        </transition>
    </RouterView>
</template>

<script>

import MainHeader from './layout/MainHeader.vue';
import SideBar from './layout/SideBar.vue';
import CheckBoxMain from './miscellaneous/CheckBoxMain';
import { ref, onMounted, nextTick } from 'vue';

export default {

    name: "Test",

    components: {
      MainHeader,
      SideBar,
      CheckBoxMain
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
.main-view {
    margin: 5rem 0;
}
</style>
