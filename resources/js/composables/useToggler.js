import { computed } from 'vue'
import { useStore } from 'vuex'
import { ACTIVE_ITEM, SET_TOGGLER_ITEM, TOGGLER_MODULE } from '../store/types/types'


export default function useToggler() {

    const store = useStore()

    const activeItem = computed(() => store.getters[`${[TOGGLER_MODULE]}/${[ACTIVE_ITEM]}`])

    const open = (id) => {
        return id.toLowerCase() == activeItem.value.id && activeItem.value.status
    }

    const toggleActiveItem = (id) => {
        let status = activeItem.value.status
        let activeId = activeItem.value.id
        status = id.toLowerCase() == activeId ? !status : true
        store.dispatch(`${[TOGGLER_MODULE]}/${[SET_TOGGLER_ITEM]}`, { id, status })
    }

    return {
        open,
        activeItem,
        toggleActiveItem
    }

}