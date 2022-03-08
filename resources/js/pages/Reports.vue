<template>

    <router-view>
        <transition
            enter-active-class="animate__animated animate__fadeIn"
        >
            <div class="container-fluid h-100 bg-color" v-if="showcontainer">
                <main-header />

                <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap reports-page" style="z-index:100" >
                    
                    <side-bar />

                    <div class="col main-view container">
                        <div>

                            <div class="d-flex gap-4">

                                <div class="left-page-container"> <!-- Left section -->

                                    <div class="d-flex justify-content-between align-items-center margin-bottom">
                                
                                        <div>
                                            <h4 class="tile_h1">
                                                <Icon name="report" width="32" height="32" />
                                                Creation/Edition Report
                                            </h4>
                                        </div>

                                        <div class="d-flex">
                                            <BaseButton 
                                                title="Sauvegarder" 
                                                kind="success" 
                                                classes="me-12 heading-buttons" 
                                            />
                                            <BaseButton 
                                                title="pdf" 
                                                kind="danger" 
                                                class="text-uppercase heading-buttons heading-buttons-pdf" 
                                                @click="submitPage" 
                                            />
                                        </div>

                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="reports-dropdown">

                                            <select-box
                                                v-model="activeTemplate" 
                                                :placeholder="template.name || 'Template'" 
                                                :options="formattedTemplates" 
                                                name="template"
                                                classnames="reports-dropdown-button"
                                            />

                                        </div>

                                        <div class="d-flex align-items-center">
                                            
                                            <div>

                                                <a 
                                                class="orange text d-flex align-items-center gap-half pointer" 
                                                @click.prevent="addPage">
                                                    <Icon name="plus-circle" />
                                                    Ajouter Page
                                                </a>

                                                <a 
                                                class="text d-flex align-items-center gap-half"
                                                :class="[pages.length <= 1 ? 'not-allowed': 'pointer']" 
                                                @click.prevent="deletePage"
                                                :disabled="pages.length <= 1"
                                                >
                                                    <Icon name="bin" />
                                                    Supprimer Page
                                                </a>

                                            </div>
                                            
                                            <div class="reports-dropdown page-dropdown">

                                                <select-box
                                                    v-model="activePage" 
                                                    :placeholder="pageName" 
                                                    :options="formattedPages" 
                                                    name="page"
                                                    classnames="reports-dropdown-button"
                                                />

                                            </div>

                                        </div>


                                    </div>
                                    
                                    <div class="shadow-sm builder-container">

                                        <div class="template-header">
                                            <img 
                                                v-if="'id' in activePageTemplate"
                                                :src="activePageTemplate.template.header" 
                                                alt="Template header" 
                                            >
                                        </div>


                                        <div class="template-body">

                                            <div 
                                            v-for="(element, index) in page.elements" 
                                            :key="index"
                                            >
                                                <component 
                                                    :is="element.item" 
                                                    v-bind="element.attributes"
                                                    @click.stop="activateItem($event)"
                                                    @dblclick="openUpdatePopup(element)" 
                                                    :class="{ 
                                                        'cursor-move': `#${element.attributes.id}` == activeItem 
                                                    }"
                                                >
                                                    <span 
                                                        v-if="element.name =='textarea'" 
                                                        v-html="element.content"
                                                    >
                                                    </span>
                                                </component>

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


                                <div class="right-page-container">  <!-- Right section -->

                                    <adjouter-zone 
                                        @generateElement="generateElement"
                                        @promptImage="promptImage"
                                    />
                                                    
                                    <box-bottom-right 
                                        @generateElement="generateElement"
                                    />


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
import { onMounted, unref, ref, nextTick, computed, watch } from 'vue'
import { BUILDER_MODULE, SAVE_PAGE } from '../store/types/types'
import Moveable from "vue3-moveable"
import popup from '../components/reports/popup'
import adjouterZone from '../components/reports/adjouter-zone'
import boxBottomRight from '../components/reports/box-bottom-right'

import useStyles from '../composables/reports/useStyles'
import useHelpers from '../composables/useHelpers'
import useElementsGenerator from '../composables/reports/useElementsGenerator'

export default {

    components: {
        popup,
        Moveable,
        adjouterZone,
        boxBottomRight
    },

    setup() {

        const store = useStore()
        const { generateId, getDomElementParent } = useHelpers()
        const { itemAttributes, getStylesOfElement, getComputedStyle } = useStyles()
        const { generateTextarea, generateIcon, generateButton, generateImage } = useElementsGenerator()

        const pages = ref([])
        const activePage = ref(0)
        const activeItem = ref(null)
        const showcontainer = ref(false)
        const templates = ref([])
        const activeTemplate = ref(-1)
        const activeElement = ref({})
        const openPopup = ref(false)

        const template = computed(() => {
            return templates.value.length 
            ? templates.value.find(template => template.id == activeTemplate.value) 
            : {}
        })

        const activePageTemplate = computed(() => {
            return page.value?.template_id != undefined
            ? templates.value.find(template => {
                return template.id == page.value.template_id
            }) 
            : {}
        })

        const pageName = computed(() =>  {
            const pageValue = +activePage.value + 1
            return 'Page ' + pageValue
        })

        const formattedPages = computed(() => {
            return pages.value.map((_, index) => {
                const pageValue = +index + 1
                return {
                    value: index, 
                    display: 'Page ' + pageValue
                }
            })
        })

        const formattedTemplates = computed(() => {
            return templates.value.map(template => {
                return {
                    value: template.id, 
                    display: template.name
                }
            })
        })
    
        const page = computed(() =>  pages.value.length ? pages.value[activePage.value] : {})

        const assignTemplateToActivePage = (id) => {
            if(!pages.value.length && !activePage.value) return
            pages.value[activePage.value].template_id = id
        }

        const loadPages = () => {
            pages.value = [{
                id: generateId(12),
                elements: [],
                template_id: activeTemplate.value || -1
            }]
        }

        const addPage = () => {
            pages.value.push({
                id: generateId(12),
                elements: [],
                template_id: activeTemplate.value
            })
        }

        const deletePage = () => {
            if(pages.value.length > 1) {
                const deletedPageIndex = activePage.value
                if(activePage.value != 0) activePage.value --
                pages.value.splice(deletedPageIndex, 1)
            }
        }

        const onDrag = ({ top, left, target }) => {
            updateElementStyles(target.id, { left, top }, getStylesOfElement(target))
        }

        const onScale = ({ target, drag }) => {
            updateElementStyles(target.id, { transform: drag.transform }, getStylesOfElement(target))
        }        

        const onRotate = ({ target, drag }) => {
            updateElementStyles(target.id, { transform: drag.transform }, getStylesOfElement(target))
        }

        const activateItem = (e) => {
            let elem = e.target
            const dataName = elem.getAttribute('dataName')
            elem = dataName == 'svg' ? elem : getDomElementParent(e.target, 'draggable')
            const id = elem.getAttribute('id')
            activeItem.value = `#${id}`
            elem.blur()
        }

        const updateElementStyles = (id, styles, elementOldStyles) => {

            const itemIndex = pages.value[activePage.value].elements.findIndex(item => item.attributes.id == id)
            const computedStyles = getComputedStyle(styles, elementOldStyles)
            pages.value[activePage.value].elements[itemIndex].attributes.style = computedStyles

        }

        const updateElementValue = ({ item = 'textarea', index, value }) => {
            const domElements = ['input', 'textarea', 'select']
            if(domElements.includes(item)) {
                pages.value[activePage.value].elements[index].content = value
            }
        }

        const updateElementFromPopup = ({ id, textValue }) => {
            const index = pages.value[activePage.value].elements.findIndex(item => item.attributes.id == id)
            const domElem = document.querySelector(`#${id}`)
            if(textValue != undefined) {
                updateElementValue({ index, value: unref(textValue) })
            }
            updateElementStyles(id, unref(itemAttributes), getStylesOfElement(domElem))
            openPopup.value = false
        }

        const generateElement = (name, attrs = {}) => {
            const elementMapping = {
                textarea: generateTextarea,
                icon: generateIcon,
                button: generateButton
            }
            const element = elementMapping[name](attrs)
            pages.value[activePage.value].elements.push(element)
        }

        const promptImage = async () => {

            let image = {}
            let filename = {}

            let file = document.querySelector('#file')
            file.click()

            file.onchange = (e) => {
                image = e.target.files[0]
                filename = URL.createObjectURL(image)

                pages.value[activePage.value].elements.push(generateImage({ filename, image }))
                
                file.value = ''

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

        const fetchTemplates = () => {
            templates.value = ([
                {
                    id: 'template1',
                    name: 'Template1',
                    template: {
                        header: '../images/sample-template.png',
                        footer: '../images/sample-footer-template.png'
                    }
                },
                {
                    id: 'template2',
                    name: 'Template2',
                    template: {
                        header: '../images/sample-template-1.png',
                        footer: '../images/sample-footer-template-1.png'
                    }
                },
            ])
            templates.value.length ? activeTemplate.value = templates.value[0]?.id : -1
            return Promise.resolve() 
        }

        const openUpdatePopup = (element) => {
            openPopup.value = true
            activeElement.value = element
            activeItem.value = null
        }

        watch(page, () => {
            activeItem.value = null
        })

        watch(activeTemplate, (value) => {
            if(value) assignTemplateToActivePage(value)
        })

        onMounted(() => {
            nextTick(async () => {
                showcontainer.value = true
                await fetchTemplates()
                loadPages()
            })
        })
      
        return { 
            page,
            pages,
            onDrag,
            addPage,
            onScale,
            pageName,
            onRotate,
            template,
            templates,
            openPopup,
            activePage,
            submitPage,
            deletePage,
            activeItem,
            promptImage,
            activateItem,
            showcontainer,
            generateElement,
            formattedPages,
            activeElement,
            activeTemplate,
            openUpdatePopup,
            activePageTemplate,
            formattedTemplates,
            updateElementValue,
            updateElementFromPopup,
            assignTemplateToActivePage,
        }
    },
}

</script>

<style lang="scss" scoped>
$orange: orange;

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
            width: auto;
            height: auto;
            object-fit: cover;
            width: 25rem;
            height: 25rem;
            border: 3px solid $orange;
        }
        span {
            word-break: break-all !important;
        }
    }
}


.heading-buttons {
    font-family: sans-serif;
    font-style: normal;
    font-weight: bold;
    font-size: 12px;
    line-height: 23px;
    color: #fff !important;
    width: auto;
    border: none;
}



.builder-container {
    position: relative;
    min-height: 45rem;
    background: #fff;
    overflow: hidden;
    padding: 1rem 2rem;

    .draggable {
        z-index: 10;
        position: absolute;
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
        float: right;
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


.reports-dropdown {
    position: relative;
    margin-bottom: .75rem;
    &-button {
        background: #C4C4C4;
        border: none;
        font-family: Roboto;
        font-style: normal;
        font-weight: normal;
        font-size: 18px;
        line-height: 21px;
        color: #000000;
        gap: 0.51rem;
        padding-left: 1.43rem;
        padding-right: 1.43rem;
        min-width: 9.56rem;
        min-height: 2.93rem;
        border-radius: 0;
    }
    .page-button {
        gap: 2.62rem;
    }
}

.page-dropdown {
    margin-left: 2.06rem;
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

