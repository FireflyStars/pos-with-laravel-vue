<template>
    <div class="row camping-section ml-2">
        <div class="col d-flex gap-3 p-0">
            <Icon name="camping" />
            <p class="text-base orange">Acces tolture</p>
        </div>
        <div class="col">
            <h4>
                {{ zone.moyenacces?.name }}
            </h4>
        </div>
        <div class="col">
            <Icon 
                name="circle-plus" 
                class="pointer"
                @click="generateElement('textarea', {
                    content: zone.moyenacces?.name
                })"
            />
        </div>
    </div>
</template>

<script>

import { inject } from 'vue'

export default {
    name: 'camping-section',
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
.camping-section {
    width: 90%;
    margin-left: auto;
    margin-right: auto;
}

.camping-section {
    margin-top: 2.75rem;
    h4 {
        font-family: Mulish;
        font-style: normal;
        font-weight: normal;
        font-size: 16px;
        line-height: 20px;
        color: #000000;
        margin-bottom: 0;
    }
}

.text {
    font-family: Poppins;
    font-style: normal;
    font-weight: 600;
    font-size: 14px;
    line-height: 22px;
    display: flex;
    align-items: center;
    margin-bottom: 3px;
    text-decoration: none;
    color: #000000;
    &-base {
        font-family: Poppins;
        font-style: normal;
        font-weight: 600;
        line-height: 22px;
        display: flex;
        align-items: center;
        margin-bottom: 3px;
        font-size: 16px;
    }
}


</style>