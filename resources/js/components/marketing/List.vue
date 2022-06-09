<template>
    
    <div class="container-fluid h-100 bg-color">

        <main-header />

        <div 
            class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap" style="z-index:100"
        >

            <side-bar />

            <transition
                enter-active-class="animate__animated animate_fadeIn"
                leave-active-class="animate__animated animate_fadeOut"
            >

                <div class="col main-view container px-5">
                    
                    <page-title 
                        icon="emailing" 
                        name="PLATEFORME MARKETING" 
                        class="almarai_extrabold_normal_normal"
                    />

                        
                    <tab-pane :tabs="tabs" current='tout' class="almarai_700_normal">

                        <template v-slot:tout>
                            
                            <item-list-table :table_def="campagnesList" />
                                
                        </template>

                        <template v-slot:mes_campagnes>
                            
                            <item-list-table :table_def="campagnesUserList" />

                        </template>
                        
                    </tab-pane>


                </div>

            </transition>    

        </div>

    </div>

</template>

<script setup>

    import { useStore } from 'vuex'
    import { ref, computed, onMounted } from 'vue'
    import CampagneStatusTag from '../miscellaneous/CampagneStatusTag'
    import ItemListTable from '../miscellaneous/ItemListTable/ItemListTable.vue';

    
    import {
        CAMPAGNE_LIST_MODULE
    }
    from '../../store/types/types'


    const store = useStore()

    const tabs = ref({
        tout: 'Tout',
        mes_campagnes: 'Mes Campagnes',
    })

    const campagnesList = computed(() => store.getters[`${CAMPAGNE_LIST_MODULE}campagnesList`])
    const campagnesUserList = computed(() => store.getters[`${CAMPAGNE_LIST_MODULE}campagnesUserList`])

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
        cursor: pointer;
        &:hover {
            opacity: .8;
        }
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
    padding-left: 2rem;
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
