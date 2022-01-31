import {
    SET_SELECTED_BOXES,
    GET_SELECTED_BOXES,
    RESET_FILTER,
    SET_ITEMS,
    GET_ITEMS,
} from '../types/types'

export const filter = {
    namespaced: true,
    state: {
        selected_items: [],
        items: []
    },
    mutations: {
        [SET_ITEMS]: (state, payload) => state.items = payload,

        [SET_SELECTED_BOXES]: (state, payload) => {

            const index = state.selected_items.findIndex(object => object.id === payload.id);
            console.log(index);
            if (index === -1 && payload.value !== '') {
                state.selected_items.push(payload);

            } else {
                state.selected_items.splice(index, 1);
                // console.log(state.items[index]);

            }


        },
        [RESET_FILTER]: (state) => {
            state.selected_items = []
            state.items.forEach(element => {
                element.options.forEach(option => {
                    option.check = false;

                });

            });
        },
    },
    actions: {
        SET_ITEMS: (context, payload) => context.commit(SET_ITEMS, payload),
        SET_SELECTED_BOXES: (context, payload) => context.commit(SET_SELECTED_BOXES, payload),
        RESET_FILTER: context => context.commit(RESET_FILTER)

    },
    getters: {
        [GET_ITEMS]: state => state.items,
        [GET_SELECTED_BOXES]: state => state.selected_items,

    }
}
