<template>
    <div class="breadcrumb d-flex align-items-center gap-4">
        <Icon name="house" />
        <h4 class="breadcrumb-title">{{ zone.name }}</h4>
        <Icon 
            name="circle-plus" 
            class="align-self-start pointer"
            @click="generateElement('textarea', { 
                content: `<strong>${ zone.name }</strong>` 
            })"
        />
    </div>
</template>

<script>
import { inject } from 'vue'
export default {

    props: {
        zone: {
            required: true,
            type: Object
        }
    },

    setup () {
        
        const generateElement = inject('generateElement')

        return {
            generateElement
        }
    }
}
</script>

<style lang="scss" scoped>
.breadcrumb {
    margin-top: 3rem;
    &-title {
        font-family: Mulish;
        font-style: normal;
        font-weight: 900;
        font-size: 18px;
        line-height: 23px;
        letter-spacing: 0.01em;
        color: #000000;
        text-transform: uppercase;
        margin-bottom: 0;
    }

}
</style>