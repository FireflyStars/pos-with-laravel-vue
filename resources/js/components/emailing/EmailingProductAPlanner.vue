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
                                                    <h4 class="panel-title text-uppercase">votre planner</h4>
                                                </div>
        
                                                <div class="content">
                                                    
                                                    <div 
                                                        v-for="n in 2" 
                                                        :key="n"
                                                        class="item-box"
                                                    >
                                                        
                                                        <div class="delete-tag">
                                                            <Icon 
                                                                name="trash-solid" 
                                                                color="white" 
                                                                width="18" 
                                                                height="18" 
                                                            />
                                                        </div>

                                                        <div class="row">

                                                            <div class="col-4">

                                                                <div class="item-box--left">
                                                                    
                                                                    <div class="thumbnail">
                                                                        <img 
                                                                            src="/images/item.png" 
                                                                            alt="Item"
                                                                            style="width: 100px; height: 100px; object-fit: cover;"
                                                                        >
                                                                    </div>

                                                                    <h4 
                                                                        class="text-uppercase item-title text-center almarai-bold"
                                                                    >
                                                                        Plaquette <br>audit
                                                                    </h4>
                                                                    
                                                                    <base-button
                                                                        class="btn btn-newrdv body_medium text-uppercase border-0"
                                                                        kind="warning"
                                                                        title="VOIR"
                                                                        style="font-size: 12px !important; border-radius: 0; padding-left: 3rem; padding-right: 3rem;"
                                                                    />

                                                                </div>

                                                            </div>

                                                            <div class="col-8 py-4">

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

                                                                <hr>

                                                                <div class="footer">

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
                                                                                style="width: 10%"
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

                                                    </div>
                                                 
                                                </div>

                                            </div>
                                            
                                            <div class="col-4 item-box--right px-4">

                                                <div class="items-list">
                                                    <p class="p-title text-uppercase">
                                                        Votre commande
                                                    </p>

                                                    <ul>
                                                        <li class="row" v-for="(item, index) in items" :key="index">
                                                            <span class="col-4 fw-bold">{{ item.name }}</span>
                                                            <span class="hr col-5"></span>
                                                            <span 
                                                                class="col-3"
                                                                :class="[{ 
                                                                    'fw-bold': ['total ht', 'total ttc'].includes(item.name.toLowerCase()) 
                                                                },{
                                                                    'color': item.name.toLowerCase() == 'total ht'
                                                                }, {
                                                                    'text-black': item.name.toLowerCase() == 'total ttc'
                                                                }]"
                                                            >
                                                                {{ item.price }} &euro;
                                                            </span>
                                                        </li>
                                                    </ul>

                                                </div>

                                                <div class="form" style="margin: 4rem 0;">

                                                    <p class="p-title text-uppercase">Adresse De livraison</p>

                                                    <div class="row">
                                                        
                                                        <div class="col-lg-12 group_input">
                                                                
                                                            <label class="fix_width">Adresse:</label>
                                                            <input
                                                                type="text"
                                                                placeholder="1 Rue Jean-Baptiste Colbert"
                                                                name="adresse"
                                                            />
            
                                                        </div>

                                                        <div class="col-lg-12 group_input">
                                                            <label class="fix_width"></label>
                                                            <input
                                                                type="text"
                                                                id="inputPassword"
                                                                name="adresse2"
                                                            />
                                                        </div>

                                                        <div class="col-lg-12 group_input">
                                                                
                                                            <label class="fix_width">Contact:</label>
                                                            <input
                                                                type="text"
                                                                placeholder="1 Rue Jean-Baptiste Colbert"
                                                                name="adresse"
                                                            />
            
                                                        </div>


                                                        <div class="col-lg-12 group_input">
                                                                
                                                            <label class="fix_width">Coord:</label>
                                                            <input
                                                                type="text"
                                                                placeholder="1 Rue Jean-Baptiste Colbert"
                                                                name="adresse"
                                                            />
        
                                                        </div>

                                                        <div class="col-lg-12 group_input">
                                                            <label class="fix_width"></label>
                                                            <input
                                                                type="text"
                                                                id="inputPassword"
                                                                name="adresse2"
                                                            />
                                                        </div>

                                                    </div>


                                                </div>


                                                <div class="d-flex align-items-center justify-content-end my-4" style="margin-top: 13rem;">
                                                    
                                                    <base-button
                                                        prepend
                                                        class="btn btn-newrdv body_medium text-uppercase"
                                                        kind="warning"
                                                        title="commander"
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
    import { ref } from 'vue'
    const items = ref([{
            name: 'Produits',
            price: '70,50',
        },{
            name: 'Livraison',
            price: '15,00',
        },{
            name: 'Total ht',
            price: '111,00',
        },{
            name: 'Total ttc',
            price: '133,20',
        },
    ])
</script>

<style lang="scss" scoped>

.item-box {

    border: 1px solid #E8581B;
    position: relative;
    margin-top: 1rem;

    &:first-of-type {
        margin-top: 4.875rem;
    }

    .delete-tag {
        background: #E8581B;
        padding: .5rem;
        color: white;
        position: absolute;
        top: 0;
        right: 0;
        clip-path: polygon(0 0, 100% 100%, 100% 0);
        width: 60px;
        height: 60px;
        display: flex; 
        justify-content: flex-end;
    }

    &--left {
        
        display: flex;
        flex-direction: column;
        align-items: center;
        height: 100%;
        gap: 4;
        
        .thumbnail {
            height: 65% !important;
            width: 100%;
            background: #EBEBEB;
            display: flex;
            justify-content: center;
            align-items: center;
            align-self: flex-start;
            margin-bottom: 1rem;
            clip-path: polygon(0 0, 100% 0, 100% 87%, 50% 100%, 0 90%, 0% 50%);
        }

    }

    &--right {
        margin-top: 4.875rem;
        ul {
            li {
                list-style-type: none;
                line-height: 2;
                text-transform: uppercase;
                font-family: 'Almarai Regular';
                font-size: 13px;

                .hr {
                    border-bottom: 1px dotted #ccc; 
                    max-width: 150px;
                }

            }
        }
    }


}

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

.content {
    padding-left: 2.5rem;
    padding-right: 1rem;

    .item-title {
        font-family: 'Almarai Bold';
        font-size: 18px;
    }

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

    label {
        font-weight: bold;
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
