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
                id="checkBoxMain"
                search
                title="Statut"
                width="250px"
                tagBackground="orange"
                tagColor="white"
                classes=""
                :styles="{}" 
                dropdownClasses=""
                :dropdownStyles="{ color: 'blue !important' }"
                v-model:options="options"
            />
        </div>
        
        <div class="col m-2">
            <h4 class="text-center">App Filters</h4>
            <Filter 
                v-model:checkboxOptions="filterCheckboxOptions"
                v-model:selectOptions="filterSelectOptions"
                v-model:selectedOptions="filterSelectedOptions"
                activeBackground="orange"
                activeColor="white"
                dropdownClasses=""
                :dropdownStyles="{}"
                classes=""
                :styles="{}"
                @validate="validateFilters"
            />
        </div>

    </div>

    <div class="row m-0">
        <div class="col">
            <h4>Dropdown Item</h4>
            <div class="position-relative">
                <BaseButton 
                    class="mt-1"
                    title="Dropdown Trigger"
                    @click="toggleActiveItem('demoDropdown')"
                />
                <Dropdown 
                    id="demoDropdown"
                    height="200px"
                    background="transparent"
                >
                    <ul class="list-group w-100">
                        <li class="list-group-item list-group-item-action">Item 1</li>
                        <li class="list-group-item list-group-item-action">Item 2</li>
                        <li class="list-group-item list-group-item-action">Item 3</li>
                        <li class="list-group-item list-group-item-action">Item 4</li>
                    </ul>
                </Dropdown>
            </div>
        </div>
        <div class="col">
        </div>
        <div class="col"></div>
    </div>

    
</template>

<script>

import { ref, reactive } from "vue";
import Filter from "../components/Filter.vue"
import CheckBoxMain from "./../components/miscellaneous/CheckBoxMain.vue"
import CheckBoxMainOld from "./../components/miscellaneous/CheckBoxMainOld.vue"
import useToggler from '../composables/useToggler'

export default {

    components: {
        Filter,
        CheckBoxMain,
        CheckBoxMainOld,
    },

    setup() {
        
        const { open, toggleActiveItem } = useToggler()

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
            open,
            toggleActiveItem,
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
