<template>
    <!-- Il faut passer des #value pour options -->
    <NavBar/>
    <SideBar/>
<div class="main-layout">
 <CheckBoxMain></CheckBoxMain>
</div>

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
import SideBar from "../components/layout/SideBar.vue"
import CheckBoxMain from "./../components/miscellaneous/CheckBoxMain.vue";
import NavBar from "../components/NavBar.vue";
export default {
    components: {
    Filter,
    CheckBoxMain,
    SideBar,
    NavBar
},
    setup() {
        const allSelectedItems = ref([]);
        return { allSelectedItems };
    },
};
</script>

<style lang="scss">
.main-layout{
padding-left: 10%;
}
</style>
