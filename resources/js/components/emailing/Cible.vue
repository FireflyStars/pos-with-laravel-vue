<template>

       <div class="container-fluid h-100 bg-color" >
                <main-header />

                <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap" style="z-index:100" >

                    <side-bar />

                    <div class="col main-view container">
                        <page-title icon="emailing" name="MARKETING" class="almarai_extrabold_normal_normal"/>
                           <transition
            enter-active-class="animate__animated animate__fadeIn"
            leave-active-class="animate__animated animate__fadeOut"
        >
    <form class="space-y-6" @submit.prevent="saveCible" v-if="nafs.length>0">


            <div class="container position-relative">

                <div>
                    <h3 class="margin">
                        <a @click="goToHome()" class="link">Marketing </a>>
                        <a key="" @click="goToPrestation()" v-if="campagne_category.name" class="link" > {{ campagne_category.name }} > </a>
                        Cible
                    </h3>
                </div>
                  <transition
            enter-active-class="animate__animated animate__fadeIn"
            leave-active-class="animate__animated animate__fadeOut"
    >
      <div class="position-absolute"  v-if="!retravailler_panel" style="width:100%">
<div class="row bg-panel p-4 mb-2 " >
    <div class="col-lg-8 border-right">
            <div class="cibletable">
                <div class="row">
                    <template v-for="(statut, j) in customer_statuts" :key="j" >
                        <div  class="col nafname" v-if="j==0"></div>
                        <div  class="col statutname d-flex justify-content-center align-items-center" >{{statut.name}}</div>
                    </template>
                    <div class="col  text-xs grey size emphasized d-flex justify-content-center align-items-center text-center">Clients sélectionnés</div>
                </div>
                <div v-for="(naf, i) in nafs" :key="i" class="row">
                    
                            <template v-for="(statut, j) in customer_statuts" :key="j" >
                        
                            <div  class="col nafname"  v-if="j==0">{{naf.selection}}</div>
                            <div  class="col d-flex justify-content-center align-items-center" ><span class="circle" :class="{checked:checkedCible(naf.selection,statut.id,selections)}" @click="toggleCible(naf.selection,statut.id)"></span></div>
                            </template>
                            <div  class="col lastcol d-flex justify-content-center align-items-center">{{numcontacts(naf.selection,all_contacts)}}</div>
                </div>
                <div class="row"> 
                    <template v-for="(statut, j) in customer_statuts" :key="j" >
                        <div  class="col nafname" v-if="j==0"></div>
                        <div  class="col " ></div>
                    </template>
                    <b  class="col d-flex justify-content-center align-items-center">{{totalsel}}</b> 
                </div>
            </div>
            <div class="d-flex justify-content-end">
                                <div>
                                    <label class="type data"
                                        >POUR RETRAVAILLER VOTRE LISTE :</label
                                    >
                                </div>
                                <div class="type-click">
                                    <button
                                        class="button type"
                                        @click="retravaillerList()"
                                    >
                                        CLIQUEZ ICI
                                    </button>
                                </div>
                            </div>
    </div>
    <div class="col-lg-4">
    <h2 class="size px-4 py-4 text-center">CHARGER UN PRÉCÉDENT CIBLAGE</h2>
        <div class="row flex-column justify-content-between" style="height:100%">
            <div class="col p-0">
            <div class="cibletable row">
                <div class="col">
                <div class="row" v-for="(campagne,index) in previous_campagnes" :key="index"> 
                    <div class="col d-flex justify-content-center align-items-center"><span class="circle" :class="{checked:checkedCampagne(campagne.id,selections_campagne)}" @click="toggleCampagne(campagne.id)"></span></div>
                    <div class="col campname d-flex justify-content-center align-items-center">{{campagne.name}}</div>
                    <div class="col d-flex justify-content-center align-items-center size-date">{{campagne.formated_date}}</div>
                    <div class="col lastcol p-0 d-flex justify-content-center align-items-center">{{campagne.contacts.length}}</div>
                </div>
                </div>
            </div>
            </div>
            <div class="col p-0 position-relative">
                <div class="row " >
                            <div class="left col p-0" style="position: absolute; right: 0; bottom: 72px;">
                                <div class="bloc_count">
                                    <p>
                                        <strong class="font total">{{filtered_emails.length}}&nbsp;</strong>

                                        <span class="emphasized size-mail" v-if="filtered_emails.length==1">client</span>
                                         <span class="emphasized size-mail" v-else>clients</span>
                                    </p>
                                    <p class="color">
                                        <strong class="font">{{formatPrice(total_price)}}</strong>
                                        <span class="emphasized size-mail">&nbsp;HT</span>
                                    </p>
                                </div>

                                <button
                                    class="button-valider type"
                                    @click="createCampagne()"
                                >
                                    VALIDER
                                </button>
                            </div>
                </div>
            </div>
        </div>
    </div>


</div></div>
                  </transition>
                    <transition
            enter-active-class="animate__animated animate__fadeIn"
            leave-active-class="animate__animated animate__fadeOut"
    >
    <div class="position-absolute"  v-if="retravailler_panel" style="width:100%">
<div class="row bg-panel p-4 mb-2 ">
        <div class="row">
            <div class="col mb-2">
                <label>Filtrer par Société:</label> <input v-model="filtersociete" type="text" >
            </div>
        </div> 
        <div class="row mt-2 theader mb-2 ml-0">
            <div class="col-1">
                <span class="circle" :class="{checked:allchecked()}" @click="togglecheckedall()"></span>
            </div> 
            <div class="col-2">
                Email
            </div>    
             <div class="col-1">
                Civilité
            </div>  
             <div class="col-1">
                Prénom
            </div>  
             <div class="col-1">
                Nom
            </div>  
             <div class="col-1">
                Société
            </div>  
            <div class="col-1">
                Téléphone
            </div>  
            <div class="col-1">
                Site web
            </div>  
            <div class="col-3">
                Addrese 1
            </div>
        </div>  
        <div class="ml-0 row tbody" v-for="(contact,index) in uniqueContacts" :key="index">
            <div class="col-1">  <span class="circle" :class="{checked:emailchecked(contact.email)}" @click="togglecheckedEmail(contact.email)"></span></div>
            <div class="col-2">{{contact.email}}</div>
            <div class="col-1">{{contact.gender}}</div>
            <div class="col-1">{{contact.firstname}}</div>
            <div class="col-1">{{contact.name}}</div>
            <div class="col-1">{{contact.company}}</div>
            <div class="col-1">{{contact.telephone}}</div>
            <div class="col-1">{{contact.siteweb}}</div>
            <div class="col-3">{{contact.address1}}<br v-if="contact.address2!=null&&contact.address2.trim()!=''">{{contact.address2}}<br>{{contact.postcode}} {{contact.city}}</div>
        </div>
                    <div class="d-flex justify-content-end mt-4 pr-0">
                                <div class="">
                                  <button
                                        class="button type"
                                        @click="annuler()"
                                    >
                                        ANNULER
                                    </button>
                                </div>
                                <div >
                                    <button
                                    class="button-valider type"
                                    @click="validerSelection()"
                                >
                                    VALIDER
                                </button>
                                </div>
                            </div>
</div></div>
                    </transition>

                
            </div>

                </form>
                  </transition>
                        </div>
                    </div>
                </div>

</template>

<script>
import { Vue, watch, ref, computed, nextTick, onMounted, onBeforeMount } from "vue";
import SideBar from "../layout/SideBar";
import WaveLoader from "../WaveLoader";

import { useRouter, useRoute } from "vue-router";
import { useStore } from "vuex";
import {

    TOASTER_MESSAGE,
    TOASTER_MODULE,
    CIBLE_INIT,
    CIBLE_MODULE,
    CIBLE_GET_CUSTOMER_STATUT,
    CIBLE_GET_NAF,
    CIBLE_TOGGLE,
    CIBLE_GET_SELECTION,
    CIBLE_GET_ALL_CONTACTS,
    CIBLE_GET_PREVIOUS_CAMPAGNE_LIST,
    CIBLE_CAMPAGNE_TOGGLE,
    CIBLE_GET_CAMPAGNE_SELECTION,
    CIBLE_SET_UNIQUE_CONTACTS,
    CIBLE_GET_UNIQUE_CONTACTS,
    CIBLE_GET_UNSELECTED_EMAILS,
    CIBLE_UNSET_UNSELECTED_EMAIL,
    CIBLE_SET_UNSELECTED_EMAIL,
    CIBLE_GET_FILTERED_EMAILS,
    CIBLE_SET_FILTERED_EMAILS,
    CIBLE_GET_PRICE,
    CIBLE_CREATE_CAMPAGNE,
    CIBLE_GET_CAMPAGNE_CATEGORY,
    CIBLE_RESET_STATE,
} from "../../store/types/types";

import {removeDuplicatesBy,formatPrice} from "../helpers/helpers.js"
export default {
    components: {

        SideBar,
        WaveLoader,
    },
    props: {
        cible_id: {
            type: Number,
        },
        type: {
            type: String,
            default() {
                return "";
            },
        },
    },

    setup(props) {
        const store = useStore();
        const router= useRouter();
        const route =useRoute();
        const campagne_category=computed(()=>store.getters[`${CIBLE_MODULE}${CIBLE_GET_CAMPAGNE_CATEGORY}`]);
        const customer_statuts=computed(()=>store.getters[`${CIBLE_MODULE}${CIBLE_GET_CUSTOMER_STATUT}`]);
        const nafs=computed(()=>store.getters[`${CIBLE_MODULE}${CIBLE_GET_NAF}`]);
        const unique_contacts=computed(()=>store.getters[`${CIBLE_MODULE}${CIBLE_GET_UNIQUE_CONTACTS}`]);
        const previous_campagnes=computed(()=>store.getters[`${CIBLE_MODULE}${CIBLE_GET_PREVIOUS_CAMPAGNE_LIST}`]);
        const all_contacts=computed(()=>store.getters[`${CIBLE_MODULE}${CIBLE_GET_ALL_CONTACTS}`]);
        const unselected_emails=computed(()=>store.getters[`${CIBLE_MODULE}${CIBLE_GET_UNSELECTED_EMAILS}`]);
        const filtered_emails=computed(()=>store.getters[`${CIBLE_MODULE}${CIBLE_GET_FILTERED_EMAILS}`]);
        const price=computed(()=>store.getters[`${CIBLE_MODULE}${CIBLE_GET_PRICE}`]);
        
        const selections=ref([]);
        const selections_campagne=ref([]);
        const totalsel=ref(0);
        const allemails=ref([]);
        const uniqueContacts=ref([]);
        const unselectedEmails=ref([]);
        const retravailler_panel=ref(false);
        const total_price = ref(0);
        const filtersociete=ref('');
        
         selections.value= computed(()=>store.getters[`${CIBLE_MODULE}${CIBLE_GET_SELECTION}`]);
        const toggleCible=(naf,statut)=>{
                store.dispatch(`${CIBLE_MODULE}${CIBLE_TOGGLE}`,{naf:naf,statut:statut,type:route.params.type});
        }
        const toggleCampagne=(campagne_id)=>{
                  store.dispatch(`${CIBLE_MODULE}${CIBLE_CAMPAGNE_TOGGLE}`,{campagne_id});
        }
        const checkedCible=(naf,statut,selections)=>{
            const checked = selections.value.filter(obj => obj.naf== naf&&obj.statut==statut);
            if(checked.length===0)
            return false;
            return true;
        }
        selections_campagne.value= computed(()=>store.getters[`${CIBLE_MODULE}${CIBLE_GET_CAMPAGNE_SELECTION}`]);
        const checkedCampagne=(id,selections_campagne)=>{
            const checked_campagne = selections_campagne.value.filter(obj => obj.campagne_id==id);
            if(checked_campagne.length===0)
            return false;
            return true;
        }
        const allchecked=()=>{
            if(unselectedEmails.value.length==0)
            return true;

            return false;
        }
        const validerSelection=()=>{
             for(const i in unique_contacts.value){
                    store.commit(`${CIBLE_MODULE}${CIBLE_UNSET_UNSELECTED_EMAIL}`,unique_contacts.value[i].email);
                }
        
            for(const i in unselectedEmails.value){
                      store.commit(`${CIBLE_MODULE}${CIBLE_SET_UNSELECTED_EMAIL}`,unselectedEmails.value[i]);
                 
                 }
             retravailler_panel.value=false;
             filtersociete.value='';
        }
        const retravaillerList=()=>{
            console.log(unique_contacts.value.length);
            if(unique_contacts.value.length>0){
            retravailler_panel.value=true;
            }else{
                store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,{message: "Veuillez faire au moins une sélection.",ttl: 5,type: 'danger'});
            }
        }
        const annuler=()=>{
            unselectedEmails.value=[];
            for(const i in unselected_emails.value){
                unselectedEmails.value.push(unselected_emails.value[i]);
            }
            retravailler_panel.value=false;
        }
        const togglecheckedall=()=>{
            if(unselectedEmails.value.length==0){
                for(const i in unique_contacts.value){
                    unselectedEmails.value.push(unique_contacts.value[i].email);
                 
                 
                }
            }else{
                 for(const i in unique_contacts.value){
                      unselectedEmails.value=unselectedEmails.value.filter(email=>email== unique_contacts.value[i].email);
                  
                }
            }
        }
        const togglecheckedEmail=(email)=>{
            const ischecked=unselectedEmails.value.filter(unselected_email=>unselected_email==email);

            if(ischecked.length==0){
                unselectedEmails.value.push(email);
            
            }else{
    
                  unselectedEmails.value=unselectedEmails.value.filter(unselected_email=>unselected_email!=email);
              
            }
        }
        const emailchecked=(email)=>{
            const emailfound=unselectedEmails.value.filter(unselected_email=> unselected_email==email);
            if(emailfound.length>0){
                return false;
            }
            return true;
        }
        const numcontacts=(naf,all_contacts)=>{
                let c=0;

                let nafcontacts=all_contacts.filter(obj=>{
                    return obj.naf==naf
                });

                for (const property in nafcontacts) {
                    c+=nafcontacts[property].contacts.length;
                }
             
                return c;
        }
    
          watch(() => all_contacts, (currentValue, oldValue) => {
                    totalsel.value=0
                    let allcontacts=currentValue.value
                    for (const k in allcontacts) {
                        if(typeof allcontacts[k].contacts!="undefined"&& typeof allcontacts[k].naf!="undefined")
                            totalsel.value+=allcontacts[k].contacts.length;
                    }  
                    allemails.value=[];
                    for(const obj in allcontacts){

                        let contacts=allcontacts[obj].contacts;

                        for(const k in contacts){
                            allemails.value.push(contacts[k]);
                        }
                    }
               
                    uniqueContacts.value=removeDuplicatesBy(x=>x.email,allemails.value);
                    store.commit(`${CIBLE_MODULE}${CIBLE_SET_UNIQUE_CONTACTS}`,uniqueContacts.value);
                   
            },
                { deep: true }
            );

            const processFinal=()=>{

                const filteredcontacts=unique_contacts.value.filter(contact=>{
                        if(unselected_emails.value.length==0)
                        return true;
                        const emails=unselected_emails.value.filter(email=>contact.email==email);
                        if(emails.length==0)
                        return true;

                        return false;
                });
                total_price.value=price.value*filteredcontacts.length;
                store.commit(`${CIBLE_MODULE}${CIBLE_SET_FILTERED_EMAILS}`,filteredcontacts);
            }
              watch(() => unique_contacts, (currentValue, oldValue) => {
                  processFinal(); 
                   
            },
                { deep: true }
            );
                 watch(() => unselected_emails, (currentValue, oldValue) => {
                  processFinal(); 
                   
            },
                { deep: true }
                );
            watch(()=>filtersociete.value,(currentValue,oldValue)=>{
    
                uniqueContacts.value=unique_contacts.value.filter(uniqueContact=>uniqueContact.company.toLowerCase().includes(currentValue.toLowerCase()));
            });
            const createCampagne=()=>{
                store.dispatch(`${CIBLE_MODULE}${CIBLE_CREATE_CAMPAGNE}`).then((response)=>{
                    if(route.params.type=='Email'){
                    router.push({
                            name: "content",
                            params: {
                                cible_id: response.data.campagne_id,
                                type: route.params.type,
                            },
                        });
                    }else if(route.params.type=='Courrier'){
                        router.push({
                            name: "mailingContenu",
                            params: {
                                cible_id: response.data.campagne_id,
                                type: route.params.type,
                            },
                        });
                    }

                }).catch((error)=>{
                    if(typeof error.response!="undefined")
                        store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`,{message:`An error has occured: ${error.response.status} ${error.response.statusText}`,ttl:5,type:'danger'});
                });
            }
       
        onBeforeMount(()=>{
                store.commit(`${CIBLE_MODULE}${CIBLE_RESET_STATE}`);
        });
        onMounted(() => {

                store.dispatch(`${CIBLE_MODULE}${CIBLE_INIT}`,route.params.categ_id);
            
          
        });

        
        const goToHome=()=>{
            router.push("/emailing");
        };
        const goToPrestation=()=>{
      
            router.push({
                name: "emailingprestations",
                params: {
                    id: `${route.params.categ_id}`,
                },
            });
        };
       
       

       

        return {
             customer_statuts,
             nafs,
             toggleCible,
             checkedCible,
             checkedCampagne,
             selections,
             selections_campagne,
             numcontacts,
             all_contacts,
             totalsel,
             previous_campagnes,
             toggleCampagne,
             uniqueContacts,
             allchecked,
             emailchecked,
             togglecheckedall,
             togglecheckedEmail,
             validerSelection,
             annuler,
             unselectedEmails,
             retravailler_panel,
             filtered_emails,
             total_price,
             filtersociete,
             retravaillerList,
             createCampagne,
             router,
             campagne_category,
             formatPrice,
             goToHome,
             goToPrestation
        
        };
    },

 
};
</script>

<style scoped>
.cibletable {
    width: 100%;
    margin: 0;
}
.cibletable .col{
 flex:1;
}
.cibletable .nafname{
    padding: 0px;
    font-size: 12px;
    text-align: right;
    padding-right: 10px;
    line-height: 1.3;
    text-transform: uppercase;
    font-weight: bold;
    flex:2;
    height: 73px;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    min-width: 100px;
}
.cibletable .campname{
    padding: 0px;
    font-size: 12px;
    padding-right: 5px;
    line-height: 1.3;
    text-transform: uppercase;
    font-weight: bold;
    flex:2;
    height: 73px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    min-width: 100px;
}
.cibletable .statutname{

    font-size: 12px;
    text-align: center;
    padding-right: 10px;
    line-height: 1.3;
    text-transform: uppercase;
    font-weight: bold;
}
 .circle{
    width: 25px;
    height: 25px;
    display: block;
    border-radius: 50%;
    border:1px solid #ff4500;
    cursor: pointer;
    background-color: white;
    transition: background-color 0.3s ease-in-out;
}
 .circle.checked{
    background-color:  #ff4500;
}
.cibletable .lastcol{
    background-color: #BBB;
}
.size-date {
    font-size: 12px;
}
.theader>div{
    font-size:12px;
    font-weight: bold;
    text-transform: uppercase;
    display: flex;
    align-items: center;
}
.tbody>div{
    font-size: 12px;
    margin-top: 6px;
    margin-bottom: 6px;
    display: flex;
    align-items: center;

}
.tbody:nth-child(odd) {background: #CCC}
.ml-0{
    margin-left: 0;
}
.pr-0{
    padding-right:0;
}

.margin-align {
    margin-bottom: 40px;
    margin-top: -34px;
    font-size: 17px;
    font-weight: bold;
}



.container {
    padding-bottom: 100px;
}
.color {
    color: orangered;
}
.margin {
    margin-bottom: 40px;
    margin-top: 35px;
    font-size: 17px;
    font-weight: bold;
}
.type-click {
    width: fit-content;
    margin-right: -20px;
}

.h1 {
    color: #ff5c00;
    margin-bottom: 3%;
}
.padding {
    padding: 15px 12px;
}
.grey {
    color: grey;
}
.size {
    font-size: 12px;
}
.size-mail {
    font-size: small;
}
.font {
    font-weight: bold;
}

.type {
    font-size: x-small;
    font-weight: bold;
}

.emphasized {
    font-style: italic;
    font-weight: 400;
}

.radio {
    width: 15px;
    height: 15px;
}


.line {
    border-bottom: 1px;
    border-style: none solid dotted dashed;
}
.x-btn {
    color: #ff4500;
    margin-right: 8px;
}
.button-click {
    background-color: white;
    color: orangered;
    border: 2px solid #e7e7e7;
}
.button {
    background-color: white;
    border: none;
    color: orangered;
    cursor: pointer;
    width: 117px;
    height: 100%;
}
.type-click {
    border: orangered 1px solid;
}
.button-valider {
    background-color: orangered;
    color: white;
    border: 2px solid orangered;
    width: 150px;
    height: 27px;
}
.data {
    width: 120px;
    text-align: right;
    margin-right: 15px;
}
.custom-control-input::checked ~ .custom-control-label {
    color: #fff;
    border-color: orangered;
}
.center {
    text-align: center;
    line-height: 1;
}

.left {
    text-align: end;
}
.border-right {
    border-right: 1px solid #000;
    padding-right: 40px;
}


.retravailler {
    margin-top: 60px;
    justify-content: end;
}

.total {
    height: auto;
    position: relative;
}



.bloc_count {
    width: 150px;
    margin-top: 30px;
    border: 1px solid #ff4500;
    padding: 12px;
    margin-left: auto;
}
.bloc_count p {
    margin-bottom: 0;
}



.link {
    cursor: pointer;
    text-decoration: none;
    color:orange;
}
.link:hover {
    color: orangered;
}
</style>
