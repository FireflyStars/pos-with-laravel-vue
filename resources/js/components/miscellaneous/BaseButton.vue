<template>
    <button>
        <div :class="textClass">{{ title }}</div>
        <slot></slot>
    </button>
</template>

<script>
    export default {
        props: {
            title: {
                required: true,
                type: String
            },
            textClass: String
        }
    }
</script>


<style lang="scss" scoped>
    button {
        display: flex;
        justify-items: center;
        align-items: center;
        gap: 3px;
    }
</style>