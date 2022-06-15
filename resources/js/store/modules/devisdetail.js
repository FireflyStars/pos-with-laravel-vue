import {DEVIS_DETAIL_LOAD, DEVIS_DETAIL_GET, DEVIS_DETAIL_SET} from '../types/types'

export const devisdetail= {
    namespaced:true,
    state: {
        order:{}
    },
    mutations: {
        [DEVIS_DETAIL_SET]:(state,order)=>state.order=order,
    },
    actions: {
        [DEVIS_DETAIL_LOAD]:async({commit},order_id)=>{
            return axios.post(`/get-order-detail`,{order_id:order_id}).then((response)=>{
                commit(DEVIS_DETAIL_SET,response.data);
                return  Promise.resolve(response);
                      
              }).catch((error)=>{
                return  Promise.resolve(error);
              });
        }
 
    },
    getters: {
        [DEVIS_DETAIL_GET]: state => state.order,
    }
}