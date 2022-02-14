<template>

    <div class="row m-0">
        
        <div class="col m-2">

            <SelectBox
                v-model="select1" 
                placeholder="Choose a number" 
                :options="selectBoxOptions" 
                name="select2" 
                :valid="true"
                label="Positive" 
            />

        </div>

        <div class="col m-2">
            <CheckBoxMain 
                title="Statut"
                width="250px"
                search
                v-model:options="options"
            />
        </div>
        
        <div class="col m-2">
            <h4>App Filters</h4>
            <Filter 
                v-model:checkboxOptions="filterCheckboxOptions"
                v-model:selectOptions="filterSelectOptions"
                v-model:selectedOptions="filterSelectedOptions"
                @validate="validateFilters"
            />
        </div>


    </div>

    
</template>

<script>

import { ref, reactive } from "vue";
import Filter from "../components/Filter.vue"
import CheckBoxMain from "./../components/miscellaneous/CheckBoxMain.vue"

export default {

    components: {
        Filter,
        CheckBoxMain,
    },

    setup() {

        const select1 = ref(0)
        const selectBoxOptions = reactive([
            { value:'1', display: 'One' },
            { value:'2', display:'Two' }
        ])

        const options = reactive([
            { id: 1, value: 'Perdu', check: false},
            { id: 2, value: 'Gagne', check: false},
            { id: 3, value: 'Abondonne', check: false},
            { id: 4, value: 'Laravel', check: false},
            { id: 5, value: 'Vue', check: false},
            { id: 6, value: 'Wordpress', check: false},
            { id: 7, value: 'Js', check: false},
            { id: 8, value: 'NodeJs', check: false},
            { id: 9, value: 'GraphQl', check: false},
        ]);

        const filterSelectedOptions = reactive({
            0: '',
            1: ''
        })
        const filterCheckboxOptions =  ref([
            {
                id: 1,
                name: 'Champs',
                options: [
                    { id: 1, value: 'no devis', check: false },
                    { id: 2, value: 'client', check: false },
                    { id: 3, value: 'contact', check: false },
                    { id: 4, value: 'chantier', check: false },
                    { id: 5, value: 'date creation', check: false },
                    { id: 6, value: 'responsable', check: false },
                    { id: 7, value: 'status', check: false },
                ],
            },
            {
                id: 2,
                name: 'Champs 2',
                options: [
                    { id: 1, value: 'no devis', check: false },
                    { id: 2, value: 'client', check: false },
                    { id: 3, value: 'contact', check: false },
                    { id: 4, value: 'chantier', check: false },
                    { id: 5, value: 'date creation', check: false },
                    { id: 6, value: 'responsable', check: false },
                    { id: 7, value: 'status', check: false },
                ],
            }
        ])

        const filterSelectOptions = reactive([
            {
                label: 'Grouper par',
                options: [
                    { value: 1, display: 'One' },
                    { value: 2, display: 'Two' },
                ],
            },
        ])

        const validateFilters = () => {
            console.log('validated')
        }

        return { 
            select1,
            options,
            validateFilters, 
            selectBoxOptions,
            filterSelectOptions,
            filterCheckboxOptions,
            filterSelectedOptions,
        }
    },
}

</script>

<style lang="scss"></style>
