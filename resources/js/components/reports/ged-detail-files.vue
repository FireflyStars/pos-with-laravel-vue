<template>
    
    <div class="black-box pointer" 
    v-for="[, detail] in images(gedDetail)" 
    :key="detail.id">
        <img 
            :src="detail.urls.small" 
            :alt="detail.human_readable_filename"
            @click.prevent="$emit('generatePrefetchedImage', detail)"
        />
    </div>

    <div
    v-for="[, detail] in nonImages(gedDetail)"
    :key="detail.id"
    >
        <div 
            class="ml-5 d-flex gap-2 align-items-center" 
            v-if="detail.description"
        >
            <p class="m-0">
                {{ detail.description }}
            </p>
            <Icon 
                name="plus-circle" 
                class="pointer"
                @click="generateElement('textarea', {
                    content: detail.description
                })"
            />
        </div>
    </div>

</template>

<script>
export default {

    props: {
        gedDetail: {
            type: [Object, Array],
            required: true
        }
    },

    emits: ['generatePrefetchedImage', 'generateElement'],

    setup (_, { emit }) {

        const isImage = (gedDetail) => ['png', 'jpg', 'jpeg', 'gif', 'svg'].includes(gedDetail.type)

        const images = (gedDetails) => {
            if(!Object.entries(gedDetails)) return []
            return Object.entries(gedDetails).filter(([_, detail]) => {
                return isImage(detail)
            })
        }

        const nonImages = (gedDetails) => {
            if(!Object.entries(gedDetails)) return []
            return Object.entries(gedDetails).filter(([_, detail]) => {
                return !isImage(detail)
            })
        }

        const generateElement = () => emit('generateElement', data)

        return {
            images,
            nonImages,
            generateElement
        }

    }
}
</script>

<style lang="scss" scoped>

</style>