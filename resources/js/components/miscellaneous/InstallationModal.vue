<template>
    <Teleport to="body">
        <div class="search-layer d-flex align-items-center justify-content-center position-fixed" v-if="showModal">
            <transition name="list" appear>
                <div class="search-panel m-auto bg-white">
                    <div class="search-header text-capitalize d-flex align-items-center justify-content-center position-relative almarai-extrabold font-22">
                        <span class="devis-icon me-3"></span> Ajout ouvrage Installation
                        <svg @click="closeModal" class="close-icon cursor-pointer" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.78812 5.2973C6.3976 4.90481 5.76444 4.90481 5.37392 5.2973C4.98339 5.6898 4.98339 6.32616 5.37392 6.71865L10.5883 11.9594L5.29289 17.2816C4.90237 17.6741 4.90237 18.3105 5.29289 18.703C5.68341 19.0955 6.31657 19.0955 6.7071 18.703L12.0025 13.3808L17.293 18.6979C17.6835 19.0904 18.3166 19.0904 18.7072 18.6979C19.0977 18.3054 19.0977 17.6691 18.7072 17.2766L13.4167 11.9594L18.6261 6.7237C19.0167 6.33121 19.0167 5.69485 18.6261 5.30235C18.2356 4.90986 17.6025 4.90986 17.2119 5.30235L12.0025 10.5381L6.78812 5.2973Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="search-body">
                        <div class="d-flex justify-content-center mt-5">
                            <div class="search-part d-flex align-items-center justify-content-between px-3">
                                <input type="text" ref="queryElement" class="w-100" placeholder="Rechercher dans base ouvrage">
                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8.25982 0.0710449C10.2565 0.0710449 12.1713 0.890046 13.5832 2.34788C14.995 3.80571 15.7882 5.78295 15.7882 7.84464C15.7882 9.7701 15.1048 11.5401 13.9814 12.9035L14.2941 13.2264H15.2091L21.0001 19.206L19.2628 21L13.4718 15.0203V14.0755L13.1591 13.7526C11.793 14.9566 10.0559 15.6181 8.25982 15.6182C6.26317 15.6182 4.3483 14.7992 2.93645 13.3414C1.52461 11.8836 0.731445 9.90633 0.731445 7.84464C0.731445 5.78295 1.52461 3.80571 2.93645 2.34788C4.3483 0.890046 6.26317 0.0710449 8.25982 0.0710449ZM8.25982 2.46292C5.36429 2.46292 3.04787 4.8548 3.04787 7.84464C3.04787 10.8345 5.36429 13.2264 8.25982 13.2264C11.1553 13.2264 13.4718 10.8345 13.4718 7.84464C13.4718 4.8548 11.1553 2.46292 8.25982 2.46292Z" fill="black"/>
                                </svg>
                            </div>
                        </div>
                        <div class="result-panel mt-4">
                            <div v-if="step == 1">
                                <div class="ouvrage-wrap border-bottom" v-for="(item, index) in ouvrages" :key="index" :class="{ 'border-top': index == 0 }">
                                    <div class="ouvrage-item d-flex">
                                        <div class="col-1 installation-icon"></div>
                                        <div class="ouvrage-item-content col-11 ps-3 position-relative">
                                            <p class="mt-3 mulish-extrabold font-16">{{ item.name }}</p>
                                            <div class="my-2 ps-2 almarai-light font-14 text-justify">
                                                {{ item.textchargeaffaire }}
                                            </div>
                                            <div class="d-flex justify-content-between ps-2">
                                                <div class="custom-text-danger almarai-light font-14">{{ item.type }}</div>
                                                <div class="custom-text-danger almarai-light font-14">{{ item.metier }}</div>
                                                <div class="custom-text-danger almarai-light font-14">{{ item.toit }}</div>
                                            </div>
                                            <div class="add-ouvrage-btn d-flex align-items-center mulish-semibold font-14 custom-text-danger cursor-pointer position-absolute"
                                                @click="selectOuvrage(item)"
                                            >
                                                <span class="plus-icon me-2"></span> AJOUTER CET OUVRAGE
                                            </div>
                                        </div>
                                    </div>                                
                                </div>
                            </div>
                            <div class="ouvrage-wrap" v-else>
                                <div class="ouvrage-item">
                                    <div class="d-flex">
                                        <div class="col-1 installation-icon"></div>
                                        <div class="col-11">
                                            <p class="mt-3 mulish-extrabold font-16">{{ ouvrage.name }}</p>
                                        </div>
                                    </div>
                                    <div class="almarai-light font-14 text-justify">
                                        {{ ouvrage.textchargeaffaire }}
                                    </div>
                                    <div class="d-flex justify-content-between px-5">
                                        <div class="form-group col-5">
                                            <label for="unit">Unité</label>
                                            <input type="text" id="unit" :value="ouvrage.unit" readonly class="form-control">
                                        </div>
                                        <div class="form-group col-5">
                                            <label for="unit">Quantité</label>
                                            <input type="text" v-model="ouvrage.qtyOuvrage" class="form-control">
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

import {nextTick, ref} from 'vue';
import axios from 'axios';
import {
    LOADER_MODULE,
    DISPLAY_LOADER,
    HIDE_LOADER,
} from '../../store/types/types';
import { useStore } from 'vuex';

export default {
    name: 'InstallationModal',
    props: {
        modelValue: Object
    },
    emits: ['selectedOuvrage'],
    components:{
    },
    setup(props, { emit }){
        const store = useStore();
        const ouvrages = ref([
        ]);
        const step = ref(1);
        const query = ref('');
        const ouvrage = ref({
            id: '',
            qtyOuvrage: 1,
            name: '',
            textchargeaffaire: '',            
        });
        
        const queryElement = ref(null);
        const zoneIndex = ref(null);
        
        const closeModal = ()=>{
            showModal.value = !showModal.value;
        }
        
        const searchOuvrage = async ()=>{
            store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [true, 'Search Ouvrage...']);
            axios.post('/search-ouvrage', {
                search: query.value,
                type: '',
            }).then((response)=>{
                ouvrages.value = response.data;
            }).catch((error)=>{
                console.log(error)
            }).finally(()=>{
                store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
            })
        }
        const showModal = ref(false);

        const openModal = (index)=>{
            step.value = 1;
            zoneIndex.value = index;
            showModal.value = !showModal.value;
            nextTick(()=>{
                queryElement.value.focus();
            })
            store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [true, 'Loading Installation Ouvrages...']);
            axios.post('/search-ouvrage', {
                search: query.value,
                type: 'INSTALLATION',
            }).then((response)=>{
                ouvrages.value = response.data;
            }).catch((error)=>{
                console.log(error)
            }).finally(()=>{
                store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`);
            })
        };

        const selectOuvrage = (data)=>{
            ouvrage.value.id = data.id;
            ouvrage.value.unit = data.unit;
            ouvrage.value.name = data.name;
            ouvrage.value.textchargeaffaire = data.textchargeaffaire;
            step.value = 2;
        };

        const confirm = ()=>{
            showModal.value = false;
            emit('selectedOuvrage', { 
                type: 'installation',
                ouvrageId: ouvrage.value.id,
                qtyOuvrage: ouvrage.value.qtyOuvrage,
                zoneIndex: zoneIndex.value
            });
        };

        return {
            query,
            step,
            ouvrage,
            ouvrages,
            showModal,
            queryElement,
            searchOuvrage,
            closeModal,
            openModal,
            selectOuvrage,
            confirm
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
        width: 700px;
        height: 800px;
        padding: 40px 35px;
        .search-header{
            .close-icon{
                position: absolute;
                top: 0;
                right: 0;
            }
        }
        .result-panel{
            height: 600px;
            overflow-y: auto;
        }
        .search-part{
            width: 332px;
            height: 39px;
            border: 1px solid #000000;
            border-radius: 10px;
            input,
            input:focus{
                border: none;
                outline: none;
                box-shadow: none;
            }
        }
        .ouvrage-wrap{
            padding: 15px 20px;
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