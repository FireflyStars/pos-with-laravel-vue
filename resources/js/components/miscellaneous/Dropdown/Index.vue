<template>

    <transition name="dropdown-select">
        <div 
        v-if="open(id)"
        class="dropdown-container"
        :class="classSet"
        :style="styleSet"
        v-bind="$attrs"
        v-click-away="close"
        >
            <slot></slot>
        </div>
    </transition>
    

</template>

<script>
import { computed } from 'vue'
import useToggler from '../../../composables/useToggler'

export default {
    
    name: "Dropdown",
    inheritAttrs: false,

    props: {
        dark: Boolean,
        search: Boolean,
        id: {
            required: true,
            type: String
        },
        classes: {
            type: String,
            required: false,
            default: ''
        },
        styles: {
            type: Object,
            required: false,
            default: () => {}
        }
    },

    setup(props, { attrs }) {

        const { open, toggleActiveItem } = useToggler()

        const close = () => {
            toggleActiveItem(props.id)
        }

        const classSet = computed(() => {
            return [{ 
                'active': open(props.id),
                'dark': props.dark,
                },
                ...props.classes.split(',')
            ]
        })

        const styleSet = computed(() => {
            return {
                width: attrs.width ? `${attrs.width} !important` : '100%',
                padding: attrs.padding ? `${attrs.padding} !important` : '',
                margin: attrs.margin ? `${attrs.margin} !important` : 0,
                top: attrs.top ? `${attrs.top} !important` : '100%',
                right: attrs.right ? `${attrs.right} !important` : '',
                left: attrs.left ? `${attrs.left} !important` : '0',
                bottom: attrs.bottom ? `${attrs.bottom} !important` : '',
                height: attrs.height ? `${attrs.height} !important` : 'auto',
                background: attrs.background ? `${attrs.background} !important` : '#EEEEEE',
                transformOrigin: attrs.transformOrigin ? `${attrs.transformOrigin} !important` : 'bottom',
                ...props.styles
            }
        })

        return {
            open,
            close,
            classSet,
            styleSet,
            toggleActiveItem
        }

    }

}

</script>


<style lang="scss" scoped>

.dropdown-select-enter-from {
    opacity: 0;
    transform: scale(0.6);
}
.dropdown-select-enter-to {
    opacity: 1;
    transform: scale(1);
}
.dropdown-select-enter-active {
    transition: all ease 0.2s;
}
.dropdown-select-leave-from {
    opacity: 1;
    transform: scale(1);
}
.dropdown-select-leave-to {
    opacity: 0;
    transform: scale(0.6);
}
.dropdown-select-leave-active {
    transition: all ease 0.2s;
}

.dropdown-container {
    background: #EEEEEE;
    color: #000000;
    width: 100%;
    overflow: hidden;
    order: 1;
    font-family: Almarai;
    font-style: normal;
    font-weight: bold;
    font-size: 14px;
    line-height: 140%;
    position: absolute;
    top: 0;
    z-index: 10;
    width: 100%;

    &::-webkit-scrollbar {
        width: 8px;
        background: #EEEEEE;
        border-radius: 0 8px 8px 0;
    }

    &::-webkit-scrollbar-thumb {
        background: #525861;
        border-radius: 0 8px 8px 0;
    }

}

.active {
    transition: all .2s;
    // overflow-y: auto;
    overflow: visible;
}

    
.dropdown-container.dark {
    background: #494c50 !important;
    color: #F0F0F0 !important;
    &::-webkit-scrollbar {
        background: #525861;
    }

    &::-webkit-scrollbar-thumb {
        background: #494c50;
    }
}


</style>

