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
            <button class="filter-reset" @click.prevent="resetFilter">
                <div class="text-filter">Reinitialisation</div>
            </button>
            <button class="button-filter">
                <div class="text-filter">Filtre</div>
                <!-- 
                <div class="rectangle"></div>
                <div class="rectangle2"></div>
                <div class="rectangle3"></div> -->
            </button>
        </div>

        <div class="items" :class="{ selectHide: !open }">
            <div
                class="checkboxes"
                v-for="(checkboxes, index) of checkboxes"
                :key="index"
            >
                <div class="text-title">{{ checkboxes.name }} :</div>
                <div
                    class="checkbox-items"
                    v-for="option of checkboxes.options"
                    :key="option.id"
                >
                    <check-box
                        :id="option.id"
                        :checked_checkbox="option.check"
                        :name="option.name"
                        @checkbox-clicked="updateSelectedList"
                    >
                        {{ option.name }}
                    </check-box>
                </div>
            </div>

            <select-options
                v-for="(select, index) of select_options"
                :key="index"
                v-model="sel1"
                placeholder="Choose a number"
                :options="select.options"
                :name="select.label"
                :valid="true"
                :label="select.label"
            ></select-options>

            <button class="validate-button text-title" type="submit">
                Valider
            </button>
        </div>
    </div>
</template>

<script>
import { ref, computed } from "@vue/reactivity";
import { useStore } from "vuex";
import { mapGetters, mapMutations, mapActions } from "vuex";
import {
    GET_SELECTED_BOXES,
    SET_SELECTED_BOXES,
    RESET_FILTER,
    SET_ITEMS,
    GET_ITEMS,
    FILTER_MODULE,
} from "../store/types/types";

import CheckBox from "./miscellaneous/CheckBox.vue";
import SelectOptions from "./miscellaneous/SelectOptions.vue";
export default {
    components: { CheckBox, SelectOptions },
    props: {
        checkboxes_options: {
            type: Array,
            required: false,
        },
        select_options: {
            type: Array,
            required: false,
        },
        tabindex: {
            type: Number,
            required: false,
            default: 0,
        },
    },
    setup(props) {
        const store = useStore();

        let sel1 = ref(1);
        let open = ref(false);

        const checkboxes = props.checkboxes_options;
        store.dispatch(SET_ITEMS, props.checkboxes_options);
        const resetFilter = () => {
            console.log("reset");
            store.dispatch(RESET_FILTER);
        };

        return {
            checkboxes,
            sel1,
            open,
            resetFilter,
            updateSelectedList: (event) =>
                store.dispatch(SET_SELECTED_BOXES, event),
            selected_items: computed(() => store.getters[GET_SELECTED_BOXES]),
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

    max-height: 1000px;
    line-height: 47px;
    float: right;
}
.custom-filter-dropdown .items {
    font-family: Almarai;
    color: #47454b;
    font-style: normal !important;
    font-weight: bold !important;
    font-size: 16px !important;

    border-radius: 0px 0px 6px 6px;
    position: relative;
    background: #eeeeee;
    left: 0;
    right: 0;
    z-index: 1;
    padding: 5% 12%;
    overflow: auto;
    min-height: 500px;
    height: auto !important;
}

.custom-filter-dropdown .items .checkboxes {
    font-family: Almarai;
    font-style: normal;
    font-weight: bold;
    font-size: 14px;
    line-height: 140%;
    /* or 20px */

    /* Medium grey */

    color: #868686;
    display: flex;
    flex-direction: column;
    margin-bottom: 10px;
}

.custom-filter-dropdown .items .checkbox-items:hover {
    background-color: #e0dede;
}

.selectHide {
    display: none;
}
.text-title {
    margin-bottom: 16px;
    font-style: normal !important;
    font-weight: bold !important;
    font-size: 16px !important;
    line-height: 140% !important;
    /* or 22px */

    /* dark grey */

    color: #47454b !important;
}
.validate-button {
    /* Auto layout */
    margin: 10% 25% 0% 25%;
    display: block;
    position: relative;

    bottom: 0;
    width: 96px;
    height: 40px;

    border: 1px solid #47454b;
    box-sizing: border-box;
    border-radius: 4px;
    /* margin-top: 25px; */
}
</style>
<style scoped>
.filter-reset {
    height: 40px;
    width: 116px;
    left: 0px;
    top: 0px;
    margin: 1% 3% 0% 0%;
    /* dark gre */

    border: 1px solid #47454b;
    box-sizing: border-box;
    border-radius: 5px;
}
.button-filter {
    /* Rectangle 423 */
    height: 40px;
    width: 116px;
    left: 0px;
    top: 0px;
    margin: 1% 0% 0% 0%;
    /* dark gre */

    border: 1px solid #47454b;
    box-sizing: border-box;
    border-radius: 5px;
}
.rectangle {
    height: 2.410329818725586px;
    width: 21px;

    /* Rectangle 420 */

    position: relative;
    left: 68.1%;
    right: 13.79%;
    bottom: 35%;

    /* dark grey */

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

    font-family: Almarai;
    font-style: normal;
    font-weight: bold;
    font-size: 14px;
    line-height: 140%;
    /* or 20px */

    display: flex;
    align-items: center;

    /* dark grey */

    color: #47454b;
}
</style>
