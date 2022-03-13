<template>
    
    <div class="box-bottom-right bg-white p-3 shadow-sm">
                                        
        <div class="row mx-0" style="margin-top: 2rem">
            <div class="col">
                <div class="d-flex gap-2 align-items-center">
                    <div class="thumbnail"></div>
                    <div class="title-section">
                        <p>Nom du client</p>
                        <h4>{{ order?.customer?.firstname || 'Name' }}</h4>
                    </div>
                    <Icon 
                        name="circle-plus" 
                        class="pointer" 
                        @click.prevent="generateElement('textarea', { 
                            content: order?.customer?.firstname || 'Name'
                        })" 
                    />
                </div>
            </div>
            <div class="col">
                <div class="d-flex gap-2 align-items-center">
                    <div class="title-section title-section-right">
                        <p>Adresse du chantier</p>
                        <h4>{{ order?.customer?.address?.address1 || 'Address' }}</h4>
                    </div>
                    <Icon 
                        name="circle-plus" 
                        class="pointer"
                        @click.prevent="generateElement('textarea', { 
                            content: order?.customer?.address?.address1 || 'Address'
                        })"
                    />
                </div>
            </div>
        </div>

        <template v-if="'id' in order && order?.orderZones?.length">

            <div 
                class="breadcrumb-section"
                v-for="zone in order.orderZones"
                :key="zone.id"
            >

                <div class="breadcrumb d-flex align-items-center gap-4">
                    <Icon name="house" />
                    <h4 class="breadcrumb-title">{{ zone.name }}</h4>
                    <Icon 
                        name="circle-plus" 
                        class="align-self-start pointer"
                        @click.prevent="generateElement('textarea', { 
                            content: `<strong>${ zone.name }</strong>` 
                        })"
                    />
                </div>
                
                <div class="row camping-section ml-2">
                    <div class="col d-flex gap-3 p-0">
                        <Icon name="camping" />
                        <p class="text-base orange">Acces tolture</p>
                    </div>
                    <div class="col">
                        <h4>20 M, Nacelle 30M</h4>
                    </div>
                    <div class="col">
                        <Icon 
                            name="circle-plus" 
                            class="pointer"
                            @click.prevent="generateElement('textarea', {
                                content: '20 M, Nacelle 30M'
                            })"
                        />
                    </div>
                </div>

                <template v-if="zone?.gedDetails">

                    <div class="image-grid-section ml-2" 
                    v-for="(gedDetail, category) in zone.gedDetails"
                    :key="gedDetail.id"
                    >
                        <div class="d-flex align-items-center gap-2" style="margin-bottom: 1.31rem">
                            <Icon name="camera" />
                            <h4 class="text-base orange">{{ category }}</h4>
                        </div>

                        <div class="d-flex gap-2">
                            <div class="black-box" v-for="n in 4" :key="n"></div>
                            
                            <div class="ml-5 d-flex gap-2 align-items-start">
                                <div class="d-none">
                                    <input type="file" id="file" accept="image/*">
                                </div>
                                <p class="m-0">Attention grosse poutre en haut</p>
                                <Icon name="plus-circle" class="mt-2 pointer" />
                            </div>
                        </div>    

                    </div>

                </template>

                <!-- <div class="image-grid-section ml-2">
                    <div class="d-flex align-items-center gap-2" style="margin-bottom: 1.31rem">
                        <Icon name="camera" />
                        <h4 class="text-base orange">Vue interieure</h4>
                    </div>

                    <div class="d-flex gap-2">
                        <div class="black-box" v-for="n in 4" :key="n"></div>
                    
                        <div class="ml-5 d-flex gap-2 align-items-start">
                            <p class="m-0">Attention grosse poutre en haut</p>
                            <Icon name="plus-circle" class="mt-2 pointer" />
                        </div>
                    </div>    

                </div>  


                <div class="image-grid-section ml-2">
                    <div class="d-flex align-items-center gap-2" style="margin-bottom: 1.31rem">
                        <Icon name="camera" />
                        <h4 class="text-base orange">Vue Exterieure</h4>
                    </div>

                    <div class="d-flex gap-2">
                        <div class="black-box" v-for="n in 4" :key="n"></div>
                    
                        <div class="ml-5 d-flex gap-2 align-items-start">
                            <p class="m-0">Attention grosse poutre en haut</p>
                            <Icon name="plus-circle" class="mt-2 pointer" />
                        </div>
                    </div>    

                </div>   


                <div class="image-grid-section ml-2">
                    <div class="d-flex align-items-center gap-2" style="margin-bottom: 1.31rem">
                        <Icon name="camera" />
                        <h4 class="text-base orange">Metre</h4>
                    </div>

                    <div class="d-flex gap-2">
                        <div class="black-box" v-for="n in 4" :key="n"></div>
                    
                        <div class="ml-5 d-flex gap-2 align-items-start">
                            <p class="m-0">Attention grosse poutre en haut</p>
                            <Icon name="plus-circle" class="mt-2 pointer" />
                        </div>
                    </div>    

                </div>                   -->

            </div><!-- breadcrumb-section -->

        </template>

        <template v-if="'id' in order && order.orderZoneComments?.length">

            <div class="zone-comments-section">
                
                <div class="zone-comments-header d-flex align-items-center gap-4">
                    <Icon name="house" />

                    <h4 class="breadcrumb-title zone-comments-title">
                        Orderzone Comments
                    </h4>

                </div>    

                <div class="zone-comments-body"
                    v-for="comment in order.orderZoneComments"
                    :key="comment.id"
                >
                    <div class="d-flex align-items-center gap-4">
                        <span>{{ comment.comment }}</span>
                        <Icon 
                            name="circle-plus" 
                            class="pointer"
                            @click.prevent="generateElement('textarea', { 
                                content: comment.comment || 'Comment'
                            })"
                        />

                    </div>
                </div>

            </div>
            

        </template>

        <template v-if="'id' in order && order.orderOuvrages">
            
            <div 
                :class="getCategoryClassName(category)" 
                v-for="(ouvrage, category) in order.orderOuvrages" 
                :key="category"
            >

                <div class="title-section d-flex align-items-center gap-4" style="margin-bottom: 1.31rem">
                    <div class="icon">
                        <Icon name="marker" />
                    </div>
                    <h4 class="title">{{ category }}</h4>
                </div>


                <div 
                :class="getCategoryClassName(category) + '-content'">
                    
                    <h4 class="text-base orange main-title">{{ ouvrage.name }}</h4>

                    <div class="main-body row m-0">
                        <h4 
                        class="text-base orange text-uppercase col-6 d-flex justify-content-center" 
                        style="margin-bottom: .56rem">
                            Avant
                        </h4>

                        <div class="col"></div>

                        <div class="d-flex gap-2 col">
                            <div class="black-box" v-for="n in 4" :key="n"></div>
                        </div>    
                    </div>

                    <div class="main-body row mx-0" style="margin-top: 1.75rem">
                        <h4 
                        class="text-base orange text-uppercase col-6 d-flex justify-content-center" 
                        style="margin-bottom: .56rem">
                            apres
                        </h4>

                        <div class="col"></div>

                        <div class="d-flex gap-2 col">
                            <div class="black-box" v-for="n in 4" :key="n"></div>
                        </div>    
                    </div>
                    
                </div>


            </div>

        </template>


        <!-- <div class="security-section">

            <div class="title-section d-flex align-items-center gap-4">
                <div class="icon">
                    <Icon name="notepad" />
                </div>
                <h4 class="title">Securite</h4>
            </div>

            <div class="security-section-content">
                
                <h4 class="text-base orange main-title">Ouvrage XXXXXXXX</h4>

                <div class="main-body">

                    <div class="row m-0">

                        <h4 
                        class="text-base orange text-uppercase col-6 d-flex justify-content-center" 
                        style="margin-bottom: .56rem">
                            Avant
                        </h4>
                        
                        <div class="col"></div>

                        <div class="col">
                            <div class="d-flex gap-2">
                                <div class="black-box" v-for="n in 4" :key="n"></div>
                            </div>   
                        </div>
                        
                    </div>

                        
                </div>

                <div class="main-body" style="margin-top: 1.75rem">

                    <div class="row m-0">
                        <h4 
                        class="text-base orange text-uppercase col-6 d-flex justify-content-center" 
                        style="margin-bottom: .56rem">
                            apres
                        </h4>
                        <div class="col"></div>
                        <div class="d-flex gap-2">
                            <div class="black-box" v-for="n in 4" :key="n"></div>
                        </div>    

                    </div>

                </div>
                
            </div>
            
            <div class="security-section-content">
                
                <h4 class="text-base orange main-title">Ouvrage YYYYYYYY</h4>

                <div class="main-body">

                    <div class="row m-0">

                        <h4 
                        class="text-base orange text-uppercase col-6 d-flex justify-content-center" 
                        style="margin-bottom: .56rem">
                            Avant
                        </h4>
                        
                        <div class="col"></div>

                        <div class="col">
                            <div class="d-flex gap-2">
                                <div class="black-box" v-for="n in 4" :key="n"></div>
                            </div>   
                        </div>

                        <div class="col">
                            <div class="d-flex gap-2 align-items-start">
                                <p class="m-0">Attention grosse poutre en haut</p>
                                <Icon name="plus-circle" class="mt-2 pointer" />
                            </div>
                        </div>
                    </div>

                        
                </div>

                <div class="main-body" style="margin-top: 1.75rem">

                    <div class="row m-0">
                        <h4 
                        class="text-base orange text-uppercase col-6 d-flex justify-content-center" 
                        style="margin-bottom: .56rem">
                            apres
                        </h4>
                        <div class="col"></div>
                        <div class="d-flex gap-2">
                            <div class="black-box" v-for="n in 4" :key="n"></div>
                        </div>    

                    </div>

                </div>
                
            </div>


        </div>


        <div class="prestations-section">

            <div class="title-section d-flex align-items-center gap-4">
                <div class="icon">
                    <Icon name="settings" />
                </div>
                <h4 class="title">Prestations</h4>
            </div>
            
            <div class="image-grid-section ml-2">
                <div class="d-flex align-items-center gap-2" style="margin-bottom: 1.31rem">
                    <Icon name="camera" />
                    <h4 class="text-base orange">Validation Chantier / Signature</h4>
                </div>

                <div class="row m-0">
                    
                    <div class="col">
                        <div class="black-box"></div>
                    </div>
                
                    <div class="col d-flex gap-2 align-items-start">
                        <p class="m-0">Attention grosse poutre en haut</p>
                        <Icon name="plus-circle" class="mt-2 pointer" />
                    </div>
                </div>    

            </div>

        </div> -->

    </div><!--  box-top-right -->

</template>

<script>

import { useStore } from 'vuex'
import { computed } from 'vue'
import { BUILDER_MODULE } from '../../store/types/types'

export default {
    name: 'report-order-resource',
    setup (_, { emit }) {

        const store = useStore()

        const order = computed(() => store.getters[`${BUILDER_MODULE}/order`])

        const getCategoryClassName = (category) => {
            const categories = {
                installation: 'installation',
                securite: 'securite',
                prestation: 'prestation'
            }
            return category !='' ? `${categories[category.toLowerCase()]}-section` : ''
        }
        
        const generateElement = (name, attributes) => {
            emit('generateElement', name, attributes)
        }

        return {
            order,
            generateElement,
            getCategoryClassName
        }
    }
}
</script>

<style lang="scss" scoped>

.box-bottom-right {
    margin-top: .75rem;
    margin-bottom: 2rem;
    .thumbnail {
        background: #7998C7;
        width: 2.95rem;
        height: 3.15rem;
        border-radius: 50%;
    }
    .title-section {
        p {
            font-family: Mulish;
            font-weight: 600;
            font-style: normal;
            font-size: 0.625rem;
            line-height: 13px;
            color: rgba(0, 24, 51, 0.22);
            transform: matrix(1, 0, 0, 1, 0, 0);
            margin-bottom: .4rem;
        }
        h4 {
            font-family: Mulish;
            font-style: normal;
            font-weight: 800;
            font-size: 16px;
            line-height: 162.7%;
            color: #324A59;
        }

        &-right {
            p {
                font-family: Almarai;
                font-weight: bold;
                font-size: 14px;
                line-height: 140%;
                color: #C3C3C3;
            }

            h4 {
                font-family: Almarai;
                font-weight: 300;
                font-size: 14px;
                line-height: 140%;
                color: #000000;
            }

        }

    }

    .breadcrumb {
        margin-top: 3rem;
        &-title {
            font-family: Mulish;
            font-style: normal;
            font-weight: 900;
            font-size: 18px;
            line-height: 23px;
            letter-spacing: 0.01em;
            color: #000000;
            text-transform: uppercase;
            margin-bottom: 0;
        }

    }

    .zone-comments-section {
        margin-top: 2.75rem;
        margin-bottom: 1.5rem;
        .zone-comments-body {
            margin-top: 1.125rem;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }
    }

    .camping-section,
    .image-grid-section, 
    .installation-section-content, 
    .security-section-content {
        width: 90%;
        margin-left: auto;
        margin-right: auto;
    }

    .camping-section {
        margin-top: 2.75rem;
        h4 {
            font-family: Mulish;
            font-style: normal;
            font-weight: normal;
            font-size: 16px;
            line-height: 20px;
            color: #000000;
            margin-bottom: 0;
        }
    }

    .image-grid-section {
        margin-top: 2.845rem;
        h4 {
            margin-bottom: 0;
        }
    }

    .installation-section, .security-section {
        margin-top: 2.875rem;
        .title-section {
            .icon {
                background: #FFF0E6;
                width: 3.31rem;
                height: 3.31rem;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .title {
                font-family: Mulish;
                font-style: normal;
                font-weight: 900;
                font-size: 17px;
                line-height: 21px;
                color: #000000;
                opacity: 0.5;
            }
        }

        &-content {
            
            margin-top: 2.03rem;
            .main-body {
                margin-top: 1.125rem;
            }

        }

    }

    .security-section {
        .title-section {
            .icon {
                background: #ECEAFE;
            }
            .title {
                font-weight: 900;
                font-family: Mullish, sans-serif;
            }
        }
    }

    .prestations-section {
        margin-bottom: 4rem;
        .title-section {
            margin-top: 3rem;
            margin-bottom: 3rem;

            .icon {
                background: #ECEAFE;
                width: 3.31rem;
                height: 3.31rem;
                border-radius: 50%;
                display: flex;
                justify-content: center;
                align-items: center;
            }
            .title {
                font-family: Mulish;
                font-style: normal;
                font-weight: 900;
                font-size: 17px;
                line-height: 21px;
                color: #000000;
                opacity: 0.5;
            }
        }
    }


}

.black-box {
    background: #525252;
    border-radius: 8px;
    width: 3.43rem !important;
    height: 3.43rem !important;
}

.text {
    font-family: Poppins;
    font-style: normal;
    font-weight: 600;
    font-size: 14px;
    line-height: 22px;
    display: flex;
    align-items: center;
    margin-bottom: 3px;
    text-decoration: none;
    color: #000000;
    &-base {
        font-family: Poppins;
        font-style: normal;
        font-weight: 600;
        line-height: 22px;
        display: flex;
        align-items: center;
        margin-bottom: 3px;
        font-size: 16px;
    }
}



</style>