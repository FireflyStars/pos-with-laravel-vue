<template>
    <div class="d-flex align-items-center gap-1">
        <a
            class="mr-1 action-link"
            href="#" 
            @click.prevent="searchMore"
            v-show="!loadingAppend && !limitReached"
        >
            Voir plus
        </a>
        <Icon 
            class="icon"
            name="spinner"
            v-show="loadingAppend"
        />
    </div>
</template>

<script>
export default {
    name: 'load-more'
}
</script>

<script setup>

import { computed } from 'vue'
import { useStore } from 'vuex'
import { 
    SEARCH_MODULE,
    SEARCH_MORE
} from '../../../store/types/types'

const props = defineProps({
    action: {
        required: true,
        type: String
    }
})

const store = useStore()

const loadingAppend = computed(() => {
    const { id, value } = store.getters[`${SEARCH_MODULE}/loading`]
    return id == `search-append-${props.action}` && value
})

const limitReached = computed(() => {
    return store.getters[`${SEARCH_MODULE}/limitReached`][props.action]
})

const searchMore = () => {
    if(loadingAppend.value) return
    store.dispatch(`${[SEARCH_MODULE]}/${[SEARCH_MORE]}`, props.action)
}

</script>

<style lang="scss" scoped>
.action-link {
    font-family: 'Almarai Regular';
    font-style: normal;
    font-weight: 300;
    font-size: 18px;
    line-height: 100%;
    display: flex;
    align-items: center;
    text-decoration-line: underline;
    color: #000000;
    }
</style>