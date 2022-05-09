<template>
    <div class="template-header">
        <img 
            v-if="'id' in template"
            :src="template.template.header" 
            alt="Template header" 
        >
    </div>
</template>

<script>
export default {
    name: 'report-header',
    props: {
        template: {
            required: true,
            type: Object
        }
    }

}
</script>

<style lang="scss" scoped>
.template {
    &-header {
        top: 0;
        max-height: 4.75rem;
        width: 100%;
        height: auto;
        position: absolute;
        left: 0;
        img {
            width: 100%;
            height: 100%;
            padding: 1rem;
            object-fit: cover;
        }
    }
}
</style>