<template>

    <router-view>
        <transition
            enter-active-class="animate__animated animate__fadeIn"
        >
            <div class="container-fluid h-100 bg-color" v-if="showcontainer">
                <main-header />

                <div 
                class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap reports-page" 
                style="z-index:100" >
                    
                    <side-bar />

                    <div class="col main-view container">
                        <div>

                            <div class="d-flex gap-4">

                                <div class="left-page-container">

                                    <header-section 
                                        title="Creation/Edition Template" 
                                        @submitPage="generatePagePdf"
                                        @save="saveTemplate" 
                                    />
                                    
                                    <page-builder-container 
                                        :showcontainer="showcontainer" 
                                    />

                                </div>


                                <div class="right-page-container">

                                    <adjouter-zone />
                                    <div class="d-none">
                                        <input type="file" id="file" accept="image/*">
                                    </div>
                                                    
                                </div>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </transition>
    </router-view>


</template>

<script>

import { useStore } from 'vuex'
import { onMounted, ref, nextTick, computed, provide } from 'vue'

import { 
    BUILDER_MODULE, 
    UPDATE_REPORT_TEMPLATE,
    GET_REPORT_TEMPLATE
} from '../../store/types/types'

import adjouterZone from '../../components/reports/adjouter-zone'
import headerSection from '../../components/reports/header-section'
import reportOrderResources from '../../components/reports/report-order-resources'
import reportTable from '../../components/reports/report-table'
import pageBuilderContainer from '../../components/reports/page-builder-container'

import useElementsGenerator from '../../composables/reports/useElementsGenerator'
import useReports from '../../composables/reports/useReports'


export default {

    components: {
        reportTable,
        adjouterZone,
        headerSection,
        reportOrderResources,
        pageBuilderContainer
    },

    props: {
        id: {
            required: true,
            type: [Number, String]
        }
    },

    setup(props) {

        const store = useStore()
        const { 
            promptImage,
            generateElement,
            generatePrefetchedImage,
        } = useElementsGenerator()

        const { resetPages, generatePagePdf } = useReports()

        const showcontainer = ref(false)

        const pages = computed(() => store.getters[`${BUILDER_MODULE}/pages`])


        const fetching = computed(() => { 
            const { id, value } = store.getters[`${BUILDER_MODULE}/loading`]
            return id == 'fetching' && value
        })
    
        const saveTemplate = async () => {
            store.dispatch(`${[BUILDER_MODULE]}/${[UPDATE_REPORT_TEMPLATE]}`, {
                pages,
                id: props.id
            })
        }

        const getPageTemplate = () => {
            store.dispatch(`${[BUILDER_MODULE]}/${[GET_REPORT_TEMPLATE]}`, props.id)
            return Promise.resolve()
        }

        provide('fetching', fetching)
        provide('promptImage', promptImage)
        provide('generateElement', generateElement)
        provide('generatePrefetchedImage', generatePrefetchedImage)

        onMounted(() => {
            resetPages()
            nextTick(async () => {
                await getPageTemplate()
                showcontainer.value = true
            })
        })
      
        return { 
            fetching,
            saveTemplate,
            showcontainer,
            generatePagePdf,
        }
    },
}

</script>

<style lang="scss" scoped>

$orange: orange;

.swal2-container {
    z-index: 999999999999 !important;
}

.active-item {
    cursor: move;
}

.title_h1 {
    font-family: Almarai;
    font-style: normal;
    font-weight: 800;
    font-size: 22px;
    line-height: 110%;
    color: #000000;
}

.left-page-container {
    width: 793px;
    height: 1122px;
}

.right-page-container {
    width: auto;
}

.main-view {
    margin-top: 6rem;
    padding-left: 85px;
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

