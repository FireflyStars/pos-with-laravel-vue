
import useHelpers from '../../composables/useHelpers'
import useReports from '../../composables/reports/useReports'

const { generateId } = useHelpers()
const { formatFormData, getFormattedPages } = useReports()

import { 
    
    SET_LOADING,
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
    UPDATE_ELEMENT_CONTENT,
    UPDATE_ELEMENT_TABLE,
    UPDATE_TABLE_CONTENT,
    SAVE_REPORT_TEMPLATE,
    SAVE_REPORT_TEMPLATES,
    UPDATE_REPORT_TEMPLATE,
    GET_REPORT_TEMPLATE,
    GET_REPORT_TEMPLATES

} from "../types/types"

import { unref } from 'vue'
import axios from "axios"

export const PageBuilder = {

    namespaced: true,

    state: {
        pages: [],
        order: {},
        templates: [],
        reportTemplates: [],
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
        reportTemplates: state => state.reportTemplates,
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
        [SET_LOADING](state, { id, value = true }) {
            state.loading.id = id
            state.loading.value = value
        },
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
        [SAVE_REPORT_PAGES](state, pages = {}) {
            if(!_.isEmpty(pages)) return state.pages = pages
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
        },
        [UPDATE_ELEMENT_TABLE](state, { rows, cols, headers, index, content }) {
            const page = state.pages[state.activePage].elements[index]
            page.attributes.rows = rows
            page.attributes.cols = cols
            page.attributes.headers = headers
            page.content = {
                ...page.content, 
                ...content
            }
        },
        [UPDATE_TABLE_CONTENT](state, { row, col, type, value, index }) {
            const content = state.pages[state.activePage].elements[index].content
            content[type] = {
                ...content[type],
                [row + '' +col]: value
            }
        },
        [SAVE_REPORT_TEMPLATES](state, data) {
            state.reportTemplates = data
        }
    },

    actions: {

        async [SAVE_PAGE]({ commit }, { pages, template }) {

            commit(SET_LOADING, { id: 'submit' })

            const formData = formatFormData(pages)

            try {
                const { data } = await axios.post('/save-page-elements', formData, {  
                    responseType: 'arraybuffer'
                })
                commit(SET_LOADING, { id: 'submit', value: false })
                return data
            }
            catch(e) {
                commit(SET_LOADING, { id: 'submit', value: false })
                throw e
            }

        },

        async [GET_ORDER_DETAILS]({ commit }, orderId) {
            commit(SET_LOADING, { id: 'fetching' })
            try {
                const { data } = await axios.get(`/get-page-order/${orderId}`)
                commit(SAVE_PAGE_ORDER, data)
                commit(SET_LOADING, { id: 'fetching', value: false })
            }
            catch(e) {
                commit(SET_LOADING, { id: 'fetching', value: false })
                throw e
            }
        },

        async [GET_TEMPLATES]({ commit, getters }) {
            try {
                const { data } = await axios.get(`/get-templates`)
                await commit(SAVE_TEMPLATES, data)
                if(getters.templates.length) commit(SET_ACTIVE_TEMPLATE)
            }
            catch(e) {
                throw e
            }
        },

        async [SAVE_REPORT_TEMPLATE]({ commit }, { pages, orderId }) {

            commit(SET_LOADING, { id: 'save-template' })

            const formData = formatFormData(pages)

            if(orderId != null && orderId != undefined) formData.append('order_id', orderId)

            try {
                const { data } = await axios.post('/page-template', formData)
                commit(SET_LOADING, { id: 'save-template', value: false })
                return data
            }
            catch(e) {
                commit(SET_LOADING, { id: 'save-template', value: false })
                throw e
            }

        },

        async [UPDATE_REPORT_TEMPLATE]({ commit }, { pages, id }) {

            commit(SET_LOADING, { id: 'save-template' })

            const formData = formatFormData(pages)

            try {
                const { data } = await axios.post(`/page-template/${id}`, formData)
                commit(SET_LOADING, { id: 'save-template', value: false })
                return data
            }
            catch(e) {
                commit(SET_LOADING, { id: 'save-template', value: false })
                throw e
            }

        },

        async [GET_REPORT_TEMPLATE]({ commit }, id) {
            try {
                const { data } = await axios.get(`/page-template/${id}`)
                if(!_.isEmpty(data)) {
                    const pages = typeof pages == 'string' ? JSON.parse(data.pages) : data.pages
                    const formattedPages = getFormattedPages(data)
                    console.log(formattedPages, formattedPages.length)
                    commit(SAVE_REPORT_PAGES, formattedPages)
                }
            }
            catch(e) {
                throw e
            }
        },

        async [GET_REPORT_TEMPLATES]({ commit }) {
            try {
                commit(SET_LOADING, { id: 'fetching' })
                const { data } = await axios.get('page-templates')
                commit(SAVE_REPORT_TEMPLATES, data)
                commit(SET_LOADING, { id: 'fetching', value: false })
            }
            catch(e) {
                commit(SET_LOADING, { id: 'fetching', value: false })
                throw e
            }
        }


    }

}