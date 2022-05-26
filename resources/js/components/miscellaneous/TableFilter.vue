<template>
    <div 
    class="custom-filter-dropdown "
    :class="classes"
    :style="styles"
    :tabindex="tabindex">
        
        <div class="selected text-end filter-buttons">
            <BaseButton 
                title="Réinitialisation"
                @click.prevent="resetFilter"
                :classes="{'almarai_700_bold':true}"
            />

            <BaseButton
                :class="[{ 'colored': isActive }]"
                 :classes="{'almarai_700_bold':true}"
                title="Filtre"
                @click.prevent="toggleActiveItem(id)"
                :style="{
                    background: customActiveBgColor,
                    color: customActiveColor,
                }"
                :textStyle="{
                    paddingRight: '1rem'
                }"
            >
                <Icon name="filter" :color="customActiveColor" />
            </BaseButton>
        </div>


        <Dropdown 
        :id="id"
        :classes="$attrs.dropdownClasses"
        :styles="$attrs.dropdownStyles"
        >
            <div class="items">

                <div
                    class="checkboxes"
                    v-for="(checkbox, index) of checkboxOptions"
                    :key="index"
                >
                    <div class="text-title">{{ checkbox.name }} :</div>
                    <div
                        class="checkbox-items"
                        v-for="option of checkbox.options"
                        :key="option.id"
                    >
                        <CheckBox
                            :id="option.id"
                            :checked="option.check"
                            :name="option.value"
                            :title="option.value"
                            @change="updateSelectedCheckboxes($event, checkbox.id)"
                            :transformOrigin="$attrs.transformOrigin"
                        />

                    </div>
                </div>

                <SelectBox
                    v-for="(select, index) of selectOptions"
                    :key="index"
                    :placeholder="select.label"
                    :options="select.options"
                    :name="select.label"
                    :label="`${select.label}:`"
                    v-model="selectedOptionItems[index]"
                    :styles="{ width: '196px !important', marginTop: '1.125rem', marginLeft: 0,color:'#868686',fontSize:'14px' }"
                />


                <BaseButton
                    class="validate-button text-title"
                    type="submit"
                    title="Valider"
                    @click.prevent="validate"
                />

            </div>
        </Dropdown>



    </div>
</template>

<script>

import { ref, computed } from "vue"
import useToggler from '../../composables/useToggler'

export default {
    name:'TableFilter',
    props: {
        checkboxOptions: {
            type: Array,
            required: false,
        },
        selectOptions: {
            type: Array,
            required: false,
        },
       
        tabindex: {
            type: Number,
            required: false,
            default: 0,
        },
        classes: String,
        styles: {
            type: String,
            default: ''
        }
    },

    emits: [
        'onChange'
    ],

    setup(props, { emit, attrs }) {

        const { open, toggleActiveItem } = useToggler()

        const isActive = ref(false)
        const defaultBackground = 'lawgreen'
        const defaultColor = '#47454b'
        const customActiveColor = computed(() => {
            return isActive.value ? attrs.activeColor || defaultColor : ''
        })
        const customActiveBgColor = computed(() => {
            return isActive.value ? attrs.activeBackground || defaultBackground : ''
        })

        const id = computed(() => attrs.id || 'filtersMain')
       
        const selectedOptionItems=ref({});

        let checkboxOptions = [ ...props.checkboxOptions ]
        let selectedOptions = { ...props.selectedOptions }

        const resetFilter = () => {
             checkboxOptions = [ ...props.checkboxOptions ]


            checkboxOptions.forEach((checkbox, index) => {
                checkbox.options.forEach((option, optionIndex) => {
                    checkboxOptions[index].options[optionIndex].check = false
                })
            })

            Object.entries(selectedOptionItems.value).forEach((item, index) => {
                   selectedOptionItems.value[index]='';
            })
   
           emit('onChange', {checkboxOptions,selectedOptions:selectedOptionItems.value});
            
            isActive.value = false

            if(open(id.value)) toggleActiveItem(id.value)

        }

        const updateSelectedCheckboxes = ({ id, value }, parentId) => {
             checkboxOptions = [ ...props.checkboxOptions ]
            let checkboxIndex = checkboxOptions.findIndex(checkbox => checkbox.id == parentId)

            if(checkboxIndex != -1) {
                let optionIndex = checkboxOptions[checkboxIndex].options.findIndex(option => option.id == id)
                if(optionIndex != -1) {
                    checkboxOptions[checkboxIndex].options[optionIndex].check = value
                
                }
            }
        }

        
        const validate = () => {
            isActive.value = true
            
            
            emit('onChange', {checkboxOptions,selectedOptions:selectedOptionItems.value});
            
            toggleActiveItem(id.value)
        }
       

        return {
            id,
            validate,
            isActive,
            resetFilter,
            toggleActiveItem,
            customActiveColor,
            customActiveBgColor,
            selectedOptionItems,
            updateSelectedCheckboxes
        };
    },
};
</script>

<style scoped>


.filter-buttons {
    display: flex;
    justify-content: space-between;
}

.custom-filter-dropdown {
    position: absolute;
    text-align: left;
    outline: none;
    width: 307px;
    max-height: 1000px;
    line-height: 47px;
}
.custom-filter-dropdown .items {
    color: #47454b;
    font-size: 16px !important;
    border-radius: 0px 0px 6px 6px;
    position: relative;
    left: 0;
    right: 0;
    z-index: 1;
    padding: 1.312rem 0 0 3.875rem;
    overflow: visible;
    height: auto !important;
}
.custom-filter-dropdown .items .checkboxes {
    font-family: inherit;
    font-size: 14px;
    font-weight: bold;
    line-height: 140%;
    color: #868686;
    display: flex;
    flex-direction: column;
    margin-bottom: 28px;
    text-transform: uppercase;
}

.text-title {
    margin-bottom: 0.861rem;
    font-size: 16px !important;
    line-height: 140% !important;
    color: #47454B !important;
    font-family: inherit;
    font-weight: bold;
    line-height: 140%;
    text-transform: capitalize;
    line-height: 22.4px;
}

.select {
    display: none;
}


.validate-button {
    margin: 1.62rem 0 1.062rem 3.25rem;
    display: block;
    position: relative;
    bottom: 0;
    width: 96px;
    height: 40px;
    border: 1px solid #47454b;
    box-sizing: border-box;
    border-radius: 4px;
    font-family: inherit;
    font-weight: bold;
    color: #000;
}
</style>
<style scoped>
.filter-reset {
    max-height: 40px;
    left: 0px;
    top: 0px;
    margin: 1% 3% 0% 0%;
    border: 1px solid #47454B;
    box-sizing: border-box;
    border-radius: 5px;
    line-height: 140%;
    padding: .5rem .2rem;
    background: #E5E5E5;
    color: #47454B;
    min-width: 116px;
}
.button-filter {
    max-height: 40px;
    margin: 1% 0% 0% 0%;
    border: 1px solid #47454B;
    box-sizing: border-box;
    border-radius: 5px;
    line-height: 140%;
    padding: .5rem .2rem;
    background: #E5E5E5;
    color: #47454B;
    display: flex;
    min-width: 116px;
}
.colored {
    background-color: lawngreen;
}
.rectangle {
    height: 2.410329818725586px;
    width: 21px;
    position: relative;
    left: 68.1%;
    right: 13.79%;
    bottom: 35%;
    background: #47454b;
    border-radius: 5px;
}
.rectangle2 {
    height: 2.4103260040283203px;
    width: 13.674415588378906px;
    border-radius: 5px;

    /* Rectangle 420 */

    position: relative;
    left: 71.26%;
    right: 16.95%;
    bottom: 25%;

    /* dark grey */

    background: #47454b;
    border-radius: 5px;
}
.rectangle3 {
    height: 2.4103336334228516px;
    width: 6.3488311767578125px;

    /* Rectangle 422 */

    position: relative;
    left: 74.42%;
    right: 20.11%;
    bottom: 15%;

    /* dark grey */

    background: #47454b;
    border-radius: 5px;
}
.text-filter {
    height: 12px;
    width: 69px;
    left: 12px;
    top: 14px;

    font-size: 14px;
    line-height: 140%;

    display: flex;
    align-items: center;

    /* dark grey */

    color: #47454b;
}
</style>
