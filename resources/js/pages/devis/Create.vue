<template>
  <router-view>
    <transition enter-active-class="animate__animated animate__fadeIn">
      <div class="container-fluid h-100 bg-color" id="container">
        <main-header />
        <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap reports-page" style="z-index:100" >
            <side-bar />
            <div class="col main-view container">
                <h1 class="d-flex align-items-center m-0">
                  <span class="devis-icon"></span>
                  <span class="ms-3 font-22 almarai_extrabold_normal_normal">Nouveau Devis</span>
                </h1>
                <ul class="m-0 p-0 breadcrumb mt-3" v-if="breadcrumbs.length">
                  <li class="breadcrumb-item almarai-extrabold font-18" v-for="(breadcrumb, index) in breadcrumbs" :key="index">{{ breadcrumb }}</li>
                </ul>
                <div class="choose-customer-panel d-flex mt-3" v-if="devisCreateStep == 'choose_customer'">
                  <div class="col-5 bg-white p-3 rounded">
                    <h2 class="almarai-extrabold font-22">Détail Client <span @click="addNewCustomer" class="ms-3 almarai-bold font-16 cursor-pointer text-decoration-underline text-custom-success">Nouveau</span></h2>
                    <SearchCustomer name="search" @selected="selectedCustomer" :droppos="{top:'auto',right:'auto',bottom:'auto',left:'0',transformOrigin:'top right'}" label="Search a customer" hint="disabled till 2021-09-10" ></SearchCustomer>
                  </div>
                </div>
                <div class="choose-address-panel mt-3" v-if="devisCreateStep == 'choose_address'">
                  <div class="col-5 p-3 bg-white rounded">
                    <div class="d-flex">
                      <div class="col-6">
                        <h2 class="almarai-extrabold font-22">{{ form.customer.company }}</h2>
                        <p class="text-gray font-16 almarai-bold">{{ form.customer.raisonsocial }}</p>
                      </div>
                      <div class="col-6 d-flex align-items-center justify-content-end">
                        <p @click="chooseOtherCustomer" class="text-custom-success font-16 almarai-bold text-decoration-underline cursor-pointer">Autre client</p>
                      </div>
                    </div>
                    <div class="d-flex mt-3">
                      <div class="col-4">
                        <label for="" class="text-gray font-16 almarai-bold">GROUPE</label>
                        <p class="font-16 almarai-bold">{{ form.customer.group }}</p>
                      </div>
                      <div class="col-4">
                        <label for="" class="text-gray font-16 almarai-bold">CONTACT</label>
                        <p class="font-16 almarai-bold">{{ form.customer.contact }}</p>
                      </div>
                      <div class="col-4">
                        <label for="" class="text-gray font-16 almarai-bold">TELEPHONE</label>
                        <p class="font-16 almarai-bold">{{ form.customer.telephone }}</p>
                      </div>
                    </div>
                    <div class="d-flex mt-3">
                      <div class="col-4">
                        <label for="" class="text-gray font-16 almarai-bold">TVA</label>
                        <p class="font-16 almarai-bold">{{ form.customer.tax }}</p>
                      </div>
                      <div class="col-4">
                        <label for="" class="text-gray font-16 almarai-bold">NAF</label>
                        <p class="font-16 almarai-bold">{{ form.customer.naf }}</p>
                      </div>
                      <div class="col-4">
                        <label for="" class="text-gray font-16 almarai-bold">SIRET</label>
                        <p class="font-16 almarai-bold">{{ form.customer.siret }}</p>
                      </div>
                    </div>
                  </div>
                  <div class="col-5 p-3 mt-3 rounded bg-white">
                    <h2 class="almarai-extrabold font-22">Choix adresse Chantier <span @click="addNewAddress" class="ms-3 almarai-bold font-16 cursor-pointer text-decoration-underline text-custom-success">Nouvelle adresse</span></h2>
                    <div class="mt-3 customer-addresses">
                      <div class="px-4 py-3 bg-gray mt-2 address-item rounded cursor-pointer" 
                        @click="chooseCustomerAddress(address)" v-for="(address, index) in customerAddresses" :key="index">
                        <div class="d-flex">
                          <div class="col-7">
                            <h3 class="almarai-bold font-16">{{ address.name }}</h3>
                          </div>
                          <div class="col-5">
                            <p class="almarai-bold font-16 text-gray">{{ address.addressType }}</p>
                          </div>
                        </div>
                        <div class="d-flex">
                            <div class="col-6 almarai-bold text-gray">{{ address.address1 }}</div>
                            <div class="col-1 almarai-bold text-gray">{{ address.address2 }}</div>
                            <div class="col-5 almarai-bold text-gray">{{ address.postcode }} {{ address.city }}</div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="devis-panel d-flex" v-if="devisCreateStep == 'create_devis'">
                    <div class="left-panel">
                      <div class="customer-section px-3 py-2 d-flex bg-white">
                          <div class="col-7 d-flex">
                            <div class="customer-pic rounded-circle bg-primary">
                                
                            </div>
                            <div class="ms-3 customer-name d-flex flex-wrap">
                              <div class="small-title w-100">
                                Nom du client
                              </div>
                              <div class="mulish-extrabold font-16 w-100">
                                {{ form.customer.contact }}
                              </div>
                            </div>
                            <div class="ms-5 customer-edit d-flex align-items-center">
                              <!-- <span class="edit-icon me-3"></span> -->
                              <!-- <span class="call-external"></span> -->
                            </div>
                          </div>
                          <div class="col-5 me-3 price-section d-flex align-items-end">
                            <span class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">15 hr</span>
                            <span class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">15 000 €</span>
                            <span class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">350 000 €</span>
                          </div>
                      </div>
                      <div class="zone-section" v-for="(zone, zoneIndex) in form.zones" :key="zoneIndex">
                        <div class="ged-section bg-white px-3 py-2">
                          <div class="zone-header d-flex align-items-center">
                            <span class="home-icon"></span>
                            <div class="zone-name ms-2">
                              <input type="text" @blur="zoneEdit = !zoneEdit" v-if="zoneEdit" class="form-control form-control-sm" v-model="zone.name">
                              <span class="mulish-extrabold font-18 text-black" @dblclick="zoneEdit = !zoneEdit" v-else>{{ zone.name }}</span>
                            </div>
                            <div v-if="zoneIndex == 0" @click="addZone(zoneIndex)" class="add-btn ms-3 d-flex align-items-center mulish-semibold font-14 custom-text-danger cursor-pointer">
                              <span class="plus-icon me-2"></span> AJOUTER
                            </div>
                            <div @click="removeZone(zoneIndex)" class="remove-btn ms-3 d-flex align-items-center mulish-semibold font-14 custom-text-danger cursor-pointer">
                              <span class="cancel-icon me-2"></span> RETIRER
                            </div>
                          </div>
                          <div class="d-flex px-4 mt-4">
                            <div class="col-6">
                              <div class="roof-access d-flex align-items-end mulish-semibold font-16 custom-text-danger">
                                <span class="roof-icon me-2"></span> Accès toiture
                              </div>
                              <div class="d-flex mt-3 ms-4">
                                <SelectBox :label="''" 
                                    v-model="zone.roofAccess" 
                                    :options="[ 
                                        { display:'Intérieur', value: 'Intérieur' }, 
                                        { display:'Extérieur', value: 'Extérieur' },
                                        { display:'Pas d’accès', value: 'Pas d’accès' }
                                    ]"
                                    :name="'roofAccess'"
                                    :classnames="'col-5'"
                                />
                                <SelectBox v-if="zone.roofAccess == 'Pas d’accès'" :label="''" 
                                    v-model="zone.roofAccess1" 
                                    :options="[ 
                                        { display:'Echelle', value: 'Echelle' }, 
                                        { display:'Echafaudage', value: 'Echafaudage' },
                                        { display:'Nacelle', value: 'Nacelle' }
                                    ]"
                                    :name="'roofAccess_second'"
                                    :classnames="'col-5 ms-2'"
                                />
                              </div>
                            </div>
                            <div class="col-6 px-3 d-flex">
                              <div class="col-9 px-5">
                                <p class="m-0 almarai-bold font-14 text-gray">Adresse du chantier</p>
                                <p class="m-0 almarai-light font-14">{{ form.address.address1 }} {{ form.address.address1 }} {{ form.address.postCode }} {{ form.address.city }}</p>
                              </div>
                              <div class="col-3 bg-primary">
                              </div>
                            </div>
                          </div>
                          <div class="d-flex px-4 mt-4 flex-wrap">
                            <div class="col-6 mb-3" v-for="(gedCat, catIndex) in zone.gedCats" :key="catIndex">
                              <div class="ged-cat-header d-flex align-items-end mulish-semibold font-16 custom-text-danger">
                                <span class="camera-icon me-2"></span> {{ gedCat[0].name }} 
                                <div class="add-btn ms-3 d-flex align-items-center mulish-semibold font-14 custom-text-danger cursor-pointer"
                                @click="addFileToGed(zoneIndex, gedCat[0].id)">
                                  <span class="plus-icon me-2"></span> AJOUTER
                                </div>
                              </div>
                              <div class="ged-cat-content mt-3 mb-3 d-flex flex-wrap">
                                <div class="img ms-2 cursor-pointer" v-for="(gedDetail, key) in gedCat[0].items" :key="key">
                                  <div class="rounded border border-1"
                                    :style="{ 'background-image': `url(${gedDetail.previewContent})`, 'background-size': 'contain', 'width': '55px', 'height':'55px'}"
                                    @click="zoomImage(gedDetail.previewContent)"
                                  >
                                  <div class="w-100 h-100 image-overlayer">
                                  </div>
                                  </div>
                                </div>
                              </div>
                              <div v-if="gedCat[0].name == 'Vue exterieur'" class="get-cat-footer almarai-light font-14 mb-3">
                                Attention grosse poutre en haut
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="ouvrage-section bg-white px-4 py-3 mt-2 mb-2">
                          <div class="ouvrage-header d-flex">
                            <div class="col-7">
                              <div class="col-5 d-flex align-items-center cursor-pointer toggle-btn" @click="togglePanel">
                                <span class="installation-icon me-2"></span> 
                                <span class="me-4">Installation</span>
                                <span class="arrow-icon ms-auto"></span>
                              </div>
                              <div class="add-btn ms-5 ps-3 d-flex align-items-center mulish-semibold font-14 custom-text-danger cursor-pointer" 
                                @click="openOuvrageModal('Installation', zoneIndex)">
                                <span class="plus-icon me-2"></span> AJOUTER UN OUVRAGE
                              </div>
                            </div>
                            <div class="col-5 d-flex align-items-center">
                              <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">{{ zone.installOuvrage.totalHour }} hr</div>
                              <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">{{ zone.installOuvrage.unitPrice }} €</div>
                              <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">{{ zone.installOuvrage.totalPrice }} €</div>
                            </div>
                          </div>
                          <div class="ouvrage-body ms-5 ps-3 mt-3">
                            Ouvrage
                          </div>
                        </div>

                        <div class="ouvrage-section bg-white px-4 py-3 mt-2 mb-2">
                          <div class="ouvrage-header d-flex">
                            <div class="col-7">
                              <div class="col-5 d-flex align-items-center cursor-pointer toggle-btn" @click="togglePanel">
                                <span class="securite-icon me-2"></span> 
                                <span class="me-4">Sécurité</span>
                                <span class="arrow-icon ms-auto"></span>
                              </div>
                              <div class="add-btn ms-5 ps-3 d-flex align-items-center mulish-semibold font-14 custom-text-danger cursor-pointer" 
                                @click="openOuvrageModal('Sécurité', zoneIndex)">
                                <span class="plus-icon me-2"></span> AJOUTER UN OUVRAGE
                              </div>
                            </div>
                            <div class="col-5 d-flex align-items-center">
                              <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">{{ zone.securityOuvrage.totalHour }} hr</div>
                              <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">{{ zone.securityOuvrage.unitPrice }} €</div>
                              <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">{{ zone.securityOuvrage.totalPrice }} €</div>
                            </div>
                          </div>
                          <div class="ouvrage-body ms-5 ps-3 mt-3">
                          </div>
                        </div>

                        <div class="ouvrage-section bg-white px-4 py-3 mt-2 mb-2">
                          <div class="ouvrage-header d-flex">
                            <div class="col-7">
                              <div class="col-5 d-flex align-items-center cursor-pointer toggle-btn" @click="togglePanel">
                                <span class="prestation-icon me-2"></span> 
                                <span class="me-4">Prestations</span>
                                <span class="arrow-icon ms-auto"></span>
                              </div>
                              <div class="add-btn ms-5 ps-3 d-flex align-items-center mulish-semibold font-14 custom-text-danger cursor-pointer" 
                              @click="openPrestationModal(zoneIndex)">
                                <span class="plus-icon me-2"></span> AJOUTER UN OUVRAGE
                              </div>
                            </div>
                            <div class="col-5 d-flex align-items-center">
                              <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">{{ zone.prestationOuvrage.totalHour }} hr</div>
                              <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">{{ zone.prestationOuvrage.unitPrice }} €</div>
                              <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">{{ zone.prestationOuvrage.totalPrice }} €</div>
                            </div>
                          </div>
                          <div class="ouvrage-body ms-5 ps-3 mt-3">
                            <div class="ouvrage-list d-flex">
                              <div class="col-4">
                                <ul class="nav flex-column">
                                  <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center px-0 active" data-id="home" href="javascript:;"
                                      @click="activeItem"
                                    >
                                      <span class="option-icon me-2"><span class="option-icon-dot"></span></span> Ouvrage Securite
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center px-0" data-id="menu1" href="javascript:;"
                                      @click="activeItem"
                                    >
                                      <span class="option-icon me-2"><span class="option-icon-dot"></span></span>Narcelle 30 mm
                                    </a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link d-flex align-items-center px-0" data-id="menu2" href="javascript:;"
                                      @click="activeItem">
                                      <span class="option-icon me-2"><span class="option-icon-dot"></span></span>Ouvrage Secu1
                                    </a>
                                  </li>
                                </ul>
                              </div>
                              <div class="col-8">
                                <table class="table table-hover table-bordered" style="margin-top: -40px">
                                  <tbody>
                                    <tr v-for="(item, index) in 5" :key="index">
                                      <td class="text-center">2</td>
                                      <td class="text-center">UN</td>
                                      <td class="text-center">0 hr</td>
                                      <td class="text-center"></td>
                                      <td class="text-center">2 000 €</td>
                                      <td class="text-center">
                                        <svg @click="removeOuvrage(index)" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17 6H22V8H20V21C20 21.2652 19.8946 21.5196 19.7071 21.7071C19.5196 21.8946 19.2652 22 19 22H5C4.73478 22 4.48043 21.8946 4.29289 21.7071C4.10536 21.5196 4 21.2652 4 21V8H2V6H7V3C7 2.73478 7.10536 2.48043 7.29289 2.29289C7.48043 2.10536 7.73478 2 8 2H16C16.2652 2 16.5196 2.10536 16.7071 2.29289C16.8946 2.48043 17 2.73478 17 3V6ZM18 8H6V20H18V8ZM13.414 14L15.182 15.768L13.768 17.182L12 15.414L10.232 17.182L8.818 15.768L10.586 14L8.818 12.232L10.232 10.818L12 12.586L13.768 10.818L15.182 12.232L13.414 14ZM9 4V6H15V4H9Z" fill="black"/>
                                        </svg>
                                      </td>
                                    </tr>
                                  </tbody>
                                </table>
                              </div>
                            </div>
                            <!-- Tab panes -->
                            <div class="tab-content">
                              <div class="tab-pane active ps-3" id="home">
                                <h3 class="mulish-light fw-light custom-text-danger font-14">TEXTE COMMENTAIRE TECHNIQUE</h3>
                                <ul class="ps-3">
                                  <li class="mulish-regular font-10">Kindly note that we will only accept POS payment option on delivery</li>
                                  <li class="mulish-regular font-10">You have to make payment before opening package</li>
                                  <li class="mulish-regular font-10">Once the seal is broken, item can only be returned if damaged or defective </li>
                                </ul>
                                <h3 class="mt-3 mulish-light fw-light text-custom-success font-14">TEXTE POUR CLIENTS</h3>
                                <ul class="ps-3">
                                  <li class="mulish-regular font-10 custom-text-danger">Kindly note that we will only accept POS payment option on delivery</li>
                                  <li class="mulish-regular font-10 custom-text-danger">You have to make payment before opening package</li>
                                </ul>                                
                              </div>
                              <div class="tab-pane ps-3" id="menu1">
                                <h3 class="mulish-light fw-light custom-text-danger font-14">TEXTE COMMENTAIRE TECHNIQUE</h3>
                                <ul class="ps-3">
                                  <li class="mulish-regular font-10">Kindly note that we will only accept POS payment option on delivery</li>
                                  <li class="mulish-regular font-10">You have to make payment before opening package</li>
                                  <li class="mulish-regular font-10">Once the seal is broken, item can only be returned if damaged or defective </li>
                                </ul>
                                <h3 class="mt-3 mulish-light fw-light text-custom-success font-14">TEXTE POUR CLIENTS</h3>
                              </div>
                              <div class="tab-pane ps-3" id="menu2">
                                <h3 class="mulish-light fw-light custom-text-danger font-14">TEXTE COMMENTAIRE TECHNIQUE</h3>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="ms-2 right-panel">
                      <div class="section bg-white">
                        <div class="d-flex">
                          <div class="col-10 d-flex flex-wrap">
                            <p class="w-100 m-0 title">
                              Arrondir les heures
                            </p>
                            <p class="w-100 m-0 sub-title">
                              Les jours du Chantiers
                            </p>
                          </div>
                          <div class="col-2 d-flex align-items-center">
                            <p class="w-100 text-center font-16 mulish-extrabold">
                              2 jours
                            </p>
                          </div>
                        </div>
                        <div class="d-flex mt-2">
                          <div class="col-10 d-flex flex-wrap">
                            <p class="w-100 m-0 title">
                              Remise Euros :  
                            </p>
                            <p class="w-100 m-0 sub-title">
                              A convertir en heure et a soustraire au total d’heures
                            </p>
                          </div>
                          <div class="col-2 d-flex align-items-center">
                            <p class="w-100 text-center font-16 mulish-extrabold">
                              5 000 €
                            </p>
                          </div>
                        </div>
                      </div>
                      <div class="section mt-2 bg-white">
                        <div class="d-flex">
                          <div class="d-flex flex-wrap col-8">
                            <p class="w-100 title m-0">
                              Synthese Chantier
                            </p>
                            <p class="w-100 m-0 sub-title">
                              Apud has gentes, quarum exordiens 
                            </p>
                          </div>
                          <div class="col-2 d-flex align-items-center justify-content-center fw-bold mulish-extra-bold font-16 text-black">16 hr</div>
                          <div class="col-2 d-flex align-items-center justify-content-center fw-bold mulish-extra-bold font-16 text-black">15 000 €</div>
                        </div>
                        <div class="d-flex mt-4">
                          <div class="col-8 title">
                            Installation
                          </div>
                          <div class="col-2 border-bottom text-center border-end font-14">2hr</div>
                          <div class="col-2 border-bottom text-center font-14">2 000 €</div>
                        </div>
                        <div class="d-flex mt-3">
                          <div class="col-8 title">
                            Mise en Securite
                          </div>
                          <div class="col-2 border-bottom text-center border-end font-14">2hr</div>
                          <div class="col-2 border-bottom text-center font-14">2 000 €</div>
                        </div>
                        <div class="d-flex mt-3">
                          <div class="col-8 title">
                            Intervention
                          </div>
                          <div class="col-2 border-bottom text-center border-end font-14">12hr</div>
                          <div class="col-2 border-bottom text-center font-14">10 000 €</div>
                        </div>
                        <div class="d-flex mt-4">
                          <div class="col-10 bold-title">
                            Total Jours Interim
                          </div>
                          <div class="col-2 font-14 fw-bold">37 Jours</div>
                        </div>
                        <div class="d-flex mt-3">
                          <div class="col-10 bold-title">
                            Total M/V  Fourniseurs
                          </div>
                          <div class="col-2 font-14 fw-bold">€ 230 000</div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="file" @change="previewFile" ref="file" class="d-none">
        <zoom-modal ref="zoomModal"></zoom-modal>
        <OuvrageModal ref="ouvrageModal" @selectedOuvrage="selectedOuvrage"></OuvrageModal>
        <PrestationModal ref="prestationModal" @selectedOuvrage="selectedOuvrage"></PrestationModal>
        <SupplierModal ref="supplierModal"></SupplierModal>
        <AddressModal ref="addressModal" @addedNewAddress="addedNewAddress"></AddressModal>
      </div>
    </transition>
  </router-view>
</template>
<script>
import { ref, onMounted, watch, watchEffect } from 'vue';
import SelectBox from '../../components/miscellaneous/SelectBox';
import SearchCustomer from '../../components/miscellaneous/SearchCustomer';
import ZoomModal from '../../components/miscellaneous/ZoomModal';
import OuvrageModal from '../../components/miscellaneous/OuvrageModal';
import PrestationModal from '../../components/miscellaneous/PrestationModal';
import SupplierModal from '../../components/miscellaneous/SupplierModal';
import AddressModal from '../../components/miscellaneous/AddressModal';
import {     
  DISPLAY_LOADER,
  HIDE_LOADER,
  LOADER_MODULE 
  } from '../../store/types/types';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useStore } from 'vuex';
export default {
  components:{
    SearchCustomer,
    SelectBox,
    ZoomModal,
    OuvrageModal,
    PrestationModal,
    SupplierModal,
    AddressModal,
  },
  setup() {
    const store = useStore();
    const router = useRouter();
    const breadcrumbs = ref(['Choix client']);
    const devisCreateStep = ref('choose_customer');
    watchEffect(()=>{
      if(devisCreateStep.value == 'choose_customer'){
        breadcrumbs.value = ['Choix client'];
      }else if(devisCreateStep.value == 'choose_address'){
        breadcrumbs.value = ['Choix client', 'Choix adresse chantier'];
      }else{
        breadcrumbs.value = [];
      }
    })
    const zoneEdit = ref(false);
    const customerAddresses = ref([]);
    const zoneIndex = ref(0);
    var formData = new FormData();
    const file = ref(null);
    const zoomModal = ref(null);
    const ouvrageModal = ref(null);
    const prestationModal = ref(null);
    const supplierModal = ref(null);
    const addressModal = ref(null);
    const gedCatId = ref(0);
    const gedCats = ref([]);
    const form = ref({
      customer: {
        id: '',
        company: 'La boulangerie',
        raisonsocial: 'de la plangne',
        group: 'Lagardere',
        contact: 'Thierry Gavois',
        telephone: '58 58 74 58 44',
        tax: '10%',
        naf: 'Boulangerie',
        siret: '4654654646546546',
      },
      address: {
        id: '',
        name: '',
        address1: '',
        address2: '',
        postcode: '',
        city: '',
        addressType: '',
      },
      zones: [
        {
          name: 'Zone 1',
          roofAccess: 'Intérieur',
          roofAccess1: 'Echelle',
          gedCats: [],
          installOuvrage: {
            totalHour: 0,
            unitPrice: 0,
            totalPrice: 0,
            ouvrages: [
              {
                id: '',
                name: '',
                // techText: '',
                customerText: '',
                qty: '',
                unit: '',
                totalHour: '',
                toalQty: '',
                tasks:[
                  {
                    id: '',
                    name: '',
                    techText: '',
                    customerText: '',                    
                    details:[
                      {
                        id: '',
                        name: '',
                        qtyOuvrage: '',
                        qty: '',
                        unit: '',
                        numberH: '',
                        unitPrice: '',
                        marge: '',
                        totalPrice: '',
                        tax: '',
                      }
                    ]
                  }
                ]
              }
            ]
          },
          securityOuvrage: {
            totalHour: 0,
            unitPrice: 0,
            totalPrice: 0,
            ouvrages: []
          },
          prestationOuvrage: {
            totalHour: 0,
            unitPrice: 0,
            totalPrice: 0,
            ouvrages: []
          },          
        }
      ],
    });    
    onMounted(()=>{
      // axios.post('/get-ged-categories').then((res)=>{
      //   gedCats.value = res.data;
      //   form.value.zones.forEach(element => {
      //     element.gedCats = res.data;
      //   });
      // }).catch((error)=>{
      //   console.log(error);
      // })
    })
    const addFileToGed = (zone, catId)=>{
      zoneIndex.value = zone;
      gedCatId.value = catId;
      file.value.click();
    }
    const previewFile = ()=>{
      let image = file.value.files;
      formData.append('zone['+zoneIndex.value+']["gedCat"]['+ gedCatId.value +']', image[0]);
      if (image && image[0]) {
        let reader = new FileReader
        reader.onload = e => {
          form.value.zones[zoneIndex.value].gedCats[gedCatId.value][0].items.push({
            type: 'img',
            previewContent: e.target.result
          })
        }
        reader.readAsDataURL(image[0])
      }
    }
    const zoomImage = (content)=>{
      zoomModal.value.openModal(content);
    }
    const togglePanel = (event)=>{
      // toggle open class for 3th parent. (<div class="ouvrage-section bg-white px-4 py-3 mt-2 mb-2">)
      event.path[3].classList.toggle('open');
    }
    const openOuvrageModal = (title)=>{
      ouvrageModal.value.openModal(title);
    }
    const openPrestationModal = (zoneIndex)=>{
      prestationModal.value.openModal(zoneIndex);
    }
    const openSupplierModal = ()=>{
      supplierModal.value.openModal();
    }
        
    const addNewCustomer = ()=>{
      router.push({
        name: "customer-create"
      })
    }

    const addNewAddress = ()=>{
      addressModal.value.openModal(form.value.customer.id)
    }

    const addedNewAddress = (data)=>{
      customerAddresses.value.push(data);
    }
    
    const selectedCustomer = (data)=>{
      // move on to "addess choose step"
      devisCreateStep.value = 'choose_address';
      // set customer value to devis form
      form.value.customer = data;

      // loading customer addresses
      store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [true, 'Loading customer addresses..']);
      axios.post('/get-customer-addresses', { customer_id: data.id }).then((res)=>{
        customerAddresses.value = res.data;
      }).catch((error)=>{
        console.log(error);
      }).finally(()=>{
        store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
      })
    }
    // handler to choose other customer
    const chooseOtherCustomer = ()=>{
      devisCreateStep.value = 'choose_customer';
    }
    // handler to choose a customer address
    const chooseCustomerAddress = (data)=>{
      devisCreateStep.value = 'create_devis';
      form.value.address = data;
    }

    const selectedOuvrage = (data)=>{
      axios.post('/get-ouvrage', { id: data.ouvrageId }).then((res)=>{

      }).catch((error)=>{

      }).finally(()=>{

      });
    }
    const addZone = (index)=>{
      form.value.zones.push(
        {
          name: 'zone '+ (form.value.zones.length+1),
          roofAccess: 'Intérieur',
          roofAccess1: 'Echelle',
          gedCats: gedCats.value,
          installOuvrage: {
            totalHour: 0,
            unitPrice: 0,
            totalPrice: 0,
            tasks: []
          },
          securityOuvrage: {
            totalHour: 0,
            unitPrice: 0,
            totalPrice: 0,
            tasks: []
          },
          prestationOuvrage: {
            totalHour: 0,
            unitPrice: 0,
            totalPrice: 0,
            tasks: []
          },
        } 
      );
    }

    const removeZone = (index)=>{
      var zones = [];
      form.value.zones.forEach((element, i) => {
        if(index != i){
          zones.push(element);
        }   
      });
      form.value.zones = zones;
    }

    const activeItem = (event)=>{
      document.querySelectorAll('.nav-link').forEach((item)=>{
        item.classList.remove('active');
      })
      document.querySelectorAll('.tab-pane').forEach((item)=>{
        item.classList.remove('active');
      })
      event.target.classList.add('active');
      document.getElementById(event.target.getAttribute('data-id')).classList.add('active');
    }
    return {
      breadcrumbs,
      customerAddresses,
      devisCreateStep,
      form,
      zoneEdit,
      file,
      zoomModal,
      ouvrageModal,
      prestationModal,
      supplierModal,
      addressModal,
      addFileToGed,
      previewFile,
      zoomImage,
      togglePanel,
      openOuvrageModal,
      openPrestationModal,
      openSupplierModal,
      addNewCustomer,
      selectedCustomer,
      chooseOtherCustomer, // handler to choose other customer
      chooseCustomerAddress, // handler to choose customer addess
      addNewAddress, // handler to add a new address
      addedNewAddress, // address modal emits
      selectedOuvrage, // Ouvrage was choosed
      addZone,
      removeZone,
      activeItem,
    }
  },
}
</script>
<style lang="scss" scoped>
  /* width */
  ::-webkit-scrollbar {
    width: 9px;
  }
  /* Track */
  ::-webkit-scrollbar-track {
    background: #E0E0E0; 
  }
  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #47454B; 
    border-radius: 6px;
  }
  .bold-title{
    font-family: "Mulish ExtraBold";
    font-weight: 800;
    font-size: 20px;
    line-height: 18px;
  }
  .title{
    font-family: "Mulish SemiBold";
    font-weight: 600;
    font-size: 20px;
    line-height: 18px;
  }
  .sub-title{
    font-family: "Mulish Regular";
    font-weight: 400;
    font-size: 15px;
    color: #324A59;
    line-height: 194.62%;
  }
  .small-title{
    font-family: "Mulish SemiBold";
    font-size: 10px;
    color: rgba(0, 24, 51, 0.22);
    line-height: 12.55px;    
  }
  .breadcrumb{
    .breadcrumb-item + .breadcrumb-item::before{
      content: '>';
      color: black;
    }
  }
  .customer-addresses{
    height: 400px;
    overflow-y: auto;
  }
  .nav-link {
    .option-icon{
      display: block;
      width: 13px;
      height: 13px;
      padding: 3px;
      border-radius: 50%;
      border: solid 1px #E8581B;
      .option-icon-dot{
        display: block;
        height: 100%;
        border-radius: 50%;
        background-color: transparent;
      }
    }
    &.active{
      .option-icon-dot{
        background-color: #E8581B;
      }      
    }
    *{
      pointer-events: none;
    }
  }
  .main-view{
    padding: 60px 10px 0 80px;
    .devis-panel{
      margin-top: 28px;
      .left-panel{
        // width: 1019px;
        width: 60%;
        height: fit-content;
        .customer-section{
          .customer-pic{
            width: 42px;
            height: 42px;
          }
        }
        .zone-section{
          .image-overlayer:hover{
            background: rgba(0, 0, 0, .2);
            transition: background ease-out .3s;
          }
        }
        .ouvrage-section{
          .toggle-btn{
            span,
            svg{
              pointer-events: none;
            }
          }
          .ouvrage-body{
            display: none;
          }
        }
        .ouvrage-section.open{
          .ouvrage-body{
            display: block;
            transition: all ease-in .3s;
          }
        }
      }
      .right-panel{
        // width: 704px;
        width: 40%;
        height: fit-content;
        .section{
          padding: 15px 25px;
        }
      }
    }
  }
</style>