
import { unref } from 'vue'
import { isEmpty } from 'lodash'
import store from '../../store/store'

import {
    BUILDER_MODULE,
    SAVE_REPORT,
    SAVE_REPORT_PAGES,
    RESET_PAGES
}
from '../../store/types/types'

export default function useReports() {

    const formatFormData = (pages) => {

        let formData = new FormData()
        pages = unref(pages)

        pages.forEach((page) => {
            
            const { elements, background } = page

            let fileElements = elements
            .filter((element) => element.item == 'img')
            .map(element => {
                return {
                    id: element.attributes.id, 
                    file: element.dataFile,
                }
            })

            fileElements.forEach(element => {
                formData.append(`Img#${element.id}`, element.file)
            })

            if(!isEmpty(page.background)) {
                formData.append(`BackgroundImage#${page.background.attributes.id}`, page.background.dataFile)
            }

        })

        formData.append('pages', JSON.stringify({ ...pages }))
        return formData
    
    }

    const getFormattedPages = (data) => {

        const pages = data.pages
        const formattedPages = []

        if(pages.length) {

            pages.forEach((page, index) => {

                let formattedPage = {
                    id: page.id,
                    template_id: page.template_id,
                    elements: [],
                    background: {}
                }

                if(!isEmpty(page.background)) {
                    const id = `backgroundImage_${index}`
                    formattedPage.background = {
                        ...page.background,
                        attributes: {
                            ...page.background.attributes,
                            src: findFile(data.page_files, id)?.public_path
                        },
                        dtaFile: findFile(data.page_files, id)?.file,
                        prefetched: true,
                    }
                }

                page.elements.forEach(element => {
                    if(element.name == 'img') {
                        
                        formattedPage.elements.push({
                            ...element,
                            attributes: {
                                ...element.attributes,
                                src: findFile(data.page_files, element.attributes.id)?.public_path,
                            },
                            dataFile: findFile(data.page_files, element.attributes.id)?.file,
                            prefetched: true,
                        })
                    }
                    else {
                        formattedPage.elements.push({ ...element })
                    }
                })

                formattedPages.push(formattedPage)

            })

        }

        return formattedPages

    }

    const findFile = (files, id) => {
        return files.find(file => file.id == id)
    }

    const saveReportPages = (data) => {
        if(!_.isEmpty(data)) {
            const pages = typeof pages == 'string' ? JSON.parse(data.pages) : data.pages
            if(!pages.length) {
                resetPages()
                return
            }
            const formattedPages = getFormattedPages(data)
            store.commit(`${BUILDER_MODULE}/${SAVE_REPORT_PAGES}`, formattedPages)
        }
    }

    const resetPages = () => {
        store.commit(`${BUILDER_MODULE}/${SAVE_REPORT}`, {
            id: null, 
            status: 'store' 
        })
        store.commit(`${BUILDER_MODULE}/${RESET_PAGES}`, [])
    }

    return {
        resetPages,
        formatFormData,
        saveReportPages,
        getFormattedPages
    }

}
