<template>
    <!-- Il faut passer des ID# pour checkboxes_options -->
    <CheckBoxMain></CheckBoxMain>
    <Filter
        :checkboxes_options="[
            {
                name: 'Champs',
                options: [
                    { id: 1, name: 'LARAVEL', check: false },
                    { id: 2, name: 'Sail', check: false },
                    { id: 3, name: 'Eloquent', check: false },
                ],
            },
            {
                name: 'Champs 2',
                options: [{ id: 4, name: 'Vue 3', check: false }],
            },
            {
                name: 'Champs 3',
                options: [
                    { id: 5, name: 'Vue 3', check: false },
                    { id: 6, name: 'VUEX', check: false },
                ],
            },
            {
                name: 'Champs 4',
                options: [
                    { id: 7, name: 'Vue 3', check: false },
                    { id: 8, name: 'VUEX', check: false },
                ],
            },
        ]"
        :select_options="[
            {
                label: 'Select',
                options: [
                    { value: 0, display: '' },
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
            {
                label: 'Select 3',
                options: [
                    { value: '', display: '' },
                    { value: 'respo', display: 'respo' },
                    { value: 'info', display: 'info' },
                    { value: 'bi', display: 'BI' },
                    { value: 'mrk', display: 'MKG' },
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
        return {};
    },
};
</script>

<style lang="scss"></style>
