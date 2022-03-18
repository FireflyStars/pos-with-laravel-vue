<template>
    <div class="image-grid-section ml-2" 
    v-for="(gedDetail, category) in gedDetails"
    :key="gedDetail.id"
    >

        <div class="d-flex align-items-center gap-2" style="margin-bottom: 1.31rem">
            <Icon name="camera" />
            <h4 class="text-base orange">{{ category }}</h4>
        </div>

        <div class="d-flex gap-2">
            <ged-detail-files 
                :gedDetail="gedDetail"
                @generatePrefetchedImage="generatePrefetchedImage"
                @generateElement="generateElement" 
            />
        </div>

    </div>
</template>

<script>

import gedDetailFiles from './ged-detail-files.vue'

export default {

    components: {
        gedDetailFiles
    },

    props: {
        gedDetails: {
            required: true,
            type: [Object, Array]
        }
    },

    emits: ['generateElement', 'generatePrefetchedImage'],

    setup (_, { emit }) {
        
        const generatePrefetchedImage = (data) => emit('generatePrefetchedImage', data)
        const generateElement = (data) => emit('generateElement', data)

        return {
            generateElement,
            generatePrefetchedImage
        }
    }
}
</script>

<style lang="scss" scoped>
.image-grid-section {
    width: 90%;
    margin-left: auto;
    margin-right: auto;
}

.image-grid-section {
    margin-top: 2.845rem;
    h4 {
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