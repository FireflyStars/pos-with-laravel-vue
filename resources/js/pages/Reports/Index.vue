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
                        <h4 class="tile_h1 flex align-items-center gap-3 mt-2">
                            <Icon name="report" width="32" height="32" />
                            Reports List
                        </h4>

                        <item-list-table 
                            :table_def="reports" 
                        >

                            <template v-slot:pages="{ row }">
                                {{ row.pages.length }}
                            </template>

                            <template v-slot:id="{ row }">
                                <router-link 
                                    class="link"
                                    :to="{ 
                                        name: 'report-page',
                                        params: {
                                            id: row.id
                                        } 
                                    }"
                                >
                                    {{ row.pages.length ? 'Edit Report': 'Create Report' }}
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

import { 
    REPORTS_BUILDER_MODULE, 
} from '../../store/types/types'

import ItemListTable from '../../components/miscellaneous/ItemListTable/ItemListTable.vue'

const store = useStore()

const showcontainer = ref(false)

const reports = computed(() => store.getters[`${REPORTS_BUILDER_MODULE}reportListDefinition`])

onMounted(() => {
    nextTick(() => {
        showcontainer.value = true
    })
})
      
      

</script>

<style scoped>
.main-view {
    margin-top: 6rem;
}
</style>

