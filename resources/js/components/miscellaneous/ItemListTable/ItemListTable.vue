<template>
   
<div :id="table_def.identifier">
    <div class="list-header">
        <template v-for="item,index in table_def.columns_def" :key="index">
            <div class="list-header-col almarai_700_normal" :class="headerClasses(item)" :style="item.css">
                <span>{{item.display_name}}</span>
                <check-box v-if="item.type=='checkbox'" name="checkall" id="checkall" :checked="false" @change="checkboxallclicked"/>
                <input  class="mulish_400_normal" v-if="(item.type=='string'||item.type=='html'||item.type=='price')&&item.sort" type="text" @keyup.enter="filterColumn(item,$event.target.value)"/>
            </div>
        </template>
    </div>
    <transition-group tag="div" class="list"  name="list" appear>
        <template v-for="row,index in lists" :key="index">
        <div class="list-row" @click.self="selectrow(row.id,index)" :class="{current_sel:row.id==CURRENT_SELECTED}">
             <template v-for="col,indexcol in table_def.columns_def" :key="indexcol">
                 <div class="list-col almarai_700_normal" :style="col.css" :class="colClasses(col,row)"  @click="selectrow(row.id,col.type=='checkbox'?'line_select':index)">
                     <span v-if="col.type=='date'">{{formatDate(row[col.id],'DD/MM/YY')}}</span>
                     <check-box v-else-if="col.type=='checkbox'" :name="col.id" :id="row[col.id]" @change="checkboxclicked" :checked="row.id==CURRENT_SELECTED"/>
                      <span v-else-if="col.type=='html'" v-html="ifnull(row[col.id])"></span>
                     <span v-else>{{ifnull(row[col.id])}}</span>
                     </div>
             </template>
        </div>
        </template>
    </transition-group>
    <div class="list-footer">
        <div class="justify-align-content-start align-items-center">
            XX ITEMS
        </div>
    </div>
    <div class="d-flex justify-content-center">
        <span class="loadmore mulish_400_normal">Charger plus</span>
    </div>
</div>

</template>
<script>
import { ref, onMounted, nextTick, computed, watch } from 'vue';
import { useStore } from 'vuex';
import { formatDate } from '../../helpers/helpers';
import { ITEM_LIST_FILTER, ITEM_LIST_GET_COLUMN_FILTERS, ITEM_LIST_GET_CURRENT, ITEM_LIST_GET_FILTERS, ITEM_LIST_GET_LISTS, ITEM_LIST_GET_TABLES, ITEM_LIST_MODULE, ITEM_LIST_SELECT_CURRENT, ITEM_LIST_SET_ACTIONS, ITEM_LIST_SET_TABLEDEF, ITEM_LIST_TABLEDEF, ITEM_LIST_TABLE_RELOAD } from '../../../store/types/types';
import { useRouter } from 'vue-router';

export default {

    
    name: "ItemListTable",

    props: { 
        table_def: {
            required: true,
            type: Object,
            
        }
    },

    setup(props) {
        const router=useRouter();
        const store=useStore();
        const identifier=props.table_def.identifier;//table identifier
      
      onMounted(()=>{
          let table={
              table_def:props.table_def,
          }
     
          store.dispatch(`${ITEM_LIST_MODULE}${ITEM_LIST_TABLEDEF}`,table);
     
      })
        
        const lists=computed(()=>{
            let lists=store.getters[`${ITEM_LIST_MODULE}${ITEM_LIST_GET_LISTS}`];
            if(typeof lists[identifier]!="undefined")
                return lists[identifier];
            });

        //set a column filter
        const filterColumn=(col,word)=>{
            store.dispatch(`${ITEM_LIST_MODULE}${ITEM_LIST_FILTER}`,{col:col,word:word,identifier:identifier});
        }
        //watch for any column filter change and send request to server

        const colfilters=computed(()=>{
            let col_filters=store.getters[`${ITEM_LIST_MODULE}${ITEM_LIST_GET_COLUMN_FILTERS}`];
            if(typeof col_filters[identifier]!="undefined")
                return col_filters[identifier];
            });

         const CURRENT_SELECTED=computed(()=>{
            let current_selecteds=store.getters[`${ITEM_LIST_MODULE}${ITEM_LIST_GET_CURRENT}`];
            if(typeof current_selecteds[identifier]!="undefined")
                return current_selecteds[identifier];
            }); 
         watch(() => colfilters, (currentValue, oldValue) => {
                
                  store.dispatch(`${ITEM_LIST_MODULE}${ITEM_LIST_TABLE_RELOAD}`,{identifier:identifier,fullreload:true});   
            },
                { deep: true }
            );
         //end watch for any column filter change and send request to server

        const headerClasses=item=>{
            let header_class=item.header_class;
            if(item.type=="checkbox")
            header_class=`${header_class} d-flex justify-content-center`;
            return header_class;
        }
         const colClasses=(col,row)=>{
            let col_class=col.class;
            if(col.type=="checkbox")
            col_class=`${col_class} justify-content-center`;

            if(ifnull(row[col.id])=='--')
            col_class=`${col_class} justify-content-center`;

            return col_class;
        }
         const selectrow=(id,colname)=>{
   
                if(colname=='line_select') return;
                store.dispatch(`${ITEM_LIST_MODULE}${ITEM_LIST_SELECT_CURRENT}`,{current:id,identifier:identifier});
                  router.push({
                    name:'DevisDetail',
                    params: {
                        id:id,
                    },
                })
            }
        const checkboxclicked=(checkbox)=>{
                    console.log('bangx',checkbox);
                if(CURRENT_SELECTED.value==checkbox.id&&checkbox.value==false){
                    store.dispatch(`${ITEM_LIST_MODULE}${ITEM_LIST_SELECT_CURRENT}`,{current:'',identifier:identifier});
                    router.back();
                }
                if(checkbox.value==true){
                  //  store.dispatch(`${ORDERLIST_MODULE}${ORDERLIST_MULITCHECKED}`,id);
                }
                if(checkbox.value==false){
                 //   store.dispatch(`${ORDERLIST_MODULE}${ORDERLIST_MULITUNCHECKED}`,id);
                }
            }
        const  checkboxallclicked=(check,id,name)=>{
                console.log('bangbang',check,id,name);
                    if(check==false)
                        //store.dispatch(`${ORDERLIST_MODULE}${ORDERLIST_RESET_MULITCHECKED}`);

                    if(check){
                       // const list=_.cloneDeep(ORDER_LIST.value);
                       // list.forEach(order => store.dispatch(`${ORDERLIST_MODULE}${ORDERLIST_MULITCHECKED}`,order.id));
                        }
            }
   
      const ifnull=(val)=>{
          if(val==null||val=='')
          return '--';

          return val;
      }
      return{
          table_def:props.table_def,
          lists,
          filterColumn,
          headerClasses,
          colClasses,
          formatDate,
          checkboxclicked,
          checkboxallclicked,
          selectrow,
          ifnull,
          CURRENT_SELECTED
      }

    }

}
</script>

<style lang="scss" scoped>

.list-header{
    background: #FFF;
    display: flex;
    gap:8px;
    padding: 23px 5px 4px 5px;
    margin-bottom: 3px;
     box-shadow: inset 0px -1px 0px rgba(168, 168, 168, 0.5);
}
.list-footer{
    background: #FFF;
    display: flex;
    gap:8px;
    padding: 0 5px 0 5px;
      box-shadow: inset 0px -1px 0px rgba(168, 168, 168, 0.5);
      min-height: 66px;
      margin-bottom: 10px;
}
.list-header input{
    width:100%;
    height: 40px;
    background: #EEEEEE;
    border-radius: 5px 5px 0  0;
    border:none;
    padding:0 6px;
    outline: none;
    transition: all 0.3s ease-in-out;
}
.list-header input:focus{
   background: #DDDDDD;
}
.list-header-col{
    flex:1;
    font-size: 14px;
    color:#868686;
}
.list-row{
    display: flex;
    min-height: 66px;
    background: #FFFFFF;
    box-shadow: inset 0px -1px 0px rgba(168, 168, 168, 0.25);
    gap:8px;
    padding:0 5px 0 5px;
     cursor: pointer;
        transition: background-color 300ms ease-out;
}
.list-col{
    flex:1;
    align-items: center;
    display: flex;
    font-size: 16px;
   
}
.list-row{
    transform-origin: left center;
}
.current_sel{
    position: relative;
    z-index: 10000;
    background: rgb(247, 251, 246);
}
 /*list transitions*/
    .list-enter-from{
        opacity: 0;
        transform: scale(0.6);
    }
    .list-enter-to{
        opacity: 1;
        transform: scale(1);
    }
    .list-enter-active{
        transition: all 1s ease;
    }

    .list-leave-from{
        transform-origin: right center;
        opacity: 1;
        transform: scale(1);
    }
    .list-leave-to{
        transform-origin: right center;
        opacity: 0;
        transform: scale(0.6);
    }
    .list-leave-active{
         transform-origin: right center;
        transition: all 1s ease;
        position:absolute;     
        width: 100%;
    }
    .list-move{
        transition:all 0.9s ease;
    }
    .loadmore{
        text-decoration: underline;
        cursor: pointer;
        text-align: center;
        margin-bottom: 10px;
        
    }
</style>
