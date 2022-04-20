<template>
    <router-view>
        <transition enter-active-class="animate__animated animate__fadeIn">
            <div class="container-fluid h-100 bg-color">
                <main-header />
                <div class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap reports-page" style="z-index:100" >
                    <side-bar />
                    <div class="col main-view container">
                        <h1 class="m-0"> 
                            <svg width="44" height="46" viewBox="0 0 44 46" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.40418 7.57715C4.89168 7.57715 3.65527 8.87573 3.65527 10.4927V18.2595H5.49188V10.4927C5.49188 9.95797 5.90001 9.52521 6.40418 9.52521H28.3715V7.57715H6.40418Z" fill="black"/>
                                <path d="M6.40408 36.2947C5.89992 36.2947 5.49179 35.8618 5.49179 35.327V25.6123H3.66718V35.327C3.66718 36.9313 4.89158 38.2426 6.41609 38.2426H15.5751V36.3074H6.40408V36.2947Z" fill="black"/>
                                <path d="M29.0317 38.621L6.80027 15.0409C6.44015 14.6589 5.86396 14.6589 5.50384 15.0409L0.27009 20.5921C-0.09003 20.9741 -0.09003 21.5853 0.27009 21.9673L22.5015 45.5472C22.8616 45.9292 23.4378 45.9292 23.7979 45.5472L29.0317 39.996C29.3918 39.6268 29.3918 39.0157 29.0317 38.621C29.0317 38.6337 29.0317 38.6337 29.0317 38.621ZM23.1497 43.4846L2.21474 21.2797L6.15205 17.1035L27.087 39.3212L23.1497 43.4846Z" fill="black"/>
                                <path d="M39.5592 36.1226H25.8266V38.0579H35.898V42.9088C35.898 43.4436 36.3061 43.8765 36.8103 43.8765H39.5592C41.5759 43.9274 43.2564 42.2341 43.3164 40.0951C43.3645 37.956 41.7679 36.1735 39.7512 36.1099C39.6792 36.1226 39.6192 36.1226 39.5592 36.1226ZM39.5592 41.9539H37.7346V38.0707H39.5592C40.5675 38.0707 41.3958 38.9364 41.3958 40.0186C41.3958 41.1008 40.5675 41.9412 39.5592 41.9539Z" fill="black"/>
                                <path d="M39.5543 6.99268H34.9808V8.928H39.5543C40.5626 8.928 41.3789 9.79367 41.3789 10.8759V40.0073H43.2035V10.8759C43.2155 8.7369 41.571 6.99268 39.5543 6.99268Z" fill="black"/>
                                <path d="M16.5147 26.9772L13.7617 29.8896L15.0532 31.256L17.8062 28.3435L16.5147 26.9772Z" fill="black"/>
                                <path d="M12.9196 23.1612L10.1666 26.0737L11.4581 27.4401L14.2111 24.5276L12.9196 23.1612Z" fill="black"/>
                                <path d="M20.1076 30.7916L17.3546 33.7041L18.6461 35.0705L21.3991 32.158L20.1076 30.7916Z" fill="black"/>
                                <path d="M23.7051 34.61L20.9521 37.5225L22.2437 38.8888L24.9966 35.9764L23.7051 34.61Z" fill="black"/>
                                <path d="M9.32204 19.3453L6.56909 22.2578L7.86061 23.6242L10.6136 20.7117L9.32204 19.3453Z" fill="black"/>
                                <path d="M38.7645 2.14847L37.5041 0.811679C36.4357 -0.27056 34.7431 -0.27056 33.6748 0.811679L19.7501 15.581C19.39 15.963 19.39 16.5741 19.7501 16.956L23.5434 20.9795C23.9035 21.3614 24.4797 21.3614 24.8398 20.9795L38.7645 6.21013C39.8208 5.08969 39.8208 3.2689 38.7645 2.14847ZM37.4681 4.83495L24.1916 18.9169L21.6948 16.2686L34.9592 2.1867C35.3073 1.8302 35.8475 1.8302 36.1956 2.1867L37.456 3.52365C37.8042 3.88015 37.8042 4.46571 37.4681 4.83495Z" fill="black"/>
                                <path d="M24.2696 19.064L20.3203 20.4647L21.6408 16.263L19.9002 15.6519L18.0036 21.6869C17.8475 22.1962 18.1116 22.7436 18.5917 22.9092C18.6878 22.9346 18.7838 22.9601 18.8799 22.9601C18.9759 22.9601 19.0719 22.9474 19.1679 22.9092L24.8578 20.8975L24.2696 19.064Z" fill="black"/>
                                <path d="M32.5709 3.51695L31.2794 4.8833L35.0774 8.9014L36.369 7.53505L32.5709 3.51695Z" fill="black"/>
                                <path d="M32.4997 20.9756H18.7671V22.9109H32.4997V20.9756Z" fill="black"/>
                                <path d="M36.0168 20.9756H34.1922V22.9109H36.0168V20.9756Z" fill="black"/>
                                <path d="M39.552 20.9756H37.7274V22.9109H39.552V20.9756Z" fill="black"/>
                            </svg>
                            <span class="ms-3 font-22 almarai_extrabold_normal_normal">Creation / Edition  Devis</span>
                        </h1>
                        <div class="devis-panel d-flex">
                            <div class="left-panel bg-white">
                              <div class="customer-section px-3 py-2 d-flex">
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
                                  <div class="ms-auto me-3 price-section d-flex align-items-end">
                                    <span class="mx-3 fw-bold mulish-extra-bold font-16 text-black">15 hr</span>
                                    <span class="mx-3 fw-bold mulish-extra-bold font-16 text-black">15 000 €</span>
                                    <span class="mx-3 fw-bold mulish-extra-bold font-16 text-black">350 000 €</span>
                                  </div>
                              </div>
                              <div class="zone-section px-3 py-2" v-for="(zone, index) in form.zones" :key="index">
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
                                    <div class="col-3 bg-primary"
                                    :style="{ 'background-image': `url(${previewImage})` }"
                                    >

                                    </div>
                                  </div>
                                </div>
                                <div class="d-flex px-4 mt-4 flex-wrap">
                                  <div class="col-6 mb-3" v-for="(gedCat, index) in gedCats" :key="index">
                                    <div class="ged-cat-header d-flex align-items-end mulish-semibold font-16 custom-text-danger">
                                      <span class="camera-icon me-2"></span> {{ gedCat.name }} 
                                      <div class="add-btn ms-3 d-flex align-items-center mulish-semibold font-14 custom-text-danger cursor-pointer"
                                       @click="addFileToGed(gedCat.id)">
                                        <span class="plus-icon me-2"></span> AJOUTER
                                      </div>
                                    </div>
                                    <div class="ged-cat-content mt-3 mb-3">
                                      &nbsp;
                                    </div>
                                    <div v-if="gedCat.name == 'Vue Exterieur'" class="get-cat-footer almarai-light font-14 mb-3">
                                      Attention grosse poutre en haut
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
            </div>
        </transition>
    </router-view>
</template>
<script>
import { ref } from '@vue/reactivity'
import SelectBox from '../../components/miscellaneous/SelectBox.vue';
export default {
  components:{
    SelectBox
  },
  setup() {
    const zoneEdit = ref(false);
    const formData = new FormData();
    const file = ref(null);
    const previewImage = ref('');
    const getCatId = ref(0);
    const gedCats = ref([
      {
        id: 1,
        name: 'Environment',
        items: [
          {
            type: 'img',
            content: null,
          }
        ]
      },
      {
        id: 2,
        name: 'Vue Exterieur'
      },
      {
        id: 3,
        name: 'Vue Interieur'
      },
      {
        id: 4,
        name: 'Metre'
      },
    ])
    const addFileToGed = (gedCatId)=>{
      getCatId.value = gedCatId;
      file.value.click();
    }
    const previewFile = ()=>{
      let image = file.value.files;
      if (image && image[0]) {
        let reader = new FileReader
        reader.onload = e => {
          previewImage.value = e.target.result
        }
        reader.readAsDataURL(image[0])
      }      
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
      gedCats,
      file,
      previewImage,
      addFileToGed,
      previewFile
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