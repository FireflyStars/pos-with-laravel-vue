import {
    SET_SELECTED_BOXES,
    GET_SELECTED_BOXES,
    RESET_FILTER
} from '../types/types'

export const filter = {
    namespaced: true,
    state: {
        selected_items: [],
    },
    mutations: {
        [SET_SELECTED_BOXES]: (state, payload) => {

            const index = state.selected_items.findIndex(object => object.id === payload.id);

            if (index === -1) {
                state.selected_items.push(payload);
            } else {
                state.selected_items.splice(index, 1);
            }


        },
        [RESET_FILTER]: (state) => state.selected_items = [],
    },
    actions: {
        SET_SELECTED_BOXES: (context, payload) => context.commit(SET_SELECTED_BOXES, payload),
        RESET_FILTER: context => context.commit(RESET_FILTER)

    },
    getters: {
        [GET_SELECTED_BOXES]: state => state.selected_items,

    }
}
