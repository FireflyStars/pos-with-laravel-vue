
<template>
    <router-view v-slot="{ Component }">
        <transition
            enter-active-class="animate__animated animate__fadeIn"
        >
            <div class="container-fluid h-100 bg-color" v-if="showcontainer">
                <main-header />

                <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap" style="z-index:100" >
                    
                    <side-bar />

                    <div class="col main-view container">
                            hello
                        <component :is="Component" />

                    </div>

                </div>
            </div>
        </transition>
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
.main-view {
    margin: 5rem 0;
}
</style>
