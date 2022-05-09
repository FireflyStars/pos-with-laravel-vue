import { 
    GET_SEARCH_RESULTS,
    SET_SEARCH_RESULTS,
    SET_LOADING
} from '../types/types'

import axios from 'axios'

export const mainSearch = {

    namespaced: true,
    
    state: {
        search: null,
        results: [],
        loading: {
            id: '',
            value: ''
        },
    },

    getters: {
        loading: state => state.loading,
        search: (state) => state.search,
        results: (state) => state.results,
    },
    
    mutations: {
        [SET_LOADING](state, { id = 'search', value = true }) {
            state.loading.id = id
            state.loading.value = value
        },
        [SET_SEARCH_RESULTS](state, data) {
            state.results = data
        }
    },

    actions: {

        async [GET_SEARCH_RESULTS]({ state, commit }) {
            try {
                commit(SET_LOADING, { id: 'search', value: true })
                const { data } = await axios.get('/search', {
                    search: state.search
                })
                commit(SET_SEARCH_RESULTS, data)
                commit(SET_LOADING, { value: false, id: 'search' })
            }
            catch(e) {
                commit(SET_LOADING, { value: false, id: 'search' }) 
                throw e
            }
        },

    }

}