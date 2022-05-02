
import { unref, computed } from 'vue'
import { isEmpty } from 'lodash'
import store from '../../store/store'
import useElementsGenerator from './useElementsGenerator'

import {
    BUILDER_MODULE,
    SAVE_REPORT,
    SAVE_REPORT_PAGES,
    RESET_PAGES,
    GENERATE_PDF
}
from '../../store/types/types'

export default function useReports() {

    const pages = computed(() => store.getters[`${BUILDER_MODULE}/pages`])

    const { generateElement } = useElementsGenerator()

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
                        dataFile: findFile(data.page_files, id)?.file,
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


    const generatePagePdf = async (orderId = null) => {
        try {
            const data = await store.dispatch(`${[BUILDER_MODULE]}/${[GENERATE_PDF]}`, { 
                pages: pages.value,
                orderId 
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
        link.download = 'Report.pdf'
        link.click()
    }

    const generateCustomerInfo = (tag) => {
        const order = store.getters[`${BUILDER_MODULE}/order`]
        tag = tag?.toString()?.trim()

        switch (tag) {
            case 'customer-name': generateElement('textarea', { 
                content: `<div>
                    <div class='heading'>Client</div>
                    <div>${order?.customer?.name || ''}</div>
                    <div>${order?.customer?.firstname || ''}</div>
                    <div>${order?.customer?.compnay || ''}</div>
                    <div>${order?.customer?.signupdate || ''}</div>
                </div>`
            })
            break
            case 'customer-contact': generateElement('textarea', { 
                content: `
                    <h4 class='title'>Contact</h4>
                    <div>${order.contact?.name || ''}</div>
                    <div>${order.contact?.email || ''}</div>
                    <div>${order.contact?.mobile || ''}</div>
                    <div>${order.contact?.type || ''}</div>
                    <div>${order.contact?.comment || ''}</div>
                `
            })
            break
            case 'customer-address': generateElement('textarea', { 
                content: `<div>
                    <div class='heading'>Client Address</div>
                    <div>${order?.customer?.address?.address1 || ''}</div>
                    <div>${order?.customer?.address?.address2 || ''}</div>
                    <div>${order?.customer?.address?.city || ''}</div>
                    <div>${order?.customer?.address?.phone || ''}</div>
                    <div>${order?.customer?.address?.phone_mobile || ''}</div>
                    <div>${order?.customer?.address?.vat_number || ''}</div>
                </div>    
                `
            })
            break
        }
    }

    return {
        resetPages,
        generatePDF,
        formatFormData,
        generatePagePdf,
        saveReportPages,
        getFormattedPages,
        generateCustomerInfo
    }

}
