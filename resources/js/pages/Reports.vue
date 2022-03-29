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
                                        @save="saveTemplate" 
                                    />
                                    
                                    <div class="shadow-sm builder-container" @click="activeItem = null">

                                        <div class="template-header">
                                            <img 
                                                v-if="'id' in activePageTemplate"
                                                :src="activePageTemplate.template.header" 
                                                alt="Template header" 
                                            >
                                        </div>

                                        <div class="template-body">

                                            <span 
                                                v-show="!fetching"
                                                class="page-number text-muted" 
                                            >
                                                {{ +activePage + 1 }}/{{ pages.length }}
                                            </span>

                                            <div 
                                                v-for="(element, index) in page.elements" 
                                                :key="index"
                                                class="item-container"
                                            >

                                                <component 
                                                    :is="element.item" 
                                                    v-bind="element.attributes"
                                                    @click.stop="activateItem($event)"
                                                    @dblclick="openUpdatePopup(element)"
                                                    :disabled="element.name == 'table'"
                                                    :content="element.content"
                                                    :class="{ 
                                                        'active-item': `#${element.attributes.id}` == activeItem 
                                                    }"
                                                >

                                                    <div 
                                                        class="content"
                                                        v-if="['textarea', 'table'].includes(element.name)" 
                                                        v-html="element.content"
                                                    >
                                                    </div>

                                                    <!-- <span 
                                                    class="close" 
                                                    v-show="`#${element.attributes.id}` == activeItem"
                                                    @click.prevent="deleteItem($event.target, element.attributes.id)"
                                                    >
                                                        &times;
                                                    </span> -->

                                                </component>

                                                <span 
                                                class="close" 
                                                v-show="`#${element.attributes.id}` == activeItem"
                                                @click.prevent="deleteItem($event.target, element.attributes.id)"
                                                >
                                                    &times;
                                                </span>
                                                

                                            </div>
                                            
                                            <popup 
                                                :item="activeElement" 
                                                v-if="openPopup"
                                                @close="openPopup = false"
                                                @update="updateElementFromPopup"
                                            />

                                        </div>

                                        <div class="template-footer">
                                            <img 
                                                v-if="'id' in activePageTemplate"
                                                :src="activePageTemplate.template.footer" 
                                                alt="Template footer" 
                                            >
                                        </div>

                                    </div>

                                    <Moveable
                                        v-if="pages.length"
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
    BUILDER_MODULE, 
    SAVE_PAGE,
    GET_ORDER_DETAILS, 
    GET_TEMPLATES,
    SAVE_REPORT_PAGES,
    DELETE_ITEM,
    GENERATE_ELEMENT,
    UPDATE_ELEMENT_STYLES,
    UPDATE_ELEMENT_CONTENT,
    UPDATE_ELEMENT_TABLE,
    UPDATE_TABLE_CONTENT,
    SAVE_REPORT_TEMPLATE
} from '../store/types/types'

import Moveable from "vue3-moveable"
import popup from '../components/reports/popup'
import adjouterZone from '../components/reports/adjouter-zone'
import headerSection from '../components/reports/header-section'
import reportOrderResources from '../components/reports/report-order-resources'
import reportTable from '../components/reports/report-table'

import useStyles from '../composables/reports/useStyles'
import useHelpers from '../composables/useHelpers'
import useElementsGenerator from '../composables/reports/useElementsGenerator'

export default {

    components: {
        popup,
        Moveable,
        reportTable,
        adjouterZone,
        headerSection,
        reportOrderResources
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
        const { itemAttributes, getStylesOfElement, getComputedStyle } = useStyles()
        const { 
            generateTextarea, 
            generateIcon, 
            generateButton, 
            generateImage, 
            generateTable 
        } = useElementsGenerator()

        const activeItem = ref('#myTable')
        const showcontainer = ref(false)
        const activeElement = ref({})
        const openPopup = ref(false)

        const activePage = computed(() => store.getters[`${BUILDER_MODULE}/activePage`])
        const page = computed(() => store.getters[`${BUILDER_MODULE}/page`])
        const pages = computed(() => store.getters[`${BUILDER_MODULE}/pages`])

        const template = computed(() => store.getters[`${BUILDER_MODULE}/template`])
        const activePageTemplate = computed(() => store.getters[`${BUILDER_MODULE}/activePageTemplate`])
        const activeTemplate = computed(() => store.getters[`${BUILDER_MODULE}/activeTemplate`])

        const fetching = computed(() => { 
            const { id, value } = store.getters[`${BUILDER_MODULE}/loading`]
            return id == 'fetching' && value
        })
    
        const loadPages = () => {
            store.commit(`${BUILDER_MODULE}/${SAVE_REPORT_PAGES}`)
            return Promise.resolve()
        }

        const deleteItem = (elem, id) => {
            const elementIndex = page.value.elements.findIndex(page => {
                return page.attributes.id == id
            })
            if(elementIndex != -1) {
                elem = getDomElementParent(elem, 'item-container')
                elem.remove()
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

        const updateElementStyles = (target, styles, elementOldStyles) => {
            const { id } = target
            if(target.parentElement) {
                const { top,  left } = styles
                if(top) target.parentElement.style.top = `${top}px`
                if(left) target.parentElement.style.left = `${left}px`
            }
            const itemIndex = pages.value[activePage.value].elements.findIndex(item => item.attributes.id == id)
            const computedStyles = getComputedStyle(styles, elementOldStyles)
            store.commit(`${BUILDER_MODULE}/${UPDATE_ELEMENT_STYLES}`, { 
                styles: computedStyles, 
                index: itemIndex 
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
            updateElementStyles(id, unref(itemAttributes), getStylesOfElement(domElem))
            openPopup.value = false
        }

        const generateElement = (name, attrs = {}) => {
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

        const openUpdatePopup = (element) => {
            openPopup.value = true
            activeElement.value = element
            activeItem.value = null
        }

        const getOrderDetails = () => {
            return store.dispatch(`${BUILDER_MODULE}/${GET_ORDER_DETAILS}`, props.id)
        }

        const saveTemplate = () => {
            store.dispatch(`${[BUILDER_MODULE]}/${[SAVE_REPORT_TEMPLATE]}`, {
                pages,
                orderId: props.id
            })
        }

        const submitPage = async () => {
            try {
                const data = await store.dispatch(`${[BUILDER_MODULE]}/${[SAVE_PAGE]}`, { 
                    pages, 
                    template: template.value 
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

        provide('fetching', fetching)
        provide('promptImage', promptImage)
        provide('generateElement', generateElement)
        provide('updateTableValue', updateTableValue)
        provide('generatePrefetchedImage', generatePrefetchedImage)

        watch(page, () => activeItem.value = null)

        onMounted(() => {
            loadPages()
            getOrderDetails()
            nextTick(async () => {
                showcontainer.value = true
                await fetchTemplates()
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
            deleteItem,
            submitPage,
            promptImage,
            saveTemplate,
            activateItem,
            showcontainer,
            generateElement,
            activeElement,
            activeTemplate,
            openUpdatePopup,
            updateTableValue,
            activePageTemplate,
            updateElementValue,
            updateElementFromPopup,
            generatePrefetchedImage,
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
    &-header {
        top: 0;
        max-height: 4.75rem;
    }
    &-footer {
        bottom: 0;
    }
    &-header, 
    &-footer {
        width: 100%;
        height: auto;
        position: absolute;
        left: 0;
        img {
            width: 100%;
            height: 100%;
            padding: 1rem;
            object-fit: cover;
        }
    }
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
    }

    .item-container {
        z-index: 12;
        position: absolute;
        width: 20rem;
        height: auto;
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
        width: 92%;
        display: flex;
        align-items: center;
    }

    .textarea {
        min-width: 350px;
        min-height: 50px;
        border: 1px solid #ccc;
        z-index: 99999;
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

