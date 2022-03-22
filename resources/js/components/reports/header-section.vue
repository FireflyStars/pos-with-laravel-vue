<template>

    <div class="d-flex justify-content-between align-items-center margin-bottom">
                                
        <div>
            <h4 class="tile_h1">
                <Icon name="report" width="32" height="32" />
                Creation/Edition Report
            </h4>
        </div>

        <div class="d-flex">
            <BaseButton 
                title="Sauvegarder" 
                kind="success" 
                classes="me-12 heading-buttons" 
            />
            <BaseButton 
                title="pdf" 
                kind="danger" 
                class="text-uppercase heading-buttons heading-buttons-pdf" 
                @click="$emit('submitPage')" 
            />
        </div>

    </div>

    <div class="d-flex justify-content-between align-items-center">
        <div class="reports-dropdown">
            <select-box
                v-model="activeTemplate" 
                :placeholder="template?.name || 'Template'" 
                :options="formattedTemplates" 
                name="template"
                classnames="reports-dropdown-button"
            />

        </div>

        <div class="d-flex align-items-center">
            
            <div>

                <a 
                class="orange text d-flex align-items-center gap-half pointer" 
                @click.prevent="addPage">
                    <Icon name="plus-circle" />
                    Ajouter Page
                </a>

                <a 
                class="text d-flex align-items-center gap-half"
                :class="[pages.length <= 1 ? 'not-allowed': 'pointer']" 
                @click.prevent="$emit('deletePage')"
                :disabled="pages.length <= 1"
                >
                    <Icon name="bin" />
                    Supprimer Page
                </a>

            </div>
            
            <div class="reports-dropdown page-dropdown">

                <select-box
                    v-model="activePage" 
                    :placeholder="pageName" 
                    :options="formattedPages" 
                    name="page"
                    classnames="reports-dropdown-button"
                />

            </div>

        </div>


    </div>

</template>

<script>

import { ref, computed, watch } from 'vue'
import { useStore } from 'vuex'
import { 
    BUILDER_MODULE,
    ASSIGN_TEMPLATE,
    ADD_PAGE,
    DELETE_PAGE,
    SET_ACTIVE_TEMPLATE,
    SET_ACTIVE_PAGE 
} from '../../store/types/types'

export default {

    emits: ['submitPage'],

    setup () {
        
        const store = useStore()
        
        const activeTemplate = computed({
            set(value) {
                store.commit(`${BUILDER_MODULE}/${SET_ACTIVE_TEMPLATE}`, value)
            },
            get() {
                return store.getters[`${BUILDER_MODULE}/activeTemplate`]
            }
        })

        const activePage = computed({
            set(value) {
                store.commit(`${BUILDER_MODULE}/${SET_ACTIVE_PAGE}`, value)
            },
            get() {
                return store.getters[`${BUILDER_MODULE}/activePage`]
            }
        })

        const page = computed(() => store.getters[`${BUILDER_MODULE}/page`])
        const pages = computed(() => store.getters[`${BUILDER_MODULE}/pages`])

        const pageName = computed(() =>  {
            const pageValue = +activePage.value + 1
            return 'Page ' + pageValue
        })

        const formattedPages = computed(() => {
            return pages.value.map((_, index) => {
                const pageValue = +index + 1
                return {
                    value: index, 
                    display: 'Page ' + pageValue
                }
            })
        })

        const templates = computed(() => store.getters[`${BUILDER_MODULE}/templates`])
        const template = computed(() => store.getters[`${BUILDER_MODULE}/template`])

        const formattedTemplates = computed(() => {
            return templates.value.map(template => {
                return {
                    value: template.id, 
                    display: template.name
                }
            })
        })
        
    
        const assignTemplateToActivePage = (id) => {
            store.commit(`${BUILDER_MODULE}/${ASSIGN_TEMPLATE}`, id)
            return Promise.resolve()
        }

        const addPage = () => {
            store.commit(`${BUILDER_MODULE}/${ADD_PAGE}`)
        }

        const deletePage = () => {
            store.commit(`${BUILDER_MODULE}/${DELETE_PAGE}`)
        }

        watch(activeTemplate, (value) => {
            if(value) assignTemplateToActivePage(value)
        })
        
        return {
            page,
            pages,
            addPage,
            pageName,
            template,
            templates,
            deletePage,
            activePage,
            activeTemplate,
            formattedPages,
            formattedTemplates,
            assignTemplateToActivePage
        }
    }
}
</script>

<style lang="scss" scoped>

.reports-dropdown {
    position: relative;
    margin-bottom: .75rem;
    &-button {
        background: #C4C4C4;
        border: none;
        font-family: Roboto;
        font-style: normal;
        font-weight: normal;
        font-size: 18px;
        line-height: 21px;
        color: #000000;
        gap: 0.51rem;
        padding-left: 1.43rem;
        padding-right: 1.43rem;
        min-width: 9.56rem;
        min-height: 2.93rem;
        border-radius: 0;
    }
    .page-button {
        gap: 2.62rem;
    }
}

.page-dropdown {
    margin-left: 2.06rem;
}

.heading-buttons {
    font-family: sans-serif;
    font-style: normal;
    font-weight: bold;
    font-size: 12px;
    line-height: 23px;
    color: #fff !important;
    width: auto;
    border: none;
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