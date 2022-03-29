<template>

    <div class="zone-comments-section">
                            
        <div class="zone-comments-header d-flex align-items-center gap-4">
            <Icon name="house" />

            <h4 class="breadcrumb-title zone-comments-title">
                zone Comments
            </h4>

        </div>    

        <div class="zone-comments-body"
            v-for="comment in orderZoneComments"
            :key="comment.id"
        >
            <div class="d-flex align-items-center gap-4">
                <span>{{ comment.comment }}</span>
                <Icon 
                    name="circle-plus" 
                    class="pointer"
                    @click.prevent="generateElement('textarea', { 
                        content: comment.comment || 'Comment'
                    })"
                />

            </div>
        </div>

    </div>

</template>

<script>
import { inject } from 'vue'
export default {
    name: 'zone-comments-section',
    props: {
        orderZoneComments: {
            required: true,
            type: [Array, Object]
        }
    },

    setup () {
        
        const generateElement = inject('generateElement')

        return {
            generateElement
        }
    }
}
</script>

<style lang="scss" scoped>

.box-bottom-right {

    .breadcrumb {
        margin-top: 3rem;
        &-title {
            font-family: Mulish;
            font-style: normal;
            font-weight: 900;
            font-size: 18px;
            line-height: 23px;
            letter-spacing: 0.01em;
            color: #000000;
            text-transform: uppercase;
            margin-bottom: 0;
        }

    }

    .zone-comments-section {
        margin-top: 2.75rem;
        margin-bottom: 1.5rem;
        .zone-comments-body {
            margin-top: 1.125rem;
            width: 90%;
            margin-left: auto;
            margin-right: auto;
        }
    }
    
}

</style>