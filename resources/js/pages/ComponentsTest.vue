<template>
    <!-- Il faut passer des #value pour options -->
    <CheckBoxMain></CheckBoxMain>
    <Filter
        v-model="allSelectedItems"
        :checkboxes_options="[
            {
                name: 'Champs',
                options: [
                    { value: 'LARAVEL', check: false },
                    { value: 'Sail', check: false },
                    { value: 'Eloquent', check: false },
                ],
            },
            {
                name: 'Champs 2',
                options: [{ value: 'Vue 3', check: false }],
            },
            {
                name: 'Champs 3',
                options: [
                    { value: 'Vue 2', check: false },
                    { value: 'VUEX', check: false },
                ],
            },
        ]"
        :select_options="[
            {
                label: 'Select',
                options: [
                    { value: '', display: '' },
                    { value: 1, display: 'One' },
                    { value: 2, display: 'Two' },
                ],
            },
            {
                label: 'Select 2',
                options: [
                    { value: '', display: '' },
                    { value: 'b', display: 'A' },
                    { value: 'c', display: 'B' },
                ],
            },
        ]"
    />
</template>

<script>
import { ref } from "vue";
import Filter from "../components/Filter.vue";
import CheckBoxMain from "./../components/miscellaneous/CheckBoxMain.vue";
export default {
    components: {
        Filter,
        CheckBoxMain,
    },
    setup() {
        const allSelectedItems = ref([]);
        return { allSelectedItems };
    },
};
</script>

<style lang="scss"></style>
