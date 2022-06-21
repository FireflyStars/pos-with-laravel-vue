<template>
<item-detail-panel :showloader="showloader">
    <div class="row" v-if="show">
        <div class="col-4">
            <page-title icon="pdf" :name="`N° ${order_id}`" class="almarai_extrabold_normal_normal"/>
        </div>
        <div class="col-8" style="padding-top:33px">
            <order-state-tag :order_state_id="order.order_state_id" classes="almarai_700_normal" width="auto"></order-state-tag>
        </div>
    </div>
    <div class="row"  v-if="show" style="margin:40px 0 0 8px;"><div class="col"><h2 class="almarai_700_normal">Date promise du devis</h2></div></div>
    <div class="row"  v-if="show" style="margin:0 0 0 8px;">
        <div class="col-8"><h2 class="almarai_700_normal">{{formatDate(order.datefinprevu)}}</h2></div>
        <div class="col-2 font-14 almarai_700_normal">{{order.nbheure}}H</div>
        <div class="col-2 font-16 almarai_700_normal">{{formatPrice(order.total)}}</div>
    </div>
    <hr v-if="show"/>
    <div class="row" v-if="show"><div class="col"><h3 class="almarai_700_normal" v-if="typeof order.customer!='undefined'">{{order.customer.company}}</h3></div></div>
    <div class="row" v-if="show">
        <div class="col"><span class="subtitle almarai_700_normal">Adresse du chantier</span><br><span v-html="order.formatted_chantier_address"></span></div>
        <div class="col"><span class="subtitle almarai_700_normal">Adresse facturation</span><br><span v-html="order.formatted_facturation_address"></span></div>
    </div>
    <div class="row" v-if="show">
        <div class="col"><span class="subtitle almarai_700_normal">Contact</span><br><span v-if="typeof order.contact!='undefined'" v-html="`${typeof order.contact.firstname !='undefined'? order.contact.firstname:''} ${typeof order.contact.name !='undefined'?order.contact.name:''}${br(order.contact.mobile)}${br(order.contact.telephone)}`"></span></div>
        <div class="col"><span class="subtitle almarai_700_normal">Mode de paiement</span><br><span>--/--</span></div>
    </div>
     <hr v-if="show"/>
     <div  v-for="orderzone,index in order.order_zones" :key="index" class="od_orderzone">
         <div class="row mb-3">
             <div class="col-8 almarai_700_normal font-14 lcdtgrey d-flex  align-items-center">{{orderzone.name}}</div>
             <div class="col-2 almarai_700_normal font-14 d-flex justify-content-end align-items-center">{{sumZoneH(orderzone)}}H</div>
             <div class="col-2 almarai_700_normal font-14 d-flex justify-content-end align-items-center">{{formatPrice(sumZoneTotal(orderzone))}}</div>
        </div>
        <div class="row mb-2">
             <div class="col-4"></div>
             <div class="col-8">
                <div class="row flex-grow-1 justify-content-between">
                    <div class="col-2 almarai-light font-12 d-flex lcdtgrey justify-content-end align-items-center"></div>
                    <div class="col-4 almarai-light font-12 d-flex lcdtgrey justify-content-center align-items-center">Ouvrages</div>
                    <div class="col-3 almarai-light font-12 d-flex lcdtgrey justify-content-end align-items-center">Main-d'œuvre</div>
                    <div class="col-3 almarai-light font-12 d-flex lcdtgrey justify-content-end align-items-center">Total</div>
                </div>
             </div>
        </div>
         <div class="row" v-for="groupedOrderOuvrage,index2 in orderzone.groupedOrderOuvrage" :key="index2">
             <div class="col-4 od_catname font-14 d-flex align-items-center almarai_700_normal">{{index2}}</div>
             <div class="col-8 font-14 flex-column">
                 <div class="row flex-grow-1 justify-content-between" v-for="orderOuvrage,index3 in groupedOrderOuvrage" :key="index3">
                     <div class="col-2 d-flex align-items-center justify-content-end">{{orderOuvrage.qty}}</div>
                     <div class="col-4 d-flex align-items-center">{{orderOuvrage.name}}</div>
                    <div class="col-3 almarai-light font-14 d-flex  justify-content-end align-items-center">{{orderOuvrage.nbheure}}H</div>
                    <div class="col-3 almarai-light font-14 d-flex  justify-content-end align-items-center">{{formatPrice(orderOuvrage.total)}}</div>
                 </div>

             </div>
           
        </div>
      
     </div>
     <div class="od_actions mb-3" v-if="show">
        <button class="btn btn-outline-dark almarai_700_normal" @click="goto()">Editer</button>
        <button class="btn btn-outline-success almarai_700_normal" @click="changeOrderState(4)">Gagne</button>
        <button class="btn btn-outline-secondary almarai_700_normal"  @click="changeOrderState(20)">Perdu</button>  
        <button class="btn btn-outline-primary almarai_700_normal"  @click="changeOrderState(18)">Abandonne</button>  
        <button class="btn btn-outline-warning almarai_700_normal"  @click="changeOrderState(3)">Attente client</button>   
     </div>


</item-detail-panel>
</template>

<script>
import { computed, onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router'
import { useStore } from 'vuex';
import ItemDetailPanel from '../../components/miscellaneous/ItemListTable/ItemDetailPanel.vue'
import OrderStateTag from '../../components/miscellaneous/OrderStateTag.vue';
import { DEVIS_DETAIL_GET, DEVIS_DETAIL_LOAD, DEVIS_DETAIL_MODULE, DEVIS_DETAIL_SET, ORDERSTATETAG_GET_ORDER_STATES, ORDERSTATETAG_MODULE } from '../../store/types/types';
import { formatPrice,formatDate,br } from '../../components/helpers/helpers';
import Swal from 'sweetalert2';
    export default {
        name: "DevisDetail",
        components:{ItemDetailPanel,OrderStateTag},
        setup(){
            const route=useRoute();
            const router=useRouter();
            const store=useStore();
            const show=ref(false);
            const showloader=ref(false);
            let order_id=route.params.id;

            onMounted(()=>{
                     document.getElementsByTagName( 'body' )[0].className='hide-overflowY';
                show.value=false;
                showloader.value=true;
                store.commit(`${DEVIS_DETAIL_MODULE}${DEVIS_DETAIL_SET}`,{})
                store.dispatch(`${DEVIS_DETAIL_MODULE}${DEVIS_DETAIL_LOAD}`,order_id).then((response)=>{
                    show.value=true;
                    showloader.value=false;
                });
            })
            const order=computed(()=>store.getters[`${DEVIS_DETAIL_MODULE}${DEVIS_DETAIL_GET}`]);

             const order_states=computed(()=>store.getters[`${ORDERSTATETAG_MODULE}${ORDERSTATETAG_GET_ORDER_STATES}`]);

            const changeOrderState = (order_state_id)=>{
                const order_state=order_states.value.filter(obj=>obj.id==order_state_id);
                Swal.fire({
                    title: 'Veuillez confirmer!',
                    text: `Voulez-vous changer le statut en ${typeof order_state[0]!="undefined"?order_state[0].name:''}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#42A71E',
                    cancelButtonColor: 'var(--lcdtOrange)',
                    cancelButtonText: 'Annuler',
                    confirmButtonText: `Oui, s'il vous plaît.`
                }).then((result) => {
                    if (result.isConfirmed) {
                    
                    }
                });      
            }

            const goto=()=>{
                document.getElementsByTagName( 'body' )[0].className='';
                router.push({ name: 'EditDevis', params: { id: order_id } })
            }
            const sumZoneH=(orderzone)=>{
                let sum=0;
                for(const i in orderzone.groupedOrderOuvrage){
                    sum+=orderzone.groupedOrderOuvrage[i].reduce((a, b) =>  a + b.nbheure, 0);
                }
                return sum;
            }
            const sumZoneTotal=(orderzone)=>{
                  let sum=0;
                for(const i in orderzone.groupedOrderOuvrage){
                    sum+=orderzone.groupedOrderOuvrage[i].reduce((a, b) =>  a + b.total, 0);
                }
                return sum;
            }
             return {
                 show,
                 showloader,
                 order_id,
                 order,
                 formatPrice,
                 formatDate,
                 br,
                 router,
                 changeOrderState,
                 goto,
                 sumZoneH,
                 sumZoneTotal

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

hr{
    margin:25px -20px;
    background-color: #E0E0E0;

}
.subtitle{
    color:#C3C3C3;
    font-size:14px;
    font-weight: 400!important;
}
.od_orderzone{
    background: #F8F8F8;
    display: block;
    margin-bottom:22px;
    padding:10px 20px;
    box-shadow: inset 0px -1px 0px rgba(168, 168, 168, 0.25);
}

.lcdtgrey{
    color:var(--lcdtGrey);
}
.od_catname{
    position: relative;
    padding-left: 54px;
}
.od_catname::after{
    content:'';
    display: block;
    width: 13px;
    height: 13px;
    border-radius: 50%;
    background-color: var(--lcdtOrange);
    position: absolute;
    top:50%;
    left: 18px;
    transform: translateY(-50%);

}
.od_actions{
    display: flex;
    justify-content: space-between;
}
.od_actions button{

}

</style>