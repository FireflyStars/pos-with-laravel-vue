import axios from 'axios';
import {
    TOASTER_MESSAGE,
    TOASTER_GET_ALL,
    TOASTER_ADD_TOAST, TOASTER_REMOVE_TOAST, CIBLE_SET_CAMPAGNE_CATEGORY_ID, CIBLE_INIT,CIBLE_SET_CUSTOMER_STATUT, CIBLE_SET_NAF, CIBLE_SET_PREVIOUS_CAMPAGNE_LIST, CIBLE_GET_CUSTOMER_STATUT, CIBLE_GET_NAF, CIBLE_TOGGLE, CIBLE_SET_SELECTION, CIBLE_UNSET_SELECTION, CIBLE_GET_SELECTION, HIDE_LOADER, LOADER_MODULE, DISPLAY_LOADER, CIBLE_ADD_TO_ALL_CONTACTS, CIBLE_GET_ALL_CONTACTS, CIBLE_GET_PREVIOUS_CAMPAGNE_LIST, CIBLE_CAMPAGNE_TOGGLE, CIBLE_SET_CAMPAGNE_SELECTION, CIBLE_UNSET_CAMPAGNE_SELECTION, CIBLE_GET_CAMPAGNE_SELECTION
} from '../types/types';

export const cible= {
    namespaced:true,

    state:{
      campagne_category_id:0, 
      checked:[], 
      checkedCampagne:[], 
      customer_statut:[],
      naf:[],
      previous_campagne:[],

      // all contacts with doubles
      all_contacts:[],

      // emails from previous campagne
        previous_campagnes_emails:[ 
                    {
                        'campagnesxx':[ 
                                        {
                                            name:'john doe',
                                            customer_id:'',
                                            email:'',    
                                        }
                        ]
                    }
                ],

            // unselected customer_id
            unselected:[],       
       
            //final email list
            filtered_emails:[
                {
                    name:'john doe',
                    customer_id:'',
                    email:'',    
                  }
              ]
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
       /* [TOASTER_ADD_TOAST]: (state, payload) => {
           // state.toast.unshift(payload);
            state.toast.push(payload);
            state.auto_id=payload.id;
            },
        [TOASTER_REMOVE_TOAST]:(state,payload)=>{
            state.toast=state.toast.filter((item)=>item.id!=payload);
        }*/
    },
    actions:{
        [CIBLE_INIT]:({commit,state},campagne_category_id)=>{
            commit(CIBLE_SET_CAMPAGNE_CATEGORY_ID,campagne_category_id);  
            axios.get(`/cible/load/${state.campagne_category_id}`).then((response)=>{
                console.log(response.data);
                    commit(CIBLE_SET_CUSTOMER_STATUT,response.data.customer_statut);
                    commit(CIBLE_SET_NAF,response.data.naf);
                    commit(CIBLE_SET_PREVIOUS_CAMPAGNE_LIST,response.data.campagne_list);
            
            }).catch((error)=>{

            }).finally(()=>{

            });
        },
        [CIBLE_TOGGLE]:({commit,state,dispatch},payload)=>{

                const checked = state.checked.filter(obj => obj.naf== payload.naf&&obj.statut==payload.statut);
                if(checked.length===0){
                    commit(CIBLE_SET_SELECTION,payload);
                    dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [true, 'Chargement des cibles en cours...'], {root: true});
            
                    axios.get(`/cible/loadcible/${payload.naf}/${payload.statut}`).then((response)=>{
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
    }
}