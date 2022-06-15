<template>
<item-detail-panel :showloader="showloader">
    <div class="row" v-if="show">
        <div class="col-4">
            <page-title icon="pdf" :name="`N° ${order_id}`" class="almarai_extrabold_normal_normal"/>
        </div>
        <div class="col-8" style="padding-top:33px">
            <order-state-tag :order_state_id="order.order_state_id" classes="almarai_700_normal"></order-state-tag>
        </div>
    </div>
    <div class="row"  v-if="show" style="margin:40px 0 0 8px;"><div class="col"><h2 class="almarai_700_normal">Date promise du devis</h2></div></div>
    <div class="row"  v-if="show" style="margin:0 0 0 8px;">
        <div class="col-8"><h2 class="almarai_700_normal">{{formatDate(order.datefinprevu)}}</h2></div>
        <div class="col-2 totalh almarai_700_normal">{{order.nbheure}}H</div>
        <div class="col-2 totalamt almarai_700_normal">{{formatPrice(order.total)}}</div>
    </div>
    <hr/>
    <div class="row"><div class="col"><h3 class="almarai_700_normal" v-if="typeof order.customer!='undefined'">{{order.customer.company}}</h3></div></div>
    <div class="row">
        <div class="col"><span class="subtitle almarai_700_normal">Adresse du chantier</span><br><span v-html="order.formatted_chantier_address"></span></div>
        <div class="col"><span class="subtitle almarai_700_normal">Adresse facturation</span><br><span v-html="order.formatted_facturation_address"></span></div>
    </div>
    <div class="row">
        <div class="col"><span class="subtitle almarai_700_normal">Contact</span><br><span v-if="typeof order.contact!='undefined'" v-html="`${order.contact.firstname} ${order.contact.name}${br(order.contact.mobile)}${br(order.contact.telephone)}`"></span></div>
        <div class="col"><span class="subtitle almarai_700_normal">Mode de paiement</span><br><span>--/--</span></div>
    </div>
     <hr/>
<p> {{order}}</p>

</item-detail-panel>
</template>

<script>
import { computed, onMounted, ref } from 'vue';
import { useRoute } from 'vue-router'
import { useStore } from 'vuex';
import ItemDetailPanel from '../../components/miscellaneous/ItemListTable/ItemDetailPanel.vue'
import OrderStateTag from '../../components/miscellaneous/OrderStateTag.vue';
import { DEVIS_DETAIL_GET, DEVIS_DETAIL_LOAD, DEVIS_DETAIL_MODULE, DEVIS_DETAIL_SET } from '../../store/types/types';
import { formatPrice,formatDate,br } from '../../components/helpers/helpers';
    export default {
        name: "DevisDetail",
        components:{ItemDetailPanel,OrderStateTag},
        setup(){
            const route=useRoute();
            const store=useStore();
            const show=ref(false);
            const showloader=ref(false);
            let order_id=route.params.id;

            onMounted(()=>{
                show.value=false;
                showloader.value=true;
                store.commit(`${DEVIS_DETAIL_MODULE}${DEVIS_DETAIL_SET}`,{})
                store.dispatch(`${DEVIS_DETAIL_MODULE}${DEVIS_DETAIL_LOAD}`,order_id).then((response)=>{
                    show.value=true;
                    showloader.value=false;
                });
            })
            const order=computed(()=>store.getters[`${DEVIS_DETAIL_MODULE}${DEVIS_DETAIL_GET}`])
             return {
                 show,
                 showloader,
                 order_id,
                 order,
                 formatPrice,
                 formatDate,
                 br
             }
        }
    }
</script>

<style scoped>
h2{
    font-size: 16px;
    line-height: 16px;
    margin-bottom: 8px;
}
h3{
    font-size: 14px;
    line-height: 14px;
    margin-bottom: 8px;
}
.totalamt{
    font-size:16px
}
.totalh{
    font-size:14px
}
hr{
    margin:25px -20px;
    background-color: #E0E0E0;

}
.subtitle{
    color:#C3C3C3;
    font-size:14px;
    font-weight: 400!important;
}
</style>