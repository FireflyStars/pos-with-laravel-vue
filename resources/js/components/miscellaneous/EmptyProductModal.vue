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
                                    <h3 class="mt-3 mulish-extrabold font-16">Ajout produit vide</h3>
                                    <div class="almarai-light font-14 text-justify mt-5 px-5">
                                        Mise en place d'un complexe de sur toiture de type ONDUCLAIR RENOV FC avec isolation comprenant nettoyage du support, mise en place isolation polystyrène 50mm et plaque polystyrène opaque compris fixation 
                                    </div>
                                    <div class="d-flex justify-content-between px-5 mt-3">
                                        <div class="col-6 d-flex justify-content-between">
                                            <div class="form-group col-5">
                                                <label for="unit">Unité</label>
                                                <input type="text" id="unit" @change="setUnitCode" v-model="product.unit_id" class="form-control">
                                            </div>
                                            <div class="form-group col-5">
                                                <label for="unit">Quantité</label>
                                                <input type="text" v-model="product.qty" class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group col-5">
                                            <label for="unit">&nbsp;</label>
                                            <input type="text" v-model="product.type" class="form-control">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between px-5 mt-3">
                                        <div class="form-group col-5">
                                            <label for="productName">Nom produit</label>
                                            <input type="text" id="productName" v-model="product.name" class="form-control">
                                        </div>
                                        <div class="form-group col-5">
                                            <label for="productPrice">Prix d’achat</label>
                                            <input type="text" id="productPrice" v-model="product.productPrice" class="form-control">
                                        </div>
                                    </div>
                                    <div class="px-5 mt-3">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <input type="text" id="description" v-model="product.description" class="form-control">
                                        </div>
                                    </div>
                                    <div class="btns mt-4 d-flex justify-content-between px-5">
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
        name: 'EmptyProductModal',
        components:{
            SelectBox,
        },
        emits: ['selectedEmptyProduct'],
        setup(props, { emit }){
            const data = ref({});
            const units = ref({});
            const product = ref({
                unit_id: '',
                unit: '',
                qty: '',
                type: 'PRODUIT VIDE',
                name: '',
                productPrice: 0,
                description: '',
            });            
            const closeModal = ()=>{
                showModal.value = !showModal.value;
            }
            const showModal = ref(false);
            const openModal = (value)=>{
                data.value = value;
                showModal.value = !showModal.value;
            }  
            onMounted(()=>{
                if(units.value.length == 0){
                    axios.post('/get-units').then((res)=>{
                        units.value = res.data;
                    }).catch((error)=>{
                        console.log(error);
                    }).finally(()=>{
    
                    });
                }
            })
            const confirm = ()=>{
                showModal.value = false;
                emit('selectedEmptyProduct', data.value, product.value);
            }        
            const setUnitCode = ()=>{
                product.value.unit = units.value.filter((item)=>{
                    return item.value = product.value.unit_id
                }).display;
            }
            return {
                units,
                product,
                showModal,
                openModal,
                closeModal,
                confirm,
                setUnitCode
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
        height: 500px;
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