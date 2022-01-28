<template>
    <!-- Il faut passer des ID# pour checkboxes_options -->
    <CheckBoxMain></CheckBoxMain>
    <Filter
        v-model="allSelectedItems"
        :checkboxes_options="[
            {
                name: 'Champs',
                options: [
                    { id: 1, value: 'LARAVEL', check: false },
                    { id: 2, value: 'Sail', check: false },
                    { id: 3, value: 'Eloquent', check: false },
                ],
            },
            {
                name: 'Champs 2',
                options: [{ id: 4, value: 'Vue 3', check: false }],
            },
            {
                name: 'Champs 3',
                options: [
                    { id: 5, value: 'Vue 3', check: false },
                    { id: 6, value: 'VUEX', check: false },
                ],
            },
        ]"
        :select_options="[
            {
                label: 'Select',
                options: [
                    { id: 9, value: '', display: '' },
                    { id: 10, value: 1, display: 'One' },
                    { id: 11, value: 2, display: 'Two' },
                ],
            },
            {
                label: 'Select 2',
                options: [
                    { id: 12, value: '', display: '' },
                    { id: 13, value: 'b', display: 'A' },
                    { id: 14, value: 'c', display: 'B' },
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
