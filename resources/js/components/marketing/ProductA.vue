<template>
    
    <div class="container-fluid h-100 bg-color">

        <main-header />

        <div 
            class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap" 
            style="z-index:100"
        >

            <side-bar />

            <div class="col main-view container" style="overflow-x: hidden">
                
                <page-title 
                    icon="emailing" 
                    name="PLATEFORME MARKETING / Campagne" 
                    class="almarai_extrabold_normal_normal"
                />

                <transition
                    enter-active-class="animate__animated animate_fadeIn"
                    leave-active-class="animate__animated animate_fadeOut"
                >


                    <form action="" class="space-y-6">

                        <div class="container">
                            <div class="row">

                                <div class="col-lg-12">

                                    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">

                                        <h3 
                                            class="margin-align m-0"
                                        >
                                            PLATEFORME MARKETING > Categorie XXX
                                        </h3>

                                        <div class="d-flex align-items-center gap-2">

                                            <base-button
                                                prepend
                                                class="btn btn-newrdv body_medium"
                                                kind="warning"
                                                title="Liste campagne"
                                                classes="border-0"
                                                style="border-radius: 10px; font-size: 12px !important; margin-right: 1rem; background: #FF0000"
                                                @click.prevent="$router.push({
                                                    name: 'marketing-list'
                                                })"
                                            >
                                                <icon name="clipboard" />
                                            </base-button>

                                            <base-button
                                                prepend
                                                class="btn btn-newrdv body_medium"
                                                kind="warning"
                                                :title="'Panier :' + cardQuantity"
                                                classes="border-0"
                                                style="border-radius: 10px; font-size: 12px !important"
                                                @click.prevent="$router.push({
                                                    name: 'marketing-card'
                                                })"
                                            >
                                                <icon name="clipboard" />
                                            </base-button>
                                        
                                        </div>


                                    </div>

                                    <div class="bg-panel py-5 ps-5 pe-2">

                                        <div class="row">
                                            
                                            <div class="col-8 left-panel">
                                                
                                                <div 
                                                    class="panel-heading d-flex justify-content-between align-items-center"
                                                >
                                                    <h4 class="panel-title">{{ category.name }}</h4>
                                                    <base-button
                                                        class="btn btn-newrdv body_medium"
                                                        kind="warning"
                                                        title="Retour vers produit"
                                                        classes="border-0"
                                                        style="border-radius: 10px; font-size: 12px !important"
                                                        @click.prevent="$router.push({
                                                            name: 'emailingprestations',
                                                            params: {
                                                                id: categoryId
                                                            }
                                                        })"
                                                    />
                                                </div>
        
                                                <div class="content">
        
                                                    <div class="panel-description">
                                                        <p class="p-title text-uppercase text-start">
                                                            Descriptif
                                                        </p>
                                                        <p class="fs-6" v-html="category.text"></p>
                                                    </div>
            
                                                    <hr />
            
            
                                                    <div class="row" v-if="fields?.personalize">
            
                                                        <div class="col">
                                                            <p class="p-title text-uppercase text-start">
                                                                votre personnalisation
                                                            </p>
                                                        </div>
            
                                                        <div class="col-lg-12 group_input">
            
                                                            <label 
                                                                class="fix_width" 
                                                                for="expediteur"
                                                            >
                                                                RAISON SO.:
                                                            </label>
            
                                                            <input
                                                                type="text"
                                                                placeholder="La Compagnie des Toits"
                                                                name="expediteur"
                                                                :value="affiliate.raisonsociale"
                                                                disabled
                                                            />
            
                                                        </div>
            
                                                        <div class="col-lg-12 group_input">
                                                            
                                                            <label class="fix_width">coord:</label>
                                                            <input
                                                                type="text"
                                                                placeholder="1 Rue Jean-Baptiste Colbert"
                                                                name="adresse"
                                                                v-model="phone"
                                                            />
            
                                                            <label class="fix_width_tiret">-</label>
                                                            <input
                                                                type="text"
                                                                id="inputPassword"
                                                                name="adresse2"
                                                                v-model="email"
                                                            />
            
                                                        </div>
            
                                                        <div class="col-lg-12 group_input">
                                                            
                                                            <label class="fix_width">adresse:</label>
                                                            <input
                                                                type="text"
                                                                placeholder="1 Rue Jean-Baptiste Colbert"
                                                                name="adresse"
                                                                :value="affiliate.address"
                                                                disabled
                                                            />
            
                                                            <label class="fix_width_tiret">-</label>
                                                            <input
                                                                type="text"
                                                                id="inputPassword"
                                                                name="adresse2"
                                                                :value="affiliate.address2"
                                                                disabled
                                                            />
            
                                                        </div>
            
                                                        <div class="col-lg-12 group_input">
                                                            
                                                            <label class="fix_width">cp & ville:</label>
                                                            <input
                                                                type="text"
                                                                placeholder="1 Rue Jean-Baptiste Colbert"
                                                                name="adresse"
                                                                :value="affiliate.postcod + ' ' + affiliate.city"
                                                                disabled
                                                            />
                                                        </div>
            
                                                        <div class="col-lg-12 group_input">
                                                            
                                                            <label class="fix_width">statut:</label>
                                                            <input
                                                                type="text"
                                                                placeholder="1 Rue Jean-Baptiste Colbert"
                                                                name="adresse"
                                                                :value="affiliate.statutagence"
                                                                disabled
                                                            />
            
                                                            <label class="fix_width_tiret">-</label>
                                                            <input
                                                                type="text"
                                                                id="inputPassword"
                                                                name="adresse2"
                                                            />
            
                                                        </div>
            
                                                        <div class="col-lg-12 group_input">
                                                            
                                                            <label class="fix_width">sired & tva:</label>
                                                            <input
                                                                type="text"
                                                                placeholder="1 Rue Jean-Baptiste Colbert"
                                                                name="adresse"
                                                                :value="affiliate.siret"
                                                                disabled
                                                            />
            
                                                            <label class="fix_width_tiret">-</label>
                                                            <input
                                                                type="text"
                                                                id="inputPassword"
                                                                name="adresse2"
                                                                :value="affiliate.tva"
                                                                disabled
                                                            />
            
                                                        </div>
            
                                                        <div class="col-lg-12 group_input">
                                                            
                                                            <label class="fix_width">ape & rcs:</label>
                                                            <input
                                                                type="text"
                                                                placeholder="1 Rue Jean-Baptiste Colbert"
                                                                name="adresse"
                                                                :value="affiliate.ape"
                                                            />
            
                                                            <label class="fix_width_tiret">-</label>
                                                            <input
                                                                type="text"
                                                                id="inputPassword"
                                                                name="adresse2"
                                                                :value="affiliate.secteuragence"
                                                                disabled
                                                            />
            
                                                        </div>
            
                                                    </div>
            
                                                    <hr />
        
                                                    <div class="footer">
                                                        <p class="p-title text-uppercase text-start">
                                                            votre commande
                                                        </p>
        
                                                        <div class="row">
        
                                                            <div class="col-lg-12 group_input">
            
                                                                <label 
                                                                    class="fix_width" 
                                                                    for="expediteur"
                                                                >
                                                                    quantite:
                                                                </label>
                
                                                                <input
                                                                    type="text"
                                                                    placeholder="La Compagnie des Toits"
                                                                    name="expediteur"
                                                                    v-model="qtyOfProduct"
                                                                    max="250"
                                                                    min="1"
                                                                />
        
                                                                <span class="help text-lowercase">
                                                                    (Minimum {{ category.qtymini }})
                                                                </span>
                
                                                            </div>
        
                                                            <div class="col-lg-12 group_input d-flex align-items-center justify-content-start">
            
                                                                <label 
                                                                    class="fix_width" 
                                                                    for="expediteur"
                                                                >
                                                                    tarif:
                                                                </label>
                
                                                                <div class="price-tag">
                                                                    <strong>{{ categoryPrice  }}</strong> &euro; <i>HT</i>
                                                                </div>
        
                                                                <span class="help">
                                                                    Soit {{ categoryPriceWithTax }} &euro; TTC
                                                                </span>
                
                                                            </div>
        
                                                        </div>    
        
                                                    </div>
        
                                                </div>

                                            </div>
                                            
                                            <div class="col-4">

                                                <div class="preview-box text-center" style="margin-right: 1rem; position: relative">
                                                    
                                                    <img 
                                                        :src="category.imageTemplateUrl" 
                                                        alt="Lcdt Logo" 
                                                        style="width: 100%; height: 100%;"
                                                    >

                                                    <template v-for="(item, index) in fields" :key="index">
                                                        <span 
                                                            :style="{
                                                                color: item.color,
                                                                fontSize: `${item.size}px`,
                                                                fontFamily: item.font,
                                                                top: `${item.y}px`,
                                                                left: `${item.x}px`,
                                                            }"
                                                            v-if="item.active == 1" 
                                                        >
                                                            <template v-if="!['Telephone_agence', 'Email_agence'].includes(index)">
                                                                {{ item.value }}
                                                            </template>

                                                            <template v-if="'Email_agence' == index">
                                                                {{ email }}
                                                            </template>

                                                            <template v-if="'Telephone_agence' == index">
                                                                {{ phone }}
                                                            </template>
                                                            
                                                        </span>
                                                    </template>
                                                    
                                                </div>

                                                <div class="d-flex align-items-center justify-content-center gap-2 my-4">
                                                    
                                                    <base-button
                                                        class="btn btn-newrdv body_medium"
                                                        kind="warning"
                                                        title="Télécharger fichier"
                                                        classes="border-0"
                                                        style="border-radius: 10px; font-size: 12px !important; background: #000;"
                                                    />

                                                    <base-button
                                                        prepend
                                                        class="btn btn-newrdv body_medium"
                                                        kind="warning"
                                                        title="Ajouter au panier"
                                                        classes="border-0"
                                                        style="border-radius: 10px; font-size: 12px !important;"
                                                        @click.prevent="storeProduct"
                                                    >
                                                        <Icon name="clipboard" width="18" height="18" />
                                                    </base-button>

                                                </div>


                                            </div>

                                        </div><!-- inner row-->



                                    </div> <!-- bg-panel -->


                                </div> <!-- col-lg-12 -->
                                

                            </div><!-- row -->

                        </div><!-- container -->

                    </form>

                </transition>


            </div>

        </div>

    </div>

</template>

<script setup>
    
    import { ref, onMounted, computed, watch } from 'vue'
    import { useStore } from 'vuex'
    import {
        CIBLE_MODULE,
        GET_CAMPAGNE_CATEGORY,
        GET_CAMPAGNE_FIELDS,
        STORE_PRODUCT,
        LOADER_MODULE,
        DISPLAY_LOADER,
        TOASTER_MODULE,
        TOASTER_MESSAGE,
        HIDE_LOADER
    }
    from '../../store/types/types'

    const props = defineProps({
        categoryId: {
            type: [Number, String],
            required: true
        }
    })

    const store = useStore()

    const phone = ref('')
    const email = ref('')

    const category = computed(() => store.getters[`${CIBLE_MODULE}campagneCategory`]?.campagne || {})
    const affiliate = computed(() => store.getters[`${CIBLE_MODULE}campagneCategory`]?.affiliate || {})
    const fields = computed(() => store.getters[`${CIBLE_MODULE}fields`])

    const cardQuantity = computed(() => category.value?.card_detail?.qty || 0)
    const qtyOfProduct = ref(1)     

    const categoryPrice = computed(() => {
        const price = category.value.price * (qtyOfProduct.value || 1)
        return price?.toFixed(2) || 0
    })

    const categoryPriceWithTax = computed(() => { 
        const tax = affiliate?.value?.tax?.taux * categoryPrice.value
        const percentage = +categoryPrice.value + +tax
        return percentage?.toFixed(2) || 0
    })
    
    const getCategory = (id) => {
        return store.dispatch(`${[CIBLE_MODULE]}${[GET_CAMPAGNE_CATEGORY]}`, id)
    }

    const getFieldsData = (id) => {
        return store.dispatch(`${[CIBLE_MODULE]}${[GET_CAMPAGNE_FIELDS]}`, id)
    }

    const storeProduct = async () => {
        try {

            if(qtyOfProduct.value > category.value.qtymini) {
                store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`, {
                    type: 'danger',
                    message: 'PAS LA BONNE QUANTITE',
                    ttl: 5,
                })
                return
            }
            if(qtyOfProduct.value <= 0) {
                store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`, {
                    type: 'danger',
                    message: 'Please enter a quantity first',
                    ttl: 5,
                })
                return
            }
            store.dispatch(`${LOADER_MODULE}${DISPLAY_LOADER}`, [true, 'Loading...'])
            await store.dispatch(`${[CIBLE_MODULE]}${[STORE_PRODUCT]}`, { 
                category: category.value, 
                qty: qtyOfProduct.value,
                email: email.value,
                phone: phone.value
            })
            store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`, {
                type: 'success',
                message: 'Product saved to cart',
                ttl: 5,
            })

        }

        catch(e) {
            store.dispatch(`${TOASTER_MODULE}${TOASTER_MESSAGE}`, {
                type: 'danger',
                message: 'Something went wrong',
                ttl: 5,
            })
        }

        finally {
            store.dispatch(`${LOADER_MODULE}${HIDE_LOADER}`)
        }

    }

    watch(fields, (value) => {
        if(value) {
            email.value = value.Email_agence.value
            phone.value = value.Telephone_agence.value
        }
    })

    onMounted(async () => {
        await getCategory(props.categoryId)
        getFieldsData(props.categoryId)
    })

</script>

<style lang="scss" scoped>

.panel-title {
    color: #E8581B;
    font-family: 'Almarai Bold';
    font-style: normal;
    font-weight: 800;
    font-size: 22px;
    line-height: 110%;
    display: flex;
    align-items: center;
}

.panel-description {
    margin-top: 3.875rem;
}

.content {
    padding-left: 2.5rem;
    padding-right: 1rem;
}

.margin-align {
    font-size: 17px;
    font-weight: bold;
}
.margin-ajustement {
    margin-top: 39px;
}
.ajustement {
    display: flex;
}

.left-panel {
    border-right: 1px solid #000;
}

.p-subtitle {
    text-align: center;
    font-size: 11px;
    font-weight: 700;
    color: orangered;
}
.p-title {
    text-align: center;
    font-size: 17px;
    font-weight: 700;
    color: #e4703f;
    margin-bottom: .7rem;
}
.type {
    font-size: x-small;
    font-weight: bold;
}
.type-click {
    border: orangered 1px solid;
}
.container {
    padding-bottom: 100px;
}
img.card-img-top {
    height: 100%;
}

.preview-box {
    border: 1px solid #000;
    height: 90%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    position: relative;
}

.group_input {

    justify-content: space-between;
    text-transform: uppercase;
    margin: 7px 0;
    align-items: center;

    input {
        width: 220px;
        background-color: #d3d3d3;
        border: none;
        height: 27px;
        font-size: small;
    }

    span {
        margin-left: 15px;
        font-size: 11px;
    }

    .price-tag {
        color: #E8581B;
        border: 1px solid #E8581B;
        padding: 0.01rem 0.3rem;
    }

}

.italic {
    font-style: italic;
}

label.fix_width {
    width: 100px;
    font-size: 11px;
    font-weight: 700;
}

label.fix_width_tiret {
    width: 45px;
    text-align: center;
    font-size: 11px;
    font-weight: 700;
}
.color {
    color: orangered;
}
.margin {
    margin-bottom: 40px;
    margin-top: 35px;
}
.card-title {
    text-align: center;
    font-size: unset;
    font-family: revert;
}
.card-text {
    font-size: x-small;
    margin-top: 18%;
    text-align: center;
}
.card {
    width: 12rem;
}
.body {
    width: 100%;
    height: 100%;
}

hr {
    margin: 40px 0px;
    border: none !important;
    border-color: #000 !important;
}
.apercu h6 {
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 15px;
    text-align: center;
}
.last label {
    margin-right: 10px;
    margin-left: 15px;
}
.type {
    font-size: x-small;
    font-weight: bold;
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
