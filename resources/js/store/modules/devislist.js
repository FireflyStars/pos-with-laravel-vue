import {  DEVISLIST_LOAD_TAB, DEVISLIST_SET_LIST, DEVIS_LIST_MODULE, DISPLAY_LOADER, GET_DEVIS_LIST_DEF, HIDE_LOADER, LOADER_MODULE } from "../types/types";

export const devislist= {
    namespaced:true,
    state: {
      
        table_def: {
            column_filters:[],//required empty array
            store:{
              MODULE:DEVIS_LIST_MODULE,//required
              INIT:DEVISLIST_LOAD_TAB,//required
            },
            batch_actions:{
                delete:{
                    name:"Delete",
                    route:"DeleteDevis",
                    type:'button'
                },
                status:{
                    type:"component"
                }

            },
            translations:{
              group_item:'devis',
              group_items:'devis',
              footer_item:'ITEM',
              footer_items:'ITEMS'
            },
            item_route_name:"DevisDetail",// the route to trigger when a line is click 
            max_per_page:10,//required          
            identifier:"devislist_all",//required
            filter:"true",// required boolean
            grouped_rows:false,// required boolean
            grouped_rows_def:{},//required empty object is grouping is not required
            rearrange_columns:true,// required boolean
            columns_def:[
                {
                    id:"id",
                    display_name:"",
                    type:"checkbox",
                    class:"",
                    header_class:"",
                    event:``,   
                    sort:false,
                    filter:false,
                    css:{
                      flex:0.5
                    },
                  } , 
               {
                 id:"id",
                 display_name:"No DEVIS",
                 type:"string",
                 class:"",
                 header_class:"",
                 event:null,   
                 sort:true,
                 filter:true,
                 table:'orders',
               },     
               
              {
                id:"customer",
                display_name:"CLIENT",
                type:"string",
                class:"",
                header_class:"",
                event:null,
                sort:true,
                filter:true,   
                having:true
              },
              {
                id:"contact",
                display_name:"CONTACT",
                type:"html",
                class:"",
                header_class:"",
                event:null,
                sort:true,
                filter:true,   
                having:true
              },
              {
                id:"address",
                display_name:"CHANTIER",
                type:"html",
                class:"",
                header_class:"",
                event:null,
                sort:true,
                filter:true,   
                having:true
              },
              {
                id:"created_at",
                display_name:"DATE CREATION",
                type:"date",
                format:"DD/MM/YY",
                class:"",
                header_class:"",
                event:null,
                sort:true,
                filter:true,   
                table:'orders'
              },
 
              {
                id:"responsable",
                display_name:"RESPONSABLE",
                type:"string",
                class:"",
                header_class:"",
                event:null,
                sort:true,
                filter:true,   
                having:true,
                filter_options:[]
              },
              {
                id:"order_state_id",
                display_name:"STATUS",
                type:"component",
                class:"",
                header_class:"",
                event:null,
                sort:true,
                filter:true,   
                filter_options:[]
              },
              {
                id:"action_co",
                display_name:"ACTION CO",
                type:"html",
                class:"",
                header_class:"",
                event:null,
                sort:true,
                filter:true,   
                having:true

              },
              {
                id:"mo",
                display_name:"MO",
                type:"string",
                class:"",
                header_class:"",
                event:null,
                sort:true,
                filter:true, 
                having:true  
 
              },
              {
                id:"montant",
                display_name:"MONTANT",
                type:"price",
                class:"justify-content-center",
                header_class:"",
                event:null,
                sort:true,
                filter:true,   
 
              },
            ]

            

        },
        
    },
    mutations: {
      [DEVISLIST_SET_LIST]:(state,list)=>{
        state.list=list;
      }
    },
    actions: {
      [DEVISLIST_LOAD_TAB]:async({commit,state,dispatch},params)=>{
 
        return axios.post(`/get-devis-list`,params).then((response)=>{
          return  Promise.resolve(response);
                
        }).catch((error)=>{
          return  Promise.resolve(error);
        });
    },
    },
    getters: {
        [GET_DEVIS_LIST_DEF]: state => state.table_def,
    }
}