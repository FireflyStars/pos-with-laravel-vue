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
                                        @submitPage="submitPage"
                                        @save="saveReport" 
                                    />
                                    
                                    <div class="shadow-sm builder-container">

                                        <report-header :template="activePageTemplate" />

                                        <div 
                                            v-if="!fetching" 
                                            class="template-body"
                                        >

                                            <span 
                                                class="page-number text-muted" 
                                            >
                                                {{ +activePage + 1 }}/{{ pages.length }}
                                            </span>

                                            <!-- {{ page.elements }} -->

                                            <component 
                                                v-for="(element, index) in page.elements" 
                                                :key="index"
                                                :is="element.item" 
                                                v-bind="element.attributes"
                                                @click.prevent="activateItem($event)"
                                                @dblclick="openUpdatePopup(element, $event.target)"
                                                :disabled="element.name == 'table'"
                                                :content="element.content"
                                                :class="{ 
                                                    'active-item': `#${element.attributes.id}` == activeItem 
                                                }"
                                                contenteditable="false"
                                            >

                                                <div 
                                                    class="content"
                                                    v-if="['textarea', 'table'].includes(element.name)" 
                                                    v-html="element.content"
                                                >
                                                </div>

                                                <span 
                                                class="close" 
                                                v-show="`#${element.attributes.id}` == activeItem"
                                                @click.prevent="deleteItem($event.target, element.attributes.id)"
                                                >
                                                    &times;
                                                </span>

                                            </component>

                                            
                                            <popup 
                                                :item="activeElement"
                                                :domStyles="getStylesOfElement(activeDomElement)" 
                                                v-if="openPopup"
                                                @close="openPopup = false"
                                                @update="updateElementFromPopup"
                                            />

                                        </div>

                                        <report-footer :template="activePageTemplate" />

                                    </div>

                                    <Modal 
                                        id="report-templates"
                                        classes="d-flex justify-content-center py-5" 
                                        readonly
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

                                    <Moveable
                                        v-if="showcontainer && pages.length"
                                        className="moveable"
                                        v-bind:target="[activeItem]"
                                        v-bind:draggable="true"
                                        v-bind:scalable="true"
                                        v-bind:rotatable="true"
                                        :keepRatio="false"
                                        @drag="onDrag"
                                        @scale="onScale"
                                        @rotate="onRotate"
                                    />

                                </div>


                                <div class="right-page-container">

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
import { onMounted, unref, ref, nextTick, computed, watch, provide } from 'vue'

import { 
    SAVE_PAGE,
    GET_REPORT,
    SAVE_REPORT,
    DELETE_ITEM,
    GET_TEMPLATES,
    BUILDER_MODULE, 
    GENERATE_ELEMENT,
    GET_ORDER_DETAILS, 
    GET_REPORT_TEMPLATE,
    GET_REPORT_TEMPLATES,
    UPDATE_TABLE_CONTENT,
    UPDATE_ELEMENT_TABLE,
    UPDATE_ELEMENT_STYLES,
    UPDATE_ELEMENT_CONTENT,
} from '../../store/types/types'

import Moveable from "vue3-moveable"
import popup from '../../components/reports/popup'
import adjouterZone from '../../components/reports/adjouter-zone'
import headerSection from '../../components/reports/header-section'
import reportOrderResources from '../../components/reports/report-order-resources'
import reportTable from '../../components/reports/report-table'
import reportHeader from '../../components/reports/report-header'
import reportFooter from '../../components/reports/report-footer'

import useModal from '../../composables/useModal'
import useStyles from '../../composables/reports/useStyles'
import useHelpers from '../../composables/useHelpers'
import useElementsGenerator from '../../composables/reports/useElementsGenerator'
import useReports from '../../composables/reports/useReports'

export default {

    components: {
        popup,
        Moveable,
        reportTable,
        adjouterZone,
        headerSection,
        reportOrderResources,
        reportHeader,
        reportFooter,
    },

    props: {
        id: {
            required: true,
            type: [Number, String]
        }
    },

    setup(props) {

        const store = useStore()
        const { getDomElementParent } = useHelpers()
        const { toggleModal } = useModal()
        const { itemAttributes, getStylesOfElement, getComputedStyle } = useStyles()
        const { 
            generateTextarea, 
            generateIcon, 
            generateButton, 
            generateImage, 
            generateTable 
        } = useElementsGenerator()
        const { resetPages } = useReports()

        const activeItem = ref(null)
        const showcontainer = ref(false)
        const activeElement = ref({})
        const activeDomElement = ref(null)
        const openPopup = ref(false)
        const formattedReportTemplates = ref([])
        const activeReportTemplate = ref(0)
        
        const activePage = computed(() => store.getters[`${BUILDER_MODULE}/activePage`])
        const page = computed(() => store.getters[`${BUILDER_MODULE}/page`])
        const pages = computed(() => store.getters[`${BUILDER_MODULE}/pages`])

        const reportTemplates = computed(() => store.getters[`${BUILDER_MODULE}/reportTemplates`])

        const template = computed(() => store.getters[`${BUILDER_MODULE}/template`])
        const activePageTemplate = computed(() => store.getters[`${BUILDER_MODULE}/activePageTemplate`])
        const activeTemplate = computed(() => store.getters[`${BUILDER_MODULE}/activeTemplate`])

        const fetching = computed(() => { 
            const { id, value } = store.getters[`${BUILDER_MODULE}/loading`]
            return id == 'fetching' && value
        })


        const deleteItem = (elem, id) => {
            const elementIndex = page.value.elements.findIndex(page => {
                return page.attributes.id == id
            })
            if(elementIndex != -1) {
                document.querySelector('.moveable').style.display = "none"
                store.commit(`${BUILDER_MODULE}/${DELETE_ITEM}`, elementIndex)
                activeItem.value = null
            }
        }

        const onDrag = ({ top, left, target }) => {
            updateElementStyles(target, { left, top }, getStylesOfElement(target))
        }

        const onScale = ({ target, drag }) => {
            updateElementStyles(target, { transform: drag.transform }, getStylesOfElement(target))
        }        

        const onRotate = ({ target, drag }) => {
            updateElementStyles(target, { transform: drag.transform }, getStylesOfElement(target))
        }

        const activateItem = (e) => {
            let elem = e.target
            const dataName = elem.getAttribute('dataName')
            elem = dataName == 'svg' ? elem : getDomElementParent(e.target, 'draggable')
            const id = elem.getAttribute('id')
            activeItem.value = `#${id}`
            elem.blur()
        }

        const updateElementStyles = (target, styles, elementOldStyles, item = '') => {
            const { id } = target
            const itemIndex = pages.value[activePage.value].elements.findIndex(item => item.attributes.id == id)
            const itemName = pages.value[activePage.value].elements.find(item => item.attributes.id == id).name
            item = item == '' ? itemName : item
            const computedStyles = getComputedStyle(styles, elementOldStyles, item)
            nextTick(() => {
                store.commit(`${BUILDER_MODULE}/${UPDATE_ELEMENT_STYLES}`, { 
                    styles: computedStyles, 
                    index: itemIndex 
                })
            })
        }

        const updateElementValue = ({ item = 'textarea', index, value }) => {
            const domElements = ['input', 'textarea', 'select']
            if(domElements.includes(item)) {
                store.commit(`${BUILDER_MODULE}/${UPDATE_ELEMENT_CONTENT}`, {
                    content: value,
                    index    
                })
            }
        }

        const updateElementTable = ({ index, rows, cols, headers, content }) => {
            store.commit(`${BUILDER_MODULE}/${UPDATE_ELEMENT_TABLE}`, {
                rows,
                cols,
                headers,
                content,
                index    
            })
        }

        const updateTableValue = ({ type, row, col, value }) => {
            const index = pages.value[activePage.value].elements.findIndex(item => item.attributes.id == activeElement.value?.attributes?.id)
            if(index != -1) {
                store.commit(`${BUILDER_MODULE}/${UPDATE_TABLE_CONTENT}`, {
                    row,
                    col,
                    type,
                    value,
                    index    
                })
            }
        }

        const updateElementFromPopup = ({ id, textValue, table, name }) => {

            const index = pages.value[activePage.value].elements.findIndex(item => item.attributes.id == id)
            const domElem = document.querySelector(`#${id}`)
            if(textValue != undefined && name != 'table') {
                updateElementValue({ index, value: unref(textValue) })
            }
            if(!_.isEmpty(table) && name == 'table') {
                updateElementTable({ 
                    index, 
                    rows: table.rows, 
                    cols: table.cols, 
                    headers: table.headers,
                    content: table.content 
                })
            }
            updateElementStyles(domElem, unref(itemAttributes), getStylesOfElement(domElem), name)
            openPopup.value = false
        }

        const generateElement = (name, attrs = {}) => {
            console.log("I was clicked")
            const elementMapping = {
                textarea: generateTextarea,
                icon: generateIcon,
                button: generateButton,
                table: generateTable
            }
            const element = elementMapping[name](attrs)
            store.commit(`${BUILDER_MODULE}/${GENERATE_ELEMENT}`, element)
        }

        const generatePrefetchedImage = (detail) => {
            store.commit(`${BUILDER_MODULE}/${GENERATE_ELEMENT}`, generateImage({ 
                filename: detail.urls.original,
                image: `${detail.storage_path}/${detail.file}.${detail.type}`,
                prefetched: true
            }))
        }

        const promptImage = async () => {

            let image = {}
            let filename = {}

            let file = document.querySelector('#file')
            file.click()

            file.onchange = (e) => {
                image = e.target.files[0]
                filename = URL.createObjectURL(image)

                store.commit(`${BUILDER_MODULE}/${GENERATE_ELEMENT}`, generateImage({ filename, image }))

                file.value = ''
            }

        }

        const fetchTemplates = () => {
            return store.dispatch(`${BUILDER_MODULE}/${GET_TEMPLATES}`, props.id)
        }

        const openUpdatePopup = (element, domElement) => {
            activeElement.value = element
            activeItem.value = null
            activeDomElement.value = getDomElementParent(domElement, 'draggable')
            openPopup.value = true
        }

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

        const submitPage = async () => {
            try {
                const data = await store.dispatch(`${[BUILDER_MODULE]}/${[SAVE_PAGE]}`, { 
                    pages, 
                    template: template.value,
                    orderId: props.id
                })
                if(data) generatePDF(data)
            }
            catch(e) {
                throw e
            }
        }

        const generatePDF = (data) => {
            let blob = new Blob([data], { type: 'application/pdf' })
            let link = document.createElement('a')
            link.href = window.URL.createObjectURL(blob)
            link.download = 'test.pdf'
            link.click()
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
                fetchTemplates()
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
        provide('updateTableValue', updateTableValue)
        provide('generatePrefetchedImage', generatePrefetchedImage)

        watch(page, () => activeItem.value = null)
        watch(activeReportTemplate, (value) => {
            if(value != 0) {
                nextTick(() => {
                    toggleModal('report-templates', false)
                    getReportTemplate(value)
                    fetchTemplates()
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
            page,
            pages,
            onDrag,
            onScale,
            onRotate,
            fetching,
            template,
            openPopup,
            activePage,
            activeItem,
            toggleModal,
            deleteItem,
            submitPage,
            saveReport,
            promptImage,
            activateItem,
            showcontainer,
            activeElement,
            activeTemplate,
            generateElement,
            openUpdatePopup,
            activeDomElement,
            updateTableValue,
            activePageTemplate,
            getStylesOfElement,
            activeReportTemplate,
            updateElementValue,
            updateElementFromPopup,
            generatePrefetchedImage,
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

.left-page-container {
    width: 55%;
}

.right-page-container {
    width: 45%;
}

.main-view {
    margin-top: 6rem;
}

.template {

    &-body {
        margin-top: 5.75rem;
        img {
            object-fit: cover;
            width: 25rem;
            height: 25rem;
            height: auto;
            border: 3px solid $orange;
        }
        span {
            word-break: break-all !important;
        }
        .page-number {
            float: right;
            font-size: 12px;
            font-family: inherit;
            &::after, &::before {
                float: none;
                clear: both;
            }
        }
    }
}

.builder-container {
    position: relative;
    min-height: 58rem;
    height: auto;
    background: #fff;
    overflow: hidden;
    padding: 1rem 2rem;
    margin-bottom: 1rem;

    .draggable {
        z-index: 10;
        position: absolute;
        .close {
            position: absolute;
            top: -100%;
            left: 50%;
            width: 1.2rem;
            height: 1.2rem;
            background: #000;
            color: white;
            transform: translate(-50%, -100%);
            transform-origin: center;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            line-height: 1.08rem;
            cursor: pointer;
            &:hover {
                opacity: .8;
            }
        }
    }

    // .item-container {
    //     z-index: 12;
    //     position: absolute;
    //     width: 20rem;
    //     height: auto;
    //     .close {
    //         position: absolute;
    //         top: -100%;
    //         left: 50%;
    //         width: 1.2rem;
    //         height: 1.2rem;
    //         background: #000;
    //         color: white;
    //         transform: translate(-50%, -100%);
    //         transform-origin: center;
    //         border-radius: 50%;
    //         display: flex;
    //         justify-content: center;
    //         line-height: 1.08rem;
    //         cursor: pointer;
    //         &:hover {
    //             opacity: .8;
    //         }
    //     }
    // }

    .transparent-button {
        background: transparent;
        border-radius: 0;
        border: 2px solid #000;
        text-transform: uppercase;
        font-weight: 900;
        font-family: 'Almarai ExtraBold';
    }

    .title-bar {
        background: #797272;
        color: rgb(243, 243, 243);
        padding: 5px 1rem;
        margin: .8rem 0;
        text-transform: uppercase;
        font-size: 1.2rem;
        font-weight: 900;
        font-family: 'Almarai ExtraBold';
        width: 100%;
        display: flex;
        align-items: center;
        max-width: 588px;
        .content {
            flex-grow: 1;
        }
    }

    .textarea {
        min-width: 350px;
        min-height: 50px;
        border: 1px solid #ccc;
        z-index: 13;
        word-wrap: normal;
        &::before,
        &::after {
            float: none;
            clear: both;
        }
    }

    .builder-image {
        width: 200;
        height: 250px;
        object-fit: cover;
        margin: .5rem 0;
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

