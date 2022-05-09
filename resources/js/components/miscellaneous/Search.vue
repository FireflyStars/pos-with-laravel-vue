<template>
    <div class="search">

        <input 
            class="mulish_400_normal" 
            type="search" 
            placeholder="Rechercher..."
            v-model="search"
            @keyup.enter="submit"
            @focus="show = true"
            @blur="show = false"
        >

        <search-results :show="show" />
        
    </div>


</template>

<script>
import { useStore } from 'vuex'
import { ref, computed } from 'vue'
import {
    SEARCH_MODULE,
    GET_SEARCH_RESULTS
}
 from '../../store/types/types'
import searchResults from './search-results'

export default {
    
    name: "Search",

    components: {
        searchResults,
    },
    
    setup() {

        const store = useStore()
        const show = ref(false)
        const search = computed(() => store.getters[`${SEARCH_MODULE/'search'}`])
        
        const submit = () => store.dispatch(`${[SEARCH_MODULE]}/${[GET_SEARCH_RESULTS]}`)
        
        return {
            show,
            search,
            submit
        }    

    }

}
</script>

<style scoped lang="scss">

.search {

    float: left;
    margin-right: 19px;
    margin-top: 18px;
    width: 217px;

    input[type="search"] {
        box-sizing: border-box;
        border:1px solid #FFF;
        border-radius: 10px;
        background: transparent;
        height: 29px;
        font-size: 12px;
        width: 100%;
        color:#FFF;
        padding-left:12px;
        letter-spacing: 0.2px;
        background: url("../../images/search-icon.svg") no-repeat right 14px center;
    }

}

</style>