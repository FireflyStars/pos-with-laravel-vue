export default function useHelpers() {

    const slice = (string, limit = 4) => {
        return string.length > 5 ? string.slice(0, limit) + '...' : string
    }

    return {
        slice
    }

}