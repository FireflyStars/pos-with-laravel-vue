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

                    <div class="col main-view">
                        <div>

                            <div class="d-flex gap-3 main-container">

                                <div class="left-page-container">

                                    <header-section 
                                        @submitPage="generatePagePdf(id)"
                                        @save="saveReport" 
                                    />
                                    
                                    <page-builder-container 
                                        :showcontainer="showcontainer"
                                    />

                                    <Modal 
                                        id="report-templates"
                                        readonly
                                        classes="d-flex justify-content-center" 
                                        contentClasses="overflow-visible"
                                    >
                                        <div>
                                            <h4>Templates List</h4>
                                            <div class="mt-3">
                                                <label>Please choose a template from saved templates</label>
                                                <select-box
                                                    v-model="activeReportTemplate" 
                                                    placeholder="Choose a template" 
                                                    :options="formattedReportTemplates" 
                                                    name="page"
                                                    :selectStyles="{ maxHeight: '12rem', overflow: 'auto' }"
                                                />          
                                            </div>
                                            <BaseButton 
                                                kind="default" 
                                                title="Add New" 
                                                class="mb-2 mt-4"
                                                size="sm"
                                                @click="$router.push({
                                                    name: 'templates-add'
                                                })"
                                            />
                                        </div>
                                    </Modal>

                                </div>


                                <div 
                                    class="right-page-container" 
                                    @mouseenter="showRightContainer=true"
                                    @mouseleave="showRightContainer=false"
                                    :class="showRightContainer ? 'right-page-container-visible': ''"
                                >

                                    <adjouter-zone />
                                    <report-order-resources />

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
import { onMounted, ref, nextTick, computed, watch, provide } from 'vue'

import { 
    GET_REPORT,
    SAVE_REPORT,
    BUILDER_MODULE, 
    GET_ORDER_DETAILS, 
    GET_REPORT_TEMPLATE,
    GET_REPORT_TEMPLATES,
} from '../../store/types/types'

import adjouterZone from '../../components/reports/adjouter-zone'
import headerSection from '../../components/reports/header-section'
import reportOrderResources from '../../components/reports/report-order-resources'
import reportTable from '../../components/reports/report-table'
import reportHeader from '../../components/reports/report-header'
import reportFooter from '../../components/reports/report-footer'
import pageBuilderContainer from '../../components/reports/page-builder-container'

import useModal from '../../composables/useModal'
import useElementsGenerator from '../../composables/reports/useElementsGenerator'
import useReports from '../../composables/reports/useReports'

export default {

    components: {
        reportTable,
        adjouterZone,
        headerSection,
        reportHeader,
        reportFooter,
        reportOrderResources,
        pageBuilderContainer,
    },

    props: {
        id: {
            required: true,
            type: [Number, String]
        }
    },

    setup(props) {

        const store = useStore()
        const showRightContainer = ref(false)
        const { toggleModal } = useModal()
        const { 
            promptImage,
            generateElement,
            generatePrefetchedImage,
        } = useElementsGenerator()
        const { resetPages, generatePagePdf } = useReports()

        const activeItem = ref(null)
        const showcontainer = ref(false)
        const formattedReportTemplates = ref([])
        const activeReportTemplate = ref(0)
        
        const pages = computed(() => store.getters[`${BUILDER_MODULE}/pages`])

        const reportTemplates = computed(() => store.getters[`${BUILDER_MODULE}/reportTemplates`])

        const fetching = computed(() => { 
            const { id, value } = store.getters[`${BUILDER_MODULE}/loading`]
            return id == 'fetching' && value
        })

        const getOrderDetails = () => {
            return store.dispatch(`${BUILDER_MODULE}/${GET_ORDER_DETAILS}`, props.id)
        }

        const saveReport = () => {
            store.dispatch(`${[BUILDER_MODULE]}/${[SAVE_REPORT]}`, {
                pages,
                orderId: props.id,
                templateId: activeReportTemplate.value
            })
        }

        const getReportTemplates = async () => {
            await store.dispatch(`${[BUILDER_MODULE]}/${[GET_REPORT_TEMPLATES]}`)
            const templates = reportTemplates.value.map(({ id, name }) => {
                return {
                    value: id,
                    display: name
                }
            })
            formattedReportTemplates.value = templates
            return Promise.resolve()
        }

        const getReport = async () => {
            await store.dispatch(`${BUILDER_MODULE}/${GET_REPORT}`, props.id)
            if(!pages.value.length) {
                toggleModal('report-templates')
                await getReportTemplates()
            }
            else {
                getOrderDetails()
            }
            return Promise.resolve()
        }

        const getReportTemplate = async (id) => {
            await store.dispatch(`${[BUILDER_MODULE]}/${[GET_REPORT_TEMPLATE]}`, id)
            return Promise.resolve()
        }

        provide('fetching', fetching)
        provide('promptImage', promptImage)
        provide('generateElement', generateElement)
        provide('showRightContainer', showRightContainer)
        provide('generatePrefetchedImage', generatePrefetchedImage)

        watch(activeReportTemplate, (value) => {
            if(value != 0) {
                nextTick(() => {
                    toggleModal('report-templates', false)
                    getReportTemplate(value)
                    getOrderDetails()
                })
            }
        })

        onMounted(() => {
            resetPages()
            nextTick(async () => {
                await getReport()
                showcontainer.value = true
            })
        })
      
        return { 
            fetching,
            activeItem,
            toggleModal,
            saveReport,
            promptImage,
            showcontainer,
            generatePagePdf,
            showRightContainer,
            activeReportTemplate,
            formattedReportTemplates,
        }
    },
}

</script>

<style lang="scss" scoped>

$orange: orange;

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

.main-view {
    margin-top: 6rem;
}

.main-container {
    position: relative;
    margin-bottom: 1rem;
}

.left-page-container {
    width: 793px;
    height: 1122px;
}

.right-page-container {
    top: 0;
    right: 0;
    width: 300px;
    z-index: 99;
    position: absolute;
    transition: width .2s;
    &-visible {
        width: 530px;
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

