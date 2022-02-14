import { ACTIVE_ITEM, SET_TOGGLER_ITEM } from "../types/types"

export const toggler = {
    namespaced: true,
    state: {
        activeItem: {
            id: '',
            status: false
        }
    },
    getters: {
        [ACTIVE_ITEM]: state => state.activeItem
    },
    mutations: {
        [SET_TOGGLER_ITEM](state, { id, status }) {
            state.activeItem.id = id.toString().toLowerCase()
            state.activeItem.status = status
        }
    },
    actions: {
        [SET_TOGGLER_ITEM]({ commit }, payload) {
            commit(SET_TOGGLER_ITEM, payload)
        }
    }
}