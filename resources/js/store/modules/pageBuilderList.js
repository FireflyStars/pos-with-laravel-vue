
import {
    BUILDER_MODULE_LIST,
    GET_REPORT_TEMPLATES,
    SAVE_REPORT_TEMPLATES
}
from '../types/types'

export const pageBuilderList = {

    namespaced: true,

    state: {
        table_def: {

            column_filters: [],//required empty array
            store: {
              MODULE: BUILDER_MODULE_LIST,//required
              INIT: GET_REPORT_TEMPLATES,//required
            },
            batch_actions: {
                delete: {
                    name: "Delete",
                    route: "DeleteDevis",
                    type: 'button'
                },
                status: {
                    type: "component"
                }

            },
            translations: {
              group_item: 'devis',
              group_items: 'devis',
              footer_item: 'ITEM',
              footer_items: 'ITEMS',
              no_batch_action: "Aucune action par lot n'est disponible.",
            },
            highlight_row: {
                  where: [
                    { col: 'id', value: 10 },
                    { col: 'nbheure', value: 6},
                  ], 
                  backgroundColor: '#f7c5af',
                  color: '#fd3b35'
                }
            ,
            item_route_name: "",// the route to trigger when a line is click 
            max_per_page: 10,//required          
            identifier: "templates_list_all",//required
            filter: true,// required boolean
            rearrange_columns: true,// required boolean
            columns_def: [
                {
                    id: "id",
                    display_name: "",
                    type: "checkbox",
                    class: "",
                    header_class: "",
                    sort: false,
                    filter: false,
                    css: {
                      flex: 0.5
                    },
                }, 
                {
                    id: "id",
                    display_name: "Template id",
                    type: "string",
                    class: "",
                    header_class: "",
                    sort: true,
                    filter: true,
                    prefix: "",
                    suffix: "",
                },     
                {
                    id: "name",
                    display_name: "Name",
                    type: "string",
                    class: "",
                    header_class: "",
                    sort: true,
                    filter: true,   
                    having: true,
                    prefix: "",
                    suffix: "",
                },
        
          
            ]

        },
    },
    getters: {
        templateListDefinition: state => state.table_def
    },

    actions: {

        async [GET_REPORT_TEMPLATES]({ commit }, params) {


            return axios.get(`/report-templates`, params).then((response) => {
                return Promise.resolve(response.data);
                      
            }).catch((error)=>{
                return  Promise.resolve(error);
            });


        },

    }
}