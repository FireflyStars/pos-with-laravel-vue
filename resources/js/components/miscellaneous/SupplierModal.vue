<template>
    <Teleport to="body">
        <div class="search-layer d-flex align-items-center justify-content-center position-fixed" v-if="showModal">
            <transition name="list" appear>
                <div class="search-panel m-auto bg-white">
                    <div class="search-header d-flex align-items-center justify-content-center position-relative almarai-extrabold font-22">
                        <span class="devis-icon me-3"></span> Ajout commande fournisseur
                        <svg @click="closeModal" class="close-icon cursor-pointer" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M6.78812 5.2973C6.3976 4.90481 5.76444 4.90481 5.37392 5.2973C4.98339 5.6898 4.98339 6.32616 5.37392 6.71865L10.5883 11.9594L5.29289 17.2816C4.90237 17.6741 4.90237 18.3105 5.29289 18.703C5.68341 19.0955 6.31657 19.0955 6.7071 18.703L12.0025 13.3808L17.293 18.6979C17.6835 19.0904 18.3166 19.0904 18.7072 18.6979C19.0977 18.3054 19.0977 17.6691 18.7072 17.2766L13.4167 11.9594L18.6261 6.7237C19.0167 6.33121 19.0167 5.69485 18.6261 5.30235C18.2356 4.90986 17.6025 4.90986 17.2119 5.30235L12.0025 10.5381L6.78812 5.2973Z" fill="black"/>
                        </svg>
                    </div>
                    <div class="search-body">
                        <div class="result-panel mt-4">
                            <div class="col-12 form-group">
                                <label>Nom</label>
                                <input type="text" v-model="supplier.name" placeholder="Nom" class="form-control">
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <div class="col-5">
                                    <SelectBox :label="'Fournisseur'" 
                                        v-model="supplier.supplier_id" 
                                        :options="suppliers"
                                        :name="'Fournisseur'"
                                        :classnames="'w-100'"
                                        :placeholder="'Fournisseur'"
                                    />
                                </div>
                                <div class="col-5 form-group">
                                    <label>Montant HT</label>
                                    <input type="text" v-model="supplier.unitPrice" placeholder="Montant HT" class="form-control">
                                </div>
                            </div>
                            <div class="d-flex mt-3 justify-content-between">
                                <div class="col-5 form-group">
                                    <label>Date</label>
                                    <input type="date" v-model="supplier.datesupplier" placeholder="Date" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 mt-3">
                                <input type="file" class="form-control" @change="readFile" accept="application/pdf" id="commande-file">
                            </div>
                            <div class="btns mt-4 d-flex justify-content-between px-5">
                                <button class="custom-btn btn-cancel" @click="closeModal">Annuler</button>
                                <button class="custom-btn btn-ok" @click="selectSupplier">Validé</button>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </Teleport>
</template>
<script>

import {onMounted, ref} from 'vue';
import axios from 'axios';
import SelectBox from '../../components/miscellaneous/SelectBox';

export default {
    name: 'SupplierModal',
    props: {
        modelValue: Object
    },
    emits: ['selectedSupplier'],
    components:{
        SelectBox
    },
    setup(props, { emit }){
        const suppliers = ref([]);
        onMounted(()=>{
            axios.post('/get-suppliers').then((res)=>{
                suppliers.value = res.data;
            }).catch((error)=>{
                
            })
        })
        const closeModal = ()=>{
            showModal.value = !showModal.value;
        }
        const supplier = ref({
            supplier_id: '',
            name: '',
            type: 'COMMANDE FOURNISSEUR',
            unitPrice: '',
            base64: '',
            datesupplier: '',
            tax: '',
            marge: '',
            zoneIndex: '',
            ouvrageType: '',
            ouvrageId: '',
            taskId: '',
            qtyOuvrage: '',
        })
        const showModal = ref(false);
        const openModal = (zoneIndex, ouvrageType, ouvrageId, taskId)=>{
            supplier.value = {
                supplier_id: '',
                type: 'COMMANDE FOURNISSEUR',
                name: '',
                unitPrice: '',
                base64: '',
                datesupplier: '',
                tax: '',
                marge: 8,
                zoneIndex: zoneIndex,
                ouvrageType: ouvrageType,
                ouvrageId: ouvrageId,
                taskId: taskId,
                qtyOuvrage: '',
            }
            showModal.value = !showModal.value;
        }  
        const selectSupplier = (index)=>{
            showModal.value = false;
            emit('selectedSupplier', supplier.value);
        }
        const readFile = (event)=>{
            let file = event.target.files[0];
            let reader = new FileReader();
            reader.onload = (e) => {
               supplier.value.base64 = reader.result; 
            };
            reader.readAsDataURL(file);
        }
        return {
            suppliers,
            supplier,
            showModal,
            readFile,
            closeModal,
            openModal,
            selectSupplier,
        }
    }

}
</script>
<style lang="scss" scoped>
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
.search-layer{
    width: 100%;
    height: 100%;
    top: 0;
    z-index: 11;
    background: rgba(0, 0, 0, 0.3);
    .search-panel{
        width: 600px;
        padding: 40px 35px;
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
    }
}
</style>