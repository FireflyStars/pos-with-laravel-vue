<template>
    <nav v-if="totalPages > 1">
        <ul class="pagination my-2">
            <li class="page-item"
                :class="{ 'disabled': page == 1 }"
                @click.prevent="prev"
            >
                <a 
                    class="page-link" 
                    href="#" 
                    tabindex="-1" 
                    aria-disabled="true" 
                    :disabled="page == 1"
                >
                    Previous
                </a>
            </li>
            <li 
                v-for="n in formattedPages"
                :key="n"
                class="page-item"
                :class="{ 'active disabled': n == page || n == '...' }"
                @click.prevent="changePage(n)"
                :disabled="n === '...' || n === page"
            >
                <a class="page-link" href="#" :disabled="n === '...' || n === page">{{ n }}</a>
            </li>
            <li class="page-item"
                :class="{ 'disabled': page == totalPages }"
                @click.prevent="next"
            >
                <a 
                    class="page-link" 
                    href="#" 
                    :disabled="page == totalPages"
                >
                    Next
                </a>
            </li>
        </ul>
    </nav>
</template>

<script>
import { ref, computed, onMounted } from 'vue'
export default {
    name: 'pagination',
    props: {
        total: {
            required: true,
            type: Number
        },
        page: {
            required: true,
            type: Number
        },
        perPage: {
            required: false,
            type: Number,
            default: 15
        }
    },

    emits: ['change'],
    
    setup (props, { emit }) {

        const formattedPages = ref([])
        
        const totalPages = computed(() => {
            return Math.ceil(parseFloat(props.total / props.perPage))
        })

        const prev = () => {
            if(props.page == 1) return
            emit('change', Number(props.page) - 1)
        }

        const next = () => {
            if(props.page == totalPages.value.length) return 
            emit('change', Number(props.page) + 1)
        }

        const changePage = (toPage) =>{ 
            if(toPage == '...' || props.page == toPage) return
            emit('change', toPage)
        }

        const setPages = () => {

            const page = props.page || 0
            const pages = totalPages.value || 0
            const displayPages = 6
            const pagesList = []
            const activePage = page

            for (let i = 1; i <= pages; i++) {
                if (pages <= displayPages) {
                    pagesList.push(i)
                } 
                else if (
                    i === 1 ||
                    i === pages ||
                    i === activePage ||
                    activePage + 1 === i ||
                    activePage - 1 === i ||
                    ((activePage === 1 || activePage === 2) && (i === 3 || i === 4)) ||
                    ((activePage === pages || activePage === pages - 1) &&
                        (i === pages - 2 || i === pages - 3))
                ) 
                {
                    pagesList.push(i)
                }
            }
            if (pages > displayPages) {
                if (activePage >= displayPages - 1) {
                    pagesList.splice(1, 0, "...")
                }
                if (pages - activePage >= displayPages - 2) {
                    pagesList.splice(pagesList.length - 1, 0, "...")
                }
            }

            formattedPages.value = pagesList
            
        }

        onMounted(() => setPages())

        return {
            prev,
            next,
            changePage,
            totalPages,
            formattedPages,
        }
    }
}
</script>

<style lang="scss" scoped>

</style>