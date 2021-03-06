export default function useHelpers() {

    const slice = (string, limit = 4) => {
        return string.length > 5 ? string.slice(0, limit) + '...' : string
    }

    const generateId = (length = 12) => {
        const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'
        let result = ''
        const charactersLength = characters.length
        for ( let i = 0; i < length; i++ ) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength))
        }
        return result
    }

    const getDomElementParent = (element, className = 'library-item') => {
        return element.closest(`.${className}`)
    }

    return {
        slice,
        generateId,
        getDomElementParent
    }

}