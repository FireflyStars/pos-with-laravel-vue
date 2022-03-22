
import useHelpers from '../../composables/useHelpers'

const { generateId } = useHelpers()

import { 
    
    SAVE_PAGE, 
    ADD_PAGE,
    DELETE_PAGE,
    SAVE_PAGE_ELEMENTS, 
    GET_ORDER_DETAILS, 
    SAVE_PAGE_ORDER, 
    SAVE_TEMPLATES,
    GET_TEMPLATES,
    ASSIGN_TEMPLATE,
    SET_ACTIVE_TEMPLATE,
    SET_ACTIVE_PAGE,
    LOAD_REPORT_PAGES,
    SAVE_REPORT_PAGES,
    DELETE_ITEM,
    GENERATE_ELEMENT,
    UPDATE_ELEMENT_STYLES,
    UPDATE_ELEMENT_CONTENT

} from "../types/types"

import { unref } from 'vue'
import axios from "axios"

export const PageBuilder = {

    namespaced: true,

    state: {
        pages: [],
        order: {},
        templates: [],
        activeTemplate: -1,
        activePage: 0,
        loading: {
            id: '',
            value: ''
        }
    },

    getters: {
        loading: state => state.loading,
        pages: state => state.pages,
        order: state => state.order,
        templates: state => state.templates,
        activeTemplate: state => state.activeTemplate,
        template: state => {
            return state.templates.length 
            ? state.templates.find(template => template.id == state.activeTemplate) 
            : {} 
        },
        activePage: state => state.activePage,
        page: state => state.pages.length ? state.pages[state.activePage] : {},
        activePageTemplate: (state, getters) => {
            if(getters.page.template_id != -1 && getters.page.template_id != undefined) {
                const template = state.templates.find(template => {
                    return template.id == getters.page.template_id
                })
                return template != undefined ? template : {}
            }
            return {}
        }
    },

    mutations: {
        [SAVE_PAGE_ELEMENTS](state, elements) {
            state.page.elements = elements
        },
        [SAVE_PAGE_ORDER](state, order) {
            state.order = order
        },
        [SAVE_TEMPLATES](state, data) {
            state.templates = data
        },
        [SET_ACTIVE_TEMPLATE](state, template = '') {
            if(template != '' && template != undefined) state.activeTemplate = template
            else state.activeTemplate = state.templates[0].id
        },
        [SET_ACTIVE_PAGE](state, page) {
            state.activePage = page
        },
        [SAVE_REPORT_PAGES](state) {
            state.pages = [{
                id: generateId(12),
                elements: [],
                template_id: state.activeTemplate || -1
            }]
        },
        [ADD_PAGE](state) {
            state.pages.push({
                id: generateId(12),
                elements: [],
                template_id: state.activeTemplate
            })
        },
        [ASSIGN_TEMPLATE](state, id) {
            if(!state.pages.length && !state.activePage) return
            state.pages[state.activePage].template_id = id
        },
        [DELETE_PAGE](state) {
            if(state.pages.length > 1) {
                const deletedPageIndex = state.activePage
                if(activePage.value != 0) state.activePage --
                state.pages.splice(deletedPageIndex, 1)
            }
        },
        [DELETE_ITEM](state, elementIndex) {
            state.pages[state.activePage].elements.splice(elementIndex, 1)
        },
        [GENERATE_ELEMENT](state, element) {
            state.pages[state.activePage].elements.push(element)
        },
        [UPDATE_ELEMENT_STYLES](state, { styles, index }) {
            state.pages[state.activePage].elements[index].attributes.style = styles
        },
        [UPDATE_ELEMENT_CONTENT](state, { content, index }) {
            state.pages[state.activePage].elements[index].content = content
        }
    },

    actions: {

        async [SAVE_PAGE]({ commit }, { pages, template }) {

            let formData = new FormData()
            pages = unref(pages)
            pages.forEach((page) => {
                
                const { elements } = page

                let fileElements = elements
                .filter((element) => element.item == 'img')
                .map(element => {
                    return {
                        id: element.attributes.id, 
                        file: element.dataFile
                    }
                })

                fileElements.forEach(element => {
                    formData.append(`Img#${element.id}`, element.file)
                })    

            })

            formData.append('pages', JSON.stringify({ ...pages }))

            try {
                const { data } = await axios.post('/save-page-elements', formData, {  
                    responseType: 'arraybuffer'
                })
                return data
            }
            catch(e) {
                throw e
            }

        },

        async [GET_ORDER_DETAILS]({ commit }, orderId) {
            const { data } = await axios.get(`/get-page-order/${orderId}`)
            commit(SAVE_PAGE_ORDER, data)
        },

        async [GET_TEMPLATES]({ commit, getters }, orderId) {
            const { data } = await axios.get(`/get-page-templates/${orderId}`)
            await commit(SAVE_TEMPLATES, data)
            if(getters.templates.length) commit(SET_ACTIVE_TEMPLATE)
        }

    }

}