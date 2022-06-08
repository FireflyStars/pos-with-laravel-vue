
import {
    REPORTS_BUILDER_MODULE,
    GET_REPORTS,
}
from '../types/types'

export const reportsBuilderList = {

    namespaced: true,

    state: {
        table_def: {

            column_filters: [],//required empty array
            store: {
              MODULE: REPORTS_BUILDER_MODULE,//required
              INIT: GET_REPORTS,//required
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
                    // { col: 'id', value: 10 }, example
                  ], 
                  backgroundColor: '#f7c5af',
                  color: '#fd3b35'
                }
            ,
            item_route_name: "",// the route to trigger when a line is click 
            max_per_page: 10,//required          
            identifier: "report_list_all",//required
            filter: true,// required boolean
            rearrange_columns: true,// required boolean
            columns_def: [
                {
                    id: "id",
                    display_name: "",
                    type: "checkbox",
                    class: "text-center",
                    header_class: "",
                    sort: false,
                    filter: false,
                    css: {
                        flex: 0.5
                    }
                }, 
                {
                    id: "template_name",
                    display_name: "Template name",
                    type: "string",
                    class: "text-center",
                    header_class: "",
                    sort: true,
                    filter: true,   
                    prefix: "",
                    suffix: "",
                },
                {
                    id: "affiliate",
                    display_name: "Affiliate",
                    type: "string",
                    class: "text-center",
                    header_class: "",
                    sort: true,
                    filter: true,   
                    prefix: "",
                    suffix: "",
                },
                {
                    id: "pages",
                    display_name: "Pages",
                    type: "component",
                    class: "text-center",
                    header_class: "",
                    sort: true,
                    filter: true,   
                    prefix: "",
                    suffix: "",
                },
                {
                    id: "created_at",
                    display_name: "Created At",
                    type: "date",
                    class: "text-center",
                    header_class: "",
                    sort: true,
                    filter: true,   
                    prefix: "",
                    suffix: "",
                },
                {
                    id: "id",
                    display_name: "Action",
                    type: "component",
                    class: "text-center",
                    header_class: "",
                    sort: false,
                    filter: false,   
                    prefix: "",
                    suffix: "",
                },
        
          
            ]

        },
    },
    getters: {
        reportListDefinition: state => state.table_def
    },

    actions: {

        async [GET_REPORTS]({ commit }, params) {
            return axios.post(`/page-reports`, params).then((response) => {
                console.log(response)
                return Promise.resolve(response.data)
            }).catch((error)=>{
                return  Promise.resolve(error)
            })

        },

    }
}