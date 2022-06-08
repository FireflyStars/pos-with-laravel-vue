<template>

    <router-view>
        <transition
            enter-active-class="animate__animated animate__fadeIn"
        >
            <div class="container-fluid h-100 bg-color" v-if="showcontainer">
                <main-header />

                <div 
                class="row d-flex align-content-stretch align-items-stretch flex-row hmax main-view-wrap reports-page" 
                style="z-index:100" >
                    
                    <side-bar />

                    <div class="col main-view container">
                        <h4 class="tile_h1 flex align-items-center gap-2">
                            <Icon name="report" width="32" height="32" />
                            Templates List
                        </h4>


                        <BaseButton 
                            kind="default" 
                            title="Add New" 
                            class="mb-2 mt-3"
                            @click="$router.push({
                                name: 'templates-add'
                            })"
                        />

                        <item-list-table 
                            :table_def="templatesList" 
                        >
                            <template v-slot:pages="{ row }">
                                {{ row.pages.length }}
                            </template>
                            <template v-slot:id="{ row }">
                                <router-link 
                                    class="link"
                                    :to="{ 
                                        name: 'templates-edit',
                                        params: {
                                            id: row.id
                                        } 
                                    }"
                                >
                                    Edit
                                </router-link>
                            </template>
                        </item-list-table>

                    </div>

                </div>
            </div>
        </transition>
    </router-view>


</template>

<script setup>

import { useStore } from 'vuex'
import { onMounted, ref, nextTick, computed } from 'vue'
import ItemListTable from '../../components/miscellaneous/ItemListTable/ItemListTable.vue'

import { 
    BUILDER_MODULE_LIST, 
} from '../../store/types/types'

const store = useStore()

const showcontainer = ref(false)

const templatesList = computed(() => store.getters[`${BUILDER_MODULE_LIST}templateListDefinition`]);

onMounted(() => {
    nextTick(() => {
        showcontainer.value = true
    })
})
      

</script>

<style lang="scss" scoped>

$orange: orange;

.active-item {
    cursor: move;
}

.title_h1 {
    font-family: Almarai;
    font-style: normal;
    font-weight: 800;
    font-size: 22px;
    line-height: 110%;
    color: #000000;
}

.left-page-container {
    width: 55%;
}

.right-page-container {
    width: 45%;
}

.main-view {
    margin-top: 6rem;
}

.template {
    &-header {
        top: 0;
        max-height: 4.75rem;
    }
    &-footer {
        bottom: 0;
    }
    &-header, 
    &-footer {
        width: 100%;
        height: auto;
        position: absolute;
        left: 0;
        img {
            width: 100%;
            height: 100%;
            padding: 1rem;
            object-fit: cover;
        }
    }
    &-body {
        margin-top: 5.75rem;
        img {
            object-fit: cover;
            width: 25rem;
            height: 25rem;
            height: auto;
            border: 3px solid $orange;
        }
        span {
            word-break: break-all !important;
        }
        .page-number {
            float: right;
            font-size: 12px;
            font-family: inherit;
            &::after, &::before {
                float: none;
                clear: both;
            }
        }
    }
}

.builder-container {
    position: relative;
    min-height: 58rem;
    height: auto;
    background: #fff;
    overflow: hidden;
    padding: 1rem 2rem;
    margin-bottom: 1rem;

    .draggable {
        z-index: 10;
        position: absolute;
        .close {
            position: absolute;
            top: -100%;
            left: 50%;
            width: 1.2rem;
            height: 1.2rem;
            background: #000;
            color: white;
            transform: translate(-50%, -100%);
            transform-origin: center;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            line-height: 1.08rem;
            cursor: pointer;
            &:hover {
                opacity: .8;
            }
        }
    }

    .transparent-button {
        background: transparent;
        border-radius: 0;
        border: 2px solid #000;
        text-transform: uppercase;
        font-weight: 900;
        font-family: 'Almarai ExtraBold';
    }

    .title-bar {
        background: #797272;
        color: rgb(243, 243, 243);
        padding: 5px 1rem;
        margin: .8rem 0;
        text-transform: uppercase;
        font-size: 1.2rem;
        font-weight: 900;
        font-family: 'Almarai ExtraBold';
        width: 92%;
        display: flex;
        align-items: center;
    }

    .textarea {
        min-width: 350px;
        min-height: 50px;
        border: 1px solid #ccc;
        z-index: 99999;
        word-wrap: normal;
        &::before,
        &::after {
            float: none;
            clear: both;
        }
    }

    .builder-image {
        width: 200;
        height: 250px;
        object-fit: cover;
        margin: .5rem 0;
    }

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

