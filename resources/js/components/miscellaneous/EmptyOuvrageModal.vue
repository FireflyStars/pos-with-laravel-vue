<template>
    <Teleport to="body">
        <div class="search-layer d-flex align-items-center justify-content-center position-fixed" v-if="showModal">
            <transition name="list" appear>
                <div class="search-panel m-auto bg-white">
                    <div class="search-header text-capitalize d-flex align-items-center justify-content-center position-relative almarai-extrabold font-22">
                        <svg @click="closeModal" class="close-icon cursor-pointer" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.78812 5.2973C6.3976 4.90481 5.76444 4.90481 5.37392 5.2973C4.98339 5.6898 4.98339 6.32616 5.37392 6.71865L10.5883 11.9594L5.29289 17.2816C4.90237 17.6741 4.90237 18.3105 5.29289 18.703C5.68341 19.0955 6.31657 19.0955 6.7071 18.703L12.0025 13.3808L17.293 18.6979C17.6835 19.0904 18.3166 19.0904 18.7072 18.6979C19.0977 18.3054 19.0977 17.6691 18.7072 17.2766L13.4167 11.9594L18.6261 6.7237C19.0167 6.33121 19.0167 5.69485 18.6261 5.30235C18.2356 4.90986 17.6025 4.90986 17.2119 5.30235L12.0025 10.5381L6.78812 5.2973Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="search-body">
                        <div class="result-panel">
                            <div class="ouvrage-wrap">
                                <div class="ouvrage-item">
                                    <div class="d-flex">
                                        <div class="col-1" :class="{
                                            'installation-icon': type == 1,
                                            'securite-icon': type == 2,
                                            'prestation-icon': type == 3,
                                        }"></div>
                                        <div class="col-11">
                                            <p class="mt-3 mulish-extrabold font-16">Ajout ouvrage vide</p>
                                        </div>
                                    </div>
                                    <div class="almarai-light font-14 text-justify mt-5">
                                        Mise en place d'un complexe de sur toiture de type ONDUCLAIR RENOV FC avec isolation comprenant nettoyage du support, mise en place isolation polystyrène 50mm et plaque polystyrène opaque compris fixation 
                                    </div>
                                    <div class="d-flex justify-content-between mt-5">
                                        <div class="col-7 d-flex justify-content-between">
                                            <div class="form-group col-5">
                                                <SelectBox :label="'Unité'" 
                                                v-model="ouvrage.unit" 
                                                :options="units"
                                                :name="'unit'"
                                                :classnames="'w-100'"
                                                />                                                
                                            </div>
                                            <div class="form-group col-5">
                                                <label for="unit">Quantité</label>
                                                <input type="text" v-model="ouvrage.qtyOuvrage" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group col-4">
                                            <SelectBox :label="'Prestation'" 
                                                v-model="ouvrage.ouvrage_prestation_id" 
                                                :options="prestations"
                                                :name="'prestation'"
                                                :classnames="'w-100'"
                                            />
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="col-7">
                                            <div class="form-group">
                                                <label for="name">Nom ouvrage vide</label>
                                                <input type="text" id="name" v-model="ouvrage.name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group col-4">
                                            <SelectBox :label="'Métier'" 
                                                v-model="ouvrage.ouvrage_metier_id" 
                                                :options="metiers"
                                                :name="'metier'"
                                                :classnames="'w-100'"
                                            />
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <div class="col-7">
                                            <div class="form-group">
                                                <label for="textchargeaffaire">Texte pour chargé d’affaire</label>
                                                <input type="text" id="textchargeaffaire" v-model="ouvrage.textchargeaffaire" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group col-4">
                                            <SelectBox :label="'Toit'" 
                                                v-model="ouvrage.ouvrage_toit_id" 
                                                :options="toits"
                                                :name="'toit'"
                                                :classnames="'w-100'"
                                            />
                                        </div>
                                    </div>
                                    <div class="d-flex">
                                        <div class="col-7">
                                            <div class="form-group">
                                                <label for="customertext">Texte pour clients</label>
                                                <input type="text" id="customertext" v-model="ouvrage.customerText" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btns mt-4 d-flex justify-content-between">
                                        <button class="custom-btn btn-cancel" @click="closeModal">Annuler</button>
                                        <button class="custom-btn btn-ok" @click="confirm">Suivant</button>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </Teleport>
</template>
<script>
    import {ref, onMounted} from 'vue';
    import axios from 'axios';
    import SelectBox from '../../components/miscellaneous/SelectBox';
    export default {
        name: 'EmptyOuvrageModal',
        components:{
            SelectBox,
        },
        emits: ['selectedEmptyOuvrage'],
        setup(props, { emit }){
            const zoneIndex = ref(null);
            const type = ref('');
            const units = ref([]);
            const prestations = ref([]);
            const metiers = ref([]);
            const toits = ref([]);
            const ouvrage = ref({
                qty: 0,
                totalHour: 0,
                avg: 0,
                total: 0,
                totalWithoutMarge: 0,
                qtyOuvrage: 1,
                name: '',
                unit: '',
                textchargeaffaire: '',
                customerText: '',
                textoperator: '',
                ouvrage_prestation_id: '',
                ouvrage_metier_id: '',
                ouvrage_toit_id: '',
                tasks: []
            });            
            const closeModal = ()=>{
                showModal.value = !showModal.value;
            }
            const showModal = ref(false);
            const openModal = (data)=>{
                zoneIndex.value = data.zoneIndex;
                type.value = data.type;
                showModal.value = !showModal.value;
            }  
            onMounted(()=>{
                if(toits.value.length == 0){
                    axios.post('/get-info-for-emtpy-ouvrage').then((res)=>{
                        units.value = res.data.units;
                        toits.value = res.data.toits;
                        prestations.value = res.data.prestations;
                        metiers.value = res.data.metiers;
                    }).catch((error)=>{
                        console.log(error);
                    }).finally(()=>{
    
                    });
                }
            })
            const confirm = ()=>{
                showModal.value = false;
                emit('selectedEmptyOuvrage', type.value, zoneIndex.value, ouvrage.value);
            }        
            return {
                ouvrage,
                showModal,
                units,
                toits,
                metiers,
                prestations,
                type,
                openModal,
                closeModal,
                confirm,
            }
        }
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
    opacity: 1;
    transform: scale(1);
}
.list-leave-to{
    opacity: 0;
    transform: scale(0.6);
}
.list-leave-active{
    transition: all 1s ease;
    position: absolute;
    width: 100%;
}
.list-move{
    transition:all 0.9s ease;
}
.custom-btn{
    width: 96px;
    height: 40px;
    font-family: 'Almarai Bold';
    font-style: normal;
    font-weight: 700;
    font-size: 16px;
    line-height: 140%;
    border-radius: 4px;
    text-align: center;
    border: 1px solid #47454B;
    cursor: pointer;
}
.btn-cancel{
    color: rgba(0, 0, 0, 0.2);
}
.btn-ok{
    background: #A1FA9F;
    color: #3E9A4D;
}
.search-layer{
    width: 100%;
    height: 100%;
    top: 0;
    z-index: 11;
    background: rgba(0, 0, 0, 0.3);
    .search-panel{
        width: 600px;
        .search-header{
            .close-icon{
                position: absolute;
                top: 0;
                right: 0;
            }
        }
        .result-panel{
            .btns{
                .custom-btn{
                    width: 96px;
                    height: 40px;
                    font-family: 'Almarai Bold';
                    font-style: normal;
                    font-weight: 700;
                    font-size: 16px;
                    line-height: 140%;
                    border-radius: 4px;
                    text-align: center;
                    border: 1px solid #47454B;
                    cursor: pointer;
                }
                .btn-cancel{
                    color: rgba(0, 0, 0, 0.2);
                }
                .btn-ok{
                    background: #A1FA9F;
                    color: #3E9A4D;
                }
            }
        }
        .ouvrage-wrap{
            .ouvrage-item{
                padding: 15px 20px;
                background: #F8F8F8;
                box-shadow: inset 0px -1px 0px rgba(168, 168, 168, 0.25);
                .add-ouvrage-btn{
                    top: -5px;
                    right: 0;
                }
            }
        }
    }
}
</style>