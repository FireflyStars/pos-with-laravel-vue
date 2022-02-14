import { computed } from 'vue'
import { useStore } from 'vuex'

export default function useToggler() {

    const activeItem = computed(() => store.getters[`${[TOGGLER_MODULE]}/${[ACTIVE_ITEM]}`])

    const open = (id) => {
        return id == activeItem.value.id && activeItem.value.status
    }

    const toggleActiveItem = () => {
        const status = !activeItem.value.status
        store.dispatch(`${[TOGGLER_MODULE]}/${[SET_TOGGLER_ITEM]}`, { id: 'filter', status })
    }

    return {
        open,
        toggleActiveItem
    }

}