<template>

    <router-view>
        <transition
            enter-active-class="animate__animated animate__fadeIn"
        >
            <div class="container-fluid h-100 bg-color" v-if="showcontainer">
                <main-header />

                <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap" style="z-index:100" >
                    
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
                                            <BaseButton title="Sauvegarder" kind="success" class="me-12 heading-buttons" />
                                            <BaseButton title="pdf" kind="danger" class="text-uppercase heading-buttons heading-buttons-pdf" @click="submitPage" />
                                        </div>

                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="reports-dropdown">
                                            <BaseButton 
                                            :title="template.name || 'Template'" 
                                            class="reports-dropdown-button"
                                            @click="toggleActiveItem('templatesDropdown')">
                                                <Icon name="angle-down" />
                                            </BaseButton>
                                            <Dropdown 
                                                id="templatesDropdown"
                                                height="200px"
                                                background="transparent"
                                                transformOrigin="bottom"
                                                width="100%"
                                            >
                                                <ul class="list-group w-100">
                                                    <template v-if="templates.length">
                                                        <li class="list-group-item list-group-item-action"
                                                        :class="{ 'active': index == activeTemplate }" 
                                                        v-for="(template, index) in templates"
                                                        :key="template.id"
                                                        @click.prevent="assignTemplate(index)">
                                                            {{ template.name }}
                                                        </li>
                                                    </template>
                                                </ul>
                                            </Dropdown>

                                        </div>

                                        <div class="d-flex align-items-center">
                                            
                                            <div>

                                                <a class="orange text d-flex align-items-center gap-half">
                                                    <Icon name="plus-circle" class="pointer" />
                                                    Ajouter Page
                                                </a>

                                                <a class="text d-flex align-items-center gap-half">
                                                    <Icon name="bin" />
                                                    Supprimer Page
                                                </a>

                                            </div>
                                            
                                            <div class="reports-dropdown page-dropdown">

                                                <BaseButton 
                                                title="Page 1" 
                                                class="reports-dropdown-button page-button"
                                                @click="toggleActiveItem('pageDropdown')">
                                                    <Icon name="angle-down" />
                                                </BaseButton>
                                                <Dropdown 
                                                    id="pageDropdown"
                                                    height="200px"
                                                    background="transparent"
                                                    transformOrigin="bottom"
                                                    width="100%"
                                                >
                                                    <ul class="list-group w-100">
                                                        <li class="list-group-item list-group-item-action">Page 1</li>
                                                        <li class="list-group-item list-group-item-action">Page 2</li>
                                                        <li class="list-group-item list-group-item-action">Page 3</li>
                                                        <li class="list-group-item list-group-item-action">Page 4</li>
                                                    </ul>
                                                </Dropdown>

                                            </div>

                                        </div>


                                    </div>
                                    
                                    <div class="shadow-sm builder-container">

                                        <div class="template-header">
                                            <img 
                                                v-if="templates.length"
                                                :src="template.template.header" 
                                                alt="Template header" 
                                            >
                                        </div>


                                        <div class="template-body">

                                            <div class="title-bar">
                                                Vue d'ensemble du batiment
                                            </div>

                                            <div 
                                            v-for="(element, index) in page.elements" 
                                            :key="index">
                                            <!-- Changed event from click to dblclick becasue of a conflict in focus and drag -->
                                                <component 
                                                    :is="element.item" 
                                                    v-bind="element.attributes"
                                                    @dblclick="activateItem($event)" 
                                                    @input="updateElementValue({ 
                                                        value: $event.target.value,
                                                        index,
                                                        item: element.item
                                                    })"
                                                    :class="{ 
                                                        'cursor-move': `#${element.attributes.id}` == activeItem 
                                                    }"
                                                />
                                                
                                            </div>

                                        </div>

                                        <div class="template-footer">
                                            <img 
                                                v-if="templates.length"
                                                :src="template.template.footer" 
                                                alt="Template footer" 
                                            >
                                        </div>

                                    </div>

                                    <Moveable
                                        v-if="page.elements.length"
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

                                    <div class="box-top-right d-flex align-items-center shadow-sm">

                                        <div class="row m-0">

                                            <div class="col">
                                                <div>
                                                    <Icon name="file" class="d-inline" />
                                                    <p class="d-inline orange text-base">Ajouter Titre</p>
                                                </div>
                                                <div @click="generateTextarea" class="pointer">
                                                    <Icon name="file" class="d-inline" />
                                                    <p class="d-inline orange text-base">Ajouter Zone texts</p>
                                                </div>
                                            </div>

                                            <div class="col">
                                                
                                                <div class="d-flex align-items-center gap-3">
                                                    <Icon 
                                                        class="library-item"
                                                        name="arrow-top"
                                                        @click="generateIcon($event, { id: 'Icon', name: 'arrow-top' })"
                                                    />
                                                    
                                                    <Icon 
                                                        class="library-item"
                                                        name="egg"
                                                        @click="generateIcon($event, { id: 'Icon', name: 'egg' })"
                                                    />

                                                    <Icon 
                                                        class="library-item"
                                                        name="plus-o"
                                                        @click="generateIcon($event, { id: 'Icon', name: 'plus-o' })"
                                                    />

                                                    <p class="orange text-base">Ajouter Forme</p>
                                                </div>

                                                <BaseButton 
                                                    title="Ajouter Image"
                                                    class="image-button"
                                                />            


                                            </div>

                                        </div>


                                    </div><!--  box-top-right -->
                                                    
                                    <div class="box-bottom-right bg-white p-3 shadow-sm">
                                        

                                        <!-- <div class="d-flex align-items-center">
                                            <BaseButton
                                                class="library-item"
                                                title="Button"
                                                kind="primary"
                                                @click="generateButton($event, { id: 'BaseButton', kind: 'primary' })"
                                            />

                                            <BaseButton
                                                class="library-item"
                                                title="Button"
                                                kind="light"
                                                @click="generateButton($event, { id: 'BaseButton', kind: 'light' })"
                                            />

                                            <BaseButton
                                                class="library-item"
                                                title="Button"
                                                kind="danger"
                                                @click="generateButton($event, { id: 'BaseButton', kind: 'danger' })"
                                            />
                                        </div> -->


                                        <div class="row mx-0" style="margin-top: 3.4rem">
                                            <div class="col">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <div class="thumbnail"></div>
                                                    <div class="title-section">
                                                        <p>Nom du client</p>
                                                        <h4>M. Marcus Pinnochio</h4>
                                                    </div>
                                                    <Icon name="circle-plus" class="pointer" />
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="d-flex gap-2 align-items-center">
                                                    <div class="title-section title-section-right">
                                                        <p>Adresse du chantier</p>
                                                        <h4>43 Lower Sloane Street 31000 Toulouse</h4>
                                                    </div>
                                                    <Icon name="circle-plus" class="pointer" />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="breadcrumb-section">
                                            <div class="breadcrumb d-flex align-items-center gap-4">
                                                <Icon name="house" />
                                                <h4 class="breadcrumb-title">Batiment exa</h4>
                                                <Icon name="circle-plus" class="align-self-start pointer" />
                                            </div>
                                            
                                            <div class="row camping-section ml-2">
                                                <div class="col d-flex gap-3 p-0">
                                                    <Icon name="camping" />
                                                    <p class="text-base orange">Acces tolture</p>
                                                </div>
                                                <div class="col">
                                                    <h4>20 M, Nacelle 30M</h4>
                                                </div>
                                                <div class="col">
                                                    <Icon name="circle-plus" class="pointer" />
                                                </div>
                                            </div>


                                            <div class="image-grid-section ml-2">
                                                <div class="d-flex align-items-center gap-2" style="margin-bottom: 1.31rem">
                                                    <Icon name="camera" />
                                                    <h4 class="text-base orange">Environment</h4>
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <div class="black-box"></div>
                                                    <div class="black-box"></div>
                                                    <div class="black-box"></div>
                                                    <div class="black-box"></div>
                                                
                                                    <div class="ml-5 d-flex gap-2 align-items-start">
                                                        <div class="d-none">
                                                            <input type="file" id="file" accept="image/*">
                                                        </div>
                                                        <p class="m-0">Attention grosse poutre en haut</p>
                                                        <Icon name="plus-circle" class="mt-2 pointer" @click.prevent="generateImage" />
                                                    </div>
                                                </div>    

                                            </div>


                                            <div class="image-grid-section ml-2">
                                                <div class="d-flex align-items-center gap-2" style="margin-bottom: 1.31rem">
                                                    <Icon name="camera" />
                                                    <h4 class="text-base orange">Vue interieure</h4>
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <div class="black-box"></div>
                                                    <div class="black-box"></div>
                                                    <div class="black-box"></div>
                                                    <div class="black-box"></div>
                                                
                                                    <div class="ml-5 d-flex gap-2 align-items-start">
                                                        <p class="m-0">Attention grosse poutre en haut</p>
                                                        <Icon name="plus-circle" class="mt-2 pointer" />
                                                    </div>
                                                </div>    

                                            </div>  


                                            <div class="image-grid-section ml-2">
                                                <div class="d-flex align-items-center gap-2" style="margin-bottom: 1.31rem">
                                                    <Icon name="camera" />
                                                    <h4 class="text-base orange">Vue Exterieure</h4>
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <div class="black-box"></div>
                                                    <div class="black-box"></div>
                                                    <div class="black-box"></div>
                                                    <div class="black-box"></div>
                                                
                                                    <div class="ml-5 d-flex gap-2 align-items-start">
                                                        <p class="m-0">Attention grosse poutre en haut</p>
                                                        <Icon name="plus-circle" class="mt-2 pointer" />
                                                    </div>
                                                </div>    

                                            </div>   


                                            <div class="image-grid-section ml-2">
                                                <div class="d-flex align-items-center gap-2" style="margin-bottom: 1.31rem">
                                                    <Icon name="camera" />
                                                    <h4 class="text-base orange">Metre</h4>
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <div class="black-box"></div>
                                                    <div class="black-box"></div>
                                                    <div class="black-box"></div>
                                                    <div class="black-box"></div>
                                                
                                                    <div class="ml-5 d-flex gap-2 align-items-start">
                                                        <p class="m-0">Attention grosse poutre en haut</p>
                                                        <Icon name="plus-circle" class="mt-2 pointer" />
                                                    </div>
                                                </div>    

                                            </div>                  



                                        </div><!-- breadcrumb-section -->


                                        <div class="installation-section">

                                            <div class="title-section d-flex align-items-center gap-4" style="margin-bottom: 1.31rem">
                                                <div class="icon">
                                                    <Icon name="marker" />
                                                </div>
                                                <h4 class="title">Installation</h4>
                                            </div>


                                            <div class="installation-section-content">
                                                
                                                <h4 class="text-base orange main-title">Ouvrage A</h4>

                                                <div class="main-body row m-0">
                                                    <h4 
                                                    class="text-base orange text-uppercase col-6 d-flex justify-content-center" 
                                                    style="margin-bottom: .56rem">
                                                        Avant
                                                    </h4>

                                                    <div class="col"></div>

                                                    <div class="d-flex gap-2 col">
                                                        <div class="black-box"></div>
                                                        <div class="black-box"></div>
                                                        <div class="black-box"></div>
                                                        <div class="black-box"></div>
                                                    </div>    
                                                </div>

                                                <div class="main-body row mx-0" style="margin-top: 1.75rem">
                                                    <h4 
                                                    class="text-base orange text-uppercase col-6 d-flex justify-content-center" 
                                                    style="margin-bottom: .56rem">
                                                        apres
                                                    </h4>

                                                    <div class="col"></div>

                                                    <div class="d-flex gap-2 col">
                                                        <div class="black-box"></div>
                                                        <div class="black-box"></div>
                                                        <div class="black-box"></div>
                                                        <div class="black-box"></div>
                                                    </div>    
                                                </div>
                                                
                                            </div>


                                        </div>


                                        <div class="security-section">

                                            <div class="title-section d-flex align-items-center gap-4">
                                                <div class="icon">
                                                    <Icon name="notepad" />
                                                </div>
                                                <h4 class="title">Securite</h4>
                                            </div>

                                            <div class="security-section-content">
                                                
                                                <h4 class="text-base orange main-title">Ouvrage XXXXXXXX</h4>

                                                <div class="main-body">

                                                    <div class="row m-0">

                                                        <h4 
                                                        class="text-base orange text-uppercase col-6 d-flex justify-content-center" 
                                                        style="margin-bottom: .56rem">
                                                            Avant
                                                        </h4>
                                                        
                                                        <div class="col"></div>

                                                        <div class="col">
                                                            <div class="d-flex gap-2">
                                                                <div class="black-box"></div>
                                                                <div class="black-box"></div>
                                                                <div class="black-box"></div>
                                                                <div class="black-box"></div>
                                                            </div>   
                                                        </div>
                                                        
                                                    </div>

                                                     
                                                </div>

                                                <div class="main-body" style="margin-top: 1.75rem">

                                                    <div class="row m-0">
                                                        <h4 
                                                        class="text-base orange text-uppercase col-6 d-flex justify-content-center" 
                                                        style="margin-bottom: .56rem">
                                                            apres
                                                        </h4>
                                                        <div class="col"></div>
                                                        <div class="d-flex gap-2">
                                                            <div class="black-box"></div>
                                                            <div class="black-box"></div>
                                                            <div class="black-box"></div>
                                                            <div class="black-box"></div>
                                                        </div>    

                                                    </div>

                                                </div>
                                                
                                            </div>
                                            
                                            <div class="security-section-content">
                                                
                                                <h4 class="text-base orange main-title">Ouvrage YYYYYYYY</h4>

                                                <div class="main-body">

                                                    <div class="row m-0">

                                                        <h4 
                                                        class="text-base orange text-uppercase col-6 d-flex justify-content-center" 
                                                        style="margin-bottom: .56rem">
                                                            Avant
                                                        </h4>
                                                        
                                                        <div class="col"></div>

                                                        <div class="col">
                                                            <div class="d-flex gap-2">
                                                                <div class="black-box"></div>
                                                                <div class="black-box"></div>
                                                                <div class="black-box"></div>
                                                                <div class="black-box"></div>
                                                            </div>   
                                                        </div>

                                                        <div class="col">
                                                            <div class="d-flex gap-2 align-items-start">
                                                                <p class="m-0">Attention grosse poutre en haut</p>
                                                                <Icon name="plus-circle" class="mt-2 pointer" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                     
                                                </div>

                                                <div class="main-body" style="margin-top: 1.75rem">

                                                    <div class="row m-0">
                                                        <h4 
                                                        class="text-base orange text-uppercase col-6 d-flex justify-content-center" 
                                                        style="margin-bottom: .56rem">
                                                            apres
                                                        </h4>
                                                        <div class="col"></div>
                                                        <div class="d-flex gap-2">
                                                            <div class="black-box"></div>
                                                            <div class="black-box"></div>
                                                            <div class="black-box"></div>
                                                            <div class="black-box"></div>
                                                        </div>    

                                                    </div>

                                                </div>
                                                
                                            </div>


                                        </div>


                                        <div class="prestations-section">

                                            <div class="title-section d-flex align-items-center gap-4">
                                                <div class="icon">
                                                    <Icon name="settings" />
                                                </div>
                                                <h4 class="title">Prestations</h4>
                                            </div>
                                            
                                            <div class="image-grid-section ml-2">
                                                <div class="d-flex align-items-center gap-2" style="margin-bottom: 1.31rem">
                                                    <Icon name="camera" />
                                                    <h4 class="text-base orange">Validation Chantier / Signature</h4>
                                                </div>

                                                <div class="row m-0">
                                                    
                                                    <div class="col">
                                                        <div class="black-box"></div>
                                                    </div>
                                                
                                                    <div class="col d-flex gap-2 align-items-start">
                                                        <p class="m-0">Attention grosse poutre en haut</p>
                                                        <Icon name="plus-circle" class="mt-2 pointer" />
                                                    </div>
                                                </div>    

                                            </div>

                                        </div>




                                    </div><!--  box-top-right -->


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
import { onMounted, reactive, ref, nextTick, computed } from 'vue'
import { useStore } from 'vuex'
import { BUILDER_MODULE, SAVE_PAGE } from '../store/types/types'
import useToggler from '../composables/useToggler'
import Moveable from "vue3-moveable"


export default {

    components: {
        Moveable,
    },

    setup() {

        const store = useStore()
        const { toggleActiveItem } = useToggler()

        const page = reactive({ elements: [] })

        const activeItem = ref(null)
        const showcontainer = ref(false)
        const templates = ref([])
        const activeTemplate = ref(0)

        const template = computed(() => {
            return templates.value.length ? templates.value[activeTemplate.value] : {}
        })

        const assignTemplate = (index) => {
            activeTemplate.value = index
            toggleActiveItem('templatesDropdown')
        }

        const onDrag = ({ top, left, target }) => {
            // let styles = getStylesOfElement(target)
            // styles['top'] = `${top}`
            // styles['left'] = `${left}`
            // styles['scale'] = `${styles['scale'] || []}`
            // styles['rotate'] = `${styles['rotate'] || []}`
            // target.style.left = `${left}px`
            // target.style.top = `${top}px`
            updateElementStyles(target, { left, top })
        }

        const onScale = ({ target, drag }) => {
            // let styles = getStylesOfElement(target)
            // styles['scale'] = scale
            // styles['rotate'] = `${styles['rotate'] || []}`
            // console.log(styles['scale'])
            // target.style.transform = drag.transform
            updateElementStyles(target, { transform: drag.transform })
        }

        const getStylesOfElement = (element) => {
            return {
                left: element.style.left,
                right: element.style.right,
                top: element.style.top,
                bottom: element.style.bottom,
                transform: element.style.transform
            }
        }

        const onRotate = ({ target, drag }) => {
            // target.style.transform = drag.transform;
            updateElementStyles(target, { transform: drag.transform })
        }

        const activateItem = (e) => {
            let elem = e.target
            const dataName = elem.getAttribute('dataName')
            elem = dataName == 'svg' ? elem : getElementParent(e.target, 'draggable')
            const id = elem.getAttribute('id')
            activeItem.value = `#${id}`
            elem.blur()
        }

        const updateElementStyles = (elem, styles) => {
            const { id } = elem
            const itemIndex = page.elements.findIndex(item => item.attributes.id == id)

            const elementOldStyles = getStylesOfElement(elem)

            let top = styles.top ? `${styles.top}px` : elementOldStyles.top
            let left = styles.left ? `${styles.left}px` : elementOldStyles.left
            let transform = styles.transform ? styles.transform : elementOldStyles.transform

             let computedStyles =
            `
                top: ${top};
                left: ${left};
                transform: ${transform};
            `

            console.log(computedStyles)
            page.elements[itemIndex].attributes.style = computedStyles
        }

        const updateElementValue = ({item, index, value}) => {
            const domElements = ['input', 'textarea', 'select']
            if(domElements.includes(item)) {
                page.elements[index].attributes.value = value
            }
        }


        const generateString = (length) => {
            const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'
            let result = ''
            const charactersLength = characters.length
            for ( let i = 0; i < length; i++ ) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength))
            }
            return result
        }


        const generateTextarea = () => {
            page.elements.push({
                item: 'textarea',
                attributes: {
                    class: 'draggable',
                    style: '',
                    dataName: 'textarea',
                    id: generateString(12),
                    value: ''
                },
                name: 'textarea'
            })
        }

        const generateImage = async () => {

            let image = {}
            let filename = {}

            let file = document.querySelector('#file')
            file.click()

            file.onchange = (e) => {
                console.log(e.target)
                image = e.target.files[0]
                console.log(image)
                filename = URL.createObjectURL(image)

                page.elements.push({
                    item: 'img',
                    attributes: {
                        src: filename,
                        alt:  image.name || 'Uploaded Image',
                        class: 'draggable',
                        style: '',
                        dataName: 'img',
                        id: generateString(12),
                    },
                    name: 'img',
                    dataFile: image
                })

            }


        }

        const generateButton = (e, { id, kind }) => {
            page.elements.push({ 
                item: id,
                attributes: {
                    kind,
                    title: 'Button',
                    class: 'draggable',
                    id: generateString(12),
                    style: '',
                    dataName: 'button'
                },
                name: 'button'
            })
        }
        
        const generateIcon = (e, { id, name }) => {
            page.elements.push({
                item: id,
                attributes: {
                    name,
                    class: 'draggable',
                    id: generateString(12),
                    style: '',
                    dataName: 'svg'
                },
                name: 'svg'
            })
        }

        const getElementParent = (element, className = 'library-item') => {
            console.log(element.className, className, element.className.split(' ').includes(className))
            if(element.className.split(' ').includes(className)) return element.cloneNode(true)
            return getElementParent(element.parentNode, className)
        }

        const submitPage = async () => {
            try {
                const data = await store.dispatch(`${[BUILDER_MODULE]}/${[SAVE_PAGE]}`, { 
                    page, 
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
        }

        onMounted(() => {
            nextTick(() => {
                showcontainer.value = true
                fetchTemplates()
            })
        })
      
        return { 
            page,
            onDrag,
            onRotate,
            onScale,
            template,
            templates,
            activeTemplate,
            assignTemplate,
            submitPage,
            activeItem,
            activateItem,
            showcontainer,
            generateIcon,
            generateButton,
            generateTextarea,
            generateImage,
            toggleActiveItem,
            updateElementValue,
        }
    },
}

</script>

<style lang="scss" scoped>

.cursor-move {
    cursor: move;
}

.pointer {
    cursor: pointer;
}

.left-page-container {
    width: 55%;
}

.right-page-container {
    width: 45%;
}

.bg-color {
    background: #E5E5E5;
}

.main-view {
    margin-top: 6rem;
}

.me-12 {
    margin-right: .75rem;
}

.margin-bottom {
    margin-bottom: 2.375rem;
}

.gap-half {
    gap: 0.64rem;
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
            max-height: 25rem;
            max-width: 25rem;
        }
    }
}


.heading-buttons {
    font-family: sans-serif;
    font-style: normal;
    font-weight: bold;
    font-size: 12px;
    line-height: 23px;
    color: #FFFFFF;
    width: auto;
    border: none;
}



.builder-container {
    position: relative;
    min-height: 40rem;
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
    }

    textarea {
        min-width: 350px;
        min-height: 50px;
        float: right;
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

.orange {
    color: #E8581B !important;
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


.box-top-right {
    background: #fff;
    padding: 1rem;
    .image-button {
        background: rgba(168, 168, 168, 0.25);
        border-radius: 10px;
        border: 1px solid rgba(168, 168, 168, 0.25) !important;
    }
}

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
        margin-top: 7rem;
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

    .camping-section,
    .image-grid-section, 
    .installation-section-content, 
    .security-section-content {
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

    .image-grid-section {
        margin-top: 2.845rem;
        h4 {
            margin-bottom: 0;
        }
    }

    .installation-section, .security-section {
        margin-top: 2.875rem;
        .title-section {
            .icon {
                background: #FFF0E6;
                width: 3.31rem;
                height: 3.31rem;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .title {
                font-family: Mulish;
                font-style: normal;
                font-weight: 900;
                font-size: 17px;
                line-height: 21px;
                color: #000000;
                opacity: 0.5;
            }
        }

        &-content {
            
            margin-top: 2.03rem;
            .main-body {
                margin-top: 1.125rem;
            }

        }

    }

    .security-section {
        .title-section {
            .icon {
                background: #ECEAFE;
            }
            .title {
                font-weight: 900;
                font-family: Mullish, sans-serif;
            }
        }
    }

    .prestations-section {
        margin-bottom: 10rem;
        .title-section {
            margin-top: 4.34rem;
            margin-bottom: 6.593rem;

            .icon {
                background: #ECEAFE;
                width: 3.31rem;
                height: 3.31rem;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .title {
                font-family: Mulish;
                font-style: normal;
                font-weight: 900;
                font-size: 17px;
                line-height: 21px;
                color: #000000;
                opacity: 0.5;
            }
        }
    }


}


.black-box {
    background: #525252;
    border-radius: 8px;
    width: 3.43rem !important;
    height: 3.43rem !important;
}

</style>

