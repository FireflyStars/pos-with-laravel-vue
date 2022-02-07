<template>
    <select-options v-model="sel1" placeholder="Choose a number" :options="[{value:'',display:''},{value:'1',display: 'One'},{value:'2',display:'Two'}]" name="select2" hint="nice." :valid="true" label="Positive"></select-options>
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
            {
                name: 'Champs 4',
                options: [
                    { value: 'new', check: false },
                    { value: 'text', check: false },
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
            {
                label: 'Select 3',
                options: [
                    { value: '', display: '' },
                    { value: 'x', display: 'X' },
                    { value: 'y', display: 'Y' },
                ],
            },
           
        ]"
    />
</template>

<script>
import { ref } from "vue";
import Filter from "../components/Filter.vue";
import CheckBoxMain from "./../components/miscellaneous/CheckBoxMain.vue";
import SelectOptions from "../components/miscellaneous/SelectOptions.vue";
export default {
    components: {
        Filter,
        CheckBoxMain,
        SelectOptions,
    },
    setup() {
        const allSelectedItems = ref([]);
        const sel1 = ref([]);
        return { sel1,allSelectedItems };
    },
};
</script>

<style lang="scss"></style>
