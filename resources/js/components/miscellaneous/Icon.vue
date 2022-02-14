<template>
    <template v-if="name == 'filter'">
        <svg :width="$attrs.width || 21" :height="$attrs.heigth || 16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg" v-bind="$attrs">
            <rect y="0.941406" width="21" height="2.41033" rx="1.20516" :fill="$attrs.color || '#47454B'" />
            <rect x="3.66278" y="6.96729" width="13.6744" height="2.41033" rx="1.20516" :fill="$attrs.color || '#47454B'" />
            <rect x="7.32556" y="12.9932" width="6.34883" height="2.41033" rx="1.20517" :fill="$attrs.color || '#47454B'" />
        </svg>
    </template>
</template>

<script>
    export default {
        name: 'Icon',
        inheritAttrs: false,
        props: {
            name: {
                required: true,
                type: String
            }
        }
    }
</script>
