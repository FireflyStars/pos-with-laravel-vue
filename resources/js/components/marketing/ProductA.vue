<template>
    
    <div class="container-fluid h-100 bg-color">

        <main-header />

        <div 
            class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap" style="z-index:100"
        >

            <side-bar />

            <div class="col main-view container">
                
                <page-title 
                    icon="emailing" 
                    name="Marketing / Campagne" 
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
                                            Marketing > Categorie XXX
                                        </h3>

                                        <base-button
                                            prepend
                                            class="btn btn-newrdv body_medium"
                                            kind="warning"
                                            title="Panier : XXX"
                                            classes="border-0"
                                            style="border-radius: 10px; font-size: 12px !important"
                                        >
                                            <icon name="clipboard" />
                                        </base-button>

                                    </div>

                                    <div class="bg-panel py-5 ps-5 pe-2">

                                        <div class="row">
                                            
                                            <div class="col-8 left-panel">
                                                
                                                <div 
                                                    class="panel-heading d-flex justify-content-between align-items-center"
                                                >
                                                    <h4 class="panel-title">PRODUIT A</h4>
                                                    <base-button
                                                        class="btn btn-newrdv body_medium"
                                                        kind="warning"
                                                        title="Retour vers produit"
                                                        classes="border-0"
                                                        style="border-radius: 10px; font-size: 12px !important"
                                                    />
                                                </div>
        
                                                <div class="content">
        
                                                    <div class="panel-description">
                                                        <p class="p-title text-uppercase text-start">
                                                            Descriptif
                                                        </p>
                                                        <p class="fs-6" >
                                                            Tampon pre-imprime Trodat Printy, 6.0 * 4.0cm <br>
                                                            Conditionnement: 1ex. <br>
                                                            Poids: X kg
                                                        </p>
                                                    </div>
            
                                                    <hr />
            
            
                                                    <div class="row">
            
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
                                                            />
            
                                                        </div>
            
                                                        <div class="col-lg-12 group_input">
                                                            
                                                            <label class="fix_width">coord:</label>
                                                            <input
                                                                type="text"
                                                                placeholder="1 Rue Jean-Baptiste Colbert"
                                                                name="adresse"
                                                            />
            
                                                            <label class="fix_width_tiret">-</label>
                                                            <input
                                                                type="text"
                                                                id="inputPassword"
                                                                name="adresse2"
                                                            />
            
                                                        </div>
            
                                                        <div class="col-lg-12 group_input">
                                                            
                                                            <label class="fix_width">adresse:</label>
                                                            <input
                                                                type="text"
                                                                placeholder="1 Rue Jean-Baptiste Colbert"
                                                                name="adresse"
                                                            />
            
                                                            <label class="fix_width_tiret">-</label>
                                                            <input
                                                                type="text"
                                                                id="inputPassword"
                                                                name="adresse2"
                                                            />
            
                                                        </div>
            
                                                        <div class="col-lg-12 group_input">
                                                            
                                                            <label class="fix_width">cp & ville:</label>
                                                            <input
                                                                type="text"
                                                                placeholder="1 Rue Jean-Baptiste Colbert"
                                                                name="adresse"
                                                            />
                                                        </div>
            
                                                        <div class="col-lg-12 group_input">
                                                            
                                                            <label class="fix_width">statut:</label>
                                                            <input
                                                                type="text"
                                                                placeholder="1 Rue Jean-Baptiste Colbert"
                                                                name="adresse"
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
                                                            />
            
                                                            <label class="fix_width_tiret">-</label>
                                                            <input
                                                                type="text"
                                                                id="inputPassword"
                                                                name="adresse2"
                                                            />
            
                                                        </div>
            
                                                        <div class="col-lg-12 group_input">
                                                            
                                                            <label class="fix_width">ape & rcs:</label>
                                                            <input
                                                                type="text"
                                                                placeholder="1 Rue Jean-Baptiste Colbert"
                                                                name="adresse"
                                                            />
            
                                                            <label class="fix_width_tiret">-</label>
                                                            <input
                                                                type="text"
                                                                id="inputPassword"
                                                                name="adresse2"
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
                                                                    value="250"
                                                                />
        
                                                                <span class="help text-lowercase">
                                                                    (Minimum 250ex)
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
                                                                    <strong>32,00</strong> &euro; <i>HT</i>
                                                                </div>
        
                                                                <span class="help">
                                                                    Soit 38, 40 &euro; TTC
                                                                </span>
                
                                                            </div>
        
                                                        </div>    
        
                                                    </div>
        
                                                </div>

                                            </div>
                                            
                                            <div class="col-4">

                                                <div class="preview-box text-center" style="margin-right: 1rem">
                                                    
                                                    <img 
                                                        src="/images/lcdt-logo.png" 
                                                        alt="Lcdt Logo" 
                                                        style="width: 100%; object-fit: cover;"
                                                    >

                                                    <h4>Avenir Toitures</h4>

                                                    <p>
                                                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta est corrupti cupiditate sapiente recusandae placeat esse animi excepturi aliquid laboriosam assumenda ut repellendus ad veritatis, possimus culpa totam voluptate eius!
                                                    </p>
                                                    
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
    
    import { onMounted, computed } from 'vue'
    import { useStore } from 'vuex'
    import {
        CIBLE_MODULE,
        GET_CAMPAGNE_CATEGORY
    }
    from '../../store/types/types'

    const props = defineProps({
        categoryId: {
            type: [Number, String],
            required: true
        }
    })

    const store = useStore()

    const category = computed(() => store.getters[`${CIBLE_MODULE}/campagneCategory`])

    const getCategory = (id) => {
        store.dispatch(`${[CIBLE_MODULE]}/${[GET_CAMPAGNE_CATEGORY]}`, id)
    }

    onMounted(() => {
        getCategory(props.categoryId)
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
    padding: 1rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
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
