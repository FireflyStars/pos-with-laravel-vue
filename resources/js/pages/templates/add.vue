<template>

    <router-view>
        <transition
            enter-active-class="animate__animated animate__fadeIn"
        >
            <div class="container-fluid h-100 bg-color" v-if="showcontainer">
                <main-header />

                <div 
                    class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap reports-page" 
                    style="z-index:100" 
                >
                    
                    <side-bar />

                    <div class="col main-view">
                        <div>

                            <div class="d-flex gap-2">

                                <div class="left-page-container">

                                    <header-section 
                                        title="Creation/Edition Templates" 
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

import Swal from 'sweetalert2'
import { useStore } from 'vuex'
import { onMounted, ref, nextTick, computed, watch, provide } from 'vue'

import { 
    BUILDER_MODULE, 
    SAVE_REPORT_PAGES,
    SAVE_REPORT_TEMPLATE,
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

    setup() {

        const store = useStore()
        
        const { 
            promptImage,
            generateElement,
            generatePrefetchedImage,
        } = useElementsGenerator()

        const { resetPages, generatePagePdf } = useReports()

        const activeItem = ref(null)
        const showcontainer = ref(false)

        const page = computed(() => store.getters[`${BUILDER_MODULE}/page`])
        const pages = computed(() => store.getters[`${BUILDER_MODULE}/pages`])

        const fetching = computed(() => { 
            const { id, value } = store.getters[`${BUILDER_MODULE}/loading`]
            return id == 'fetching' && value
        })
    
        const loadPages = () => {
            store.commit(`${BUILDER_MODULE}/${SAVE_REPORT_PAGES}`)
            return Promise.resolve()
        }

        const saveTemplate = async () => {
            activeItem.value = null
            const { value: name } = await Swal.fire({
                title: 'Sauvegarde',
                input: 'text',
                inputLabel: 'Voulez vous sauvegarder ce rapport comme template',
                inputPlaceholder: 'Nom du template',
                showCancelButton: true,
                confirmButtonText: 'Sauvegarde',
            })

            if (name) {
                store.dispatch(`${[BUILDER_MODULE]}/${[SAVE_REPORT_TEMPLATE]}`, {
                    pages,
                    name
                })
            }

        }

        provide('fetching', fetching)
        provide('promptImage', promptImage)
        provide('generateElement', generateElement)
        provide('generatePrefetchedImage', generatePrefetchedImage)

        watch(page, () => activeItem.value = null)

        onMounted(() => {
            resetPages()
            loadPages()
            nextTick(async () => {
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

// * {
//     margin: 0;
//     padding: 0;
//     box-sizing: border-box;
// }

.swal2-container {
    z-index: 999999999999999999 !important;
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

