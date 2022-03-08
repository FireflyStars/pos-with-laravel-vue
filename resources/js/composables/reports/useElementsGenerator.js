
import useHelpers from '../useHelpers'

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
    
    const generateIcon = ({ id, name }) => {
        return {
            item: id,
            attributes: {
                name,
                class: 'draggable',
                id: generateId(12),
                style: '',
                dataName: 'svg',
                color: 'orange'
            },
            name: 'svg'
        }
    }

    const generateImage = ({ filename, image }) => {
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
            dataFile: image
        }
    }

    return {
        generateImage,
        generateIcon,
        generateButton,
        generateTextarea,
    }

}