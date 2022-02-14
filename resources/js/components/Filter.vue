<template>
    <div class="custom-filter-dropdown almarai_bold_normal" :tabindex="tabindex">
        
        <div class="selected text-end filter-buttons">
            <BaseButton 
                class="filter-reset" 
                title="Reinitialisation"
                @click.prevent="resetFilter"
                textClass="text-filter" 
            />

            <BaseButton
                class="button-filter"
                :class="[isColored]"
                textClass="text-filter"
                title="Filtre"
                @click.prevent="toggleActiveItem"
                :style="{
                    background: customActiveColor
                }"
            >
                <Icon name="filter" />
            </BaseButton>
        </div>

        <div class="items" :class="{ 'selectHide': !open('filter') }">

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
                        @changed="updateSelectedCheckboxes($event, checkbox.id)"
                    />

                </div>
            </div>

            <SelectBox
                v-for="(select, index) of selectOptions"
                :key="index"
                :placeholder="select.label"
                :options="select.options"
                :name="select.label"
                :label="select.label"
                v-model="selectedOptionItems[index]"
            />

            <BaseButton
                class="validate-button text-title"
                type="submit"
                title="Valider"
                @click.prevent="validate"
            />

        </div>
    </div>
</template>

<script>

import { ref, computed } from "vue"
import { useStore } from 'vuex'
import { ACTIVE_ITEM, SET_TOGGLER_ITEM, TOGGLER_MODULE } from '../store/types/types'

export default {

    props: {
        checkboxOptions: {
            type: Array,
            required: false,
        },
        selectOptions: {
            type: Array,
            required: false,
        },
        selectedOptions: {
            type: [Object, Array],
            required: false
        },
        tabindex: {
            type: Number,
            required: false,
            default: 0,
        },
    },

    emits: [
        'update:checkboxOptions',
        'update:selectOptions',
        'update:selectedOptions',
        'validate'
    ],

    setup(props, { emit, attrs }) {

        const store = useStore()

        const isActive = ref(false)
        const defaultColor = 'lawgreen'

        const activeItem = computed(() => store.getters[`${[TOGGLER_MODULE]}/${[ACTIVE_ITEM]}`])


        const customActiveColor = computed(() => {
            return isActive.value ? `${attrs.activeColor} !important` || defaultColor : ''
        })

        const selectedOptionItems = computed(() => props.selectedOptions)

        const isColored = computed(() => {
            const hasSelectedItems = Object.values(selectedOptionItems.value).some(option => option != '')
            const hasSelectedCheckboxes = props.checkboxOptions.some(checkbox => {
                return checkbox.options.some(option => option.check)
            })
            if(hasSelectedItems || hasSelectedCheckboxes) {
                isActive.value = true
                return 'colored'
            }
            isActive.value = false
            return ''
        })

        const open = (id = '') => {
            return id == activeItem.value.id && activeItem.value.status
        }

        const toggleActiveItem = () => {
            const status = !activeItem.value.status
            store.dispatch(`${[TOGGLER_MODULE]}/${[SET_TOGGLER_ITEM]}`, { id: 'filter', status })
        }


        const resetFilter = () => {
            const checkboxOptions = [ ...props.checkboxOptions ]
            const selectedOptions = { ...props.selectedOptions }

            checkboxOptions.forEach((checkbox, index) => {
                checkbox.options.forEach((option, optionIndex) => {
                    checkboxOptions[index].options[optionIndex].check = false
                })
            })

            Object.entries(selectedOptions).forEach((item, index) => {
                selectedOptions[index] = ''
            })

            emit('update:checkboxOptions', checkboxOptions)
            emit('update:selectedOptions', selectedOptions)

        }

        const updateSelectedCheckboxes = ({ id, value }, parentId) => {
            const checkboxOptions = [ ...props.checkboxOptions ]
            let checkboxIndex = checkboxOptions.findIndex(checkbox => checkbox.id == parentId)

            if(checkboxIndex != -1) {
                let optionIndex = checkboxOptions[checkboxIndex].options.findIndex(option => option.id == id)
                if(optionIndex != -1) {
                    checkboxOptions[checkboxIndex].options[optionIndex].check = value
                    emit('update:checkboxOptions', checkboxOptions)
                }
            }
        }

        
        const validate = () => {
            emit('validate')
        }
       

        return {
            open,
            validate,
            isColored,
            resetFilter,
            toggleActiveItem,
            customActiveColor,
            selectedOptionItems,
            updateSelectedCheckboxes
        };
    },
};
</script>

<style scoped>

.filter-buttons {
    display: flex;
    justify-items: flex-start;
    align-items: center;
}

.almarai_bold_normal{
    font-family: 'Almarai Bold';
   /* font-weight:700; */
   font-style:normal;
}  
.almarai_extrabold_normal{
    font-family: 'Almarai ExtraBold';
   /* font-weight:800; */
   font-style:normal;
}  
.almarai_light_normal{
    font-family: 'Almarai Light';
   /* font-weight:300; */
   font-style:normal;
}  
.almarai_regular_normal{
    font-family: 'Almarai regular';
   /* font-weight:400; */
   font-style:normal;
}  
.custom-filter-dropdown {
    position: relative;
    text-align: left;
    outline: none;
    width: 307px;
    max-height: 1000px;
    line-height: 47px;
    float: right;
}
.custom-filter-dropdown .items {
    color: #47454b;
    font-size: 16px !important;
    border-radius: 0px 0px 6px 6px;
    position: relative;
    background: #eeeeee;
    left: 0;
    right: 0;
    z-index: 1;
    padding: 5% 12%;
    overflow: visible;
    min-height: 500px;
    height: auto !important;
}
.custom-filter-dropdown .items .checkboxes {
    font-size: 14px;
    line-height: 140%;
    color: #868686;
    display: flex;
    flex-direction: column;
    margin-bottom: 10px;
    text-transform: uppercase;
}
/* .custom-filter-dropdown .items .checkbox-items:hover {
    background-color: #e0dede;
} */

.selectHide {
    display: none;
}
.text-title {
    margin-bottom: 16px;
    font-size: 16px !important;
    line-height: 140% !important;
    color: #47454b !important;
}
.validate-button {
    margin: 10% 25% 0% 25%;
    display: block;
    position: relative;
    bottom: 0;
    width: 96px;
    height: 40px;
    border: 1px solid #47454b;
    box-sizing: border-box;
    border-radius: 4px;
}
</style>
<style scoped>
.filter-reset {
    max-height: 40px;
    left: 0px;
    top: 0px;
    margin: 1% 3% 0% 0%;
    border: 1px solid #47454b;
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
