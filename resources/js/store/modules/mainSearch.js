import { 
    SET_SEARCH,
    SET_LOADING,
    GET_SEARCH_RESULTS,
    SET_SEARCH_RESULTS,
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
        [SET_LOADING](state, { id, value }) {
            state.loading.id = id
            state.loading.value = value
        },
        [SET_SEARCH_RESULTS](state, data) {
            state.results = data
        },
        [SET_SEARCH](state, value) {
            state.search = value
        }
    },

    actions: {

        async [GET_SEARCH_RESULTS]({ state, commit }) {
            if(_.isEmpty(state.search)) return
            try {
                commit(SET_LOADING, { id: 'search', value: true })
                const { data } = await axios.get('/search', {
                    params: {
                        search: state.search
                    }
                })
                commit(SET_SEARCH_RESULTS, data)
                commit(SET_LOADING, { id: 'search', value: false  })
            }
            catch(e) {
                commit(SET_LOADING, { id: 'search', value: false  }) 
                throw e
            }
        },

    }

}