<template>
    <div class="template-footer">
        <img 
            v-if="'id' in template"
            :src="template.template.footer" 
            alt="Template footer" 
        >
    </div>
    <div 
        class="template-affiliate" 
        v-html="footerreport" 
        v-show="!fetching"
    >
    </div>
</template>

<script>

import { BUILDER_MODULE } from '../../store/types/types'
import { useStore } from 'vuex'
import { inject, computed } from 'vue'

export default {

    name: 'report-footer',
    
    props: {
        template: {
            required: true,
            type: Object
        }
    },

    setup() {
        
        const store = useStore()
        const fetching = inject('fetching')

        const activePageTemplate = computed(() => store.getters[`${BUILDER_MODULE}/activePageTemplate`])
        const order = computed(() => store.getters[`${BUILDER_MODULE}/order`])
        const footerreport = computed(() => {
            return order.value.affiliate?.footerreport
        })
       
        return {
            order,
            fetching,
            footerreport,
            activePageTemplate
        }

    }
    
}
</script>

<style lang="scss" scoped>

* {
    margin: 0;
    padding: 0;
}

.template {
    
    &-affiliate {
        bottom: 0;
        left: 0;
        width: 100%;
        position: absolute;
        padding: 1rem;
        font-size: 10px;
        font-family: inherit;
        &, 
        & > * {
            margin-bottom: 0 !important;
        }
    }

    &-footer {
        bottom: 7rem;
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

}

</style>