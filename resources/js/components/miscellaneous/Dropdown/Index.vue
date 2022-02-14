<template>
    
    <div 
    class="dropdown-container"
    :class="[{ 
        'active': open(id),
        'dark': dark,
    }]"
    :style="{
        width: `${$attrs.width} !important` || 'auto',
        padding: $attrs.padding || '',
        margin: $attrs.margin || 0,
        top: $attrs.top || '100%',
        right: $attrs.right || '',
        left: $attrs.left || '0',
        bottom: $attrs.bottom || '',
        height: $attrs.height || 'auto',
        background: $attrs.background || '#EEEEEE'
    }"
    v-bind="$attrs"
    >

        <slot></slot>

    </div>

</template>

<script>
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
        }
    },

    setup() {

        const { open } = useToggler()

        return {
            open,
        }

    }

}

</script>


<style lang="scss" scoped>

.dropdown-container {
    background: #EEEEEE;
    color: #000000;
    width: 100%;
    transition: all .2s;
    height: 0;
    opacity: 0;
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
    opacity: 1;
    transition: all .2s;
    overflow-y: auto;
}

    
.dropdown-container.dark {
    background: #494c50;
    color: #F0F0F0;
    &::-webkit-scrollbar {
        background: #525861;
    }

    &::-webkit-scrollbar-thumb {
        background: #494c50;
    }
}


</style>

