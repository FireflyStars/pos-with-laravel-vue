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
                                        title="Creation/Edition Templates" 
                                        @submitPage="submitPage"
                                        @save="saveTemplate" 
                                    />

                                    <!-- <div 
                                        id="builder-container"
                                        class="shadow-sm builder-container"
                                        :style="{ 
                                            backgroundImage: `url('${reportBackground?.attributes?.src}')`,
                                            backgroundRepeat: 'no-repeat',
                                            backgroundSize: 'cover',
                                            backgroundPosition: 'center center' 
                                        }" 
                                    >

                                        <div class="template-body">
                                            
                                            <span 
                                                v-show="pages.length"
                                                class="page-number text-muted" 
                                            >
                                                {{ +activePage + 1 }}/{{ pages.length }}
                                            </span>

                                            <component 
                                                v-for="(element, index) in page.elements" 
                                                :key="index"
                                                :is="element.item" 
                                                v-bind="element.attributes"
                                                @click.stop="activateItem($event)"
                                                @dblclick="openUpdatePopup(element, $event.target)"
                                                :disabled="element.name == 'table'"
                                                :content="element.content"
                                                contenteditable="false"
                                                :class="{ 
                                                    'active-item': `#${element.attributes.id}` == activeItem 
                                                }"
                                            >

                                                <span 
                                                    v-if="['textarea', 'table'].includes(element.name)" 
                                                    v-html="element.content"
                                                >
                                                </span>

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

                                    </div>

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
                                    /> -->

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
import { onMounted, unref, ref, nextTick, computed, watch, provide } from 'vue'

import { 
    BUILDER_MODULE, 
    SAVE_PAGE,
    GET_TEMPLATES,
    SAVE_REPORT_PAGES,
    DELETE_ITEM,
    GENERATE_ELEMENT,
    UPDATE_ELEMENT_STYLES,
    UPDATE_ELEMENT_CONTENT,
    UPDATE_ELEMENT_TABLE,
    SAVE_REPORT_TEMPLATE,
    SET_PAGE_BACKGROUND,
} from '../../store/types/types'

// import Moveable from "vue3-moveable"
// import popup from '../../components/reports/popup'
import adjouterZone from '../../components/reports/adjouter-zone'
import headerSection from '../../components/reports/header-section'
import reportOrderResources from '../../components/reports/report-order-resources'
import reportTable from '../../components/reports/report-table'
import pageBuilderContainer from '../../components/reports/page-builder-container'

import useStyles from '../../composables/reports/useStyles'
// import useHelpers from '../../composables/useHelpers'
import useElementsGenerator from '../../composables/reports/useElementsGenerator'
import useReports from '../../composables/reports/useReports'


export default {

    components: {
        // popup,
        // Moveable,
        reportTable,
        adjouterZone,
        headerSection,
        reportOrderResources,
        pageBuilderContainer
    },

    setup() {

        const store = useStore()
        // const { getDomElementParent } = useHelpers()
        const { itemAttributes, getStylesOfElement, getComputedStyle } = useStyles()
        
        const { 
            promptImage,
            generateElement,
            generatePrefetchedImage,
        } = useElementsGenerator()

        const { resetPages } = useReports()

        const activeItem = ref(null)
        const showcontainer = ref(false)
        // const activeElement = ref({})
        // const activeDomElement = ref(null)
        // const openPopup = ref(false)

        // const activePage = computed(() => store.getters[`${BUILDER_MODULE}/activePage`])
        const page = computed(() => store.getters[`${BUILDER_MODULE}/page`])
        const pages = computed(() => store.getters[`${BUILDER_MODULE}/pages`])

        // const template = computed(() => store.getters[`${BUILDER_MODULE}/template`])
        // const activePageTemplate = computed(() => store.getters[`${BUILDER_MODULE}/activePageTemplate`])
        // const activeTemplate = computed(() => store.getters[`${BUILDER_MODULE}/activeTemplate`])
        // const reportBackground = computed(() => page.value?.background || {})

        const fetching = computed(() => { 
            const { id, value } = store.getters[`${BUILDER_MODULE}/loading`]
            return id == 'fetching' && value
        })
    
        const loadPages = () => {
            store.commit(`${BUILDER_MODULE}/${SAVE_REPORT_PAGES}`)
            return Promise.resolve()
        }

        // const deleteItem = (elem, id) => {
        //     const elementIndex = page.value.elements.findIndex(page => {
        //         return page.attributes.id == id
        //     })
        //     if(elementIndex != -1) {
        //         elem = getDomElementParent(elem, 'draggable')
        //         elem.remove()
        //         document.querySelector('.moveable').style.display = "none"
        //         store.commit(`${BUILDER_MODULE}/${DELETE_ITEM}`, elementIndex)
        //         activeItem.value = null
        //     }
        // }

        // const onDrag = ({ top, left, target }) => {
        //     updateElementStyles(target, { left, top }, getStylesOfElement(target))
        // }

        // const onScale = ({ target, drag }) => {
        //     updateElementStyles(target, { transform: drag.transform }, getStylesOfElement(target))
        // }        

        // const onRotate = ({ target, drag }) => {
        //     updateElementStyles(target, { transform: drag.transform }, getStylesOfElement(target))
        // }

        // const activateItem = (e) => {
        //     let elem = e.target
        //     const dataName = elem.getAttribute('dataName')
        //     elem = dataName == 'svg' ? elem : getDomElementParent(e.target, 'draggable')
        //     const id = elem.getAttribute('id')
        //     activeItem.value = `#${id}`
        //     elem.blur()
        // }

        // const updateElementStyles = (target, styles, elementOldStyles, item = '') => {
        //     const { id } = target
        //     const itemIndex = pages.value[activePage.value].elements.findIndex(item => item.attributes.id == id)
        //     const itemName = pages.value[activePage.value].elements.find(item => item.attributes.id == id).name
        //     item = item == '' ? itemName : item
        //     const computedStyles = getComputedStyle(styles, elementOldStyles, item)
        //     nextTick(() => {
        //         store.commit(`${BUILDER_MODULE}/${UPDATE_ELEMENT_STYLES}`, { 
        //             styles: computedStyles, 
        //             index: itemIndex 
        //         })
        //     })
        // }

        // const updateElementValue = ({ item = 'textarea', index, value }) => {
        //     const domElements = ['input', 'textarea', 'select']
        //     if(domElements.includes(item)) {
        //         store.commit(`${BUILDER_MODULE}/${UPDATE_ELEMENT_CONTENT}`, {
        //             content: value,
        //             index    
        //         })
        //     }
        // }

        // const updateElementTable = ({ index, rows, cols, headers, content }) => {
        //     store.commit(`${BUILDER_MODULE}/${UPDATE_ELEMENT_TABLE}`, {
        //         rows,
        //         cols,
        //         headers,
        //         content,
        //         index    
        //     })
        // }

        // const updateElementFromPopup = ({ id, textValue, table, name }) => {
        //     const index = pages.value[activePage.value].elements.findIndex(item => item.attributes.id == id)
        //     const domElem = document.querySelector(`#${id}`)
        //     if(textValue != undefined && name != 'table') {
        //         updateElementValue({ index, value: unref(textValue) })
        //     }
        //     if(!_.isEmpty(table) && name == 'table') {
        //         updateElementTable({ 
        //             index, 
        //             rows: table.rows, 
        //             cols: table.cols, 
        //             headers: table.headers,
        //             content: table.content 
        //         })
        //     }
        //     updateElementStyles(domElem, unref(itemAttributes), getStylesOfElement(domElem), name)
        //     openPopup.value = false
        // }

        // const generateElement = (name, attrs = {}) => {
        //     const elementMapping = {
        //         textarea: generateTextarea,
        //         icon: generateIcon,
        //         button: generateButton,
        //         table: generateTable,
        //         background: generateBackground
        //     }
        //     const element = elementMapping[name](attrs)
        //     if(name == 'background') {
        //         store.commit(`${BUILDER_MODULE}/${SET_PAGE_BACKGROUND}`, element)
        //     }
        //     else {
        //         store.commit(`${BUILDER_MODULE}/${GENERATE_ELEMENT}`, element)
        //     }
        // }

        // const generatePrefetchedImage = (detail) => {
        //     store.commit(`${BUILDER_MODULE}/${GENERATE_ELEMENT}`, generateImage({ 
        //         filename: detail.urls.original,
        //         image: `${detail.storage_path}/${detail.file}.${detail.type}`,
        //         prefetched: true
        //     }))
        // }

        // const promptImage = async (background = false) => {

        //     let image = {}
        //     let filename = {}

        //     let file = document.querySelector('#file')
        //     file.click()

        //     file.onchange = (e) => {
        //         image = e.target.files[0]
        //         filename = URL.createObjectURL(image)

        //         if(background == true) {
        //             store.commit(`${BUILDER_MODULE}/${SET_PAGE_BACKGROUND}`, 
        //                 generateImage({ filename, image, prefetched: false })
        //             )
        //         }
        //         else {
        //             store.commit(`${BUILDER_MODULE}/${GENERATE_ELEMENT}`, 
        //                 generateImage({ filename, image })
        //             )
        //         }


        //         file.value = ''
        //     }

        // }

        // const openUpdatePopup = (element, domElement) => {
        //     activeElement.value = element
        //     activeItem.value = null
        //     activeDomElement.value = getDomElementParent(domElement, 'draggable')
        //     openPopup.value = true
        // }

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
            // page,
            // pages,
            // onDrag,
            // onScale,
            // onRotate,
            fetching,
            // template,
            // openPopup,
            // activePage,
            // activeItem,
            // deleteItem,
            submitPage,
            // promptImage,
            saveTemplate,
            // activateItem,
            showcontainer,
            // generateElement,
            // reportBackground,
            // activeElement,
            // activeTemplate,
            // openUpdatePopup,
            // activeDomElement,
            // generateBackground,
            // getStylesOfElement,
            // activePageTemplate,
            // updateElementValue,
            // updateElementFromPopup,
            // generatePrefetchedImage,
        }
    },
}

</script>

<style lang="scss" scoped>

$orange: orange;

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
    width: 55%;
}

.right-page-container {
    width: 45%;
}

.main-view {
    margin-top: 6rem;
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

