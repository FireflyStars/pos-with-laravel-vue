import { SAVE_PAGE, SAVE_PAGE_ELEMENTS } from "../types/types"
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
            formData.append('template_id', template.id)

            // const { elements } = page

            // commit(SAVE_PAGE_ELEMENTS, elements)

            // let fileElements = elements
            //     .filter((element) => element.item == 'img')
            //     .map(element => {
            //         return {
            //             id: element.attributes.id, 
            //             file: element.dataFile
            //         }
            //     })

            // fileElements.forEach(element => {
            //     formData.append(`Img#${element.id}`, element.file)
            // })    
            // formData.append('elements', JSON.stringify({ ...elements }))
            // formData.append('template_id', template.id)

            try {
                const { data } = await axios.post('save-page-elements', formData, {  
                    responseType: 'arraybuffer'
                })
                return data
            }
            catch(e) {
                throw e
            }

        }

    }
}