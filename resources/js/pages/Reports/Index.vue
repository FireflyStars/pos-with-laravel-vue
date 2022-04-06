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
                        <h4 class="tile_h1 flex align-items-center gap-2 mt-2">
                            <Icon name="report" width="32" height="32" />
                            Reports List
                        </h4>

                        <div class="bg-white p-3 my-4">
                         
                            <table 
                                class="table"
                                :class="{ 'table-striped': reports.length }"
                            >
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Order Id</th>
                                        <th scope="col">Affilitiate Id</th>
                                        <th scope="col">Pages</th>
                                        <th scope="col">Created at</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <template v-if="fetching">
                                        <tr v-for="n in 2" :key="n">
                                            <td v-for="col in 6" :key="col"><loader /></td>
                                        </tr>
                                    </template>

                                    <template v-else>
                                        
                                        <template v-if="reports.length">
                                            
                                            <tr v-for="(report, index) in reports" :key="report.id">
                                                <td>{{ +index + 1 }}</td>
                                                <td>{{ report.id || 'Nil' }}</td>
                                                <td>{{ report.affiliate_id || 'Nil' }}</td>
                                                <td>{{ report.pages.length }}</td>
                                                <td>{{ report.created_at }}</td>
                                                <td>
                                                    <router-link 
                                                        class="link"
                                                        :to="{ 
                                                            name: 'report-page',
                                                            params: {
                                                                id: report.id
                                                            } 
                                                        }"
                                                    >
                                                        {{ report.pages.length ? 'Edit Report': 'Create Report' }}
                                                    </router-link>
                                                </td>
                                            </tr>

                                        </template>

                                        <template v-else>
                                            <tr>
                                                <td colspan="6">No reports found!</td>
                                            </tr>
                                        </template>

                                    </template>
                                    

                                </tbody>
                            </table>

                        </div>

                    </div>

                </div>
            </div>
        </transition>
    </router-view>


</template>

<script>

import { useStore } from 'vuex'
import { onMounted, ref, nextTick, computed } from 'vue'

import { 
    BUILDER_MODULE, 
    GET_REPORTS
} from '../../store/types/types'



export default {


    setup() {

        const store = useStore()

        const showcontainer = ref(false)

        const fetching = computed(() => { 
            const { id, value } = store.getters[`${BUILDER_MODULE}/loading`]
            return id == 'fetching' && value
        })

        const reports = computed(() => store.getters[`${BUILDER_MODULE}/reports`])

        const getReports = () => {
            store.dispatch(`${[BUILDER_MODULE]}/${[GET_REPORTS]}`)
        }

        onMounted(() => {
            nextTick(() => {
                showcontainer.value = true
                getReports()
            })
        })
      
        return { 
            reports,
            fetching,
            showcontainer,
        }
    },
}

</script>

<style scoped>
.main-view {
    margin-top: 6rem;
}
</style>

