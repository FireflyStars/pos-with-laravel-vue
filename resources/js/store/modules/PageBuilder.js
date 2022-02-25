import { SAVE_PAGE, SAVE_PAGE_ELEMENTS } from "../types/types"

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
       async [SAVE_PAGE]({ commit }, { elements }) {

            commit(SAVE_PAGE_ELEMENTS, elements)
            let formData = new FormData()

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

            formData.append('name', 'Muhammad Imran')

            formData.append('elements', JSON.stringify({ ...elements }))

            try {
                const { data } = await axios.post('save-page-elements', formData, {  
                    // headers: { "Content-Type": "multipart/form-data" },
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