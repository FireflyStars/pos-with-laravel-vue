import {
    SET_SELECTED_BOXES,
    GET_SELECTED_BOXES
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
    },
    actions: {
        SET_SELECTED_BOXES: (context, payload) => context.commit(SET_SELECTED_BOXES, payload),

    },
    getters: {
        [GET_SELECTED_BOXES]: state => state.selected_items,

    }
}
