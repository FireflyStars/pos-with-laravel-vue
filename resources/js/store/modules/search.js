import {
    CUSTOMER_SEARCH_LOAD_LIST,
    CUSTOMER_SET_SEARCH_LIST,
    CUSTOMER_GET_SEARCH_LIST,
    CUSTOMER_SET_SEARCH_COUNT,
    CUSTOMER_GET_SEARCH_COUNT,
    CUSTOMER_SET_LOADER,
} from "../types/types";
import axios from 'axios';

export const search= {
    namespaced:true,
  
    state:{
        loader:'',
        countcustomers:'',
        listsearchcustomers:[],
    },
    mutations: {
        [CUSTOMER_SET_LOADER]: (state, payload) => state.loader = payload,
        [CUSTOMER_SET_SEARCH_LIST]: (state,payload) =>state.listsearchcustomers=payload,
        [CUSTOMER_SET_SEARCH_COUNT]: (state,payload) =>state.countcustomers=payload,
    },
    actions: {
        [CUSTOMER_SEARCH_LOAD_LIST]:async ({commit,state}, payload )=>{
            commit(CUSTOMER_SET_LOADER,'animate40');

            if(typeof payload != "undefined" && payload.showmore)
            {
                state.PerPage = parseInt(state.PerPage) + 10;
            }else{
                state.PerPage = '4';
            }
            
            return axios.post('/SearchByCustomer', {
                query: payload.query,
            })
            .then( (response)=>{
                if(response.data!=null){
                    commit(CUSTOMER_SET_SEARCH_LIST ,response.data.data);
                    commit(CUSTOMER_SET_SEARCH_COUNT ,(response.data.total - state.PerPage));
                }
                return Promise.resolve(response);
            })
            .catch((error)=>{
                return Promise.reject(error);
            }).finally(()=>{
                commit(CUSTOMER_SET_LOADER,'animate40 animate100');
            });
        }
    },
    getters: {
        [CUSTOMER_GET_SEARCH_LIST]:state=>state.listsearchcustomers,
        [CUSTOMER_GET_SEARCH_COUNT]:state=>state.countcustomers,
    }
}