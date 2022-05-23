
import { 
    
    SET_SEARCH,
    SET_LOADING,
    GET_SEARCH_RESULTS,
    SET_SEARCH_RESULTS,
    SEARCH_MORE,
    APPEND_SEARCH,
    INCREMENT_ITERATION,
    RESET_SEARCH

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
        iteration: {
            customers: 0,
            contacts: 0,
            orders: 0,
            events: 0
        },
        limitReached: {
            customers: false,
            contacts: false,
            orders: false,
            events: false,
        }
    },

    getters: {
        loading: state => state.loading,
        search: state => state.search,
        results: state => state.results,
        iteration: state => state.iteration,
        limitReached: state => state.limitReached
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
        },
        [INCREMENT_ITERATION](state, action) {
            state.iteration[action]++
        },
        [APPEND_SEARCH](state, { data, action }) {
            if(data.length) state.results[action].push(...data)
            else state.limitReached[action] = true
        },
        [RESET_SEARCH](state) {
            state.iteration =  {
                customers: 0,
                contacts: 0,
                orders: 0,
                events: 0
            }
            state.limitReached =  {
                customers: false,
                contacts: false,
                orders: false,
                events: false,
            }
            state.results = []
        }
    },

    actions: {

        async [GET_SEARCH_RESULTS]({ state, commit }) {
            if(_.isEmpty(state.search)) return
            commit(RESET_SEARCH)
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

        async [SEARCH_MORE]({ state, commit }, action) {

            if(_.isEmpty(state.search)) return 
            if(state.limitReached[action]) return

            await commit(INCREMENT_ITERATION, action)

            try {

                commit(SET_LOADING, { id: `search-append-${action}`, value: true })

                const { data } = await axios.get('/search-append', {
                    params: {
                        search: state.search,
                        action,
                        skip: state.iteration[action]
                    }
                })

                commit(APPEND_SEARCH, { data, action })

                commit(SET_LOADING, { id: `search-append-${action}`, value: false })


            }

            catch(e) {
                commit(SET_LOADING, { id: `search-append-${action}`, value: false  })
                throw e
            }

        }

    }

}