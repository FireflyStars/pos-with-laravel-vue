export const devislist= {
    namespaced:true,
    state: {
        table_def: {
            identifier:"devislist_all",
            filter:"true",
            grouped_rows:false,
            grouped_rows_def:{

            },
            rearrange_columns:true,
            columns_def:[
                {
                    id:"numdevis",
                    display_name:"",
                    type:"checkbox",
                    class:"",
                    event:``,   
                    sort:false,
                    filter:false,
                  } , 
               {
                 id:"numdevis",
                 display_name:"No DEVIS",
                 type:"string",
                 class:"",
                 event:null,   
                 sort:true,
                 filter:true,
               },     
               {
                id:"new",
                display_name:"",
                type:"iconsvg",
                class:"",
                icons:{
                    0:"",
                    1:""    
                },
                event:null,
                sort:true,
                filter:true,   
              } ,    
              {
                id:"customer",
                display_name:"CLIENT",
                type:"string",
                class:"",
                event:null,
                sort:true,
                filter:true,   
              },
              {
                id:"contact",
                display_name:"CONTACT",
                type:"html",
                class:"",
                event:null,
                sort:true,
                filter:true,   
              },
              {
                id:"address",
                display_name:"CHANTIER",
                type:"html",
                class:"",
                event:null,
                sort:true,
                filter:true,   
              },
              {
                id:"created_at",
                display_name:"DATE CREATION",
                type:"date",
                class:"",
                event:null,
                sort:true,
                filter:true,   
              },
              {
                id:"responsable",
                display_name:"RESPONSABLE",
                type:"string",
                class:"",
                event:null,
                sort:true,
                filter:true,   
                filter_options:[]
              },
              {
                id:"order_state",
                display_name:"STATUS",
                type:"tag",
                class:"",
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
                event:null,
                sort:true,
                filter:true,   

              },
              {
                id:"mo",
                display_name:"MO",
                type:"string",
                class:"",
                event:null,
                sort:true,
                filter:true,   
 
              },
              {
                id:"montant",
                display_name:"MONTANT",
                type:"string",
                class:"",
                event:null,
                sort:true,
                filter:true,   
 
              },
            ]

            

        },
        
    },
    mutations: {
        //[SET_SHOW_LOADER]: (state, payload) => state.show_loader = payload,
        //[SET_LOADER_MSG]: (state, payload) => state.loader_msg = payload
    },
    actions: {
        //[DISPLAY_LOADER]: ({commit}, payload) => {
        //    commit(SET_SHOW_LOADER, payload[0]);
        //    if (typeof payload[1] != "undefined")
         //       commit(SET_LOADER_MSG, payload[1]);

      //  },
      //  [HIDE_LOADER]: ({commit}) => {
      //      commit(SET_SHOW_LOADER, false);
      //      commit(SET_LOADER_MSG, 'Chargement en cours, veuillez patienter...');
      //  }
    },
    getters: {
        [GET_TABLE_DEF]: state => state.table_def,
      //  [GET_LOADER_MSG]: state => state.loader_msg,
    }
}