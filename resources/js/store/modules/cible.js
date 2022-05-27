import axios from 'axios';
import { resolveDirective } from 'vue';
import {
    TOASTER_MESSAGE,
    TOASTER_GET_ALL,
    TOASTER_ADD_TOAST, TOASTER_REMOVE_TOAST, CIBLE_SET_CAMPAGNE_CATEGORY_ID, CIBLE_INIT,CIBLE_SET_CUSTOMER_STATUT, CIBLE_SET_NAF, CIBLE_SET_PREVIOUS_CAMPAGNE_LIST, CIBLE_GET_CUSTOMER_STATUT, CIBLE_GET_NAF, CIBLE_TOGGLE, CIBLE_SET_SELECTION, CIBLE_UNSET_SELECTION, CIBLE_GET_SELECTION, HIDE_LOADER, LOADER_MODULE, DISPLAY_LOADER, CIBLE_ADD_TO_ALL_CONTACTS, CIBLE_GET_ALL_CONTACTS, CIBLE_GET_PREVIOUS_CAMPAGNE_LIST, CIBLE_CAMPAGNE_TOGGLE, CIBLE_SET_CAMPAGNE_SELECTION, CIBLE_UNSET_CAMPAGNE_SELECTION, CIBLE_GET_CAMPAGNE_SELECTION, CIBLE_SET_UNIQUE_CONTACTS, CIBLE_GET_UNIQUE_CONTACTS, CIBLE_GET_UNSELECTED_EMAILS, CIBLE_SET_UNSELECTED_EMAIL, CIBLE_UNSET_UNSELECTED_EMAIL, CIBLE_GET_FILTERED_EMAILS, CIBLE_SET_FILTERED_EMAILS, CIBLE_SET_PRICE, CIBLE_GET_PRICE, CIBLE_CREATE_CAMPAGNE, TOASTER_MODULE, CIBLE_SET_CAMPAGNE_CATEGORY, CIBLE_GET_CAMPAGNE_CATEGORY, CIBLE_RESET_STATE,
    GET_CAMPAGNE_CATEGORY,
    SAVE_CAMPAGNE_CATEGORY
} from '../types/types';

export const cible= {
    namespaced:true,

    state:{
        campagne_category:{},
        campagne_category_id:0, 
        price:0,
        checked:[], 
        checkedCampagne:[], 
        customer_statut:[],
        naf:[],
        previous_campagne:[],

        // all contacts with doubles
        all_contacts:[],

        //contact without double
        unique_contacts:[],  

        // unselected emails
        unselected:[],       

        //final email list
        filtered_emails:[]
    },
    mutations:{
        [CIBLE_SET_CAMPAGNE_CATEGORY_ID]:(state,id)=>{
            state.campagne_category_id=id;
        },
        [CIBLE_SET_CUSTOMER_STATUT]:(state,customer_statut)=>{
           state.customer_statut=customer_statut;     
        },
        [CIBLE_SET_NAF]:(state,naf)=>{
            state.naf=naf;     
         }
         ,
        [CIBLE_SET_PREVIOUS_CAMPAGNE_LIST]:(state,campagne_list)=>{
            state.previous_campagne=campagne_list;     
         },
         [CIBLE_SET_SELECTION]:(state,payload)=>{
            state.checked.push(payload);  
         }
         ,
         [CIBLE_UNSET_SELECTION]:(state,payload)=>{
            state.checked=state.checked.filter(obj => !(obj.naf=== payload.naf&&obj.statut===payload.statut));
            state.all_contacts=state.all_contacts.filter(obj => !(obj.naf=== payload.naf&&obj.statut===payload.statut));
         },
         [CIBLE_ADD_TO_ALL_CONTACTS]:(state,payload)=>{
            state.all_contacts.push(payload);  
         },
         [CIBLE_SET_CAMPAGNE_SELECTION]:(state,payload)=>{
           
            state.checkedCampagne.push(payload);  
            const campagne=state.previous_campagne.filter(obj => (obj.id=== payload.campagne_id));
            state.all_contacts.push(campagne[0]); 
          
         }
         ,
         [CIBLE_UNSET_CAMPAGNE_SELECTION]:(state,payload)=>{
            state.checkedCampagne=state.checkedCampagne.filter(obj => !(obj.campagne_id=== payload.campagne_id));
            state.all_contacts=state.all_contacts.filter(obj => !(obj.id=== payload.campagne_id));
         },
         [CIBLE_SET_UNIQUE_CONTACTS]:(state,payload)=>{
             state.unique_contacts=payload;
         },
         [CIBLE_SET_UNSELECTED_EMAIL]:(state,email)=>{
             state.unselected.push(email);
         },
         [CIBLE_UNSET_UNSELECTED_EMAIL]:(state,email)=>{
            state.unselected=state.unselected.filter(unselected_email=>unselected_email!=email);
         },
         [CIBLE_SET_FILTERED_EMAILS]:(state,filtered_contacts)=>{
             state.filtered_emails=filtered_contacts;
         },
         [CIBLE_SET_PRICE]:(state,price)=>{
             state.price=price;
         },
         [CIBLE_SET_CAMPAGNE_CATEGORY]:(state,campagne_category)=>{
            state.campagne_category=campagne_category;
         },
         [CIBLE_RESET_STATE]:(state)=>{
            state.campagne_category={};
            state.campagne_category_id=0; 
            state.price=0;
            state.checked=[]; 
            state.checkedCampagne=[];
            state.customer_statut=[];
            state.naf=[];
            state.previous_campagne=[];
            state.all_contacts=[];
            state.unique_contacts=[];  
            state.unselected=[];       
            state.filtered_emails=[];
         },
       /* [TOASTER_ADD_TOAST]: (state, payload) => {
           // state.toast.unshift(payload);
            state.toast.push(payload);
            state.auto_id=payload.id;
            },
        [TOASTER_REMOVE_TOAST]:(state,payload)=>{
            state.toast=state.toast.filter((item)=>item.id!=payload);
        }*/
        [SAVE_CAMPAGNE_CATEGORY](state, category) {
            state.campagne_category = category
        }
    },
    actions:{

        async [GET_CAMPAGNE_CATEGORY]({ commit }, id) {

            try {
                const { data } = await axios.get(`get-campagne-category/${id}`)
                commit(SAVE_CAMPAGNE_CATEGORY, data)
            }

            catch(e) {
                throw e
            }

        },

        [CIBLE_CREATE_CAMPAGNE]:async({commit,state,dispatch})=>{
     
            if(state.filtered_emails.length==0){
                dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,{message: "Aucun emails dans votre liste.",ttl: 5,type: 'danger'}, {root: true});
            }else{

            dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [true, 'Creation nouvelle campagne en cours...'], {root: true});
         
            return axios.post(`/cible/createcampagne`,{
                campagne_category_id:state.campagne_category_id,
                contacts:state.filtered_emails
            }).then((response)=>{
                    return  Promise.resolve(response);
            }).catch((error)=>{
                return Promise.reject(error);
            }).finally(()=>{
                dispatch(`${LOADER_MODULE}${HIDE_LOADER}`,{},{root:true});
            });
            }
        },
        [CIBLE_INIT]:({commit,state,dispatch},campagne_category_id)=>{
        
            dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [true, 'Veuillez patienter. Chargement en cours...'], {root: true});
            commit(CIBLE_SET_CAMPAGNE_CATEGORY_ID,campagne_category_id);  
            axios.get(`/cible/load/${state.campagne_category_id}`).then((response)=>{
       
                    commit(CIBLE_SET_CUSTOMER_STATUT,response.data.customer_statut);
                    commit(CIBLE_SET_NAF,response.data.naf);
                    commit(CIBLE_SET_PREVIOUS_CAMPAGNE_LIST,response.data.campagne_list);
                    commit(CIBLE_SET_PRICE,response.data.campagne_category.price);
                    commit(CIBLE_SET_CAMPAGNE_CATEGORY,response.data.campagne_category);
                    
            }).catch((error)=>{

            }).finally(()=>{
                dispatch(`${LOADER_MODULE}${HIDE_LOADER}`,{},{root:true});
            });
        },
        [CIBLE_TOGGLE]:({commit,state,dispatch},payload)=>{

                const checked = state.checked.filter(obj => obj.naf== payload.naf&&obj.statut==payload.statut);
                if(checked.length===0){
                    commit(CIBLE_SET_SELECTION,payload);
                    dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [true, 'Chargement des cibles en cours...'], {root: true});
            
                    axios.get(`/cible/loadcible/${payload.naf}/${payload.statut}/${payload.type}`).then((response)=>{
                     commit(CIBLE_ADD_TO_ALL_CONTACTS,{ 
                        statut:payload.statut,
                        naf:payload.naf,
                        contacts:response.data
                        });
                
                }).catch((error)=>{
    
                }).finally(()=>{
                    dispatch(`${LOADER_MODULE}${HIDE_LOADER}`,{},{root:true});
                });
                }else{
                   commit(CIBLE_UNSET_SELECTION,payload);
                }
               
        },
        [CIBLE_CAMPAGNE_TOGGLE]:({commit,state,dispatch},payload)=>{
            const checkedCampagne = state.checkedCampagne.filter(obj => obj.campagne_id== payload.campagne_id);
            if(checkedCampagne.length===0){
                commit(CIBLE_SET_CAMPAGNE_SELECTION,payload);
            }else{
                commit(CIBLE_UNSET_CAMPAGNE_SELECTION,payload);  
            }
        },
        /*
        [TOASTER_MESSAGE]:({commit,state}, payload)=>{
            payload.id=state.auto_id+1;
            commit(TOASTER_ADD_TOAST,payload);
            if(payload.ttl>0)
            setTimeout(()=>{commit(TOASTER_REMOVE_TOAST,payload.id)},(payload.ttl*1000));
        },
        */
    },
    getters:{
        [CIBLE_GET_CUSTOMER_STATUT]:state=>state.customer_statut,
        [CIBLE_GET_NAF]:state=>state.naf,
        [CIBLE_GET_SELECTION]:state=>state.checked,
        [CIBLE_GET_ALL_CONTACTS]:state=>state.all_contacts,
        [CIBLE_GET_PREVIOUS_CAMPAGNE_LIST]:state=>state.previous_campagne,
        [CIBLE_GET_CAMPAGNE_SELECTION]:state=>state.checkedCampagne,
        [CIBLE_GET_UNIQUE_CONTACTS]:state=>state.unique_contacts,
        [CIBLE_GET_UNSELECTED_EMAILS]:state=>state.unselected,
        [CIBLE_GET_FILTERED_EMAILS]:state=>state.filtered_emails,
        [CIBLE_GET_PRICE]:state=>state.price,
        [CIBLE_GET_CAMPAGNE_CATEGORY]:state=>state.campagne_category,
        campagneCategory: state => state.campagne_category 
    }
}