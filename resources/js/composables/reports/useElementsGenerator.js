
import useHelpers from '../useHelpers'
import store from '../../store/store'

import { 
    BUILDER_MODULE, 
    SAVE_PAGE,
    GET_TEMPLATES,
    DELETE_ITEM,
    GENERATE_ELEMENT,
    UPDATE_ELEMENT_STYLES,
    UPDATE_ELEMENT_CONTENT,
    UPDATE_ELEMENT_TABLE,
    UPDATE_REPORT_TEMPLATE,
    GET_REPORT_TEMPLATE,
    SET_PAGE_BACKGROUND
} from '../../store/types/types'

const { generateId } = useHelpers()

export default function useElementsGenerator() {
    
    const generateTextarea = (attributes) => {
        return {
            item: 'div',
            attributes: {
                class: `draggable textarea ${attributes.class || ''}`,
                style: '',
                dataName: 'textarea',
                id: generateId(12),
            },
            content: 'content' in attributes ? attributes.content : '',
            name: 'textarea'
        }
    }

    const generateButton = ({ id, kind }) => {
        return { 
            item: id,
            attributes: {
                kind,
                title: 'Button',
                class: 'draggable', 
                id: generateId(12),
                style: '',
                dataName: 'button'
            },
            name: 'button'
        }
    }
    
    const generateIcon = ({ id, name, strokeWidth = null, width = null, height = null, stroke = '#000' }) => {
        return {
            item: id,
            attributes: {
                name,
                class: 'draggable',
                id: generateId(12),
                style: '',
                dataName: 'svg',
                strokeWidth: strokeWidth || 0.4,
                stroke,
                width: width || 50,
                height: height || 50,
            },
            name: 'svg'
        }
    }

    const generateImage = ({ filename, image, prefetched = false }) => {
        return {
            item: 'img',
            attributes: {
                src: filename,
                alt:  image.name || 'Uploaded Image',
                class: 'draggable',
                style: '',
                dataName: 'img',
                id: generateId(12),
            },
            name: 'img',
            dataFile: image,
            prefetched
        }
    }

    const generateTable = (attributes) => {
        return {
            item: 'reportTable',
            attributes: {
                class: `draggable ${attributes.class || ''}`,
                style: '',
                dataName: 'table',
                id: generateId(12),
                rows: 1,
                cols: 3,
                headers: true
            },
            content: {
                header: {},
                body: {}
            },
            name: 'table'
        }
    }

    const generateBackground = ({ classes, image = {}, filename, prefetched = true }) => {
        return {
            item: 'backgroundImage',
            attributes: {
                class: `draggable ${classes || ''}`,
                style: '',
                dataName: 'backgroundImage',
                id: generateId(12),
                src: filename,
                alt: image?.name || 'Report page background',
            },
            prefetched,
            dataFile: image,
            name: 'backgroundImage'
        }
    }

    const generateElement = (name, attrs = {}) => {
        const elementMapping = {
            textarea: generateTextarea,
            icon: generateIcon,
            button: generateButton,
            table: generateTable,
            background: generateBackground
        }
        const element = elementMapping[name](attrs)
        if(name == 'background') {
            store.commit(`${BUILDER_MODULE}/${SET_PAGE_BACKGROUND}`, element)
        }
        else {
            store.commit(`${BUILDER_MODULE}/${GENERATE_ELEMENT}`, element)
        }
    }

    const generatePrefetchedImage = (detail) => {
        store.commit(`${BUILDER_MODULE}/${GENERATE_ELEMENT}`, generateImage({ 
            filename: detail.urls.original,
            image: `${detail.storage_path}/${detail.file}.${detail.type}`,
            prefetched: true
        }))
    }

    const promptImage = async (background = false) => {

        let image = {}
        let filename = {}

        let file = document.querySelector('#file')
        file.click()

        file.onchange = (e) => {
            image = e.target.files[0]
            filename = URL.createObjectURL(image)

            if(background == true) {
                store.commit(`${BUILDER_MODULE}/${SET_PAGE_BACKGROUND}`, 
                    generateImage({ filename, image, prefetched: false })
                )
            }
            else {
                store.commit(`${BUILDER_MODULE}/${GENERATE_ELEMENT}`, 
                    generateImage({ filename, image })
                )
            }


            file.value = ''
        }

    }

    return {
        promptImage,
        generateIcon,
        generateTable,
        generateImage,
        generateButton,
        generateElement,
        generateTextarea,
        generateBackground,
        generatePrefetchedImage,
    }

}