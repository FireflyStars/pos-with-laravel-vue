<template>
    <div
        class="custom-filter-dropdown"
        :tabindex="tabindex"
        @blur="open = false"
    >
        <div
            class="selected text-end"
            :class="{ open: open }"
            @click="open = !open"
        >
            <filter-button />
        </div>

        <div class="items" :class="{ selectHide: !open }">
            <div class="text-title">Champs :</div>
            <div
                class="checkbox-items"
                v-for="(option, i) of checkboxes_options"
                :key="i"
            >
                <check-box
                    :id="i"
                    :checked_checkbox="false"
                    :name="option"
                    @checkbox-clicked="updateSelectedList"
                />
                {{ option }}
            </div>
            <div class="text-title mt-2">Grouper par :</div>
            <div class="button-wrap">
                <div class="select-group">
                    <select-options
                        v-model="sel1"
                        placeholder="Choose a number"
                        :options="select_options"
                        name="select2"
                        :valid="true"
                    ></select-options>
                </div>
                <button class="validate-button text-title" type="submit">
                    Valider
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, computed } from "@vue/reactivity";
import { useStore } from "vuex";
import { mapGetters, mapMutations, mapActions } from "vuex";
import { GET_SELECTED_BOXES, SET_SELECTED_BOXES } from "../store/types/types";

import FilterButton from "./FilterButton.vue";
import CheckBox from "./miscellaneous/CheckBox.vue";
import SelectOptions from "./miscellaneous/SelectOptions.vue";
export default {
    components: { FilterButton, CheckBox, SelectOptions },
    props: {
        checkboxes_options: {
            type: Array,
            required: true,
        },
        select_options: {
            type: Array,
            required: true,
        },
        tabindex: {
            type: Number,
            required: false,
            default: 0,
        },
    },
    setup() {
        const store = useStore();

        let sel1 = ref(1);
        let open = ref(false);
        return {
            sel1,
            open,
            updateSelectedList: (event) =>
                store.dispatch(SET_SELECTED_BOXES, event),
        };
    },
};
</script>

<style scoped>
.custom-filter-dropdown {
    position: relative;

    text-align: left;
    outline: none;
    width: 307px;
    height: 445px;
    line-height: 47px;
    float: right;
}
.custom-filter-dropdown .items {
    height: 445px;
    width: 307px;
    color: #fff;
    border-radius: 0px 0px 6px 6px;
    overflow: hidden;
    position: absolute;
    background: #eeeeee;
    left: 0;
    right: 0;
    z-index: 1;
    padding: 12%;
}

.custom-filter-dropdown .items div {
    font-family: Almarai;
    font-style: normal;
    font-weight: bold;
    font-size: 14px;
    line-height: 140%;
    /* or 20px */

    /* Medium grey */

    color: #868686;
    display: flex;
}

.custom-filter-dropdown .items .checkbox-items:hover {
    background-color: #e0dede;
}

.selectHide {
    display: none;
}
.text-title {
    margin-bottom: 21px;
    font-style: normal !important;
    font-weight: bold !important;
    font-size: 16px !important;
    line-height: 140% !important;
    /* or 22px */

    /* dark grey */

    color: #47454b !important;
}
.select-group {
    height: 21px;
    width: 100%;
    display: flex;
    flex-direction: column;
    /* left: 726px;
    top: 5287px;
    border-radius: 0px;
    border-style: none;

    font-family: Almarai;
    font-style: normal;
    font-weight: bold;
    font-size: 14px;
    line-height: 140%; */
    /* or 20px */

    /* display: flex;
    align-items: center; */

    /* Medium grey */

    color: #868686;
}
.validate-button {
    /* Auto layout */

    display: flex;
    flex-direction: row;
    justify-content: center;
    align-items: center;
    justify-self: center;

    position: relative;
    width: 96px;
    height: 40px;

    border: 1px solid #47454b;
    box-sizing: border-box;
    border-radius: 4px;
    margin-top: 25px;
}
.button-wrap {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;

    /* justify-self: center; */
}
</style>
