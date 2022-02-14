<template>
    <div :style="{
        width: `${$attrs.width} !importtant` || 'auto',
        padding: $attrs.padding || 0,
        margin: $attrs.margin || 0
    }"
    class="box-container"
    :class="{ 'dark': dark }"
    >

        <label for="" class="label">{{ title }}</label>

        <div class="select-box">

            <div class="selected" @click.prevent="toggleActive">
                <div class="item" v-for="item in selectedValues" :key="item.id">
                    {{ item.value }}
                </div>
            </div>

            <div 
            class="options-container"
            :class="{ 'active': active }"
            >

                <div class="search-box" v-if="search">
                    <input type="search" name="" id="" placeholder="Search..." v-model="searchValue">
                </div>

                <div 
                class="option"
                v-for="item in filteredOptions"
                :key="item.id"
                >
                    <CheckBox 
                        :id="item.id"
                        :checked="item.check"
                        :name="item.value"
                        :title="item.value"
                        @changed="updateSelectOptions"
                    />
                </div>

            </div>

        </div>

    </div>
</template>

<script>
import { ref, computed } from "vue"

export default {
    
    name: "CheckBoxMain",
    inheritAttrs: false,

    props: {
        title: String,
        search: {
            type: Boolean,
            default: false,
        },
        options: {
            required: true,
            type: [Object, Array]
        },
        dark: Boolean
    },

    emits: ['update:options'],

    
    setup(props, { emit }) {

        const active = ref(false)
        const searchValue = ref('')

        const toggleActive = () => {
            active.value = !active.value
        }

        const selectedValues = computed(() => {
            return props.options.filter(option => option.check)
        })

        const filteredOptions = computed(() => {
            let options = []
            if(props.search && searchValue.value != '') {
                options = props.options.filter(option => {
                    return option.value.toLowerCase().includes(searchValue.value.toLowerCase())
                })
            }
            else options = [ ...props.options ]
            return options
        })

        const updateSelectOptions = ({ value, id }) => {
            const optionIndex = props.options.findIndex(option => option.id == id)
            const filteredOptions = [ ...props.options ]
            filteredOptions[optionIndex].check = value
            emit('update:options', filteredOptions)
        }

        return {
            active,
            searchValue,
            toggleActive,
            selectedValues,
            filteredOptions,
            updateSelectOptions
        }


    }

}

</script>


<style lang="scss" scoped>

.box-container {
    position: relative;
}

.select-box {

    position: relative;
    display: flex;
    flex-direction: column;
    justify-items: center;
    width: 100%;
    box-sizing: border-box;

    .options-container {
        background: #EEEEEE;
        color: #000000;
        width: 100%;
        transition: all .2s;
        max-height: 0;
        opacity: 0;
        overflow: hidden;
        order: 1;
        font-family: Almarai;
        font-style: normal;
        font-weight: bold;
        font-size: 14px;
        line-height: 140%;
        position: absolute;
        top: 50px;

        &::-webkit-scrollbar {
            width: 8px;
            background: #EEEEEE;
            border-radius: 0 8px 8px 0;
        }

        &::-webkit-scrollbar-thumb {
            background: #525861;
            border-radius: 0 8px 8px 0;
        }

        .option {
            .chkbox_wrap {
                display: flex;
                align-items: center;
                gap: .2rem .4rem;
                font-weight: bold;
                label: {
                    cursor: pointer;
                }
                
            }
        }

    }

    .active {
        max-height: 240px;
        opacity: 1;
        overflow-y: scroll;
    }

    .selected {
        background: #EEEEEE;
        border-radius: 4px;
        margin-bottom: 8px;
        color: #000000;
        position: relative;
        order: 0;
        padding: .4rem;
        display: flex;
        justify-items: center;
        flex-wrap: wrap;
        gap: .3rem;
        height: 40px;
        overflow: auto;
        .item {
            background: #fff;
            padding: 2px 4px;
            font-size: 13px;
        }
        &::-webkit-scrollbar {
            width: 8px;
            background: #EEEEEE;
            border-radius: 0 8px 8px 0;
        }

        &::-webkit-scrollbar-thumb {
            background: #525861;
            border-radius: 0 8px 8px 0;
        }
    }

    .search-box {
        padding-bottom: 3rem;
        input {
            width: 100%;
            padding: 6px 12px;
            font-family: Almarai;
            font-size: 16px;
            position: absolute;
            border-radius: 8px 8px 0 0;
            z-index: 100;
            border: 8px solid #EEEEEE;
            opacity: 0;
            pointer-events: none;
            transition: all 0.2s;
            &:focus {
                outline: none;
            }
        }
    }

}

.label {
    color: #868686;
    font-family: Almarai;
    font-style: normal;
    font-weight: bold;
    font-size: 14px;
    line-height: 140%;
    text-transform: uppercase;
    margin-top: 8px;
}

.select-box .option, .selected {
    padding: 12px;
    cursor: pointer;
}

.select-box .options-container.active .search-box input {
    opacity: 1;
    pointer-events: auto;
}

.dark {
    .selected {
        background: #494c50;
        &::-webkit-scrollbar {
            background: #525861;
        }

        &::-webkit-scrollbar-thumb {
            background: #494c50;
        }
        .item {
            background: #525861;
            color: #F0F0F0;
        }
    }
    .options-container {
        background: #494c50;
        color: #F0F0F0;
        &::-webkit-scrollbar {
            background: #525861;
        }

        &::-webkit-scrollbar-thumb {
            background: #494c50;
        }
    }
    .search-box {
        input {
            border: 8px solid #494c50;
            background: #525861;
            color: #F0F0F0;
        }
    }
}

</style>

