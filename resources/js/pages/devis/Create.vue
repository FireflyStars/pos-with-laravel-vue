<template>
    <router-view>
        <transition enter-active-class="animate__animated animate__fadeIn">
            <div class="container-fluid h-100 bg-color">
                <main-header />
                <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap reports-page" style="z-index:100" >
                    <side-bar />
                    <div class="col main-view container">
                        <h1 class="d-flex align-items-center m-0">
                          <span class="devis-icon"></span>
                          <span class="ms-3 font-22 almarai_extrabold_normal_normal">Creation / Edition  Devis</span>
                        </h1>
                        <div class="devis-panel d-flex">
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
                                        M. Marcus Pinnochio
                                      </div>
                                    </div>
                                    <div class="ms-5 customer-edit d-flex align-items-center">
                                      <span class="edit-icon me-3"></span>
                                      <span class="call-external"></span>
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
                                    <div class="add-btn ms-3 d-flex align-items-center mulish-semibold font-14 custom-text-danger cursor-pointer">
                                      <span class="plus-icon me-2"></span> AJOUTER
                                    </div>
                                    <div class="remove-btn ms-3 d-flex align-items-center mulish-semibold font-14 custom-text-danger cursor-pointer">
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
                                        <p class="m-0 almarai-light font-14">43 Lower Sloane Street 31000 Toulouse</p>
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
                                      <div class="d-flex align-items-center cursor-pointer toggle-btn" @click="togglePanel">
                                        <span class="installation-icon me-2"></span> 
                                        <span class="me-4">Installation</span>
                                        <span class="arrow-icon"></span>
                                      </div>
                                      <div class="add-btn ms-5 ps-3 d-flex align-items-center mulish-semibold font-14 custom-text-danger cursor-pointer">
                                        <span class="plus-icon me-2"></span> AJOUTER UN OUVRAGE
                                      </div>
                                    </div>
                                    <div class="col-5 d-flex align-items-center">
                                      <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">2 hr</div>
                                      <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">15 000 €</div>
                                      <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">350 000 €</div>
                                    </div>
                                  </div>
                                  <div class="ouvrage-body ms-5 ps-3 mt-3">
                                    Ouvrage
                                  </div>
                                </div>

                                <div class="ouvrage-section bg-white px-4 py-3 mt-2 mb-2">
                                  <div class="ouvrage-header d-flex">
                                    <div class="col-7">
                                      <div class="d-flex align-items-center cursor-pointer toggle-btn" @click="togglePanel">
                                        <span class="securite-icon me-2"></span> 
                                        <span class="me-4">Sécurité</span>
                                        <span class="arrow-icon"></span>
                                      </div>
                                      <div class="add-btn ms-5 ps-3 d-flex align-items-center mulish-semibold font-14 custom-text-danger cursor-pointer">
                                        <span class="plus-icon me-2"></span> AJOUTER UN OUVRAGE
                                      </div>
                                    </div>
                                    <div class="col-5 d-flex align-items-center">
                                      <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">2 hr</div>
                                      <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">15 000 €</div>
                                      <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">350 000 €</div>
                                    </div>
                                  </div>
                                  <div class="ouvrage-body ms-5 ps-3 mt-3">
                                    Sécurité
                                  </div>
                                </div>

                                <div class="ouvrage-section bg-white px-4 py-3 mt-2 mb-2">
                                  <div class="ouvrage-header d-flex">
                                    <div class="col-7">
                                      <div class="d-flex align-items-center cursor-pointer toggle-btn" @click="togglePanel">
                                        <span class="prestation-icon me-2"></span> 
                                        <span class="me-4">Prestations</span>
                                        <span class="arrow-icon"></span>
                                      </div>
                                      <div class="add-btn ms-5 ps-3 d-flex align-items-center mulish-semibold font-14 custom-text-danger cursor-pointer">
                                        <span class="plus-icon me-2"></span> AJOUTER UN OUVRAGE
                                      </div>
                                    </div>
                                    <div class="col-5 d-flex align-items-center">
                                      <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">2 hr</div>
                                      <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">15 000 €</div>
                                      <div class="col-4 fw-bold mulish-extra-bold font-16 text-black text-center">350 000 €</div>
                                    </div>
                                  </div>
                                  <div class="ouvrage-body ms-5 ps-3 mt-3">
                                    Prestations
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
            </div>
        </transition>
    </router-view>
</template>
<script>
import { ref, onMounted } from 'vue';
import SelectBox from '../../components/miscellaneous/SelectBox.vue';
import ZoomModal from '../../components/miscellaneous/ZoomModal.vue';

import axios from 'axios';
export default {
  components:{
    SelectBox,
    ZoomModal
  },
  setup() {
    const zoneEdit = ref(false);
    const zoneIndex = ref(0);
    var formData = new FormData();
    const file = ref(null);
    const zoomModal = ref(null);
    const gedCatId = ref(0);
    onMounted(()=>{
      axios.post('/get-ged-categories').then((res)=>{
        form.value.zones.forEach(element => {
          element.gedCats = res.data;
        });
      }).catch((error)=>{
        console.log(error);
      })
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
    const form = ref({
      zones: [
        {
          name: 'Usine',
          roofAccess: 'Intérieur',
          roofAccess1: 'Echelle',
          gedCats: [],
        }
      ],
    });

    return {
      form,
      zoneEdit,
      file,
      zoomModal,
      addFileToGed,
      previewFile,
      zoomImage,
      togglePanel
    }
  },
}
</script>
<style lang="scss" scoped>
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