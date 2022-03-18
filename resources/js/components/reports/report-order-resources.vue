<template>
    
    <div class="box-bottom-right bg-white p-3 shadow-sm">
                                        
        <div class="row mx-0" style="margin-top: 2rem">
            <div class="col">
                <div class="d-flex gap-2 align-items-center">
                    <div class="thumbnail"></div>
                    <div class="title-section">
                        <p>Nom du client</p>
                        <h4>{{ order?.customer?.firstname || 'Name' }}</h4>
                    </div>
                    <Icon 
                        name="circle-plus" 
                        class="pointer" 
                        @click.prevent="generateElement('textarea', { 
                            content: order?.customer?.firstname || 'Name'
                        })" 
                    />
                </div>
            </div>
            <div class="col">
                <div class="d-flex gap-2 align-items-center">
                    <div class="title-section title-section-right">
                        <p>Adresse du chantier</p>
                        <h4>{{ order?.customer?.address?.address1 || 'Customer Address' }}</h4>
                    </div>
                    <Icon 
                        name="circle-plus" 
                        class="pointer"
                        @click.prevent="generateElement('textarea', { 
                            content: order?.customer?.address?.address1 || 'Customer Address'
                        })"
                    />
                </div>
            </div>
        </div>

        <template v-if="'id' in order && order?.orderZones?.length">

            <template  
                v-for="zone in order.orderZones"
                :key="zone.id">
                
                <div class="breadcrumb-section">

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
                    
                    <camping-section 
                        :zone="zone"
                        @generateElement="generateElement" 
                    />

                    <template v-if="zone?.gedDetails">

                        <ged-detail-image-grid-section 
                            :gedDetails="zone.gedDetails"
                            @generatePrefetchedImage="generatePrefetchedImage"
                            @generateElement="generateElement" 
                        />

                    </template>

                    
                    <template v-if="zone?.orderZoneComments?.length">

                        <zone-comments-section 
                            :orderZoneComments="zone.orderZoneComments"
                            @generateElement="generateElement"
                        />

                    </template>

                </div><!-- breadcrumb-section -->

                
                <order-ouvrages
                    :orderOuvrages="zone.orderOuvrages"
                    @generatePrefetchedImage="generatePrefetchedImage"
                    @generateElement="generateElement"
                />    

            </template>

        </template>


    </div>

    <div class="d-none">
        <input type="file" id="file" accept="image/*">
    </div>

</template>

<script>

import { useStore } from 'vuex'
import { computed } from 'vue'
import orderOuvrages from './order-ouvrages.vue'
import gedDetailFiles from './ged-detail-files.vue'
import zoneCommentsSection from './zone-comments-section.vue'
import gedDetailImageGridSection from './ged-detail-image-grid-section.vue'
import campingSection from './camping-section.vue'
import signatureSection from './signature-section'
import { BUILDER_MODULE } from '../../store/types/types'

export default {

    name: 'report-order-resource',

    components: {
        orderOuvrages,
        campingSection,
        gedDetailFiles,
        zoneCommentsSection,
        gedDetailImageGridSection,
        signatureSection
    },

    emits: ['generateElement', 'generatePrefetchedImage'],

    setup (_, { emit }) {

        const store = useStore()

        const order = computed(() => store.getters[`${BUILDER_MODULE}/order`])

        const getCategoryClassName = (category) => {
            const categories = {
                installation: 'installation',
                securite: 'security',
                prestation: 'prestation'
            }
            return category !='' ? `${categories[category.toLowerCase()]}-section` : ''
        }
        
        const generateElement = (name, attributes) => {
            emit('generateElement', name, attributes)
        }

        const generatePrefetchedImage = (detail) => {
            emit('generatePrefetchedImage', detail)
        }

        return {
            order,
            generateElement,
            getCategoryClassName,
            generatePrefetchedImage
        }
    }
}
</script>

<style lang="scss" scoped>

.box-bottom-right {
    margin-top: .75rem;
    margin-bottom: 2rem;
    .thumbnail {
        background: #7998C7;
        width: 2.95rem;
        height: 3.15rem;
        border-radius: 50%;
    }
    .title-section {
        p {
            font-family: Mulish;
            font-weight: 600;
            font-style: normal;
            font-size: 0.625rem;
            line-height: 13px;
            color: rgba(0, 24, 51, 0.22);
            transform: matrix(1, 0, 0, 1, 0, 0);
            margin-bottom: .4rem;
        }
        h4 {
            font-family: Mulish;
            font-style: normal;
            font-weight: 800;
            font-size: 16px;
            line-height: 162.7%;
            color: #324A59;
        }

        &-right {
            p {
                font-family: Almarai;
                font-weight: bold;
                font-size: 14px;
                line-height: 140%;
                color: #C3C3C3;
            }

            h4 {
                font-family: Almarai;
                font-weight: 300;
                font-size: 14px;
                line-height: 140%;
                color: #000000;
            }

        }

    }

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

}

.black-box {
    border-radius: 8px;
    width: 3.43rem !important;
    height: 3.43rem !important;
    img {
        width: 100%;
        height: 100%;
        object-fit: cover;
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