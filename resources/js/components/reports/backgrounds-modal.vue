<template>
    <Modal 
        id="change-fond"
        size="md"
    >
        <div>
            <h4 class="d-flex align-items-center gap-3">
                <Icon name="report" width="32" height="32" />
                Change Fond
            </h4>
            <div class="mt-3"> 

                <div class="background-container">

                    <div class="left">
                        <BaseButton 
                            title="Votre Image"
                            @click="promptImage(true)"
                        />
                    </div>

                    <div class="right">
                        
                        <div class="background-boxes">
                            <div 
                                v-for="template in reportTemplates"
                                :key="template"
                            >

                                <div 
                                    class="background-box"
                                    :class="{ 'background-box--active': isActivePageBackground(template) }"
                                    @click.prevent="generateElement('background', {
                                        filename: `/images/${template}`,
                                        classes: 'page-background',
                                        image: `/images/${template}`
                                    })"
                                >
                                    <img 
                                        :src="`/images/${template}`" 
                                        alt="Report Template"
                                    >
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="d-flex align-items-center justify-content-around mt-5">
                    <BaseButton 
                        title="Valider"
                        kind="green"
                        @click="toggleModal('change-fond', false)"
                    />
                    <BaseButton 
                        title="Non"
                        @click="toggleModal('change-fond', false)"
                    />
                </div>

            </div>
        </div>
    </Modal>

</template>

<script>

import { useStore } from 'vuex'
import { computed, inject } from 'vue'
import useModal from '../../composables/useModal'
import { 
    BUILDER_MODULE,
} from '../../store/types/types'

export default {
    
    setup () {
        
        const store = useStore()
        const generateElement = inject('generateElement')
        const promptImage = inject('promptImage')

        const { toggleModal } = useModal()
        
        const page = computed(() => store.getters[`${BUILDER_MODULE}/page`])

        const reportTemplates = computed(() => {
            return [
                'page0.jpg',
                'page1.jpg',
                'page2.jpg',
                'page3.jpg',
                'page4.jpg',
                'page5.jpg',
                'page8.jpg',
            ]
        })

        const isActivePageBackground = (template) => {
            return page.value?.background?.dataFile == `/images/${template}`
        }

        return {
            page,
            promptImage,
            toggleModal,
            generateElement,
            reportTemplates,
            isActivePageBackground
        }
    }
}
</script>

<style lang="scss" scoped>

.background-container {
    display: grid;
    align-items: center;
    justify-items: center;
    grid-template-columns: 30% 70%; 
}

.background-boxes {

    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .5rem;
    text-align: center;
    font-family: 'Poppins', sans-serif;
    font-style: normal;
    font-weight: 600;
    font-size: 16px;
    line-height: 22px;
    color: #000000;

    .background-box {
        width: 6rem;
        height: 5.825rem;
        border-radius: 8px;
        padding: 4px;
        border: 1px solid #ccc;
        cursor: pointer;
        transition: all .1s;
        &--active {
            border: 3px solid orange;
        }
        &:hover {
            border: 3px solid orange;
        }
        img {
            width: 100%;
            height: 100%;
        }
    }
}

</style>