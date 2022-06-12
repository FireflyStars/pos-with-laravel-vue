<template>

    <transition 
        enter-active-class="animate__animated animate__fadeIn" 
        leave-active-class="animate__animated animate__fadeOut"
    >
        <span 
            v-if="status != ''"
            class="tag" 
            :style="style" 
            :class="classes" 
        >
            {{ status.toLowerCase() }}
        </span>
    </transition>

</template>

<script setup>

const props = defineProps({
    status: {
        required: true,
        type: String,
    },
    classes: {
        required: false,
        type: String,
        default: ''
    }
})

</script>

<style scoped>
.tag{
    text-transform: capitalize;
    background: #DDD;
    border-radius: 70px;
    text-align: center;
    font-size: 12px;
    width: 120px!important;
    height: 24px;
    position: relative;
    display: inline-block;
    vertical-align: middle;
    line-height: 24px;
    transition: all 0.5s ease-in;
}
  
</style>
