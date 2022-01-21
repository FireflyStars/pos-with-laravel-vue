<template>
    <Filter
        :checkboxes_options="[
            'LARAVEL',
            'VUE 3',
            'VUEX',
            'COMPOSITION',
            'VUE 3',
            'VUEX',
        ]"
        :select_options="[
            { value: 0, display: 'Zero' },
            { value: 1, display: 'One' },
            { value: 2, display: 'Two' },
            { value: 3, display: 'Three' },
            { value: 4, display: 'Four' },
        ]"
    />
</template>

<script>
import { ref } from "vue";
import Filter from "../components/Filter.vue";
export default {
    components: {
        Filter,
    },
    setup() {
        return {};
    },
};
</script>

<style lang="scss"></style>
