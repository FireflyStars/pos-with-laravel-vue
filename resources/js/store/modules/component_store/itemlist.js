import { ITEM_LIST_FILTER, ITEM_LIST_GET_COLUMN_FILTERS, ITEM_LIST_GET_CURRENT, ITEM_LIST_GET_FILTERS, ITEM_LIST_GET_LISTS, ITEM_LIST_GET_TABLES, ITEM_LIST_SELECT_CURRENT, ITEM_LIST_SET_CURRENT, ITEM_LIST_SET_LIST, ITEM_LIST_SET_TABLEDEF, ITEM_LIST_TABLEDEF, ITEM_LIST_TABLE_RELOAD, ITEM_LIST_UPDATE_FILTER } from "../../types/types";

export const itemlist= {
    namespaced:true,
    state: {
        tables:{},
        lists:{},
        column_filters:{},
        filters:{},
        paginations:{},
        sortings:{},
        currentchecked:{},
        multichecked:{}
    },
    mutations: {
      [ITEM_LIST_UPDATE_FILTER]:(state,params)=>{
            if(typeof state.column_filters[params.identifier]=="undefined")
            state.column_filters[params.identifier]=[];

            let filter=state.column_filters[params.identifier].filter(obj=>obj.id==params.filter.id)
       
            if(filter.length===0)
            state.column_filters[params.identifier].push(params.filter);

            if(params.filter.word=='')
            state.column_filters[params.identifier]=state.column_filters[params.identifier].filter(obj=>obj.id!=params.filter.id);
      }, 
      [ITEM_LIST_SET_TABLEDEF]:(state,table)=>{
          state.tables[table.table_def.identifier]=table;
        },
      [ITEM_LIST_SET_LIST]:(state,params)=>{
          if(params.fullreload){
            state.lists[params.identifier]=params.lists;
          }else{
            state.lists[params.identifier]=state.lists[params.identifier].concat(params.lists);
          }
      },
      [ITEM_LIST_SET_CURRENT]:(state,params)=>{
            state.currentchecked[params.identifier]=params.current;
      },  
    },
    actions: {
        [ITEM_LIST_SELECT_CURRENT]:({commit,state,dispatch},params)=>{
            commit(`${ITEM_LIST_SET_CURRENT}`,params);

            let bodytag=document.getElementsByTagName( 'body' )[0]
            if(params.current==''){
                bodytag.className='';
            }else{
                bodytag.classList.add('hide-overflowY');
            }
        },
        [ITEM_LIST_TABLEDEF]:({commit,state,dispatch},table)=>{
            commit(`${ITEM_LIST_SET_TABLEDEF}`,table);

            dispatch(`${table.table_def.store.MODULE}${table.table_def.store.INIT}`,{},{root: true}).then((response)=>{
                commit(`${ITEM_LIST_SET_LIST}`,{identifier:table.table_def.identifier,lists:response.data,fullreload:true});
            });

        },
        [ITEM_LIST_TABLE_RELOAD]:({commit,state,dispatch},params)=>{
            dispatch(`${state.tables[params.identifier].table_def.store.MODULE}${state.tables[params.identifier].table_def.store.INIT}`,
            {
              column_filters:state.column_filters[params.identifier],

            },{root: true}).then((response)=>{
       
                    commit(`${ITEM_LIST_SET_LIST}`,{identifier:params.identifier,lists:response.data,fullreload:params.fullreload});
                
             
                
            });

        },
        [ITEM_LIST_FILTER]:({commit,state,dispatch},params)=>{
            
            params.col.word=params.word;
            const filter= params.col;
            commit(`${ITEM_LIST_UPDATE_FILTER}`,{filter:filter,identifier:params.identifier});
        }
    },
    getters: {
        [ITEM_LIST_GET_TABLES]:state=>state.tables,
        [ITEM_LIST_GET_LISTS]:state=>state.lists,
        [ITEM_LIST_GET_COLUMN_FILTERS]:state=>state.column_filters,
        [ITEM_LIST_GET_CURRENT]:state=>state.currentchecked,
    }
}