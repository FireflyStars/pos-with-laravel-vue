
import {
    CAMPAGNE_LIST_MODULE,
    GET_CAMPAGNE_LIST,
    SAVE_CAMPAGNE_LIST
}
from '../types/types'

export const campagneList = {

    namespaced: true,

    state: {

        table_def: {

            column_filters: [],//required empty array
            store: {
              MODULE: CAMPAGNE_LIST_MODULE,//required
              INIT: GET_CAMPAGNE_LIST,//required
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
                    
                  ], 
                  backgroundColor: '#f7c5af',
                  color: '#fd3b35'
                }
            ,
            item_route_name: "DevisDetail",// the route to trigger when a line is click 
            max_per_page: 15,//required          
            identifier: "campagne_list_all",//required
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
                    display_name: "No",
                    type: "number",
                    class: "text-center",
                    header_class: "",
                    sort: true,
                    filter: true,
                    prefix: "",
                    suffix: "",
                },     
                {
                    id: "name",
                    display_name: "NOM CAMPAGNE",
                    type: "string",
                    class: "text-center",
                    header_class: "",
                    sort: true,
                    filter: true,   
                    having: true,
                    prefix: "",
                    suffix: "",
                },
                {
                    id: "expediteur",
                    display_name: "CREATEUR",
                    type: "string",
                    class: "text-center",
                    header_class: "",
                    sort: true,
                    filter: true,   
                    having: true,
                    prefix: "",
                    suffix: "",
                },
                {
                    id: "run",
                    display_name: "DATE LANCEMENT",
                    type:"date",
                    format:"DD/MM/YY",
                    class: "text-center",
                    header_class: "",
                    sort: true,
                    filter: true,   
                    having: true,
                    prefix: "",
                    suffix: "",
                },
                {
                    id: "created_at",
                    display_name: "DATE CREATION",
                    type:"date",
                    format:"DD/MM/YY",
                    class: "text-center",
                    header_class: "",
                    sort: true,
                    filter: true,   
                    having: true,
                    prefix: "",
                    suffix: "",
                },
                {
                    id: "type",
                    display_name: "TYPE",
                    type: "string",
                    class: "text-center",
                    header_class: "",
                    sort: true,
                    filter: true,   
                    having: true,
                    prefix: "",
                    suffix: "",
                },
                {
                    id: "status",
                    display_name: "STATUS",
                    type: "component",
                    class: "text-center",
                    header_class: "",
                    sort: true,
                    filter: true,   
                    having: true,
                    prefix: "",
                    suffix: "",
                    filter_options: [],
                    allow_groupby: true,
                },
                {
                    id: "phone",
                    display_name: "NOMBRE",
                    type: "component",
                    class: "text-center",
                    header_class: "",
                    sort: true,
                    filter: true,   
                    having: true,
                    prefix: "",
                    suffix: "",
                },
                {
                    id: "montant",
                    display_name: "MONTANT",
                    type: "price",
                    class: "text-center",
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
        campagnesList: state => state.table_def,
    },

    actions: {

        async [GET_CAMPAGNE_LIST]({ commit }, params) {

            return axios.post(`/get-campagne-list`, params).then((response) => {
                return Promise.resolve(response)
                      
            }).catch((error) => {
                return  Promise.resolve(error)
            })

        },

    }
}