<template>
    <div 
        v-for="n in count"
        :key="n"
        class="loader"
        :class="type"
        v-bind="$attrs"
    >     
    </div>
</template>

<script>

import { computed } from 'vue'

export default {
    
    inheritAttrs: false,

    props: { 
        type: {
            required: false,
            type: String,
            default: 'list'
        },
        count: {
            required: false,
            type: Number,
            default: 1
        }
    },

    setup (props, { attrs }) {
        const styleSet = computed(() => {
            return {
                width: attrs.width || ''
            }
        })
        return {
            styleSet
        }
    }
}
</script>

<style lang="scss" scoped>

    .list {
        width: 8.5rem;
        height: 1.4rem;
    }

    .icon {
        width: 1.1rem;
        height: 1.1rem;
        border-radius: 50%;
    }

    .icon-title {
        width: 2.3rem;
        height: 2.3rem;
        border-radius: 50%;
    }

    .image {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 5px;
    }

    .button {
        width: 7rem;
        height: 2.25rem;
        border-radius: 4px;
    }

    .thumbnail {
        width: 2.95rem;
        height: 3.15rem;
        border-radius: 50%;
    }

    .loader {
        margin: 5px 0;
        background: #eee !important;
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: .5;
        }
    }

</style>