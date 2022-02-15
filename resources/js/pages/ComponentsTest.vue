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
                title="Statut"
                width="200px"
                tagBackground="orange"
                tagColor="white"
                classes=""
                :styles="{}" 
                dropdownClasses=""
                :dropdownStyles="{}"
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
            <h4>Checkbox</h4>
            <CheckBox 
                title="Custom attributes checkbox"
                name="customCheckbox"
                background="blue"
                color="orange"
                :checked="customCheckbox"
                @changed="customCheckbox = $event.value"
            />
        </div>
        
    </div>

    <div class="row m-0 mt-5">
        <div class="col">
            
            <h4>Buttons</h4>
            
            <div class="d-flex align-items-center justify-content-between">
                <BaseButton title="Danger" htmlTitle="kind danger" kind="danger" class="text-capitalize" />
                <BaseButton title="Primary" htmlTitle="kind primary" kind="primary" class="text-capitalize" />
                <BaseButton title="success" htmlTitle="kind success" kind="success" class="text-capitalize" />
                <BaseButton title="Green" htmlTitle="kind green" kind="green" class="text-capitalize" />
                <BaseButton title="Light Green" htmlTitle="kind light-green" kind="light-green" class="text-capitalize" />
                <BaseButton title="Warning" htmlTitle="kind warning" kind="warning" class="text-capitalize" />
                <BaseButton title="Light warning" htmlTitle="kind light-warning" kind="light-warning" class="text-capitalize" />

                <BaseButton 
                    title="Light warning Icon"
                    htmlTitle="kind light-warning"
                    kind="light-warning"
                    class="text-capitalize"
                    prepend
                   >
                    <Icon name="user" />
                </BaseButton>

                <BaseButton 
                    title="Warning Icon"
                    htmlTitle="kind warning"
                    kind="warning"
                    class="text-capitalize"
                   >
                    <Icon name="clipboard" />
                </BaseButton>

            </div>


        </div>
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
        const customCheckbox = ref(false)

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
            select1,
            options,
            customCheckbox,
            validateFilters, 
            toggleActiveItem,
            selectBoxOptions,
            filterSelectOptions,
            filterCheckboxOptions,
            filterSelectedOptions,
        }
    },
}

</script>

<style lang="scss"></style>
