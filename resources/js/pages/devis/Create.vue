<template>
    <router-view>
        <transition enter-active-class="animate__animated animate__fadeIn">
            <div class="container-fluid h-100 bg-color">
                <main-header />
                <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap reports-page" style="z-index:100" >
                    <side-bar />
                    <div class="col main-view container">
                        <page-title icon="edit" name="Creation / Edition  Devis" class="almarai_extrabold_normal_normal"/>
                        
                    </div>
                </div>
            </div>
        </transition>
    </router-view>
</template>
<script>
export default {
    setup() {
        
    },
}
</script>
<style lang="sass" scoped>

</style>