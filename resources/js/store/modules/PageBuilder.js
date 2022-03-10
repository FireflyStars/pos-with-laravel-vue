import { SAVE_PAGE, SAVE_PAGE_ELEMENTS, GET_ORDER_DETAILS } from "../types/types"
import { unref } from 'vue'

export const PageBuilder = {
    namespaced: true,
    state: {
        page: {
            elements: []
        }
    },
    getters: {
        page: (state) => state.page
    },
    mutations: {
        [SAVE_PAGE_ELEMENTS](state, elements) {
            state.page.elements = elements
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
                const { data } = await axios.post('save-page-elements', formData, {  
                    responseType: 'arraybuffer'
                })
                return data
            }
            catch(e) {
                throw e
            }

        },

        async [GET_ORDER_DETAILS]() {
            const { data } = await axios.get(`get-page-order/${1}`)
            console.log(data)
        }

    }
}